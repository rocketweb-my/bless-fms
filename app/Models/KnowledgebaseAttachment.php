<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgebaseAttachment extends Model
{
    use HasFactory;

    protected $table = "kb_attachments";
    protected $guarded = ['att_id'];
    public $timestamps = false;

}
