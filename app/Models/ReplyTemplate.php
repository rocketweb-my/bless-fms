<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyTemplate extends Model
{
    use HasFactory;
    protected $table = "std_replies";
    protected $guarded = ['id'];
    public $timestamps = false;
}
