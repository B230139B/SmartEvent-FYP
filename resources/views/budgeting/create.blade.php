@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- ===================== --}}
    {{-- PAGE HEADER           --}}
    {{-- ===================== --}}
    <div class="mb-4">
        <h2 class="mb-1">Add Budget Tier</h2>
        <p class="text-muted mb-0">
            Create a new budget range to guide users in planning suitable events.
        </p>
    </div>

    {{-- ===================== --}}
    {{-- GLOBAL ERROR MESSAGE  --}}
    {{-- ===================== --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ===================== --}}
    {{-- FORM CARD            --}}
    {{-- ===================== --}}
    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" action="{{ route('budget.admin.store') }}">
                @csrf

                {{-- ===================== --}}
                {{-- Budget Range          --}}
                {{-- ===================== --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Budget Range
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="range"
                           class="form-control @error('range') is-invalid @enderror"
                           value="{{ old('range') }}"
                           placeholder="RM 5,000 - RM 10,000"
                           required>

                    @error('range')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <small class="text-muted">
                        Example: RM 5,000 - RM 10,000
                    </small>
                </div>

                {{-- ===================== --}}
                {{-- Recommended Event    --}}
                {{-- ===================== --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Recommended Event Type
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="recommended_event"
                           class="form-control @error('recommended_event') is-invalid @enderror"
                           value="{{ old('recommended_event') }}"
                           placeholder="Wedding / Corporate Dinner"
                           required>

                    @error('recommended_event')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <small class="text-muted">
                        Example: Wedding, Seminar, Corporate Dinner
                    </small>
                </div>

                {{-- ===================== --}}
                {{-- Details / Description--}}
                {{-- ===================== --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Details / Description
                        <span class="text-danger">*</span>
                    </label>

                    <textarea name="details"
                              class="form-control @error('details') is-invalid @enderror"
                              rows="4"
                              placeholder="Includes venue rental, catering, basic decoration, and essential equipment support."
                              required>{{ old('details') }}</textarea>

                    @error('details')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- ===================== --}}
                {{-- ACTION BUTTONS       --}}
                {{-- ===================== --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        Save Budget Tier
                    </button>

                    <a href="{{ route('budget.admin.index') }}"
                       class="btn btn-secondary">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
