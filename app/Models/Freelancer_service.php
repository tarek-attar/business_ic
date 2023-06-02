<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Freelancer_service extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'category_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class)->withDefault();
    }
    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }
}
