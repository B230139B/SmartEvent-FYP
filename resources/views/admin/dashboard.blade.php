@extends('layouts.app')

@section('content')
<div class="container my-4">

    {{-- =============================== --}}
    {{-- ADMIN HEADER --}}
    {{-- =============================== --}}
    <div class="p-4 mb-5 rounded shadow-sm bg-white border">
        <h1 class="fw-bold mb-1 text-dark">
            🛠 Admin Dashboard
        </h1>
        <p class="mb-0 text-muted">
            System overview and administrative control panel for SmartEvent.
        </p>
    </div>

    {{-- =============================== --}}
    {{-- SYSTEM OVERVIEW --}}
    {{-- =============================== --}}
    <div class="row g-4 mb-5">

        <div class="col-md-3">
            <div class="card shadow-sm text-center h-100 border-start border-4 border-dark">
                <div class="card-body">
                    <small class="text-muted">Total Proposals</small>
                    <h2 class="fw-bold mt-2 text-dark">{{ $totalProposals }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center h-100 border-start border-4 border-warning bg-warning-subtle">
                <div class="card-body">
                    <small class="text-muted">Pending Review</small>
                    <h2 class="fw-bold text-warning mt-2">{{ $pendingProposals }}</h2>

                    @if($pendingProposals > 0)
                        <span class="badge bg-warning text-dark mt-2">
                            Action Required
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center h-100 border-start border-4 border-success bg-success-subtle">
                <div class="card-body">
                    <small class="text-muted">Approved Events</small>
                    <h2 class="fw-bold text-success mt-2">{{ $approvedEvents }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center h-100 border-start border-4 border-primary bg-primary-subtle">
                <div class="card-body">
                    <small class="text-muted">Published Events</small>
                    <h2 class="fw-bold text-primary mt-2">{{ $publishedEvents }}</h2>
                </div>
            </div>
        </div>

    </div>

    {{-- =============================== --}}
    {{-- SYSTEM MANAGEMENT --}}
    {{-- =============================== --}}
    <div class="mb-4">
        <h4 class="fw-semibold text-dark">
            ⚙️ System Management
        </h4>
        <p class="text-muted small">
            Core administrative modules for maintaining SmartEvent.
        </p>
    </div>

    <div class="row g-4 mb-5">

        @php
            $adminCards = [
                [
                    'title' => 'Event Proposals',
                    'desc'  => 'Review, approve, or reject user submissions.',
                    'route' => 'admin.proposals.index',
                    'color' => 'warning',
                    'btn'   => 'Review Now',
                    'urgent'=> true
                ],
                [
                    'title' => 'Venues',
                    'desc'  => 'Manage venue listings and capacities.',
                    'route' => 'venue.admin.index',
                    'color' => 'primary',
                    'btn'   => 'Manage Venues',
                    'urgent'=> false
                ],
                [
                    'title' => 'Budgeting',
                    'desc'  => 'Maintain budget tiers and guidelines.',
                    'route' => 'budget.admin.index',
                    'color' => 'success',
                    'btn'   => 'Manage Budget',
                    'urgent'=> false
                ],
                [
                    'title' => 'Activities',
                    'desc'  => 'Curate recommended event activities.',
                    'route' => 'activity.admin.index',
                    'color' => 'info',
                    'btn'   => 'Manage Activities',
                    'urgent'=> false
                ],
            ];
        @endphp

        @foreach($adminCards as $card)
            <div class="col-md-3">
                <div class="card shadow-sm h-100 border-0 text-center admin-card border-top border-4 border-{{ $card['color'] }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-semibold mb-2 text-dark">
                            {{ $card['title'] }}
                        </h5>

                        <p class="text-muted small flex-grow-1">
                            {{ $card['desc'] }}
                        </p>

                        <a href="{{ route($card['route']) }}"
                           class="btn btn-{{ $card['color'] }} btn-lg w-100 mt-3 shadow-sm
                           {{ $card['urgent'] && $pendingProposals > 0 ? 'pulse-btn' : '' }}">
                            {{ $card['btn'] }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    {{-- =============================== --}}
    {{-- RECENT EVENT PROPOSALS --}}
    {{-- =============================== --}}
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-semibold mb-0 text-dark">
                    📝 Recent Event Proposals
                </h4>
                <a href="{{ route('admin.proposals.index') }}"
                   class="btn btn-outline-primary btn-sm">
                    View All
                </a>
            </div>

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Event Name</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>
                @forelse(\App\Models\EventProposal::latest()->take(5)->get() as $proposal)
                    <tr>
                        <td>{{ $proposal->event_name }}</td>
                        <td>{{ $proposal->user->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge
                                @if($proposal->status == 'Approved') bg-success
                                @elseif($proposal->status == 'Rejected') bg-danger
                                @else bg-warning text-dark
                                @endif">
                                {{ $proposal->status }}
                            </span>
                        </td>
                        <td>{{ $proposal->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.proposals.view', $proposal->id) }}"
                               class="btn btn-sm btn-outline-primary">
                                Review
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            No recent proposals available.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>
    </div>

    {{-- =============================== --}}
    {{-- SYSTEM NOTICE --}}
    {{-- =============================== --}}
    <div class="alert alert-info">
        <strong>Admin Reminder:</strong>
        Review pending proposals promptly to maintain system quality and user trust.
    </div>

</div>

{{-- UI Enhancements --}}
<style>
    .admin-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .admin-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.1);
    }

    .pulse-btn {
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(255,193,7,.6); }
        70% { box-shadow: 0 0 0 10px rgba(255,193,7,0); }
        100% { box-shadow: 0 0 0 0 rgba(255,193,7,0); }
    }
</style>
@endsection
