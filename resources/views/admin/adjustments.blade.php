@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <h2 class="mb-4">Admin Adjustment Panel</h2>

    <p class="text-muted">Manage all dynamic content on the SmartEvent platform.</p>

    <div class="row">

        <!-- VENUES -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Venues</h4>
                    <p>Manage locations, pricing and capacity information.</p>
                    <a href="{{ route('venue.admin.index') }}" class="btn btn-primary">Manage Venues</a>
                </div>
            </div>
        </div>

        <!-- BUDGETING -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Budgeting</h4>
                    <p>Update budgeting tiers and recommended event sizes.</p>
                    <a href="{{ route('budget.admin.index') }}" class="btn btn-primary">Manage Budgeting</a>
                </div>
            </div>
        </div>

        <!-- ACTIVITIES -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title">Activities</h4>
                    <p>Manage activity types such as weddings, charity events, etc.</p>
                    <a href="{{ route('activities.admin.index') }}" class="btn btn-primary">Manage Activities</a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
