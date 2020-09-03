<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

class BuildingHelpDesk extends Model
{
    use Actionable, SoftDeletes;

    public static $priority = [
        'Low'    => 'Low',
        'Medium' => 'Medium',
        'High'   => 'High',
    ];

    /**
     * Cast default value for attributes.
     *
     * @var string[] $attributes
     */
    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * Help-desk statuses.
     *
     * @var string[] $statuses
     */
    public static $statuses = [
        'pending'     => 'Pending',
        'in-progress' => 'In progress',
        'done'        => 'done'
    ];

    /**
     * Get formatted date attribute.
     *
     * @return mixed
     */
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d F Y');
    }

    /**
     * A Help desk can have one Category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BuildingHelpDeskCategory::class, 'help_desk_category_id');
    }

    /**
     * A Help-desk belongsTo Building
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    /**
     * A Help-desk Belongs To User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function helpDesk(): BelongsTo
    {
        return $this->belongsTo(User::class, 'help_desk_id');
    }
}
