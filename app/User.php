<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Nova\Actions\Actionable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use Notifiable, Actionable, SoftDeletes, InteractsWithMedia, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'address',
        'phone_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * User Can impersonate
     *
     * @return Boolean
     */
    public function canImpersonate()
    {
        return $this->hasRole('Super Admin');
    }

    /**
     * A user can have many assets to manage.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function buildings(): HasMany
    {
        return $this->hasMany(Building::class, 'pic_id');
    }

    /**
     * A user can have many asset categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assignedCategories(): BelongsToMany
    {
        return $this->belongsToMany(AssetCategory::class, 'asset_category_user', 'user_id', 'asset_category_id')
            ->withTimestamps();
    }

    /**
     * Register the media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->registerMediaConversions(function () {
                $this->addMediaConversion('tiny')
                    ->fit(Manipulations::FIT_CROP, 75, 75)
                    ->performOnCollections('avatar')
                    ->nonQueued();

                $this->addMediaConversion('small')
                    ->fit(Manipulations::FIT_CROP, 150, 150)
                    ->performOnCollections('avatar');

                $this->addMediaConversion('medium')
                    ->fit(Manipulations::FIT_CROP, 300, 300)
                    ->performOnCollections('avatar');

                $this->addMediaConversion('large')
                    ->fit(Manipulations::FIT_CROP, 600, 600)
                    ->performOnCollections('avatar');
            });
    }
}
