<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestureTranslation extends Model
{
    /** @use HasFactory<\Database\Factories\GestureTranslationFactory> */
    use HasFactory;

    protected $fillable = ['gesture_id','language_code','title','description','video_path'];

    public function gesture() {
        return $this->belongsTo(Gesture::class);
    }
}
