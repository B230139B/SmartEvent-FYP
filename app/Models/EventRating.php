<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRating extends Model
{
    use HasFactory;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'event_proposal_id',
        'user_id',
        'rating',
        'comment', // optional rating comment
    ];

    /**
     * Relationship: rating belongs to an event proposal
     */
    public function proposal()
    {
        return $this->belongsTo(EventProposal::class, 'event_proposal_id');
    }

    /**
     * Alias for clarity (optional)
     * Allows: $rating->event
     */
    public function event()
    {
        return $this->belongsTo(EventProposal::class, 'event_proposal_id');
    }

    /**
     * Relationship: rating belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
