<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'chat_room_id',
        'user_id',
        'message',
        'notic',
        'privet_key',
    ];

    public function room()
    {
        return $this->hasOne(ChatRoom::class, 'id', 'chat_room_id');
    }
    public function user()
    {
        //return $this->hasOne(User::class, 'id', 'user_id');
        return $this->belongsTo(User::class);
    }
}
