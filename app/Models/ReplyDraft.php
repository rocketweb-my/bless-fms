<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyDraft extends Model
{
    use HasFactory;

    protected $table = "reply_drafts";
    protected $guarded = ['id'];
    public $timestamps = false;
}
