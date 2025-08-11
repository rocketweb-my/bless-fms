<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $table = "notes";
    protected $guarded = ['id'];
    public $timestamps = false;

    public function noteby()
    {
        return $this->hasOne('App\Models\User','id','who');
    }
}
