<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipsterApplication extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'contact',
        'experience',
        'sports',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
