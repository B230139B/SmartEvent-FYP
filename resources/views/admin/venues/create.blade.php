@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- PAGE HEADER --}}
    <div class="mb-4">
        <h2 class="fw-bold">Add New Venue</h2>
        <p class="text-muted">
            Fill in the details below to add a new event venue to the system.
        </p>
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

    {{-- CREATE VENUE FORM --}}
    <form action="{{ route('venue.admin.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="card shadow-sm p-4">

        @csrf

        {{-- Venue Name --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Venue Name</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name') }}"
                   placeholder="e.g. Grand Ballroom Johor"
                   required>
        </div>

        {{-- Location --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Location</label>
            <input type="text"
                   name="location"
                   class="form-control"
                   value="{{ old('location') }}"
                   placeholder="e.g. Johor Bahru"
                   required>
        </div>

        {{-- Capacity --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Capacity (people)</label>
            <input type="number"
                   name="capacity"
                   class="form-control"
                   value="{{ old('capacity') }}"
                   min="1"
                   placeholder="e.g. 500"
                   required>
        </div>

        {{-- Price --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Price (RM)</label>
            <input type="number"
                   name="price"
                   class="form-control"
                   value="{{ old('price') }}"
                   min="0"
                   step="0.01"
                   placeholder="e.g. 20000"
                   required>
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">Description (optional)</label>
            <textarea name="description"
                      rows="4"
                      class="form-control"
                      placeholder="Brief description of the venue...">{{ old('description') }}</textarea>
        </div>

        {{-- Image Upload --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">Venue Image (optional)</label>
            <input type="file"
                   name="image"
                   class="form-control"
                   accept="image/*">
            <small class="text-muted">
                Accepted formats: JPG, PNG. Max size recommended: 2MB.
            </small>
        </div>

        {{-- FORM ACTIONS --}}
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">
                Save Venue
            </button>

            <a href="{{ route('venue.admin.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </div>

    </form>

</div>
@endsection
