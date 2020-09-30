<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BuildingEquipment extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $table = 'building_equipments';

    /**
     * The attributes that should be cast to native types.
     *
     *
     * @var array
     */
    protected $casts = [
        'date_installation' => 'date',
    ];

    /**
     * Get formatted date attribute.
     *
     * @return mixed
     */
    public function getFormattedDateAttribute()
    {
        return $this->date_installation->format('d F Y');
    }

    /**
     * An equipment belongs to one category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BuildingEquipmentCategory::class, 'building_equipment_category_id');
    }


    /**
     * An equipment belongs to one Building.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    /**
     * An Equipment has Many Histories
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function histories(): HasMany
    {
        return $this->hasMany(BuildingEquipmentHistory::class, 'building_equipment_id');
    }
}
