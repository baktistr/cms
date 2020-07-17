<?php

namespace App\Nova\Metrics;

use App\Asset;
use App\BuildingSpace;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;

class AvailableAssets extends Value
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
            $space =  Asset::where('pic_id', $request->user()->id)->with('spaces')->first();
            return $this->result(
                $space->spaces->where('is_available', true)->count()
            )->allowZeroResult();
        }

        return $this->result(BuildingSpace::where('is_available', true)->count())
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
        return 'available-assets';
    }

    public function name()
    {
        return 'Ketersedian Space Gedung';
    }
}
