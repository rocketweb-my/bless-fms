<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\OtpMail;

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

    public function otps()
    {
        return $this->hasMany(PicOtp::class);
    }

    public function kementerian()
    {
        return $this->belongsTo(LookupKementerian::class, 'kementerian_id');
    }

    public function agensi()
    {
        return $this->belongsTo(LookupAgensi::class, 'agensi_id');
    }

    /**
     * Generate and send OTP to PIC email
     */
    public function generateOtp()
    {
        $otp = rand(100000, 999999);

        // Create new OTP record with hashed OTP
        PicOtp::create([
            'person_in_charge_id' => $this->id,
            'otp_hash' => Hash::make($otp),
            'expires_at' => now()->addMinutes(10), // OTP valid for 10 minutes
        ]);

        // Update last OTP request timestamp
        $this->last_otp_request = now();
        $this->save();

        // Send OTP via email
        Mail::to($this->email)->send(new OtpMail($this, $otp));

        return $otp;
    }

    /**
     * Verify OTP
     */
    public function verifyOtp($otp)
    {
        // Get the latest valid OTP
        $picOtp = $this->otps()
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if ($picOtp && $picOtp->verifyOtp($otp)) {
            // Mark OTP as used
            $picOtp->markAsUsed();
            return true;
        }

        return false;
    }
}
