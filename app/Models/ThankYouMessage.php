<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThankYouMessage extends Model
{
    use HasFactory;

    protected $table = "thank_you_messages";
    protected $guarded = ['id'];
    public $timestamps = false;
}
