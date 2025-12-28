<?php

namespace App\Http\Controllers;

use App\Models\EventProposal;
use App\Models\Venue;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventProposalController extends Controller
{
    /* =======================
     * USER
     * ======================= */

    public function create()
    {
        $venues = Venue::orderBy('name')->get();
        $activities = Activity::orderBy('name')->get();

        return view('proposals.create', compact('venues', 'activities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_name'   => 'required|string|max:255',
            'event_date'   => 'required|date|after:today',
            'budget'       => 'required|numeric|min:0',
            'people'       => 'required|integer|min:1',
            'venue_id'     => 'required|exists:venues,id',
            'activities'   => 'required|array|min:1',
            'activities.*' => 'exists:activities,id',
            'description'  => 'nullable|string|max:1000',
        ]);

        $proposal = EventProposal::create([
            'user_id'      => Auth::id(),
            'event_name'   => $request->event_name,
            'event_date'   => $request->event_date,
            'budget'       => $request->budget,
            'people'       => $request->people,
            'venue_id'     => $request->venue_id,
            'description'  => $request->description,
            'status'       => 'Pending',
            'is_published' => false,
        ]);

        // Attach activities
        $proposal->activities()->sync($request->activities);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Event proposal submitted successfully.');
    }

    public function userIndex()
    {
        $proposals = EventProposal::where('user_id', Auth::id())
            ->with('venue')
            ->latest()
            ->get();

        return view('proposals.user-status', compact('proposals'));
    }

    /**
     * USER — VIEW SINGLE PROPOSAL
     */
    public function show(EventProposal $proposal)
    {
        // Security: users can only view their own proposal
        if ($proposal->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $proposal->load(['venue', 'activities']);

        return view('proposals.show', compact('proposal'));
    }

    /* =======================
     * ADMIN
     * ======================= */

    public function adminIndex()
    {
        $proposals = EventProposal::with(['user', 'venue', 'activities'])
            ->latest()
            ->get();

        return view('proposals.admin-index', compact('proposals'));
    }

    /**
     * ADMIN — VIEW / REVIEW PROPOSAL
     */
    public function adminView(EventProposal $proposal)
    {
        $proposal->load([
            'user',
            'venue',
            'activities'
        ]);

        return view('proposals.admin-show', compact('proposal'));
    }

    public function adminUpdate(Request $request, EventProposal $proposal)
    {
        $request->validate([
            'status'           => 'required|in:Approved,Rejected',
            'admin_feedback'   => 'required|string|max:1000',
        ]);

        $proposal->update([
            'status'         => $request->status,
            'admin_feedback' => $request->admin_feedback,
            'is_published'   => $request->status === 'Approved',
        ]);

        return back()->with('success', 'Proposal updated successfully.');
    }
}
