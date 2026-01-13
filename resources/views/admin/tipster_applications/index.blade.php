@extends('admin.layout')

@section('title','Tipster Applications')

@section('content')
    <h2 class="text-xl font-bold mb-4">Tipster Applications</h2>

    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-600 text-white">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 rounded bg-red-600 text-white">{{ session('error') }}</div>
    @endif

    <div class="space-y-3">
        @forelse($applications as $app)
            <div class="bg-gray-800 p-4 rounded">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center">
                            @if($app->user->profile_picture)
                                <img src="{{ asset('storage/'.$app->user->profile_picture) }}" alt="{{ $app->user->name }}" class="w-full h-full rounded-full object-cover">
                            @else
                                <i class="fas fa-user text-gray-400"></i>
                            @endif
                        </div>
                        <div>
                            <div class="font-bold">{{ $app->user->name }}</div>
                            <div class="text-sm text-gray-400">{{ $app->user->email }} • {{ $app->user->phone }}</div>
                            <div class="text-sm text-gray-400">Applied: {{ $app->created_at->format('M j, Y') }}</div>
                        </div>
                    </div>
                <div class="text-right">
                        @php
                            $statusClass = match($app->status) {
                                'pending' => 'bg-yellow-600',
                                'approved' => 'bg-green-600',
                                'rejected' => 'bg-red-600',
                                default => 'bg-gray-600'
                            };
                        @endphp
                        <span class="px-2 py-1 rounded text-xs font-bold text-white {{ $statusClass }}">
                            {{ ucfirst($app->status) }}
                        </span>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4 mb-3">
                    <div>
                        <strong>Experience:</strong> {{ $app->experience }} years
                    </div>
                    <div>
                        <strong>Sports:</strong> {{ ucfirst($app->sports) }}
                    </div>
                    <div>
                        <strong>Contact:</strong> {{ $app->contact }}
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Bio:</strong>
                    <p class="text-gray-300 mt-1">{{ $app->bio }}</p>
                </div>

                @if($app->status === 'pending')
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('admin.tipster_applications.approve', $app) }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded text-white font-semibold">
                                Approve
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.tipster_applications.reject', $app) }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded text-white font-semibold">
                                Reject
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-gray-800 p-4 rounded text-center text-gray-400">
                No tipster applications found.
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $applications->links() }}</div>
@endsection
