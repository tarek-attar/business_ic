<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'user1',
        'user2',
    ];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }
}
