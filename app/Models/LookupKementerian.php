<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookupKementerian extends Model
{
    use HasFactory;
    
    protected $table = "lookup_kementerian";
    protected $guarded = ['id'];
    
    protected $fillable = [
        'nama',
        'deskripsi',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public function agensi()
    {
        return $this->hasMany(LookupAgensi::class, 'kementerian_id');
    }
}
