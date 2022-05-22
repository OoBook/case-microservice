<?php

namespace App\Models;

use App\Enum\AddressCityEnum;
use Jenssegers\Mongodb\Eloquent\Model;

class Address extends Model
{
    protected $connection = "mongodb";

    // public const CITIES = [
    //     'ISTANBUL'     => 1,
    //     'ANKARA'    => 2,
    //     'IZMIR'    => 3
    //  ];

    protected $fillable = [
        'id',
        'city',
        'address'
    ];

    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'city' => AddressCityEnum::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
