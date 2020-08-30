<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

class BuildingElectricityConsumption extends Model
{
    use Actionable, SoftDeletes;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get formatted date attribute.
     *
     * @return mixed
     */
    public function getFormattedDateAttribute()
    {
        return $this->date->format('d F Y');
    }

    /**
     * Total eletric meter.
     *
     * @return int
     */
    public function getTotalElectricMeterAttribute()
    {
        return number_format($this->totalElectricMeter()) . ' KWh';
    }

    /**
     * Total WBP gauge.
     *
     * @return int
     */
    public function getTotalWbpGaugeAttribute()
    {
        return number_format($this->totalWbpGauge()) . ' KWh';
    }

    /**
     * Total LWBP gauge.
     *
     * @return int
     */
    public function getTotalLwbpGaugeAttribute()
    {
        return number_format($this->totalLwbpGauge()) . ' KWh';
    }

    /**
     * Total KVAr.
     *
     * @return int
     */
    public function getTotalKvarAttribute()
    {
        return number_format($this->totalKvar()) . ' KWh';
    }

    /**
     * Total Cost.
     *
     * @return int
     */
    public function getTotalCostAttribute()
    {
        return 'Rp.' . number_format($this->totalCost());
    }

    /**
     * Total electric meter.
     *
     * @return int|mixed
     */
    public function totalElectricMeter()
    {
        return (int)$this->dailyConsumptions()->sum('electric_meter');
    }

    /**
     * Total WBP Gauge.
     *
     * @return int|mixed
     */
    public function totalWbpGauge()
    {
        return (int)$this->dailyConsumptions()->sum('wbp');
    }

    /**
     * Total LWBP Gauge.
     *
     * @return int|mixed
     */
    public function totalLwbpGauge()
    {
        return (int)$this->dailyConsumptions()->sum('lwbp');
    }

    /**
     * Total KVAr.
     *
     * @return int|mixed
     */
    public function totalKvar()
    {
        return (int)$this->dailyConsumptions()->sum('kvar');
    }

    /**
     * Get daily total cost.
     *
     * @return int
     */
    public function totalCost()
    {
        $totalCost = collect([]);

        $this->dailyConsumptions->each(function ($consumption) use ($totalCost) {
            return $totalCost->add($consumption->totalCost());
        });

        return $totalCost->sum();
    }

    /**
     * A electricity belongTo building.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    /**
     * A electricity consumption can have many daily consuption.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dailyConsumptions(): HasMany
    {
        return $this->hasMany(BuildingDailyElectricityConsumption::class, 'building_electricity_consumption_id');
    }
}
