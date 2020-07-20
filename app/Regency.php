<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Regency extends Model
{
    /**
     * @inheritDoc
     */
    public $incrementing = false;

    /**
     * A regency belongs to province.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    /**
     * A regency can have many districts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function districts(): HasMany
    {
        return $this->hasMany(District::class, 'regency_id');
    }

    /**
     * A province can have many area.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function area(): HasMany
    {
        return $this->hasMany(Area::class, 'regency_id');
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
}
