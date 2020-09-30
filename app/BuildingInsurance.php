<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuildingInsurance extends Model
{
    use SoftDeletes;

    /**
     * {@inheritDoc}
     */
    protected $casts = [
        'date_start'    => 'date',
        'date_expired'  => 'date',
    ];

    /**
     * A Insurance BelongsTo Asset
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'building_id');
    }
}
