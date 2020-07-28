<?php

namespace App\Nova;

use App\Tenant as AppTenant;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Rimu\FormattedNumber\FormattedNumber;
use Laravel\Nova\Http\Requests\NovaRequest;

class Tenant extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Tenant::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'tenant';

    /**
     * Indicates if the resource should be displayed in the sidebar.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'tenant',
        'floor',
        'object_rent',
        'status_contract_make',
        'allotment',
        'name_contract_gsd',
        'number_and_date',
        'phisycal_check_contract',
        'period_start',
        'period_end',
        'duration',
        'area',
        'price',
        'service_price',
    ];

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = [
        'gedung',
    ];

    /**
     * The relationship columns that should be searched.
     *
     * @var array
     */
    public static $searchRelations = [
        'gedung' => ['name'],
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            BelongsTo::make('Gedung', 'gedung', Asset::class),

            Text::make('Tenant', 'tenant')
                ->rules('required', 'string'),

            Text::make('Lantai', 'floor')
                ->rules('required', 'numeric'),

            Select::make('Objek Sewa', 'object_rent')
                ->options(AppTenant::$objectRent)
                ->displayUsingLabels()
                ->rules('required'),

            Select::make('Status Pembuatan Kontrak', 'status_contract_make')
                ->options(AppTenant::$statusMakeContract)
                ->displayUsingLabels()
                ->rules('required'),

            Text::make('Peruntukan', 'allotment')
                ->rules('required'),

            Text::make('Nama Kontrak GSD', 'name_contract_gsd')
                ->rules('required'),

            Text::make('Nomer dan Tanggal Kontrak', 'number_and_date')
                ->rules('required'),

            Text::make('Fisik Check Kontrak', 'phisycal_check_contract')
                ->rules('required'),

            Date::make('Jangka Waktu Awal', 'period_start')
                ->rules('required'),

            Date::make('Jangka Waktu Akhir', 'period_end')
                ->rules('required'),

            Text::make('Durasi', 'duration')
                ->rules('required','numeric')
                ->help('Satuan Dalam Bulan'),

            Text::make('Luas Area', 'area')
                ->rules('required'),

            FormattedNumber::make('Harga', 'price')
                ->rules('required'),

            FormattedNumber::make('Harga Service', 'service_price')
                ->rules('required'),

            Markdown::make('Keterangan Kontrak', 'contract_desc')
                ->rules('nullable'),

            Markdown::make('Keterangan Status Kontrak', 'status_contract_desc')
                ->rules('nullable'),

            Markdown::make('Status Perusahaan', 'company_status')
                ->rules('nullable'),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
