@extends('admin.layout')

@section('title','Role Changes')

@section('content')
    <h2 class="text-xl font-bold mb-4">Role changes audit</h2>

    <div class="space-y-3">
        @foreach($changes as $c)
            <div class="bg-gray-800 p-3 rounded">
                <div class="text-sm text-gray-300">{{ $c->created_at->diffForHumans() }} by {{ optional($c->actor)->name ?? 'system' }}</div>
                <div class="font-bold">{{ $c->user->name }}: <span class="text-green-300">{{ $c->old_role ?? '(none)' }} → {{ $c->new_role }}</span></div>
                @if($c->reason)
                    <div class="text-sm text-gray-400">Reason: {{ $c->reason }}</div>
                @endif
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $changes->links() }}</div>
@endsection