<?php

namespace App\Http\Controllers;

use App\Models\EventProposal;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalProposals'   => EventProposal::count(),
            'pendingProposals' => EventProposal::where('status', 'Pending')->count(),
            'approvedEvents'   => EventProposal::where('status', 'Approved')->count(),
            'publishedEvents'  => EventProposal::where('is_published', 1)->count(),
        ]);
    }
}
