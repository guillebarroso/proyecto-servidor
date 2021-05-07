<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rented_instrument extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id', 'instrument_id', 'customer_id', 'initial_date', 'return_date'
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

    public function instruments(){
        return $this->belongsTo('app/Models/Instruments');
    }
}
