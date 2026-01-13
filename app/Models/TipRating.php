<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipRating extends Model
{
    protected $fillable = ['user_id', 'tip_id', 'rating', 'comment'];

    protected $casts = [
        'rating' => 'string',
    ];

    /**
     * The user who made the rating
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The tip being rated
     */
    public function tip()
    {
        return $this->belongsTo(Tip::class);
    }
}
