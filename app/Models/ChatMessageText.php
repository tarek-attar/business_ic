<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessageText extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'notic',
        'chat_name',
    ];
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
    public function receiver()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
    public function room()
    {
        return $this->belongsTo(ChatRoom::class)->withDefault();
    }
}
