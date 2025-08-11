<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = "tickets";
    protected $guarded = ['id'];
    public $timestamps = false;

    public function replies()
    {
        return $this->hasMany('App\Models\Reply','replyto','id');
    }

    public function note()
    {
        return $this->hasMany('App\Models\Note','ticket','id');
    }

    public function category_detail()
    {
        return $this->belongsTo('App\Models\Category','category','id');
    }

    public function owner_detail()
    {
        return $this->belongsTo('App\Models\User','owner','id');
    }

    public function getStatusDetailAttribute()
    {
        if($this->status == 0)
        {
            return 'New';
        }elseif($this->status == 1)
        {
            return 'Waiting Reply';
        }elseif($this->status == 2)
        {
            return 'Replied';
        }elseif($this->status == 3)
        {
            return 'Resolved';
        }elseif($this->status == 4)
        {
            return 'In Progress';
        }elseif($this->status == 5)
        {
            return 'On Hold';
        }
    }

    public function getPriorityDetailAttribute()
    {
        return getPriorityName($this->priority) ?: 'Unknown';
    }
}
