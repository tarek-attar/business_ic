<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job_file extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'file_name',
        'connection_token',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class)->withDefault();
    }
}
