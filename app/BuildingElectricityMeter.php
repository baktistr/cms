<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

class BuildingElectricityMeter extends Model
{
    use Actionable, SoftDeletes;

    /**
     * An electirity belongs to building.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    /**
     * Daily consumption for building electricity meters.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dailyConsumptions(): HasMany
    {
        return $this->hasMany(BuildingDailyElectricityConsumption::class, 'building_electricity_meter_id');
    }
}
