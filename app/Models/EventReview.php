<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventReview extends Model
{
    protected $fillable = [
        'proposal_id',
        'user_id',
        'rating',
        'review'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function proposal()
    {
        return $this->belongsTo(EventProposal::class, 'proposal_id');
    }
}
