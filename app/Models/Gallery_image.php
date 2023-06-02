<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery_image extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'gallery_id',
        'image',

    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class)->withDefault();
    }
}
