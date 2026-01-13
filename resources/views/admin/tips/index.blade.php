@extends('admin.layout')

@section('title','Tips')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold">Tips</h2>
        <a href="{{ route('admin.tips.create') }}" class="px-4 py-2 bg-green-600 rounded">Add Tip</a>
    </div>

    <div class="space-y-4">
        @foreach($tips as $tip)
            <div class="bg-gray-800 p-4 rounded flex items-center justify-between">
                <div>
                    <div class="font-bold">{{ $tip->title }} <span class="text-sm text-gray-400">@if(!$tip->is_active) (inactive) @endif</span></div>
                    <div class="text-sm text-gray-400">{{ $tip->body }}</div>
                </div>
                <div class="flex items-center gap-2">
                    <form method="POST" action="{{ route('admin.tips.toggle', $tip) }}">@csrf<button class="px-3 py-1 bg-gray-700 rounded">Toggle</button></form>
                    <a href="{{ route('admin.tips.edit', $tip) }}" class="px-3 py-1 bg-blue-600 rounded">Edit</a>
                    <form method="POST" action="{{ route('admin.tips.destroy', $tip) }}">@csrf @method('DELETE')<button class="px-3 py-1 bg-red-600 rounded">Delete</button></form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $tips->links() }}</div>
@endsection
