<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tenant extends Model
{
    /**
     * Casting to date
     * @var array
     */
    protected $casts = [
        'period_start' => 'date',
        'period_end'   => 'date',
    ];

    /**
     * Status perusahaan
     *
     * @var array
     */
    public static $companyStatus = [
        'Ada' => 'Ada', // @muhghazaliakbar is require
    ];

    /**
     * Objek Sewa
     *
     * @var array
     */
    public static $objectRent = [
        'Lahan/Tanah'    => 'Lahan/Tanah',
        'Tanah & Gedung' => 'Tanah & Gedung',
    ];

    /**
     * Objek Sewa
     *
     * @var array
     */
    public static $statusMakeContract = [
        'Kontrak Terpusat' => 'Kontrak Terpusat',
        'Kontrak Area'     => 'Kontrak Area',
    ];

    /**
     * Objek Sewa
     *
     * @var array
     */
    public static $phisycalCheckContract = [
        'Tidak Ada' => 'Tidak Ada',
        'Ada'       => 'Ada',
    ];

    /**
     * A Tenant Belongs To building
     *
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gedung(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'building_id');
    }
}
