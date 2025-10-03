<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftTicket extends Model
{
    use HasFactory;

    protected $table = "draft_tickets";
    protected $guarded = ['id'];

    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function category_detail()
    {
        return $this->belongsTo('App\Models\Category', 'category', 'id');
    }

    public function sub_category_detail()
    {
        return $this->belongsTo('App\Models\SubCategory', 'sub_category', 'id');
    }
}
