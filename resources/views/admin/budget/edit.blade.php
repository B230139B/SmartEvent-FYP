@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2>Edit Budget Tier</h2>

    <form action="{{ route('budget.admin.update', $budget->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Minimum Amount (RM)</label>
            <input type="number" name="min_amount" value="{{ $budget->min_amount }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Maximum Amount (RM)</label>
            <input type="number" name="max_amount" value="{{ $budget->max_amount }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Suitable Event</label>
            <input type="text" name="suitable_event" value="{{ $budget->suitable_event }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Estimated Capacity (people)</label>
            <input type="number" name="estimated_capacity" value="{{ $budget->estimated_capacity }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control">{{ $budget->notes }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>

    </form>

</div>
@endsection
