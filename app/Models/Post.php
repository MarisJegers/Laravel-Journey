<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'user_id'
    ];

    /* šie posti pieder vienam lietotājam */
    public function user()
    {
        //return $this->belongsTo(User::class, 'id', 'user_id');
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
