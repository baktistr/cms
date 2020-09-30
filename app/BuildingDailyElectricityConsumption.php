<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Nova\Actions\Actionable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BuildingDailyElectricityConsumption extends Model implements HasMedia
{
    use InteractsWithMedia, Actionable;

    /**
     * Get formatted LWBP gauge
     *
     * @return mixed
     */
    public function getFormattedElectricMeterAttribute()
    {
        return number_format($this->electric_meter) . ' KWh';
    }

    /**
     * Get formatted LWBP gauge
     *
     * @return mixed
     */
    public function getFormattedLwbpGaugeAttribute()
    {
        return number_format($this->lwbp) . ' KWh';
    }

    /**
     * Get formatted WBP gauge
     *
     * @return mixed
     */
    public function getFormattedWbpGaugeAttribute()
    {
        return number_format($this->wbp) . ' KWh';
    }

    /**
     * Get formatted LWBP rate
     *
     * @return mixed
     */
    public function getFormattedLwbpRateAttribute()
    {
        return 'Rp. ' . number_format($this->lwbp_rate);
    }

    /**
     * Get formatted WBP rate
     *
     * @return mixed
     */
    public function getFormattedWbpRateAttribute()
    {
        return 'Rp. ' . number_format($this->wbp_rate);
    }

    /**
     * Get formatted KVAr rate
     *
     * @return mixed
     */
    public function getFormattedKvarAttribute()
    {
        return number_format($this->kvar) . ' KVAr';
    }

    /**
     * Get formatted total LWBP cost
     *
     * @return mixed
     */
    public function getFormattedLwbpCostAttribute()
    {
        return 'Rp. ' . number_format($this->totalLWBPCost());
    }

    /**
     * Get formatted total WBP cost
     *
     * @return mixed
     */
    public function getFormattedWbpCostAttribute()
    {
        return 'Rp. ' . number_format($this->totalWBPCost());
    }

    /**
     * Get formatted total cost
     *
     * @return mixed
     */
    public function getFormattedTotalCostAttribute()
    {
        return 'Rp. ' . number_format($this->totalCost());
    }

    /**
     * Get total LWBP cost (Rp)
     *
     * @return int
     */
    public function totalLWBPCost(): int
    {
        return $this->lwbp * $this->lwbp_rate;
    }

    /**
     * Get total WBP cost (Rp)
     *
     * @return int
     */
    public function totalWBPCost(): int
    {
        return $this->wbp * $this->wbp_rate;
    }

    /**
     * Get total cost (Rp)
     *
     * @return int
     */
    public function totalCost(): int
    {
        return $this->totalLWBPCost() + $this->totalWBPCost();
    }

    /**
     * Electricity consumption relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function electricityConsumption(): BelongsTo
    {
        return $this->belongsTo(BuildingElectricityConsumption::class, 'electricity_consumption_id');
    }

    /**
     * A daily consumption belongs to building meter.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function buildingMeter(): BelongsTo
    {
        return $this->belongsTo(BuildingElectricityMeter::class, 'electricity_meter_id');
    }

    /**
     * Register the media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('wbp')
            ->singleFile();

        $this->addMediaCollection('lwbp')
            ->singleFile();
    }
}
