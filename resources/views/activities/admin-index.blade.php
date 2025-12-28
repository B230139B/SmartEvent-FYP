<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Manage Activities</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6">

        <!-- Add New Activity Button -->
        <a href="{{ route('activities.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Add Activity
        </a>

        <!-- Activity Table -->
        <div class="mt-6 bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="p-3">Image</th>
                        <th class="p-3">Name</th>
                        <th class="p-3 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($activities as $a)
                        <tr class="border-b hover:bg-gray-50">
                            
                            <!-- Image Thumbnail -->
                            <td class="p-3">
                                @if ($a->image)
                                    <img src="{{ asset('storage/' . $a->image) }}"
                                         class="w-16 h-16 object-cover rounded">
                                @else
                                    <span class="text-gray-400 italic">No Image</span>
                                @endif
                            </td>

                            <!-- Name -->
                            <td class="p-3 font-medium">
                                {{ $a->name }}
                            </td>

                            <!-- Action Buttons -->
                            <td class="p-3 text-center">
                                <div class="flex justify-center gap-4">
                                    
                                    <!-- Edit -->
                                    <a href="{{ route('activities.edit', $a->id) }}"
                                       class="text-blue-600 hover:underline">
                                        Edit
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('activities.destroy', $a->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this activity?');">
                                        @csrf
                                        @method('DELETE')
                                        
                                        <button class="text-red-600 hover:underline">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-4 text-center text-gray-500">
                                No activities found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</x-app-layout>
