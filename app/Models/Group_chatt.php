<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group_chat extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'message',
        'notic',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
