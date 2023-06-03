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
        'job_id',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class)->withDefault();
    }
}
