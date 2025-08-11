<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookupKumpulanPengguna extends Model
{
    use HasFactory;
    
    protected $table = "lookup_kumpulan_pengguna";
    protected $guarded = ['id'];
    
    protected $fillable = [
        'nama',
        'deskripsi',
        'is_active',
        'created_by',
        'updated_by'
    ];
}
