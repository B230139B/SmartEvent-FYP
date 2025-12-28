@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Venue</h2>

    <form action="{{ route('venue.admin.update', $venue->id) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="mt-3">

        @csrf
        @method('PUT')

        {{-- Venue Name --}}
        <div class="mb-3">
            <label class="form-label">Venue Name</label>
            <input type="text" name="name" value="{{ $venue->name }}" 
                   class="form-control" required>
        </div>

        {{-- Location --}}
        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" value="{{ $venue->location }}" 
                   class="form-control" required>
        </div>

        {{-- Capacity --}}
        <div class="mb-3">
            <label class="form-label">Capacity</label>
            <input type="number" name="capacity" value="{{ $venue->capacity }}" 
                   class="form-control" required>
        </div>

        {{-- Price --}}
        <div class="mb-3">
            <label class="form-label">Price (RM)</label>
            <input type="number" name="price" value="{{ $venue->price }}" 
                   class="form-control" required>
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="4" 
                      class="form-control">{{ $venue->description }}</textarea>
        </div>

        {{-- Current Image --}}
        <div class="mb-3">
            <label class="form-label">Current Image</label><br>

            @if($venue->image)
                <img src="{{ asset('storage/' . $venue->image) }}" 
                     width="120" height="90" 
                     style="object-fit: cover; border-radius: 5px;">
            @else
                <p class="text-muted">No image uploaded</p>
            @endif
        </div>

        {{-- Replace Image --}}
        <div class="mb-3">
            <label class="form-label">Replace Image (optional)</label>
            <input type="file" name="image" class="form-control">
        </div>

        {{-- Buttons --}}
        <button class="btn btn-primary">Update Venue</button>
        <a href="{{ route('venue.admin.index') }}" class="btn btn-secondary">Back</a>

    </form>
</div>
@endsection
