<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name_en',
        'name_ar',
        'notic',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    /* public function categories()
    {
        return $this->belongsToMany(Category::class);
    } */
    public function jobs()
    {
        return $this->belongsToMany(Job::class);
    }

    public function freelancer_services()
    {
        return $this->hasMany(Freelancer_service::class);
    }
}
