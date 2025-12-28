@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Page Header --}}
    <div class="mb-3">
        <h2 class="mb-0">Add New Activity</h2>
        <small class="text-muted">
            Create a new event activity with an optional photo
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

            <form action="{{ route('activity.admin.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                {{-- Activity Name --}}
                <div class="mb-3">
                    <label class="form-label">Activity Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name') }}"
                           required>
                </div>

                {{-- Typical Budget --}}
                <div class="mb-3">
                    <label class="form-label">Typical Budget (RM)</label>
                    <input type="number"
                           step="0.01"
                           name="typical_budget"
                           class="form-control"
                           value="{{ old('typical_budget') }}"
                           required>
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description"
                              rows="4"
                              class="form-control">{{ old('description') }}</textarea>
                </div>

                {{-- Upload Activity Image --}}
                <div class="mb-3">
                    <label class="form-label">
                        Activity Photo <small class="text-muted">(optional)</small>
                    </label>
                    <input type="file"
                           name="image"
                           class="form-control"
                           accept="image/*">
                    <small class="text-muted">
                        JPG, PNG, WEBP. Max 2MB.
                    </small>
                </div>

                {{-- Buttons --}}
                <div class="mt-4">
                    <button class="btn btn-success">
                        Add Activity
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
