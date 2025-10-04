<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gesture extends Model
{
    /** @use HasFactory<\Database\Factories\GestureFactory> */
    use HasFactory;

    protected $fillable = ['slug','created_by','canonical_language_code'];

    public function translations() {
        return $this->hasMany(GestureTranslation::class);
    }

    public function author() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
