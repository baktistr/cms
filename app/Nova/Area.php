<?php

namespace App\Nova;

use App\Nova\Filters\AreaTreg;
use App\Nova\Metrics\TotalArea;
use GeneaLabs\NovaMapMarkerField\MapMarker;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Orlyapps\NovaBelongsToDepend\NovaBelongsToDepend;
use Rimu\FormattedNumber\FormattedNumber;
use Wemersonrv\InputMask\InputMask;

class Area extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Area::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'code';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'code',
        'allotment',
        'postal_code',
        'nka_sap',
        'address_detail'
    ];

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = [
        'provinsi',
        'kabupaten',
        'kecamatan',
        'witel',
        'regional',
    ];

    /**
     * The relationship columns that should be searched.
     *
     * @var array
     */
    public static $searchRelations = [
        'provinsi'  => ['name'],
        'kabupaten' => ['name'],
        'kecamatan' => ['name'],
        'witel'     => ['name'],
        'regional'  => ['name'],
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

        return $query->whereHas('assets', function ($query) use ($request) {
            $query->where('pic_id', $request->user()->id);
        });
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
            InputMask::make('Kode Lokasi', 'code')
                ->mask('#-##-##-##')
                ->rules(['required', 'unique:areas,code,{{resourceId}}']),

            BelongsTo::make('TREG', 'regional', TelkomRegional::class)
                ->rules(['required'])
                ->sortable(),

            BelongsTo::make('Witel', 'witel', WilayahTelekomunikasi::class)
                ->rules(['required'])
                ->sortable(),

            NovaBelongsToDepend::make('Provinsi')
                ->options(\App\Province::all()),

            NovaBelongsToDepend::make('Kabupaten')
                ->optionsResolve(function ($province) {
                    return $province->regencies()->get(['id', 'name']);
                })
                ->dependsOn('Provinsi'),

            NovaBelongsToDepend::make('Kecamatan')
                ->optionsResolve(function ($regency) {
                    return $regency->districts()->get(['id', 'name']);
                })
                ->dependsOn('Kabupaten')
                ->hideFromIndex(),

            Textarea::make('Alamat', 'address_detail')
                ->rules('required')
                ->alwaysShow(),

            Text::make('Alamat', 'address_detail')
                ->rules('required')
                ->onlyOnIndex(),

            MapMarker::make('Lokasi')
                ->rules('required')
                ->hideFromIndex(),

            Text::make('Total Gedung', function () {
                return $this->assets()->count();
            }),

            FormattedNumber::make('Luas Tanah Total', 'surface_area')
                ->help('satuan dalam m<sup>2</sup>')
                ->onlyOnForms(),

            Text::make('Luas Tanah Total', function () {
                return number_format($this->surface_area) . ' m<sup>2</sup>';
            })->asHtml(),

            Text::make('Sisa Luas Tanah', function () {
                return number_format($this->formatted_surface_empty_area) . ' m<sup>2</sup>';
            })->asHtml(),

            Text::make('Kode Pos', 'postal_code')
                ->nullable(),

            Text::make('Peruntukan', 'allotment')
                ->rules('required'),

            HasMany::make('Aset', 'assets', Building::class),

            HasMany::make('Sertifikat', 'certificates', AreaCertificate::class),

            HasMany::make('Riwayat Sengketa', 'disputeHistories', AreaDisputeHistory::class),
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
            (new TotalArea)->canSee(function () use ($request) {
                return $request->user()->hasRole('Super Admin');
            })->width('1/4')
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
        return [
            (new AreaTreg),
        ];
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
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return '  Lahan';
    }
}
