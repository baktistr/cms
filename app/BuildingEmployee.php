<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Nova\Actions\Actionable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BuildingEmployee extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Actionable;

    /**
     * {@inheritDoc}
     */
    protected $casts = [
        'birth_date' => 'date'
    ];

    /**
     * A Employee Belongs To Building
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    /**
     * An employee can have many attendances.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'employee_id');
    }

    /**
     * Get formatted date attribute.
     *
     * @return mixed
     */
    public function getFormattedBirthDateAttribute()
    {
        return $this->birth_date->format('d F Y');
    }

    /**
     * Get attendance today attribute.
     *
     * @return string
     */
    public function getAttendanceTodayAttribute()
    {
        $attendanceToday = $this->attendances()
            ->where('date', now()->format('Y-m-d'))
            ->first();

        if ($attendanceToday) {
            $desc = $attendanceToday->desc ? ' ('.Str::limit($attendanceToday->desc, 50).')' : null;

            return Attendance::$statuses[$attendanceToday->status] . $desc;
        }

        return 'Not yet';
    }

    /**
     * Register the media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')
            ->singleFile()
            ->registerMediaConversions(function () {
                $this->addMediaConversion('tiny')
                    ->fit(Manipulations::FIT_CROP, 75, 75)
                    ->performOnCollections('photo')
                    ->nonQueued();

                $this->addMediaConversion('small')
                    ->fit(Manipulations::FIT_CROP, 150, 150)
                    ->performOnCollections('photo')
                    ->nonQueued();

                $this->addMediaConversion('medium')
                    ->fit(Manipulations::FIT_CROP, 300, 300)
                    ->performOnCollections('photo')
                    ->nonQueued();

                $this->addMediaConversion('large')
                    ->fit(Manipulations::FIT_CROP, 600, 600)
                    ->performOnCollections('photo')
                    ->nonQueued();
            });
    }
}
