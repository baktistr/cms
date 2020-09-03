<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BuildingEquipmentCategory extends Model
{
    /**
     * An equipment category can have many equipments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipments(): HasMany
    {
        return $this->hasMany(BuildingEquipment::class, 'building_equipment_category_id');
    }

    /**
     * An equipment category can have many buildings.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'building_id');
    }
}
