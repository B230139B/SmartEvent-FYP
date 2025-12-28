@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2>Community Moderation</h2>
    <p class="text-muted">Approve or remove community posts.</p>

    <h4 class="mt-4">Pending Posts</h4>
    <table class="table table-bordered">
        <tr>
            <th>Title</th>
            <th>User</th>
            <th>Rating</th>
            <th>Action</th>
        </tr>

        @foreach($pending as $p)
            <tr>
                <td>{{ $p->event_title }}</td>
                <td>{{ $p->user->name }}</td>
                <td>{{ $p->rating }} ⭐</td>
                <td>
                    <form action="{{ route('community.admin.approve', $p->id) }}"
                          method="POST" class="d-inline">
                        @csrf
                        @method('PUT')

                        <button class="btn btn-success btn-sm">Approve</button>
                    </form>

                    <form action="{{ route('community.admin.delete', $p->id) }}"
                          method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <h4 class="mt-4">Approved Posts</h4>
    <table class="table table-bordered">
        <tr>
            <th>Title</th>
            <th>User</th>
            <th>Rating</th>
            <th>Action</th>
        </tr>

        @foreach($approved as $p)
            <tr>
                <td>{{ $p->event_title }}</td>
                <td>{{ $p->user->name }}</td>
                <td>{{ $p->rating }} ⭐</td>
                <td>
                    <form action="{{ route('community.admin.delete', $p->id) }}"
                        method="POST">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

</div>
@endsection
