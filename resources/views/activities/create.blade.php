<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Add New Activity
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8">
        <div class="bg-white p-6 rounded-lg shadow">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 border rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('activities.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Activity Name --}}
                <label class="block font-semibold mb-1">Activity Name</label>
                <input type="text" name="name"
                       class="border p-2 w-full rounded mb-4"
                       placeholder="e.g. Charity Run, Wedding Reception"
                       required>

                {{-- Description --}}
                <label class="block font-semibold mb-1">Description</label>
                <textarea name="description"
                          rows="3"
                          class="border p-2 w-full rounded mb-4"
                          placeholder="Brief description of this activity"></textarea>

                {{-- Recommended Budget --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-1">Min Budget (RM)</label>
                        <input type="number" name="recommended_min_budget"
                               class="border p-2 w-full rounded mb-4"
                               placeholder="e.g. 1000">
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Max Budget (RM)</label>
                        <input type="number" name="recommended_max_budget"
                               class="border p-2 w-full rounded mb-4"
                               placeholder="e.g. 5000">
                    </div>
                </div>

                {{-- Recommended People --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-1">Min People</label>
                        <input type="number" name="recommended_people_min"
                               class="border p-2 w-full rounded mb-4"
                               placeholder="e.g. 10">
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Max People</label>
                        <input type="number" name="recommended_people_max"
                               class="border p-2 w-full rounded mb-4"
                               placeholder="e.g. 200">
                    </div>
                </div>

                {{-- Image Upload --}}
                <label class="block font-semibold mb-1">Activity Image</label>
                <input type="file" name="image"
                       accept="image/*"
                       class="border p-2 w-full rounded mb-4"
                       onchange="previewImage(event)">

                {{-- Preview Box --}}
                <div id="preview-box" class="hidden mt-2">
                    <p class="font-semibold mb-2">Image Preview:</p>
                    <img id="preview-image" src="#" class="w-48 rounded shadow">
                </div>

                {{-- Save Button --}}
                <button class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">
                    Save Activity
                </button>
            </form>
        </div>
    </div>

    {{-- Image Preview Script --}}
    <script>
        function previewImage(event) {
            const previewBox = document.getElementById('preview-box');
            const previewImage = document.getElementById('preview-image');
            previewBox.classList.remove('hidden');
            previewImage.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
</x-app-layout>
