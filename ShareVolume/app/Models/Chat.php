<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_user_id', 'reciever_user_id', 'message',
    ];

    protected $hidden = [
    ];

    public function users(){
        return $this->belongsTo('app/Models/User');
    }
}
