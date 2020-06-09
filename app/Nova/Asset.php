<?php

namespace App\Nova;

use App\Nova\Metrics\AvailableAssets;
use App\Nova\Metrics\TotalAssets;
use App\Nova\Metrics\UnavailableAssets;
use Benjaminhirsch\NovaSlugField\Slug;
use Benjaminhirsch\NovaSlugField\TextWithSlug;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
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
use Titasgailius\SearchRelations\SearchesRelations;

class Asset extends Resource
{
    use SearchesRelations;

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
        'admin',
        'category',
        'province',
        'regency',
        'district',
    ];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
    ];

    /**
     * The relationship columns that should be searched.
     *
     * @var array
     */
    public static $searchRelations = [
        'admin'    => ['name'],
        'category' => ['name'],
        'province' => ['name'],
        'regency'  => ['name'],
        'district' => ['name'],
    ];

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Asset';

    /**
     * Build an "index" query for the given resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param \Illuminate\Database\Eloquent\Builder   $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->isSuperAdmin()) {
            return $query;
        }

        return $query->where('admin_id', $request->user()->id);
    }

    /**
     * Get the search result subtitle for the resource.
     *
     * @return string
     */
    public function subtitle()
    {
        return "Category: {$this->category->name} | Admin: {$this->admin->name}";
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

            BelongsTo::make('Category', 'category', AssetCategory::class)
                ->exceptOnForms(),

            Select::make('Category', 'asset_category_id')
                ->options($this->assetCategories($request->user()))
                ->displayUsingLabels()
                ->rules(['required', 'exists:asset_categories,id'])
                ->onlyOnForms(),

            HiddenField::make('Admin', 'admin_id')
                ->defaultValue($request->user()->id)
                ->onlyOnForms(),

            BelongsTo::make('Admin', 'admin', User::class),

            TextWithSlug::make('Name')
                ->rules(['required', 'max:255'])
                ->slug('slug'),

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

            Textarea::make('Address Detail')
                ->rules('required')
                ->alwaysShow(),

            Text::make('Phone Number')
                ->hideFromIndex(),

            Select::make('Type')
                ->options(\App\Asset::$types)
                ->displayUsingLabels()
                ->rules(['required']),

            Text::make('Unit area (m2)', 'unit_area')
                ->rules(['required', 'numeric'])
                ->hideFromIndex(),

            /**
             * Fields for Gedung dan ruko.
             * @todo better solution for dependency container relationship.
             */
            NovaDependencyContainer::make([
                Text::make('Number of Floors')
                    ->rules(['required', 'numeric', 'min:1'])
            ])->dependsOn('asset_category_id', 2)
                ->dependsOn('asset_category_id', 3)
                ->onlyOnDetail()
                ->onlyOnIndex(),

            NovaDependencyContainer::make([
                FormattedNumber::make('Price (Rupiah)', 'price')
                    ->rules(['required', 'numeric'])
                    ->onlyOnForms(),
            ])->dependsOn('type', 'sale'),

            Boolean::make('Available', 'is_available')
                ->sortable(),

            Images::make('Images', 'image')
                ->rules(['required']),

            HasMany::make('Prices', 'prices', AssetPrice::class)
                ->canSee(function () {
                    return $this->type === 'rent';
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
        if ($user->isSuperAdmin()) {
            return \App\AssetCategory::pluck('name', 'id');
        }

        return \App\AssetCategory::assignedAdmin($user)
            ->pluck('name', 'id');
    }
}
