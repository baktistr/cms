<?php

namespace App\Nova;

use App\Tenant as AppTenant;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use libphonenumber\NumberFormat;
use Rimu\FormattedNumber\FormattedNumber;

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
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'tanant',
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
            ID::make()->sortable(),

            BelongsTo::make('Gedung', 'gedung', Asset::class),

            Text::make('Lantai', 'floor')
                ->rules('required', 'numeric'),

            Select::make('Objek Sewa', 'object_rent')
                ->options(AppTenant::$objectRent)
                ->rules('required'),

            Select::make('Status Pembuatan Kontrak', 'status_contract_make')
                ->options(AppTenant::$statusMakeContract)
                ->rules('required'),

            Text::make('Peruntukan', 'allotment')
                ->rules('required'),

            Text::make('Nama Kontrak GSD', 'name_contract_gsd')
                ->rules('required'),

            Text::make('Nomer dan Tanggal Kontrak', 'number_and_date')
                ->rules('required'),

            Date::make('Jangka Waktu Awal', 'period_start')
                ->rules('required'),

            Date::make('Jangka Waktu Akhir', 'period_start')
                ->rules('required'),

            Number::make('Durasi', 'duration')
                ->help('Satuan Dalam Bulan'),

            Text::make('Luas Area', 'area')
                ->rules('required'),

            FormattedNumber::make('Harga', 'price')
                ->rules('required'),

            FormattedNumber::make('Harga Service', 'service_price')
                ->rules('required'),

            Markdown::make('Keterangan Kontrak' , 'contract_desc')
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
