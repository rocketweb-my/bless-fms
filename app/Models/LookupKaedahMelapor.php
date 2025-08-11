<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookupKaedahMelapor extends Model
{
    use HasFactory;
    
    protected $table = "lookup_kaedah_melapor";
    protected $guarded = ['id'];
    
    protected $fillable = [
        'nama',
        'deskripsi',
        'is_active',
        'created_by',
        'updated_by'
    ];
}
