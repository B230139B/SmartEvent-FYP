@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="mb-0">Manage Activities</h2>
            <small class="text-muted">
                Manage activity ideas and estimated budgets for events.
            </small>
        </div>

        <div>
            <a href="{{ route('admin.dashboard') }}"
               class="btn btn-secondary btn-sm me-2">
                ← Back to Admin Panel
            </a>

            <a href="{{ route('activity.admin.create') }}"
               class="btn btn-success btn-sm">
                + Add New Activity
            </a>
        </div>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ACTIVITIES TABLE --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-bordered table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 110px;">Image</th>
                        <th>Activity Name</th>
                        <th>Description</th>
                        <th style="width: 180px;">Recommended Budget</th>
                        <th style="width: 170px;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($activities as $activity)
                    <tr>

                        {{-- IMAGE --}}
                        <td class="text-center">
                            @if($activity->image && Storage::disk('public')->exists($activity->image))
                                <img src="{{ asset('storage/' . $activity->image) }}"
                                     alt="{{ $activity->name }}"
                                     class="img-thumbnail"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </td>

                        {{-- NAME --}}
                        <td>
                            <strong>{{ $activity->name }}</strong>
                        </td>

                        {{-- DESCRIPTION --}}
                        <td>
                            {{ $activity->description
                                ? \Illuminate\Support\Str::limit($activity->description, 90)
                                : '—' }}
                        </td>

                        {{-- BUDGET RANGE --}}
                        <td>
                            {{ $activity->budget_range }}
                        </td>

                        {{-- ACTIONS --}}
                        <td class="text-center">
                            <a href="{{ route('activity.admin.edit', $activity) }}"
                               class="btn btn-sm btn-warning mb-1">
                                Edit
                            </a>

                            <form action="{{ route('activity.admin.destroy', $activity) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this activity?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            No activities have been added yet.<br>
                            Click <strong>“Add New Activity”</strong> to create one.
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection
