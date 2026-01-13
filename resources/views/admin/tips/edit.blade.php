@extends('admin.layout')

@section('title','Edit Tip')

@section('content')
    <h2 class="text-xl font-bold mb-4">Edit Tip</h2>

    <form method="POST" action="{{ route('admin.tips.update', $tip) }}" enctype="multipart/form-data" class="space-y-3">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm text-gray-400">Title</label>
            <input name="title" value="{{ old('title', $tip->title) }}" class="w-full mt-1 px-3 py-2 rounded bg-gray-900 border border-gray-700" required />
        </div>
        <div>
            <label class="block text-sm text-gray-400">Body</label>
            <textarea name="body" class="w-full mt-1 px-3 py-2 rounded bg-gray-900 border border-gray-700">{{ old('body', $tip->body) }}</textarea>
        </div>
        <div>
            <label class="block text-sm text-gray-400">Link</label>
            <input name="link" value="{{ old('link', $tip->link) }}" class="w-full mt-1 px-3 py-2 rounded bg-gray-900 border border-gray-700" />
        </div>
        <div>
            <label class="block text-sm text-gray-400">Media (image or video) <span class="text-xs text-gray-500">(Max 40MB, mp4/webm/jpg/png/webp/gif)</span></label>
            <input type="file" name="media" accept="image/*,video/*" class="mt-1 text-sm" />
            @if($tip->image_path)
                <div class="text-sm text-gray-400 mt-1">Current: {{ basename($tip->image_path) }}</div>
            @endif
            @error('media')
                <div class="text-sm text-red-400 mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label class="inline-flex items-center"><input type="checkbox" name="is_active" {{ $tip->is_active ? 'checked' : '' }} class="mr-2"/> Active</label>
        </div>
        <div>
            <button class="px-4 py-2 bg-green-600 rounded">Update</button>
        </div>
    </form>
@endsection
