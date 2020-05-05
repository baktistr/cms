<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
}
