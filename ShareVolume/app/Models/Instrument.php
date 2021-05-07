<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'type', 'starting_price', 'description', 'rented', 'initial_date', 'return_date', 'image',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function users(){
        return $this->belongsTo('app/Models/User');
    }

    public function comments_instruments(){
        return $this->hasMany('app/Models/Comments_instruments');
    }

    public function stars_instruments(){
        return $this->hasMany('app/Models/Stars_instruments');
    }

    public function rented_instruments(){
        return $this->hasMany('app/Models/Rented_instruments');
    }
}
