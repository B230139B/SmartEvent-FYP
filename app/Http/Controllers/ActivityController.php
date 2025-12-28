<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    /* =========================================================
     |  PUBLIC SECTION (USER)
     ========================================================= */

    /**
     * PUBLIC — Display all activities for users
     */
    public function index()
    {
        $activities = Activity::orderBy('name')->get();

        return view('activities.index', compact('activities'));
    }

    /* =========================================================
     |  ADMIN SECTION
     |  (Protected by AdminOnly middleware)
     ========================================================= */

    /**
     * ADMIN — Display all activities
     */
    public function adminIndex()
    {
        $activities = Activity::orderBy('created_at', 'desc')->get();

        return view('admin.activities.index', compact('activities'));
    }

    /**
     * ADMIN — Show form to create a new activity
     */
    public function create()
    {
        return view('admin.activities.create');
    }

    /**
     * ADMIN — Store a new activity
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                   => 'required|string|max:255',
            'description'            => 'nullable|string',
            'recommended_min_budget' => 'nullable|integer|min:0',
            'recommended_max_budget' => 'nullable|integer|min:0',
            'image'                  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload image if provided
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('activities', 'public');
        }

        Activity::create($data);

        return redirect()
            ->route('activity.admin.index')
            ->with('success', 'Activity added successfully.');
    }

    /**
     * ADMIN — Show form to edit an activity
     */
    public function edit(Activity $activity)
    {
        return view('admin.activities.edit', compact('activity'));
    }

    /**
     * ADMIN — Update an existing activity
     */
    public function update(Request $request, Activity $activity)
    {
        $data = $request->validate([
            'name'                   => 'required|string|max:255',
            'description'            => 'nullable|string',
            'recommended_min_budget' => 'nullable|integer|min:0',
            'recommended_max_budget' => 'nullable|integer|min:0',
            'image'                  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Replace image if uploaded
        if ($request->hasFile('image')) {

            if ($activity->image && Storage::disk('public')->exists($activity->image)) {
                Storage::disk('public')->delete($activity->image);
            }

            $data['image'] = $request->file('image')
                ->store('activities', 'public');
        }

        $activity->update($data);

        return redirect()
            ->route('activity.admin.index')
            ->with('success', 'Activity updated successfully.');
    }

    /**
     * ADMIN — Delete an activity
     */
    public function destroy(Activity $activity)
    {
        if ($activity->image && Storage::disk('public')->exists($activity->image)) {
            Storage::disk('public')->delete($activity->image);
        }

        $activity->delete();

        return redirect()
            ->route('activity.admin.index')
            ->with('success', 'Activity deleted successfully.');
    }
}
