@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-3">Event Activities</h2>
    <p class="text-muted">
        Explore what types of activities you can include in your event.
    </p>

    <div class="row">

        @forelse($activities as $activity)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">

                    {{-- Activity Image --}}
                    @if($activity->image)
                        <img src="{{ asset('storage/' . $activity->image) }}"
                             class="card-img-top"
                             style="height: 180px; object-fit: cover;"
                             alt="{{ $activity->name }}">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center"
                             style="height: 180px;">
                            <span class="text-muted">No Image</span>
                        </div>
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $activity->name }}</h5>

                        <p class="card-text text-muted">
                            {{ $activity->description ?? 'No details provided.' }}
                        </p>

                        <p class="fw-semibold mb-0">
                            <strong>Recommended Budget:</strong>
                            <span class="text-success">
                                RM {{ $activity->budget_range }}
                            </span>
                        </p>
                    </div>

                    <div class="card-footer bg-white text-center">

                        {{-- Show correct button depending on login --}}
                        @auth
                            <a href="{{ route('proposal.create') }}"
                               class="btn btn-primary btn-sm">
                                Use This Activity
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="btn btn-secondary btn-sm">
                                Login to Continue
                            </a>
                        @endauth

                    </div>

                </div>
            </div>
        @empty
            <p class="text-muted">No activities available yet.</p>
        @endforelse

    </div>

</div>
@endsection
