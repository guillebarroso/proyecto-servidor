<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments_instrument extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'comment', 'commented_instrument_id',
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
