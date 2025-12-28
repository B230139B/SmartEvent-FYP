<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Venue;

class GuidanceController extends Controller
{
    // Step 1 — choose event type
    public function start()
    {
        $activities = Activity::all();
        return view('guidance.start', compact('activities'));
    }

    // Step 2 — save activity and ask for budget
    public function stepBudget(Request $request)
    {
        $request->validate(['activity_id' => 'required']);

        session(['guidance_activity_id' => $request->activity_id]);

        return view('guidance.budget');
    }

    // Step 3 — save budget and ask people count
    public function stepPeople(Request $request)
    {
        $request->validate(['budget' => 'required|numeric']);

        session(['guidance_budget' => $request->budget]);

        return view('guidance.people');
    }

    // Step 4 — compute recommendation
    public function result(Request $request)
    {
        $request->validate(['people' => 'required|numeric']);

        session(['guidance_people' => $request->people]);

        $activityId = session('guidance_activity_id');
        $budget = session('guidance_budget');
        $people = session('guidance_people');

        // Get selected activity
        $activity = Activity::find($activityId);

        // Simple match: venues that can fit people and within budget range
        $venues = Venue::where('estimated_min_budget', '<=', $budget)
                       ->where('estimated_max_budget', '>=', $budget)
                       ->where('max_capacity', '>=', $people)
                       ->get();

        session([
            'guidance_activity_name' => $activity->name,
            'guidance_recommended_venue' => $venues->count() > 0 ? $venues->first()->name : null,
        ]);
               
        return view('guidance.result', compact('activity', 'budget', 'people', 'venues'));
    }
}
