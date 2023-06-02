<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tell_me extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'last_job',
        'number_of_jobs',
        'vip',
        'note',
    ];
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class)->withDefault();
    }
    public function freelancer_services()
    {
        return $this->hasMany(Freelancer_service::class)->withDefault();
    }
    public function service()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }
}
