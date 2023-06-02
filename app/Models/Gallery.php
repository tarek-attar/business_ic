<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'title_en',
        'title_ar',
        'description_en',
        'description_ar',
        'minimized_picture',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
    public function gallery_images()
    {
        return $this->hasMany(Gallery_image::class);
    }
}
