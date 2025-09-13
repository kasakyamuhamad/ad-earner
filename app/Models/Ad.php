<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'reward_amount',
        'view_duration',
        'cooldown_minutes',
        'embed_code',
        'payout',
        'is_active',
    ];

    /**
     * Relationship: ad views by users
     */
    public function adViews(): HasMany
    {
        return $this->hasMany(AdView::class);
    }
}
