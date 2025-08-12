<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = "users";
    protected $guarded = ['id'];
    public $timestamps = false;

    // Relationship with Kumpulan Pengguna
    public function kumpulanPengguna()
    {
        return $this->belongsTo(LookupKumpulanPengguna::class, 'kumpulan_pengguna_id');
    }
}
