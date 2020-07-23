<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Filters\Filter;

class Tregfilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        $asset =  $query->with('area')->whereHas('area.regional', function (Builder $query) use ($value) {
            return $query->where('name', $value);
        });
        return $asset->get();
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'TREG 1' => 'TREG 1',
            'TREG 2' => 'TREG 2',
            'TREG 3' => 'TREG 3',
            'TREG 4' => 'TREG 4',
            'TREG 5' => 'TREG 5',
            'TREG 6' => 'TREG 6',
            'TREG 7' => 'TREG 7',
        ];
    }
}
