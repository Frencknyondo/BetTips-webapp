<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    protected $fillable = ['follower_id', 'followed_id'];

    /**
     * The user who is following
     */
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    /**
     * The user being followed
     */
    public function followed()
    {
        return $this->belongsTo(User::class, 'followed_id');
    }
}
