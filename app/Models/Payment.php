<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'job_id',
        'amount',
        'company_ratio',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
    public function receiver()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
    public function job()
    {
        return $this->belongsTo(Job::class)->withDefault();
    }
}
