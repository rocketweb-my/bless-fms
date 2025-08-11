<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Model;

class Ea_User extends Model
{
    protected $table = "ea_users";
    protected $guarded = ['id'];
    protected $hidden = [
        'pass', 'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->pass;
    }
}
