<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities';

    protected $fillable = [
        'name',
        'description',
        'recommended_min_budget',
        'recommended_max_budget',
        'recommended_people_min',
        'recommended_people_max',
        'image',
    ];

    protected $casts = [
        'recommended_min_budget' => 'decimal:2',
        'recommended_max_budget' => 'decimal:2',
    ];

    /* =======================
     * Relationships
     * ======================= */

    /**
     * Activity belongs to many event proposals
     */
    public function eventProposals(): BelongsToMany
    {
        return $this->belongsToMany(
            EventProposal::class,
            'activity_event_proposal',
            'activity_id',
            'event_proposal_id'
        )->withTimestamps();
    }

    /* =======================
     * Accessors
     * ======================= */

    /**
     * Get formatted budget range
     * Usage: {{ $activity->budget_range }}
     */
    public function getBudgetRangeAttribute(): string
    {
        return 'RM ' . number_format($this->recommended_min_budget, 2)
            . ' - RM ' . number_format($this->recommended_max_budget, 2);
    }
}
