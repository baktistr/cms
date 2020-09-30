<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuildingFloor extends Model
{
    use SoftDeletes;

    /**
     * Get formatted building floor.
     *
     * @return string
     */
    public function getFormattedFloorAttribute()
    {
        return "Lantai {$this->floor}";
    }

    /**
     * Building floor BelongsTo Asset
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class , 'building_id');
    }
}
