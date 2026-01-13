@extends('admin.layout')

@section('title','Edit Ad')

@section('content')
    <h2 class="text-xl font-bold mb-4">Edit Ad</h2>

    <form method="POST" action="{{ route('admin.ads.update', $ad) }}" enctype="multipart/form-data" class="space-y-3">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm text-gray-400">Title</label>
            <input name="title" value="{{ $ad->title }}" class="w-full mt-1 px-3 py-2 rounded bg-gray-900 border border-gray-700" required />
        </div>
        <div>
            <label class="block text-sm text-gray-400">Body</label>
            <textarea name="body" class="w-full mt-1 px-3 py-2 rounded bg-gray-900 border border-gray-700">{{ $ad->body }}</textarea>
        </div>
        <div>
            <label class="block text-sm text-gray-400">Link</label>
            <input name="link" value="{{ $ad->link }}" class="w-full mt-1 px-3 py-2 rounded bg-gray-900 border border-gray-700" />
        </div>
        <div>
            <label class="block text-sm text-gray-400">Media (image or video) (leave blank to keep) <span class="text-xs text-gray-500">(Max 40MB)</span></label>
            <input type="file" name="media" accept="image/*,video/*" class="mt-1 text-sm" />
            @error('media')
                <div class="text-sm text-red-400 mt-1">{{ $message }}</div>
            @enderror
            @if($ad->image_path)
                <div class="mt-2">
                    @php
                        $ext = strtolower(pathinfo($ad->image_path, PATHINFO_EXTENSION));
                    @endphp
                    @if(in_array($ext, ['mp4','webm']))
                        <video src="{{ asset('storage/'.$ad->image_path) }}" class="w-40 rounded" controls></video>
                    @else
                        <img src="{{ asset('storage/'.$ad->image_path) }}" class="w-40 rounded" />
                    @endif
                </div>
            @endif
        </div>
        <div>
            <label class="inline-flex items-center"><input type="checkbox" name="is_active" @if($ad->is_active) checked @endif class="mr-2"/> Active</label>
        </div>
        <div>
            <button class="px-4 py-2 bg-green-600 rounded">Save</button>
        </div>
    </form>
@endsection