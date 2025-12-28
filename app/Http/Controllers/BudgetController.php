<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    /* ==========================================================
     |  PUBLIC — BUDGETING OVERVIEW (USER)
     ========================================================== */

    /**
     * Show budget tiers to public users
     */
    public function index()
    {
        // Show all budget tiers in order
        $budgets = Budget::orderBy('id', 'asc')->get();

        return view('budgeting.index', compact('budgets'));
    }

    /* ==========================================================
     |  ADMIN — BUDGET MANAGEMENT
     |  (Protected by AdminOnly middleware in routes)
     ========================================================== */

    /**
     * ADMIN — List all budget tiers
     */
    public function adminIndex()
    {
        $budgets = Budget::orderBy('id', 'asc')->get();

        return view('budgeting.admin-index', compact('budgets'));
    }

    /**
     * ADMIN — Show create budget tier form
     */
    public function create()
    {
        return view('budgeting.create');
    }

    /**
     * ADMIN — Store new budget tier
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'range'             => 'required|string|max:100',
            'recommended_event' => 'required|string|max:255',
            'details'           => 'nullable|string',
        ]);

        Budget::create($validated);

        return redirect()
            ->route('budget.admin.index')
            ->with('success', 'Budget tier added successfully.');
    }

    /**
     * ADMIN — Show edit budget tier form
     */
    public function edit(Budget $budget)
    {
        return view('budgeting.edit', compact('budget'));
    }

    /**
     * ADMIN — Update budget tier
     */
    public function update(Request $request, Budget $budget)
    {
        $validated = $request->validate([
            'range'             => 'required|string|max:100',
            'recommended_event' => 'required|string|max:255',
            'details'           => 'nullable|string',
        ]);

        $budget->update($validated);

        return redirect()
            ->route('budget.admin.index')
            ->with('success', 'Budget tier updated successfully.');
    }

    /**
     * ADMIN — Delete budget tier
     */
    public function destroy(Budget $budget)
    {
        $budget->delete();

        return redirect()
            ->route('budget.admin.index')
            ->with('success', 'Budget tier deleted successfully.');
    }
}
