<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Asset extends Model implements HasMedia
{
    use Actionable, SoftDeletes, InteractsWithMedia;

    /**
     * {@inheritDoc}
     */
    protected $casts = [
        'is_available' => 'boolean',
    ];

    /**
     * {@inheritDoc}
     */
    public static $types = [
        'rent' => 'Sewa',
        'sale' => 'Jual',
    ];

    /**
     * Get formatted price on rupiah.
     *
     * @return string
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp.' . number_format($this->price);
    }

    /**
     * Scope a query to only include available assets.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * An asset belongs to pic user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_id');
    }

    /**
     * An asset belongs to location code.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    /**
     * An asset can have many prices.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prices(): HasMany
    {
        return $this->hasMany(AssetPrice::class, 'asset_id');
    }

    /**
     * A building can have many spaces.
     *
     * @return HasMany
     */
    public function spaces(): HasMany
    {
        return $this->hasMany(BuildingSpace::class, 'asset_id');
    }

    /**
     * A building can have many certificates.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(AssetCertificate::class, 'asset_id');
    }

    /**
     * Asset Has Many Asset Pbb.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assetPbbs(): HasMany
    {
        return $this->hasMany(AssetPbb::class, 'asset_id');
    }

     /**
     * A building can have many Asset disputes Histories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function disputeHistories(): HasMany
    {
        return $this->hasMany(AssetDisputeHistory::class, 'asset_id');

    }

    /**
     * Asset can have many other documents.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function otherDocuments(): HasMany
    {
        return $this->hasMany(AssetOtherDocument::class, 'asset_id');
    }

    /**
     * Asset can have many floors.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function floors(): HasMany
    {
        return $this->hasMany(AssetFloor::class, 'asset_id');
    }

    /**
     * Asset can have many PLN ID.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plns(): HasMany
    {
        return $this->hasMany(AssetPln::class, 'asset_id');
    }
    /**
     * Asset can have many Assurance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function insurances(): HasMany
    {
        return $this->hasMany(Insurance::class, 'asset_id');
    }

    /**
     * Register the media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->onlyKeepLatest(10)
            ->registerMediaConversions(function () {
                $this->addMediaConversion('thumbnail')
                    ->fit(Manipulations::FIT_CROP, 160, 105)
                    ->performOnCollections('image')
                    ->nonQueued();
            });
    }
}
