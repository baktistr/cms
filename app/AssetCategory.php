<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Actions\Actionable;

class AssetCategory extends Model
{
    use Actionable, SoftDeletes;

    /**
     * An asset category can have many admins.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assignedAdmins(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'asset_category_user', 'asset_category_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * A category can have many assets.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class, 'asset_category_id');
    }
}
