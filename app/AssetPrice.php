<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetPrice extends Model
{
    /**
     * {@inheritDoc}
     */
    public static $types = [
        'hourly'  => '/jam',
        'daily'   => '/hari',
        'monthly' => '/bulan',
        'yearly'  => '/tahun',
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
     * An asset price belongs to asset.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
