<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $table = "sub_categories";
    protected $guarded = ['id'];
    public $timestamps = false;

    public function tickets()
    {
        return $this->hasMany('App\Models\Ticket','sub_category','id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category','category_id','id');
    }
}