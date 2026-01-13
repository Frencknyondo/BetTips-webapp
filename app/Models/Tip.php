<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'company',
        'bet_code',
        'odds',
        'stake',
        'tip_type',
        'price',
        'validity_time',
        'body',
        'link',
        'image_path',
        'is_active',
        'starts_at',
        'ends_at',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get ratings for this tip
     */
    public function ratings()
    {
        return $this->hasMany(TipRating::class);
    }

    /**
     * Get access codes for this tip
     */
    public function accessCodes()
    {
        return $this->hasMany(AccessCode::class);
    }
}
