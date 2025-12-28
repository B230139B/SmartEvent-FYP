@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Page Header --}}
    <div class="mb-3">
        <h2 class="mb-0">Edit Activity</h2>
        <small class="text-muted">
            Update activity details and photo
        </small>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('activity.admin.update', $activity) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                {{-- Activity Name --}}
                <div class="mb-3">
                    <label class="form-label">Activity Name</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $activity->name) }}"
                           class="form-control"
                           required>
                </div>

                {{-- Recommended Budget --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Minimum Budget (RM)</label>
                        <input type="number"
                               step="0.01"
                               name="recommended_min_budget"
                               value="{{ old('recommended_min_budget', $activity->recommended_min_budget) }}"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Maximum Budget (RM)</label>
                        <input type="number"
                               step="0.01"
                               name="recommended_max_budget"
                               value="{{ old('recommended_max_budget', $activity->recommended_max_budget) }}"
                               class="form-control"
                               required>
                    </div>
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description"
                              rows="4"
                              class="form-control">{{ old('description', $activity->description) }}</textarea>
                </div>

                {{-- Current Image --}}
                <div class="mb-3">
                    <label class="form-label">Current Activity Photo</label><br>
                    @if($activity->image && Storage::disk('public')->exists($activity->image))
                        <img src="{{ asset('storage/' . $activity->image) }}"
                             class="img-thumbnail"
                             style="max-width: 150px;">
                    @else
                        <span class="text-muted">No photo uploaded</span>
                    @endif
                </div>

                {{-- Replace Image --}}
                <div class="mb-3">
                    <label class="form-label">
                        Replace Photo <small class="text-muted">(optional)</small>
                    </label>
                    <input type="file"
                           name="image"
                           class="form-control"
                           accept="image/*">
                </div>

                {{-- Buttons --}}
                <div class="mt-4">
                    <button class="btn btn-primary">
                        Update Activity
                    </button>

                    <a href="{{ route('activity.admin.index') }}"
                       class="btn btn-secondary ms-2">
                        Back
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
