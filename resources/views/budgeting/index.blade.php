@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-3">Budget Planning Guide</h2>
    <p class="text-muted">
        See what kind of events you can plan with different budgets.
    </p>

    <div class="row mt-4">

        @forelse($budgets as $budget)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm p-3 h-100">

                    {{-- Budget Range --}}
                    <h4 class="mb-2">
                        {{ $budget->range }}
                    </h4>

                    {{-- Recommended Event --}}
                    <p class="mb-2">
                        <strong>Recommended Event:</strong><br>
                        {{ $budget->recommended_event }}
                    </p>

                    {{-- Details / Description --}}
                    @if($budget->details)
                        <p class="text-muted mb-3">
                            {{ $budget->details }}
                        </p>
                    @endif

                    {{-- Button --}}
                    <div class="mt-auto">
                        @auth
                            <a href="{{ route('proposal.create') }}" class="btn btn-primary w-100">
                                Plan Event With This Budget
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-secondary w-100">
                                Login to Continue
                            </a>
                        @endauth
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted">No budgeting information available right now.</p>
            </div>
        @endforelse

    </div>

</div>
@endsection
