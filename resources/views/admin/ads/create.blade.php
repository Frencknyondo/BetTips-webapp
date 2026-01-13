@extends('admin.layout')

@section('title','Create Ad')

@section('content')
    <h2 class="text-xl font-bold mb-4">Create Ad</h2>

    <form method="POST" action="{{ route('admin.ads.store') }}" enctype="multipart/form-data" class="space-y-3">
        @csrf
        <div>
            <label class="block text-sm text-gray-400">Title</label>
            <input name="title" class="w-full mt-1 px-3 py-2 rounded bg-gray-900 border border-gray-700" required />
        </div>
        <div>
            <label class="block text-sm text-gray-400">Body</label>
            <textarea name="body" class="w-full mt-1 px-3 py-2 rounded bg-gray-900 border border-gray-700"></textarea>
        </div>
        <div>
            <label class="block text-sm text-gray-400">Link</label>
            <input name="link" class="w-full mt-1 px-3 py-2 rounded bg-gray-900 border border-gray-700" />
        </div>
        <div>
            <label class="block text-sm text-gray-400">Media (image or video) <span class="text-xs text-gray-500">(Max 40MB, mp4/webm/jpg/png/webp/gif)</span></label>
            <input type="file" name="media" accept="image/*,video/*" class="mt-1 text-sm" />
            @error('media')
                <div class="text-sm text-red-400 mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label class="inline-flex items-center"><input type="checkbox" name="is_active" checked class="mr-2"/> Active</label>
        </div>
        <div>
            <button class="px-4 py-2 bg-green-600 rounded">Create</button>
        </div>
    </form>
@endsection