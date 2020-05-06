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
    public static $priceTypes = [
        'hourly'  => '/jam',
        'daily'   => '/hari',
        'monthly' => '/bulan',
        'yearly'  => '/tahun',
    ];

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
     * Register the media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image');
    }
}
