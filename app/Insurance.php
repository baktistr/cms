<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Insurance extends Model
{
    use SoftDeletes ;

    /**
     * {@inheritDoc}
     */
    protected $casts = [
        'date_start'    => 'date',
        'date_expired'  => 'date',
    ];

    /**
     * A Insurance BelongsTo Asset
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
