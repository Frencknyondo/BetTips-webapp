<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notifications - Sports Betting Tips</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome icons (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #0a0e1a;
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="text-white">
    <!-- Header -->
    <header class="bg-black/50 backdrop-blur-md border-b border-gray-800">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <h1 class="text-2xl font-bold">BET<span class="text-green-500">TIPS</span></h1>
                </div>

                <!-- Navigation -->
                <nav class="flex items-center justify-center space-x-2 md:space-x-4 flex-1">
                    <a href="/" class="p-2 md:p-3 bg-gray-800 rounded-full hover:bg-gray-700 shadow-sm transform transition hover:scale-110"><i class="fas fa-home text-white text-xl"></i></a>
                    <a href="/tips" class="p-2 md:p-3 bg-gray-800 rounded-full hover:bg-gray-700 shadow-sm transform transition hover:scale-110"><i class="fas fa-lightbulb text-white text-xl"></i></a>
                    <a href="{{ route('favorites') }}" class="p-2 md:p-3 bg-gray-800 rounded-full hover:bg-gray-700 shadow-sm transform transition hover:scale-110"><i class="fas fa-heart text-white text-xl"></i></a>
                    <a href="{{ route('notifications') }}" class="p-2 md:p-3 bg-green-600 rounded-full hover:bg-green-700 shadow-sm transform transition hover:scale-110"><i class="fas fa-bell text-white text-xl"></i></a>
                    <a href="{{ route('account') }}" class="p-2 md:p-3 bg-gray-800 rounded-full hover:bg-gray-700 shadow-sm transform transition hover:scale-110">
                        <i class="fas fa-user text-white text-xl"></i>
                    </a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="ml-2 p-2 md:p-3 bg-green-600 rounded-full hover:bg-green-700 shadow-sm transform transition hover:scale-110" title="Admin">
                            <i class="fas fa-shield-alt text-white text-xl"></i>
                        </a>
                    @endif
                    @if(auth()->user()->isTipster())
                        <button id="addTipBtn" class="ml-2 p-2 md:p-3 bg-blue-600 rounded-full hover:bg-blue-700 shadow-sm transform transition hover:scale-110" title="Add New Tip">
                            <i class="fas fa-plus text-white text-xl"></i>
                        </button>
                    @endif
                </nav>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="ml-4">
                    @csrf
                    <button type="submit" class="p-2 md:p-3 bg-red-600 rounded-full hover:bg-red-700 shadow-sm transform transition hover:scale-110" title="Logout">
                        <i class="fas fa-sign-out-alt text-white text-xl"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Flash messages -->
    @if(session('success'))
        <div class="max-w-4xl mx-auto mb-4">
            <div class="p-3 rounded-md bg-green-600 text-white">{{ session('success') }}</div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-6">Notifications</h1>

            <div class="space-y-4">
                @forelse($notifications as $notification)
                    <div class="bg-zinc-800 rounded-2xl p-6 {{ $notification->pivot->is_read ? 'opacity-75' : 'border-l-4 border-green-500' }}">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-white mb-2">{{ $notification->title }}</h3>
                                <p class="text-gray-300 mb-3">{{ $notification->message }}</p>
                                <div class="text-sm text-gray-500">
                                    Sent {{ $notification->created_at->diffForHumans() }}
                                    @if($notification->creator)
                                        by {{ $notification->creator->name }}
                                    @endif
                                </div>
                            </div>
                            @if(!$notification->pivot->is_read)
                                <button onclick="markAsRead({{ $notification->id }})"
                                        class="px-3 py-1 bg-green-600 hover:bg-green-700 rounded text-sm text-white ml-4">
                                    Mark as Read
                                </button>
                            @else
                                <span class="text-green-400 text-sm ml-4">
                                    <i class="fas fa-check"></i> Read
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-zinc-800 rounded-2xl p-12 text-center">
                        <i class="fas fa-bell-slash text-6xl text-gray-600 mb-4"></i>
                        <h3 class="text-xl font-bold text-white mb-2">No notifications yet</h3>
                        <p class="text-gray-400">You'll see your notifications here when admins send them.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($notifications->hasPages())
                <div class="mt-8">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </main>

    <script>
        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the page to update the UI
                    location.reload();
                } else {
                    alert('Error marking notification as read');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Network error. Please try again.');
            });
        }
    </script>
</body>
</html>