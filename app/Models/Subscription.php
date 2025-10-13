<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    /** @use HasFactory<\Database\Factories\SubscriprionFactory> */
    use HasFactory;

    protected $fillable = ['user_id','start_date','end_date','cancel_date','meta'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
