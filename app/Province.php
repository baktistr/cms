<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
