<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;
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
     * {@inheritDoc}
     */
    public static $priceTypes = [
        'hourly'  => '/jam',
        'daily'   => '/hari',
        'monthly' => '/bulan',
        'yearly'  => '/tahun',
    ];

    /**
     * Get formatted value on rupiah.
     *
     * @return string
     */
    public function getFormattedValueAttribute()
    {
        return 'Rp. ' . number_format($this->value);
    }

    /**
     * An asset belongs to asset category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(AssetCategory::class, 'asset_category_id');
    }

    /**
     * An asset belongs to admin user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * An asset belongs to province.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    /**
     * An asset belongs to regency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class, 'regency_id');
    }

    /**
     * An asset belongs to district.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    /**
     * Register the media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->onlyKeepLatest(10);
    }
}
