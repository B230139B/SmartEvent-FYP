@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- PAGE HEADER --}}
    <div class="mb-4">
        <h2 class="mb-0">Edit Budget Tier</h2>
        <small class="text-muted">
            Update budget range and recommended event information.
        </small>
    </div>

    {{-- VALIDATION ERRORS --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- EDIT FORM --}}
    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" 
                  action="{{ route('budget.admin.update', $budget->id) }}"
                  class="mt-3">

                @csrf
                @method('PUT')

                {{-- Budget Range --}}
                <div class="mb-3">
                    <label class="form-label">
                        Budget Range
                        <small class="text-muted">(Example: RM 5,000 - RM 10,000)</small>
                    </label>
                    <input type="text"
                           name="range"
                           value="{{ old('range', $budget->range) }}"
                           class="form-control"
                           required>
                </div>

                {{-- Recommended Event --}}
                <div class="mb-3">
                    <label class="form-label">
                        Recommended Event
                        <small class="text-muted">(Example: Wedding / Corporate Dinner)</small>
                    </label>
                    <input type="text"
                           name="recommended_event"
                           value="{{ old('recommended_event', $budget->recommended_event) }}"
                           class="form-control"
                           required>
                </div>

                {{-- Details --}}
                <div class="mb-3">
                    <label class="form-label">Details / Description</label>
                    <textarea name="details"
                              class="form-control"
                              rows="4">{{ old('details', $budget->details) }}</textarea>
                </div>

                {{-- ACTION BUTTONS --}}
                <button class="btn btn-success">
                    Update Budget Tier
                </button>

                <a href="{{ route('budget.admin.index') }}"
                   class="btn btn-secondary ms-2">
                    Cancel
                </a>

            </form>

        </div>
    </div>

</div>
@endsection
