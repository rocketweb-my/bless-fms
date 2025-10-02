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

    public function status_lookup()
    {
        return $this->belongsTo('App\Models\LookupStatusLog','status','id');
    }

    public function getStatusDetailAttribute()
    {
        $statusLookup = $this->status_lookup;
        return $statusLookup ? $statusLookup->nama : 'New';
    }

    public function getPriorityDetailAttribute()
    {
        return getPriorityName($this->priority) ?: 'Unknown';
    }

    public function lesen()
    {
        return $this->belongsTo('App\Models\LookupLesen', 'lesen_id', 'id');
    }

    public function kementerian()
    {
        return $this->belongsTo('App\Models\LookupKementerian', 'kementerian_id', 'id');
    }

    public function agensi()
    {
        return $this->belongsTo('App\Models\LookupAgensi', 'agensi_id', 'id');
    }

    public function pic()
    {
        return $this->belongsTo('App\Models\PersonInCharge', 'pic_id', 'id');
    }

    public function ticketType()
    {
        return $this->belongsTo('App\Models\TicketType', 'ticket_type_id', 'id');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\User', 'vendor_id', 'id');
    }
}
