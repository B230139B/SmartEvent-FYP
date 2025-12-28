@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2>Add Budget Tier</h2>

    <form action="{{ route('budget.admin.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Minimum Amount (RM)</label>
            <input type="number" name="min_amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Maximum Amount (RM)</label>
            <input type="number" name="max_amount" class="form-control">
        </div>

        <div class="mb-3">
            <label>Suitable Event</label>
            <input type="text" name="suitable_event" class="form-control">
        </div>

        <div class="mb-3">
            <label>Estimated Capacity (people)</label>
            <input type="number" name="estimated_capacity" class="form-control">
        </div>

        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>

        <button class="btn btn-success">Save</button>

    </form>

</div>
@endsection
