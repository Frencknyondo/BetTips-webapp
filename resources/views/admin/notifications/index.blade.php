@extends('admin.layout')

@section('title','Notifications')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold">Notifications</h2>
        <a href="{{ route('admin.notifications.create') }}" class="px-4 py-2 bg-green-600 rounded">Send Notification</a>
    </div>

    <div class="space-y-4">
        @forelse($notifications as $notification)
            <div class="bg-gray-800 p-4 rounded">
                <div class="flex items-center justify-between mb-2">
                    <div class="font-bold">{{ $notification->title }}</div>
                    <div class="text-sm text-gray-400">{{ $notification->created_at->diffForHumans() }}</div>
                </div>
                <div class="text-sm text-gray-300 mb-2">{{ Str::limit($notification->message, 100) }}</div>
                <div class="text-xs text-gray-500 mb-2">
                    Sent by: {{ $notification->creator->name ?? 'Unknown' }} |
                    Recipients: {{ $notification->users()->count() }} users
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.notifications.show', $notification) }}" class="px-3 py-1 bg-blue-600 rounded text-sm">View Details</a>
                    <form method="POST" action="{{ route('admin.notifications.destroy', $notification) }}" class="inline">
                        @csrf @method('DELETE')
                        <button class="px-3 py-1 bg-red-600 rounded text-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-gray-800 p-4 rounded text-center text-gray-400">
                No notifications sent yet.
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $notifications->links() }}</div>
@endsection