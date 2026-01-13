@extends('admin.layout')

@section('title','Send Notification')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold">Send Notification</h2>
        <a href="{{ route('admin.notifications.index') }}" class="px-4 py-2 bg-gray-600 rounded">Back</a>
    </div>

    <form method="POST" action="{{ route('admin.notifications.store') }}" class="bg-gray-800 p-6 rounded">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300 mb-2">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required
                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white">
            @error('title')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300 mb-2">Message</label>
            <textarea name="message" rows="4" required
                      class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white">{{ old('message') }}</textarea>
            @error('message')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-300 mb-2">Recipients</label>

            <!-- Send to All Users Option -->
            <div class="mb-3">
                <label class="inline-flex items-center">
                    <input type="checkbox" id="send-to-all" name="send_to_all" value="1" class="mr-2">
                    <span class="text-sm text-gray-300 font-medium">Send to ALL users</span>
                </label>
            </div>

            <!-- Individual User Selection -->
            <div id="user-selection" class="max-h-64 overflow-y-auto border border-gray-600 rounded p-3 bg-gray-700">
                @foreach($users as $user)
                    <label class="flex items-center mb-2">
                        <input type="checkbox" name="recipients[]" value="{{ $user->id }}"
                               class="user-checkbox mr-2" {{ in_array($user->id, old('recipients', [])) ? 'checked' : '' }}>
                        <span class="text-sm text-gray-300">{{ $user->name }} ({{ $user->email }})</span>
                    </label>
                @endforeach
            </div>
            @error('recipients')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.notifications.index') }}" class="px-4 py-2 bg-gray-600 rounded">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-green-600 rounded">Send Notification</button>
        </div>
    </form>

    <script>
        document.getElementById('send-to-all').addEventListener('change', function() {
            const userSelection = document.getElementById('user-selection');
            if (this.checked) {
                userSelection.style.display = 'none';
                // Clear any selected individual users
                document.querySelectorAll('.user-checkbox').forEach(cb => cb.checked = false);
            } else {
                userSelection.style.display = 'block';
            }
        });
    </script>
@endsection