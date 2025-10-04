<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;

    protected $fillable = ['gesture_id','user_id','body'];

    public function gesture() {
        return $this->belongsTo(Gesture::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
