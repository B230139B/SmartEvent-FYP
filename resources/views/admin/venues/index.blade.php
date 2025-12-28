@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- =============================== --}}
    {{-- PAGE HEADER                     --}}
    {{-- =============================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Venue Management</h2>
            <small class="text-muted">
                Manage available venues used in event planning
            </small>
        </div>

        <div>
            <a href="{{ route('admin.dashboard') }}"
               class="btn btn-outline-secondary btn-sm me-2">
                ← Back to Admin Panel
            </a>

            <a href="{{ route('venue.admin.create') }}"
               class="btn btn-success btn-sm">
                + Add New Venue
            </a>
        </div>
    </div>

    {{-- =============================== --}}
    {{-- SUCCESS MESSAGE                 --}}
    {{-- =============================== --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- =============================== --}}
    {{-- EMPTY STATE                     --}}
    {{-- =============================== --}}
    @if($venues->count() === 0)

        <div class="alert alert-info">
            <h5 class="mb-2">No Venues Found</h5>
            <p class="mb-2">
                You haven’t added any venues yet. Venues are required for
                accurate event planning and budgeting.
            </p>
            <a href="{{ route('venue.admin.create') }}"
               class="btn btn-primary btn-sm">
                Add Your First Venue
            </a>
        </div>

    @else

    {{-- =============================== --}}
    {{-- VENUE TABLE                     --}}
    {{-- =============================== --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-bordered table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 90px;" class="text-center">Image</th>
                        <th>Venue Name</th>
                        <th>Location</th>
                        <th class="text-center" style="width: 110px;">Capacity</th>
                        <th class="text-center" style="width: 130px;">Price (RM)</th>
                        <th class="text-center" style="width: 180px;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($venues as $venue)
                        <tr>

                            {{-- IMAGE --}}
                            <td class="text-center">
                                @if($venue->image)
                                    <img src="{{ asset('storage/' . $venue->image) }}"
                                         alt="Venue Image"
                                         class="img-thumbnail"
                                         style="width:75px; height:55px; object-fit:cover;">
                                @else
                                    <span class="text-muted small">No Image</span>
                                @endif
                            </td>

                            {{-- DATA --}}
                            <td>
                                <strong>{{ $venue->name }}</strong>
                            </td>

                            <td>{{ $venue->location }}</td>

                            <td class="text-center">
                                {{ $venue->capacity }}
                            </td>

                            <td class="text-center">
                                {{ number_format($venue->price, 2) }}
                            </td>

                            {{-- ACTIONS --}}
                            <td class="text-center">
                                <a href="{{ route('venue.admin.edit', $venue->id) }}"
                                   class="btn btn-sm btn-primary mb-1">
                                    Edit
                                </a>

                                <form action="{{ route('venue.admin.destroy', $venue->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this venue? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    @endif

</div>
@endsection
