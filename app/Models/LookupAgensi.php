<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookupAgensi extends Model
{
    use HasFactory;
    
    protected $table = "lookup_agensi";
    protected $guarded = ['id'];
    
    protected $fillable = [
        'nama',
        'deskripsi',
        'kementerian_id',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public function kementerian()
    {
        return $this->belongsTo(LookupKementerian::class, 'kementerian_id');
    }

    public function subAgensi()
    {
        return $this->hasMany(LookupSubAgensi::class, 'agensi_id');
    }
}
