<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use ;

class GrantedUser extends Model
{
    use HasFactory;
    
    
    protected $fillable = [
        'fullname',
        'profile',
        'user_id',
        'granted_state'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}


