<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Rimu\FormattedNumber\FormattedNumber;

class AssetPbb extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\BuildingPbb::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'object_name';


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
        'object_name',
        'nop',
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

            BelongsTo::make('Gedung', 'asset', Building::class),

            Text::make('Kode Lokasi', 'location_code')
                ->rules('string', 'required'),

            Text::make('Nama Objek', 'object_name')
                ->rules('string', 'required'),

            Textarea::make('Alamat', 'address')
                ->rules('string', 'required'),

            Text::make('NOP', 'nop')
                ->rules('string', 'required'),

            FormattedNumber::make('NJOP Tanah Per Meter', 'njop_land_per_meter')
                ->rules(['required', 'numeric']),

            FormattedNumber::make('NJOP Gedung Per Meter', 'njop_building_per_meter')
                ->rules(['required', 'numeric']),

            Text::make('Luas Tanah', 'surface_area')
                ->rules('numeric', 'required'),

            FormattedNumber::make('PBB yang di Bayar', 'pbb_paid')
                ->rules(['required', 'numeric']),
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

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return 'PBB Gedung';
    }
}
