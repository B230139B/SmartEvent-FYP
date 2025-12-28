<?php

namespace App\Http\Controllers;

use App\Models\EventProposal;
use App\Models\EventRating;
use App\Models\EventReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    /**
     * ==========================================================
     * COMMUNITY INDEX PAGE
     * - Shows approved & published events only
     * ==========================================================
     */
    public function index()
    {
        $events = EventProposal::with([
                'ratings',   // ✅ IMPORTANT
                'user'
            ])
            ->where('status', 'Approved')
            ->where('is_published', true)
            ->latest()
            ->get();

        return view('community.index', compact('events'));
    }

    /**
     * ==========================================================
     * SHOW A SINGLE COMMUNITY EVENT
     * ==========================================================
     */
    public function show(EventProposal $event)
    {
        // Block access to unpublished or unapproved events
        if ($event->status !== 'Approved' || !$event->is_published) {
            abort(403, 'This event is not available.');
        }

        // Load related data
        $event->load([
            'reviews.user',
            'ratings.user'
        ]);

        // Rating summary (safe)
        $averageRating = round($event->ratings()->avg('rating') ?? 0, 1);
        $ratingCount  = $event->ratings()->count();

        // Check if current user already rated
        $userRating = null;
        if (Auth::check()) {
            $userRating = $event->ratings()
                ->where('user_id', Auth::id())
                ->first();
        }

        return view('community.show', compact(
            'event',
            'averageRating',
            'ratingCount',
            'userRating'
        ));
    }

    /**
     * ==========================================================
     * USER — RATE & REVIEW EVENT
     * ==========================================================
     */
    public function rate(Request $request, EventProposal $event)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($event->user_id === Auth::id()) {
            return back()->with('error', 'You cannot rate your own event.');
        }

        if ($event->status !== 'Approved' || !$event->is_published) {
            return back()->with('error', 'This event cannot be rated.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500'
        ]);

        EventRating::updateOrCreate(
            [
                'event_proposal_id' => $event->id,
                'user_id'           => Auth::id(),
            ],
            [
                'rating' => $request->rating
            ]
        );

        if ($request->filled('review')) {
            EventReview::updateOrCreate(
                [
                    'proposal_id' => $event->id,
                    'user_id'     => Auth::id()
                ],
                [
                    'rating' => $request->rating,
                    'review' => $request->review
                ]
            );
        } else {
            EventReview::where('proposal_id', $event->id)
                ->where('user_id', Auth::id())
                ->delete();
        }

        return back()->with('success', 'Thank you for your feedback!');
    }

    /**
     * ==========================================================
     * ADMIN — PUBLISH EVENT
     * ==========================================================
     */
    public function publish(EventProposal $event)
    {
        if ($event->status !== 'Approved') {
            return back()->with('error', 'Only approved events can be published.');
        }

        $event->update([
            'is_published' => true
        ]);

        return back()->with('success', 'Event published to community.');
    }

    /**
     * ==========================================================
     * ADMIN — UNPUBLISH EVENT
     * ==========================================================
     */
    public function unpublish(EventProposal $event)
    {
        $event->update([
            'is_published' => false
        ]);

        return back()->with('success', 'Event unpublished successfully.');
    }
}
