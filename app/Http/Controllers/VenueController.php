<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VenueController extends Controller
{
    /* =========================================================
     |  PUBLIC SECTION
     |  Accessible by: Guest & User
     ========================================================= */

    /**
     * PUBLIC — List all venues
     */
    public function index()
    {
        $venues = Venue::orderBy('name')->get();
        return view('venues.index', compact('venues'));
    }

    /**
     * PUBLIC — View single venue
     */
    public function show(Venue $venue)
    {
        return view('venues.show', compact('venue'));
    }


    /* =========================================================
     |  ADMIN SECTION
     |  Accessible by: Admin only (via AdminOnly middleware)
     ========================================================= */

    /**
     * ADMIN — List all venues (Admin Panel)
     */
    public function adminIndex()
    {
        $venues = Venue::orderBy('created_at', 'desc')->get();

        // IMPORTANT:
        // This must load the ADMIN view, not the public one
        return view('admin.venues.index', compact('venues'));
    }

    /**
     * ADMIN — Show create venue form
     */
    public function create()
    {
        return view('admin.venues.create');
    }

    /**
     * ADMIN — Store new venue
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'capacity'    => 'required|integer|min:1',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload image if provided
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                                     ->store('venues', 'public');
        }

        Venue::create($data);

        return redirect()
            ->route('venue.admin.index')
            ->with('success', 'Venue added successfully.');
    }

    /**
     * ADMIN — Show edit venue form
     */
    public function edit(Venue $venue)
    {
        return view('admin.venues.edit', compact('venue'));
    }

    /**
     * ADMIN — Update venue
     */
    public function update(Request $request, Venue $venue)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'location'    => 'required|string|max:255',
            'capacity'    => 'required|integer|min:1',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Replace image if uploaded
        if ($request->hasFile('image')) {

            if ($venue->image && Storage::disk('public')->exists($venue->image)) {
                Storage::disk('public')->delete($venue->image);
            }

            $data['image'] = $request->file('image')
                                     ->store('venues', 'public');
        }

        $venue->update($data);

        return redirect()
            ->route('venue.admin.index')
            ->with('success', 'Venue updated successfully.');
    }

    /**
     * ADMIN — Delete venue
     */
    public function destroy(Venue $venue)
    {
        if ($venue->image && Storage::disk('public')->exists($venue->image)) {
            Storage::disk('public')->delete($venue->image);
        }

        $venue->delete();

        return redirect()
            ->route('venue.admin.index')
            ->with('success', 'Venue deleted successfully.');
    }
}
