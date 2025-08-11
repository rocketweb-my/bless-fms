<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanIP extends Model
{
    use HasFactory;
    protected $table = "banned_ips";
    protected $guarded = ['id'];
    public $timestamps = false;
}
