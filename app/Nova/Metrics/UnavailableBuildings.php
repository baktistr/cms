<?php

namespace App\Nova\Metrics;

use App\Building;
use App\BuildingSpace;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class UnavailableBuildings extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        if ($request->user()->hasRole('PIC')) {
            $space =  Building::where('pic_id', $request->user()->id)->with('spaces')->first();
            return $this->result(
                $space->spaces->where('is_available', false)->count()
            )->allowZeroResult();
        }

        return $this->result(BuildingSpace::where('is_available', false)->count())
            ->allowZeroResult();
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'unavailable-gedung';
    }

    public function name()
    {
        return 'Gedung Yang Tidak Tersedia';
    }
}
