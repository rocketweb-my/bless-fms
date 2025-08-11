<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgebaseCategory extends Model
{
    use HasFactory;

    protected $table = "kb_categories";
    protected $guarded = ['id'];
    public $timestamps = false;
}
