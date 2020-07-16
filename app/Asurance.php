<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asurance extends Model
{

    protected $casts = [
        'date_start'    => 'date',
        'date_expired'  => 'date',
    ];

    /**
     * A Asurance BelongsTo Asset
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
