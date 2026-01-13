<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-linear-to-br from-gray-100 to-blue-100 text-gray-900 min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white min-h-screen p-4">
            <h2 class="text-xl font-bold mb-6">Master Admin</h2>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 py-2 px-4 rounded hover:bg-gray-700">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.ads.index') }}" class="flex items-center space-x-2 py-2 px-4 rounded hover:bg-gray-700">
                    <i class="fas fa-ad"></i>
                    <span>Ads</span>
                </a>
                <a href="{{ route('admin.tips.index') }}" class="flex items-center space-x-2 py-2 px-4 rounded hover:bg-gray-700">
                    <i class="fas fa-lightbulb"></i>
                    <span>Tips</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-2 py-2 px-4 rounded hover:bg-gray-700">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
                <a href="{{ route('admin.role_changes.index') }}" class="flex items-center space-x-2 py-2 px-4 rounded hover:bg-gray-700">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Role Changes</span>
                </a>
                <a href="{{ route('admin.notifications.index') }}" class="flex items-center space-x-2 py-2 px-4 rounded hover:bg-gray-700">
                    <i class="fas fa-bell"></i>
                    <span>Notifications</span>
                </a>
                <a href="/" class="flex items-center space-x-2 py-2 px-4 rounded hover:bg-gray-700">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to site</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="flex items-center space-x-2 py-2 px-4 rounded hover:bg-gray-700 w-full text-left">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>
</html>
