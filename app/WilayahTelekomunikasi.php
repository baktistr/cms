<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class WilayahTelekomunikasi extends Model
{
    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    /**
     * A wilayah telekomunikasi can have many area.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function areas(): HasMany
    {
        return $this->hasMany(Area::class, 'witel_id');
    }

    /**
     * A wilayah telekomunikasi can have many assets.
     *
     */
    public function buildings(): HasManyThrough
    {
        return $this->hasManyThrough(Building::class, Area::class, 'witel_id');
    }
}
