<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaDisputeHistory extends Model
{
    use SoftDeletes;

    /**
     * Asset Dispute History BelongsTo Asset
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(Building::class , 'area_id');
    }
}
