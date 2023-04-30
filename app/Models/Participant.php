<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;
    protected $fillable = [
        'chat_room_id',
        'user_id',
        'role',
    ];

    /*  public function chatRoom()
    {
        return $this->belongsTo(ChatRoom::class);
    } */
}
