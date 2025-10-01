<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonInCharge extends Model
{
    protected $table = 'person_in_charge';

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'kementerian_id',
        'agensi_id',
        'last_otp_request',
        'status',
    ];

    protected $casts = [
        'last_otp_request' => 'datetime',
    ];
}
