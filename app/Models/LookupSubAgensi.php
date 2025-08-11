<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookupSubAgensi extends Model
{
    use HasFactory;
    
    protected $table = "lookup_sub_agensi";
    protected $guarded = ['id'];
    
    protected $fillable = [
        'nama',
        'deskripsi',
        'agensi_id',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public function agensi()
    {
        return $this->belongsTo(LookupAgensi::class, 'agensi_id');
    }
}
