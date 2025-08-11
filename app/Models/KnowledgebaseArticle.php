<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgebaseArticle extends Model
{
    use HasFactory;

    protected $table = "kb_articles";
    protected $guarded = ['id'];
    public $timestamps = false;

    public function category()
    {
        return $this->hasOne('App\Models\KnowledgebaseCategory','id', 'catid');
    }

}
