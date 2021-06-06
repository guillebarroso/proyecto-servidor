<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'surname',
        'age',
        'email',
        'nickname',
        'location',
        'password',
        'description',
        'image',

    ];

    protected $hidden = [
        'password'
    ];

    public function instrument(){
        return $this->hasMany('app/Models/Instrument');
    }

    public function chats(){
        return $this->hasMany('app/Models/Chat');
    }

    public function comments_users(){
        return $this->hasMany('app/Models/Comments_users');
    }

    public function stars_users(){
        return $this->hasMany('app/Models/Stars_users');
    }

    public function rented_instruments(){
        return $this->hasMany('app/Models/Rented_instruments');
    }
}
