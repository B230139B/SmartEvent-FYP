@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h2>Manage Budget Tiers</h2>
        <a href="{{ route('budget.admin.create') }}" class="btn btn-success btn-sm">Add Budget Tier</a>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>Range (RM)</th>
            <th>Suitable Event</th>
            <th>Capacity</th>
            <th>Notes</th>
            <th>Action</th>
        </tr>

        @foreach($budgets as $b)
            <tr>
                <td>
                    RM {{ number_format($b->min_amount) }}
                    @if($b->max_amount)
                        – RM {{ number_format($b->max_amount) }}
                    @else
                        +
                    @endif
                </td>
                <td>{{ $b->suitable_event }}</td>
                <td>{{ $b->estimated_capacity }} ppl</td>
                <td>{{ Str::limit($b->notes, 50) }}</td>
                <td>
                    <a href="{{ route('budget.admin.edit', $b->id) }}" class="btn btn-primary btn-sm">Edit</a>

                    <form action="{{ route('budget.admin.delete', $b->id) }}" 
                          method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach

    </table>

</div>
@endsection
