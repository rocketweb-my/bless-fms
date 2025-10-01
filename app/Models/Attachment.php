<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $table = 'attachments';
    protected $primaryKey = 'att_id';
    protected $guarded = ['att_id'];
    public $timestamps = false;

    protected $fillable = [
        'ticket_id',
        'saved_name',
        'real_name',
        'size'
    ];
}
