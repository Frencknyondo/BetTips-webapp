<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account - BETTIPS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome icons (CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #0a0e1a;
            font-family: 'Inter', sans-serif;
        }
        .gradient-gold {
            background: linear-gradient(135deg, #d4a574 0%, #8b6914 100%);
        }
        .gradient-blue {
            background: linear-gradient(135deg, #4169e1 0%, #1e3a8a 100%);
        }
        .gradient-green {
            background: linear-gradient(135deg, #10b981 0%, #065f46 100%);
        }
        .card-hover {
            transition: transform 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
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
                    <a href="{{ route('notifications') }}" class="p-2 md:p-3 bg-gray-800 rounded-full hover:bg-gray-700 shadow-sm transform transition hover:scale-110"><i class="fas fa-bell text-white text-xl"></i></a>
                    @if(!auth()->user()->isTipster())
                        <a href="{{ route('account') }}" class="p-2 md:p-3 bg-gray-800 rounded-full hover:bg-gray-700 shadow-sm transform transition hover:scale-110">
                            <i class="fas fa-user text-white text-xl"></i>
                        </a>
                    @endif
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="ml-2 p-2 md:p-3 bg-green-600 rounded-full hover:bg-green-700 shadow-sm transform transition hover:scale-110" title="Admin">
                            <i class="fas fa-shield-alt text-white text-xl"></i>
                        </a>
                    @endif
                </nav>
            </div>
        </div>
    </header>

    <!-- Flash messages -->
    @if(session('success'))
        <div class="max-w-4xl mx-auto mb-4">
            <div class="p-3 rounded-md bg-green-600 text-white">{{ session('success') }}</div>
        </div>
    @endif
    @if($errors->any())
        <div class="max-w-4xl mx-auto mb-4">
            <div class="p-3 rounded-md bg-red-600 text-white">{{ $errors->first() }}</div>
        </div>
    @endif

    <!-- Account Content -->
    <div class="container mx-auto p-6">
        <!-- Profile Section -->
        <div class="max-w-4xl mx-auto mb-8">
            <div class="flex items-center space-x-6 mb-6">
                <!-- Profile Picture -->
                <div class="relative">
                    <div class="w-24 h-24 bg-gray-700 rounded-full overflow-hidden">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i class="fas fa-user text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    <!-- Camera Icon -->
                    <button class="absolute bottom-0 right-0 bg-green-500 text-white p-2 rounded-full hover:bg-green-600 transition-colors" onclick="document.getElementById('profile-picture-input').click()">
                        <i class="fas fa-camera text-sm"></i>
                    </button>
                    <input type="file" id="profile-picture-input" class="hidden" accept="image/*" onchange="uploadProfilePicture(this)">
                </div>

                <!-- Name and Followers -->
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-white mb-2">{{ $user->name }}</h2>
                    <p class="text-gray-400">{{ $user->followers()->count() }} followers</p>
                </div>
            </div>
        </div>

        <!-- Cards Section -->
        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- My Transaction Card -->
                <div class="bg-gray-800 rounded-lg p-6 hover:bg-gray-700 transition-colors cursor-pointer">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-receipt text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">My Transaction</h3>
                            <p class="text-gray-400 text-sm">View your transaction history</p>
                        </div>
                    </div>
                </div>

                <!-- Logout Card -->
                <div class="bg-gray-800 rounded-lg p-6 hover:bg-gray-700 transition-colors cursor-pointer" onclick="document.getElementById('logout-form').submit()">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-sign-out-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white">Logout</h3>
                            <p class="text-gray-400 text-sm">Sign out of your account</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($user->isTipster())
                <!-- My Tips Card -->
                <div class="bg-linear-to-r from-green-600 to-blue-600 rounded-lg p-8 text-center">
                    <div class="mb-4">
                        <i class="fas fa-lightbulb text-yellow-400 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">My Tips</h3>
                    <p class="text-gray-200 mb-6">View all your tips</p>
                    <button class="bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors" onclick="window.location.href='/tips'">
                        View Tips
                    </button>
                </div>

                <!-- Access Codes Section -->
                <div class="bg-zinc-800 rounded-2xl p-6 mt-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-white">Access Codes</h3>
                        <i class="fas fa-key text-yellow-500 text-2xl"></i>
                    </div>
                    <div class="space-y-3">
                        @php
                            $accessCodes = \App\Models\AccessCode::where('created_by', $user->id)
                                ->with('tip')
                                ->orderBy('created_at', 'desc')
                                ->get()
                                ->groupBy('tip_id');
                        @endphp

                        @if($accessCodes->count() > 0)
                            @foreach($accessCodes as $tipId => $codes)
                                @php $tip = $codes->first()->tip; @endphp
                                @if($tip)
                                    <div class="bg-zinc-700 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="text-white font-semibold">{{ $tip->title }}</h4>
                                            <span class="text-sm text-gray-400">{{ $codes->count() }} codes</span>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                                            @foreach($codes as $code)
                                                <div class="bg-zinc-600 rounded p-2 flex items-center justify-between">
                                                    <code class="text-green-400 text-sm font-mono">{{ $code->code }}</code>
                                                    @if($code->is_used)
                                                        <span class="text-red-400 text-xs">Used</span>
                                                    @else
                                                        <button onclick="copyToClipboard('{{ $code->code }}')" class="text-blue-400 hover:text-blue-300 text-xs">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <p class="text-gray-400 text-center py-4">No access codes generated yet</p>
                        @endif
                    </div>
                </div>
            @else
                <!-- Professional Account Card -->
                <div class="gradient-blue rounded-lg p-8 text-center card-hover">
                    <div class="mb-4">
                        <i class="fas fa-star text-yellow-400 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Turn Professional Account</h3>
                    <p class="text-gray-200 mb-6">Become a Tipster</p>
                    <a href="{{ route('tipster.apply') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-block">
                        Upgrade Now
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Hidden Logout Form -->
    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
        @csrf
    </form>

    <script>
        function uploadProfilePicture(input) {
            if (input.files && input.files[0]) {
                const formData = new FormData();
                formData.append('profile_picture', input.files[0]);
                formData.append('_token', '{{ csrf_token() }}');

                fetch('/account/update-profile-picture', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error uploading profile picture');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error uploading profile picture');
                });
            }
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success message
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                notification.textContent = 'Code copied to clipboard!';
                document.body.appendChild(notification);
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 3000);
            }).catch(function(err) {
                console.error('Failed to copy: ', err);
                alert('Failed to copy code');
            });
        }
    </script>
</body>
</html>
