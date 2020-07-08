<?php

namespace App\Nova;

use App\Nova\Metrics\AvailableAssets;
use App\Nova\Metrics\TotalAssets;
use App\Nova\Metrics\UnavailableAssets;
use Benjaminhirsch\NovaSlugField\TextWithSlug;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use GeneaLabs\NovaMapMarkerField\MapMarker;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Orlyapps\NovaBelongsToDepend\NovaBelongsToDepend;
use Outhebox\NovaHiddenField\HiddenField;
use Rimu\FormattedNumber\FormattedNumber;

class Asset extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Asset::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = [
        'pic',
        'category',
        'province',
        'regency',
        'district',
        'locationCode',
        'witel',
    ];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
        'building_code',
    ];

    /**
     * The relationship columns that should be searched.
     *
     * @var array
     */
    public static $searchRelations = [
        'pic'          => ['name'],
        'category'     => ['name'],
        'province'     => ['name'],
        'regency'      => ['name'],
        'district'     => ['name'],
        'locationCode' => ['code'],
    ];

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Aset';

    /**
     * Build an "index" query for the given resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param \Illuminate\Database\Eloquent\Builder   $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->hasRole('Super Admin')) {
            return $query;
        }

        return $query->where('pic_id', $request->user()->id);
    }

    /**
     * Get the search result subtitle for the resource.
     *
     * @return string
     */
    public function subtitle()
    {
        return "Category: {$this->category->name} | PIC: {$this->pic->name}";
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Kategori', 'category', AssetCategory::class)
                ->exceptOnForms()
                ->sortable(),

            BelongsTo::make('Regional', 'regional', TelkomRegional::class)
                ->rules(['required'])
                ->sortable(),

            BelongsTo::make('Wilayah Telekomunikasi', 'witel', WilayahTelekomunikasi::class)
                ->rules(['required'])
                ->sortable(),

            Select::make('Kategori', 'asset_category_id')
                ->options($this->assetCategories($request->user()))
                ->displayUsingLabels()
                ->rules(['required', 'exists:asset_categories,id'])
                ->onlyOnForms(),

            HiddenField::make('PIC', 'pic_id')
                ->defaultValue($request->user()->id)
                ->onlyOnForms(),

            BelongsTo::make('PIC', 'pic', User::class)
                ->hideFromIndex(),

            TextWithSlug::make('Nama', 'name')
                ->rules(['required', 'max:255'])
                ->slug('slug')
                ->sortable(),

            Textarea::make('Deskripsi', 'description')
                ->rules('required'),

            NovaBelongsToDepend::make('Province')
                ->options(\App\Province::all())
                ->hideFromIndex(),

            NovaBelongsToDepend::make('Regency')
                ->optionsResolve(function ($province) {
                    return $province->regencies()->get(['id', 'name']);
                })
                ->dependsOn('Province')
                ->hideFromIndex(),

            NovaBelongsToDepend::make('District')
                ->optionsResolve(function ($regency) {
                    return $regency->districts()->get(['id', 'name']);
                })
                ->dependsOn('Regency')
                ->hideFromIndex(),

            Textarea::make('Detail Alamat', 'address_detail')
                ->rules('required')
                ->alwaysShow(),

            BelongsTo::make('Kode Lokasi', 'locationCode', LocationCode::class)
                ->rules(['required']),

            Text::make('Kode Gedung', 'building_code')
                ->rules(['required'])
                ->onlyOnForms(),

            Text::make('Kode Gedung', function () {
                return "{$this->locationCode->code}-{$this->building_code}";
            }),

            Textarea::make('Peruntukan', 'allotment')
                ->nullable()
                ->alwaysShow(),

            MapMarker::make('Lokasi')
                ->rules('required')
                ->hideFromIndex(),

            Text::make('Nomor Handphone', 'phone_number')
                ->hideFromIndex(),

            Select::make('Tipe', 'type')
                ->options(\App\Asset::$types)
                ->displayUsingLabels()
                ->rules(['required']),

            Text::make('Luas area (m2)', 'unit_area')
                ->rules(['required', 'numeric'])
                ->hideFromIndex(),

            /**
             * Fields for Gedung dan ruko.
             * @todo better solution for dependency container relationship.
             */
            NovaDependencyContainer::make([
                Text::make('Jumlah Lantai', 'number_of_floors')
                    ->rules(['required', 'numeric', 'min:1'])
            ])->dependsOn('asset_category_id', 2)
                ->dependsOn('asset_category_id', 3)
                ->onlyOnDetail()
                ->onlyOnIndex(),

            NovaDependencyContainer::make([
                FormattedNumber::make('Harga (Rupiah)', 'price')
                    ->rules(['required', 'numeric'])
                    ->onlyOnForms(),
            ])->dependsOn('type', 'sale'),

            Boolean::make('Ketersedian', 'is_available')
                ->sortable(),

            Images::make('Gambar', 'image')
                ->rules(['required']),

            HasMany::make('Area Komersil', 'spaces', BuildingSpace::class)
                ->canSee(function () {
                    return $this->category->slug === 'gedung';
                }),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            new TotalAssets,
            new AvailableAssets,
            new UnavailableAssets,
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    /**
     * Get assets category depends on role.
     *
     * @param $user
     * @return mixed
     */
    protected function assetCategories($user)
    {
        if ($user->hasRole('Super Admin')) {
            return \App\AssetCategory::pluck('name', 'id');
        }

        return \App\AssetCategory::assignedAdmin($user)
            ->pluck('name', 'id');
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Aset');
    }
}
