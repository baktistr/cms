<?php

namespace App;

use App\Events\DieselFuelConsumptionCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BuildingDieselFuelConsumption extends Model implements HasMedia
{
    use InteractsWithMedia, Actionable, SoftDeletes;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * @var string[] $type
     */
    public static $type = [
        'incoming' => 'Incoming Diesel Fuel',
        'remain'   => 'Remain Diesel Fuel',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => DieselFuelConsumptionCreated::class,
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
     * Get formatted total remain fuel attribute.
     *
     * @return string
     */
    public function getTotalRemainFuelAttribute()
    {
        return "{$this->total_remain} liters";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    /**
     * Register the media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile();
    }
}
