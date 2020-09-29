<?php

namespace App\Nova;

use Bissolli\NovaPhoneField\PhoneNumber;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use KABBOUCHI\NovaImpersonate\Impersonate;
use Laravel\Nova\Http\Requests\NovaRequest;
use Vyuldashev\NovaPermission\RoleSelect;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\User::class;

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
        'id', 'name', 'email',
    ];

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Sistem';

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = [
        'buildings',
        'assignedBuilding',
    ];

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

        return $query->where('id', $request->user()->id);
    }

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
            
            Images::make('Avatar', 'avatar')
                ->conversionOnIndexView('small')
                ->conversionOnDetailView('large')
                ->rules('required'),

            Text::make('Nama', 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email', 'email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Text::make('Username', 'username')
                ->sortable()
                ->rules('required', 'max:254')
                ->creationRules('unique:users,username')
                ->updateRules('unique:users,username,{{resourceId}}'),

            PhoneNumber::make('Telepon', 'phone_number')
                ->onlyCountries('ID'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),

            RoleSelect::make('Role', 'roles'),

            BelongsTo::make('Gedung', 'assignedBuilding', Building::class)
                ->nullable(),

            Impersonate::make($this)->withMeta([
                'redirect_to' => config('nova.path')
            ]),

            HasMany::make('Gedung', 'buildings', Building::class),

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
