<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Admin: All Event Proposals</h2>
    </x-slot>

    <div class="p-6">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-200 text-green-900 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- FILTERS --}}
        <div class="bg-white p-4 rounded shadow mb-5">
            <form method="GET" action="{{ route('admin.proposals.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- Status Filter --}}
                    <div>
                        <label class="font-semibold">Status</label>
                        <select name="status" class="mt-1 w-full border rounded p-2">
                            <option value="">All</option>
                            <option value="Pending">Pending</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>

                    {{-- Search --}}
                    <div>
                        <label class="font-semibold">Search</label>
                        <input type="text" name="search" 
                               class="mt-1 w-full border rounded p-2"
                               placeholder="Search user or event type...">
                    </div>

                    {{-- Apply Button --}}
                    <div class="flex items-end">
                        <button class="w-full bg-blue-600 text-white py-2 rounded">
                            Apply Filters
                        </button>
                    </div>

                </div>
            </form>
        </div>

        {{-- PROPOSALS TABLE --}}
        <div class="overflow-auto bg-white rounded shadow">
            <table class="min-w-full border border-gray-300">
                <thead class="bg-gray-100">
                    <tr class="text-left">
                        <th class="p-2 border">User</th>
                        <th class="p-2 border">Event</th>
                        <th class="p-2 border">Date</th>
                        <th class="p-2 border">Budget</th>
                        <th class="p-2 border">Attendees</th>
                        <th class="p-2 border">Venue</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Feedback</th>
                        <th class="p-2 border">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($proposals as $p)
                    <tr class="hover:bg-gray-50">

                        {{-- USER --}}
                        <td class="p-2 border">
                            {{ $p->user->name }}<br>
                            <small class="text-gray-600">{{ $p->user->email }}</small>
                        </td>

                        {{-- EVENT TYPE --}}
                        <td class="p-2 border">{{ $p->event_type }}</td>

                        {{-- DATE --}}
                        <td class="p-2 border">
                            {{ $p->event_date ?? '—' }}
                        </td>

                        {{-- BUDGET --}}
                        <td class="p-2 border">RM {{ number_format($p->budget) }}</td>

                        {{-- ATTENDEES --}}
                        <td class="p-2 border">{{ $p->attendees }}</td>

                        {{-- VENUE --}}
                        <td class="p-2 border">{{ $p->venue_preference ?? '—' }}</td>

                        {{-- STATUS BADGE --}}
                        <td class="p-2 border">
                            <span class="
                                px-3 py-1 rounded text-white font-semibold
                                @if($p->status=='Approved')
                                    bg-green-600
                                @elseif($p->status=='Rejected')
                                    bg-red-600
                                @else
                                    bg-gray-600
                                @endif
                            ">
                                {{ $p->status }}
                            </span>
                        </td>

                        {{-- FEEDBACK --}}
                        <td class="p-2 border text-sm">{{ $p->feedback ?? '—' }}</td>

                        {{-- ACTION --}}
                        <td class="p-2 border text-center">

                            {{-- View Button --}}
                            <a href="{{ route('admin.proposals.view', $p->id) }}"
                               class="inline-block mb-2 px-3 py-1 bg-blue-600 text-white rounded">
                                View
                            </a>

                            {{-- Approve Form --}}
                            <form action="{{ route('admin.proposals.approve', $p->id) }}" 
                                  method="POST" class="mb-2">
                                @csrf
                                <input name="feedback" placeholder="Feedback (optional)"
                                       class="w-full border rounded p-1 text-sm mb-1">
                                <button class="w-full bg-green-600 text-white py-1 rounded">
                                    Approve
                                </button>
                            </form>

                            {{-- Reject Form --}}
                            <form action="{{ route('admin.proposals.reject', $p->id) }}" 
                                  method="POST">
                                @csrf
                                <input name="feedback" placeholder="Reason (optional)"
                                       class="w-full border rounded p-1 text-sm mb-1">
                                <button class="w-full bg-red-600 text-white py-1 rounded">
                                    Reject
                                </button>
                            </form>

                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="p-4 text-center text-gray-600">
                            No proposals found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</x-app-layout>
