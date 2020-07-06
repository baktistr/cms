<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuildingSpacePrice extends Model
{
    /**
     * {@inheritDoc}
     */
    public static $types = [
        'hourly'  => '/jam',
        'daily'   => '/hari',
        'weekly'  => '/minggu',
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
    public function buildingSpace(): BelongsTo
    {
        return $this->belongsTo(BuildingSpace::class, 'building_space_id');
    }
}
