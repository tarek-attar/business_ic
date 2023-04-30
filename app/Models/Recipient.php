<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'message_id',
        'read_at',
        'chat_room_id',
    ];
}
