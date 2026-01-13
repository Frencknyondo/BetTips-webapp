@extends('admin.layout')

@section('title','Ads')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold">Ads</h2>
        <a href="{{ route('admin.ads.create') }}" class="px-4 py-2 bg-green-600 rounded">Create Ad</a>
    </div>

    <div class="space-y-4">
        @foreach($ads as $ad)
            <div class="bg-gray-800 p-4 rounded flex items-center justify-between">
                <div>
                    <div class="font-bold">{{ $ad->title }} <span class="text-sm text-gray-400">@if(!$ad->is_active) (inactive) @endif</span></div>
                    <div class="text-sm text-gray-400">{{ $ad->body }}</div>
                </div>
                <div class="flex items-center gap-2">
                    <form method="POST" action="{{ route('admin.ads.toggle', $ad) }}">@csrf<button class="px-3 py-1 bg-gray-700 rounded">Toggle</button></form>
                    <a href="{{ route('admin.ads.edit', $ad) }}" class="px-3 py-1 bg-blue-600 rounded">Edit</a>
                    <form method="POST" action="{{ route('admin.ads.destroy', $ad) }}">@csrf @method('DELETE')<button class="px-3 py-1 bg-red-600 rounded">Delete</button></form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $ads->links() }}</div>
@endsection