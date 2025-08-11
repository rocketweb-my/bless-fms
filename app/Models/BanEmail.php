<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanEmail extends Model
{
    use HasFactory;
    protected $table = "banned_emails";
    protected $guarded = ['id'];
    public $timestamps = false;
}
