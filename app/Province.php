<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Province extends Model
{
    /**
     * @inheritDoc
     */
    public $incrementing = false;

    /**
     * A province can have many regencies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function regencies(): HasMany
    {
        return $this->hasMany(Regency::class, 'province_id');
    }

    /**
     * A province can have many area.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function area(): HasMany
    {
        return $this->hasMany(Area::class, 'province_id');
    }

    /**
     * A province can have many assets.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function assets(): HasManyThrough
    {
        return $this->hasManyThrough(Asset::class, Area::class);
    }

    /**
     * Get all of the districts for the province.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function districts(): HasManyThrough
    {
        return $this->hasManyThrough(District::class, Regency::class);
    }
}
