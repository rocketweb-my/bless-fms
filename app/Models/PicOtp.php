<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class PicOtp extends Model
{
    protected $fillable = [
        'person_in_charge_id',
        'otp_hash',
        'expires_at',
        'is_used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean',
    ];

    public function personInCharge()
    {
        return $this->belongsTo(PersonInCharge::class);
    }

    /**
     * Check if OTP is valid
     */
    public function isValid()
    {
        return !$this->is_used && $this->expires_at > now();
    }

    /**
     * Verify if provided OTP matches the hashed value
     */
    public function verifyOtp($otp)
    {
        return Hash::check($otp, $this->otp_hash);
    }

    /**
     * Mark OTP as used
     */
    public function markAsUsed()
    {
        $this->is_used = true;
        $this->save();
    }
}
