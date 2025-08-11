<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomScript extends Model
{
    use HasFactory;

    protected $table = "custom_scripts";
    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'boolean',
    ];
}
