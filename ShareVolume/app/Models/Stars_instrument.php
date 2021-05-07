<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stars_instrument extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'stars', 'liked_instrument_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function instruments(){
        return $this->belongsTo('app/Models/Instrument');
    }
}
