<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuildingProcurement extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $casts = [
        'date_of_problem'       => 'date',
        'date_of_problem_fixed' => 'date',
    ];

    /**
     * @var string[] $type
     */
    public static $type = [
        'corrective' => 'Corrective',
        'preventive' => 'Preventive',
    ];

    /**
     * BelongsTo Equipments
     * 
     * @return BelongsTo
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(BuildingEquipment::class, 'building_equipment_id');
    }

    /**
     * Get formatted date date_of_problem attribute.
     *
     * @return mixed
     */
    public function getFormattedProblemAttribute()
    {
        return $this->date_of_problem->format('d F Y');
    }

    /**
     * Get Formatted date_of_problem_fixed Attribute
     *
     * @return mixed
     */
    public function getFormattedFixedAttribute()
    {
        return $this->date_of_problem_fixed->format('d F Y');
    }

    /**
     * Get formatted LWBP rate
     *
     * @return mixed
     */
    public function getFormattedCostAttribute()
    {
        return 'Rp. ' . number_format($this->cost);
    }
}
