@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- ================================================= --}}
    {{-- PAGE HEADER                                       --}}
    {{-- ================================================= --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Manage Budget Tiers</h2>
            <small class="text-muted">
                Configure budget ranges and recommended event types to guide users during event planning.
            </small>
        </div>

        <div class="mt-2 mt-md-0">
            {{-- Back to Admin Panel --}}
            <a href="{{ route('admin.dashboard') }}"
               class="btn btn-outline-secondary me-2">
                ← Back to Admin Panel
            </a>

            {{-- Add New Budget --}}
            <a href="{{ route('budget.admin.create') }}"
               class="btn btn-primary">
                + Add New Budget Tier
            </a>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- SUCCESS MESSAGE                                   --}}
    {{-- ================================================= --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ================================================= --}}
    {{-- BUDGET TABLE                                      --}}
    {{-- ================================================= --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-bordered table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 180px;">Budget Range</th>
                        <th style="width: 220px;">Recommended Event</th>
                        <th>Description / Details</th>
                        <th style="width: 170px;" class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($budgets as $budget)
                    <tr>

                        {{-- Budget Range --}}
                        <td>
                            <strong>{{ $budget->range ?? '—' }}</strong>
                        </td>

                        {{-- Recommended Event --}}
                        <td>
                            @if(!empty($budget->recommended_event))
                                <span class="badge bg-info text-dark">
                                    {{ $budget->recommended_event }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        {{-- Description --}}
                        <td>
                            @if(!empty($budget->details))
                                {{ Str::limit($budget->details, 120) }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="text-center">

                            {{-- Edit --}}
                            <a href="{{ route('budget.admin.edit', $budget) }}"
                               class="btn btn-sm btn-warning mb-1">
                                Edit
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('budget.admin.destroy', $budget) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this budget tier?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            No budget tiers have been added yet.<br>
                            Click <strong>“Add New Budget Tier”</strong> to create one.
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection
