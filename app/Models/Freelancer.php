<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Freelancer extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'status',
        'category_id',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }
    public function freelancer_service()
    {
        return $this->hasMany(Freelancer_service::class);
    }
    public function freelancer_id()
    {
        return $this->hasMany(Freelancer_id::class);
    }
}
