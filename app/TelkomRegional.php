<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class TelkomRegional extends Model
{
    /**
     * A regional can have many areas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function areas(): HasMany
    {
        return $this->hasMany(Area::class, 'witel_id');
    }

    /**
     * A regional can have many assets.
     *
     */
    public function buildings(): HasManyThrough
    {
        return $this->hasManyThrough(Building::class, Area::class, 'telkom_regional_id');
    }
}
