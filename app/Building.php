<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Building extends Model implements HasMedia
{
    use Actionable, SoftDeletes, InteractsWithMedia;

    /**
     * An asset belongs to pic user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_id');
    }

    /**
     * An asset belongs to location code.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    /**
     * A building can have many spaces.
     *
     * @return HasMany
     */
    public function spaces(): HasMany
    {
        return $this->hasMany(BuildingSpace::class, 'building_id');
    }

    /**
     * A building can have many tenants.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tenants(): HasMany
    {
        return $this->hasMany(BuildingTenant::class, 'building_id');
    }

    /**
     * A building can have many certificates.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function certificates()
    {
        return $this->area->certificates();
    }

    /**
     * Asset Has Many Asset Pbb.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pbbs(): HasMany
    {
        return $this->hasMany(BuildingPbb::class, 'building_id');
    }

    /**
     * Asset can have many other documents.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function otherDocuments(): HasMany
    {
        return $this->hasMany(BuildingOtherDocument::class, 'building_id');
    }

    /**
     * Asset can have many floors.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function floors(): HasMany
    {
        return $this->hasMany(BuildingFloor::class, 'building_id');
    }

    /**
     * Asset can have many PLN ID.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plns(): HasMany
    {
        return $this->hasMany(BuildingPLn::class, 'building_id');
    }

    /**
     * Asset can have many Assurance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function insurances(): HasMany
    {
        return $this->hasMany(BuildingInsurance::class, 'building_id');
    }

    /**
     * A building belongs to manager.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * A building can Have Many Employees
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees(): HasMany
    {
        return $this->hasMany(BuildingEmployee::class, 'building_id');
    }

    /**
     * A building can have many employee attendances.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(BuildingEmployeeAttendance::class, 'building_id');
    }

    /**
     * A building can assign many help-desks.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function helpDesks(): HasMany
    {
        return $this->hasMany(User::class, 'building_id')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Help Desk');
            });
    }

    /**
     * A building can have many complaints.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function complaints(): HasMany
    {
        return $this->hasMany(BuildingHelpDesk::class, 'building_id');
    }

    /**
     * Register the media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->onlyKeepLatest(10)
            ->registerMediaConversions(function () {
                $this->addMediaConversion('thumbnail')
                    ->fit(Manipulations::FIT_CROP, 160, 105)
                    ->performOnCollections('image');
            });
    }
}
