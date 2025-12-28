@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Activity</h2>

    <form method="POST" action="{{ route('activity.update', $activity) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Name</label>
        <input type="text" name="name" class="form-control mb-3" value="{{ $activity->name }}" required>

        <label>Category</label>
        <input type="text" name="category" class="form-control mb-3" value="{{ $activity->category }}">

        <label>Description</label>
        <textarea name="description" class="form-control mb-3">{{ $activity->description }}</textarea>

        <label>Image</label>
        <input type="file" name="image" class="form-control mb-3">

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
