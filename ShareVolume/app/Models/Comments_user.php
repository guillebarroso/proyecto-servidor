<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments_user extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'comment', 'commented_user_id',
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
}
