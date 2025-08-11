<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookupLesen extends Model
{
    use HasFactory;

    protected $table = 'lookup_lesen';
    
    protected $fillable = [
        'nama',
        'penerangan',
        'kementerian_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship with Kementerian
    public function kementerian()
    {
        return $this->belongsTo(LookupKementerian::class, 'kementerian_id');
    }
}
