<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EventProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_name',
        'event_date',
        'budget',
        'people',
        'venue_id',
        'description',
        'status',
        'admin_feedback',
        'is_published',
    ];

    /* =======================
     * RELATIONSHIPS
     * ======================= */

    /**
     * Event belongs to a user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Event belongs to a venue
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    /**
     * Event has many activities (pivot table)
     */
    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(
            Activity::class,
            'activity_event_proposal',
            'event_proposal_id',
            'activity_id'
        )->withTimestamps();
    }

    /**
     * Event has many ratings
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(EventRating::class, 'event_proposal_id');
    }

    /**
     * Event has many reviews
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(EventReview::class, 'proposal_id');
    }
}
