<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SettingEmail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "setting_email";
    protected $guarded = ['id'];
    public $timestamps = false;
}
