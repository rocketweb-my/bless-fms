<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookupStatusLog extends Model
{
    use HasFactory;
    
    protected $table = "lookup_status_log";
    protected $guarded = ['id'];
    
    protected $fillable = [
        'nama',
        'deskripsi',
        'color',
        'order',
        'is_active',
        'created_by',
        'updated_by'
    ];
}
