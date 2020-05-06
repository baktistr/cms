<?php

namespace App\Nova;

use Benjaminhirsch\NovaSlugField\Slug;
use Benjaminhirsch\NovaSlugField\TextWithSlug;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Orlyapps\NovaBelongsToDepend\NovaBelongsToDepend;
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
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name',
    ];

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Asset';

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        $categories = \App\AssetCategory::pluck('name', 'id');

        return [
            ID::make()->sortable(),

            BelongsTo::make('Category', 'category', AssetCategory::class)
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Select::make('Category', 'asset_category_id')
                ->options($categories)
                ->displayUsingLabels()
                ->rules(['required', 'exists:asset_categories,id'])
                ->onlyOnForms(),

            BelongsTo::make('Admin', 'admin', User::class),

            TextWithSlug::make('Name')
                ->rules(['required', 'max:255'])
                ->slug('slug'),

            Slug::make('Slug')
                ->rules(['required', 'unique:assets,slug,{{resourceId}}'])
                ->hideFromIndex(),

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

//            BelongsTo::make('Province')
//                ->exceptOnForms(),
//
//            BelongsTo::make('Regency')
//                ->exceptOnForms(),
//
//            BelongsTo::make('District')
//                ->exceptOnForms(),
//
//            Select::make('Province', 'province_id')
//                ->options($provinces)
//                ->displayUsingLabels()
//                ->rules(['required', 'exists:provinces,id'])
//                ->onlyOnForms(),
//
//            NovaDependencyContainer::make([
//
//            ])->dependsOnNotEmpty('province.id'),
//
//            NovaDependencyContainer::make([
//
//            ])->dependsOnNotEmpty('regency.id'),

            Textarea::make('Address Detail')
                ->rules('required')
                ->alwaysShow(),

            Boolean::make('Available', 'is_available')
                ->sortable(),

            Text::make('Unit area (m2)', 'unit_area')
                ->rules(['required', 'numeric'])
                ->hideFromIndex(),

            /**
             * Fields for Tanah.
             * @todo better solution for dependency container relationship.
             */
            NovaDependencyContainer::make([
                FormattedNumber::make('Value (Rupiah)', 'value')
                    ->rules(['required', 'numeric']),
            ])->dependsOn('asset_category_id', 1),


            /**
             * Fields for Gedung dan ruko.
             * @todo better solution for dependency container relationship.
             */
            NovaDependencyContainer::make([
                Text::make('Number of Floors')
                    ->rules(['required', 'numeric', 'min:1']),

                FormattedNumber::make('Value (Rupiah)', 'value')
                    ->rules(['required', 'numeric']),
            ])->dependsOn('asset_category_id', 2)
            ->dependsOn('asset_category_id', 3),

            /**
             * Fields for komersil.
             * @todo better solution for dependency container relationship.
             */
            NovaDependencyContainer::make([
                FormattedNumber::make('Price (Rupiah)', 'price')
                    ->rules(['required', 'numeric'])
                    ->onlyOnForms(),

                Select::make('Price Type')
                    ->options(\App\Asset::$priceTypes)
                    ->displayUsingLabels()
                    ->rules(['required'])
                    ->onlyOnForms(),
            ])->dependsOn('asset_category_id', 4),

            Images::make('Images', 'image')
                ->rules(['required'])
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
        return [];
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
}
