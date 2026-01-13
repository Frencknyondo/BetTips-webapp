<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $user->name }}'s Tips - BETTIPS</title>
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
                    <a href="{{ route('favorites') }}" class="p-2 md:p-3 bg-green-600 rounded-full hover:bg-green-700 shadow-sm transform transition hover:scale-110"><i class="fas fa-heart text-white text-xl"></i></a>
                    <a href="{{ route('notifications') }}" class="p-2 md:p-3 bg-gray-800 rounded-full hover:bg-gray-700 shadow-sm transform transition hover:scale-110"><i class="fas fa-bell text-white text-xl"></i></a>
                    @guest
                        <button id="account-btn" class="p-2 md:p-3 bg-gray-800 rounded-full hover:bg-gray-700 shadow-sm transform transition hover:scale-110" aria-haspopup="dialog" aria-controls="auth-modal">
                            <i class="fas fa-user text-white text-xl"></i>
                        </button>
                    @endguest
                    @auth
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
                    @endauth
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

    <!-- User Header -->
    <div class="container mx-auto px-4 py-6">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('favorites') }}" class="text-gray-400 hover:text-white">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center bg-gray-700">
                            @if($user->profile_picture)
                                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile" class="w-full h-full rounded-full object-cover">
                            @else
                                <i class="fas fa-user-circle text-gray-400 text-4xl"></i>
                            @endif
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white">{{ $user->name }}'s Tips</h1>
                            <p class="text-gray-400">{{ $user->followers()->count() }} followers</p>
                            @if($user->isTipster())
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="px-2 py-1 rounded text-xs font-bold bg-blue-600 text-white">{{ $user->getTipsterLevel() }}</span>
                                    <span class="text-xs text-gray-400">{{ $user->getTipsterStats()['win_rate'] }}% win rate</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <button class="follow-btn px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition-colors"
                            data-user-id="{{ $user->id }}"
                            data-following="true">
                        Following
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @if($tips->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($tips as $tip)
                    <div class="bg-zinc-800 rounded-2xl p-6">
                        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-zinc-700">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center bg-gray-700">
                                <i class="fas fa-user-circle text-gray-400 text-4xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-white text-xl font-bold">{{ $user->name }}</h3>
                                <p class="text-gray-400 text-sm">Tipster</p>
                            </div>
                            <div class="px-4 py-2 rounded-lg text-sm font-bold text-black {{ $tip->tip_type === 'premium' ? 'bg-yellow-500' : ($tip->tip_type === 'locked' ? 'bg-orange-500' : 'bg-white') }}">
                                {{ strtoupper($tip->tip_type) }}
                            </div>
                        </div>

                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <div class="text-white text-4xl font-bold mb-2">{{ $tip->odds }}</div>
                                <div class="text-gray-400 text-sm">Odds</div>
                            </div>
                            <div class="bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                                Active
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="bg-white px-4 py-2 rounded inline-block">
                                <span class="font-bold text-sm text-black">{{ $tip->company }}</span>
                            </div>
                        </div>

                        <div class="text-gray-400 text-sm mb-4">
                            Stake: {{ $tip->stake ?? 'N/A' }}
                        </div>

                        <a href="{{ route('tips.show', $tip) }}" class="w-full bg-emerald-400 hover:bg-emerald-500 text-black font-bold text-lg py-3 rounded-xl flex items-center justify-center gap-2 transition-colors">
                            View Full Tip
                            <div class="bg-emerald-300 rounded-full p-1">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                                </svg>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center text-gray-400">
                <i class="fas fa-lightbulb text-6xl mb-4"></i>
                <h2 class="text-2xl font-bold mb-2">No Tips Available</h2>
                <p>{{ $user->name }} hasn't posted any tips yet.</p>
                <div class="mt-6">
                    <a href="{{ route('favorites') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                        Back to Favorites
                    </a>
                </div>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-black/50 border-t border-gray-800 py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                    <h1 class="text-2xl font-bold">BET<span class="text-green-500">TIPS</span></h1>
                </div>

                <!-- Links -->
                <nav class="flex space-x-8 mb-4 md:mb-0">
                    <a href="#" class="text-gray-400 hover:text-white">About</a>
                    <a href="#" class="text-gray-400 hover:text-white">Contact</a>
                    <a href="#" class="text-gray-400 hover:text-white">Terms</a>
                    <a href="#" class="text-gray-400 hover:text-white">Privacy</a>
                    <a href="#" class="text-gray-400 hover:text-white">Help</a>
                </nav>

                <!-- Copyright -->
                <div class="text-gray-400">
                    © 2026 <span class="text-white">BET<span class="text-green-500">16TIPS</span></span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Auth modal (same as welcome.blade.php) -->
    <div id="auth-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-60 px-4 py-6" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="w-full max-w-2xl bg-[#071124] rounded-xl shadow-xl overflow-hidden border border-gray-800">
            <div class="flex">
                <div class="w-1/2 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold">Ingia / Jisajili</h3>
                        <button id="auth-close" class="text-white text-2xl leading-none">&times;</button>
                    </div>

                    <!-- Tabs -->
                    <div class="flex gap-2 mb-4">
                        <button id="tab-login" class="flex-1 py-2 rounded-md bg-transparent border border-gray-700 text-white">Ingia</button>
                        <button id="tab-register" class="flex-1 py-2 rounded-md bg-transparent text-white">Jisajili</button>
                    </div>

                    <!-- Login form -->
                    <form id="login-form" method="POST" action="{{ route('login') }}" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-sm text-gray-400">Barua pepe</label>
                            <input name="email" type="email" required class="w-full mt-1 px-3 py-2 rounded-xl bg-gray-900 border border-gray-700 text-white" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400">Nenosiri</label>
                            <input name="password" type="password" required class="w-full mt-1 px-3 py-2 rounded-xl bg-gray-900 border border-gray-700 text-white" />
                        </div>
                        <div class="flex items-center justify-between">
                            <label class="text-sm text-gray-400 flex items-center gap-2"><input type="checkbox" name="remember" class="h-4 w-4"> Kumbuka</label>
                            <button id="forgot-link" type="button" class="text-sm text-green-400 underline">Umesahau nenosiri?</button>
                        </div>
                        <div>
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold">Ingia</button>
                        </div>
                    </form>

                    <!-- Register form -->
                    <form id="register-form" method="POST" action="{{ route('register') }}" class="space-y-3 hidden">
                        @csrf
                        <div>
                            <label class="block text-sm text-gray-400">Jina</label>
                            <input name="name" type="text" required class="w-full mt-1 px-3 py-2 rounded-xl bg-gray-900 border border-gray-700 text-white" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400">Barua pepe</label>
                            <input name="email" type="email" required class="w-full mt-1 px-3 py-2 rounded-xl bg-gray-900 border border-gray-700 text-white" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400">Nambari ya simu</label>
                            <input name="phone" type="text" class="w-full mt-1 px-3 py-2 rounded-xl bg-gray-900 border border-gray-700 text-white" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400">Nenosiri</label>
                            <input name="password" type="password" required class="w-full mt-1 px-3 py-2 rounded-xl bg-gray-900 border border-gray-700 text-white" />
                        </div>
                        <div>
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold">Jisajili</button>
                        </div>
                        <div>
                            <button type="button" id="back-to-login" class="text-sm text-gray-400 underline">Rudi kwenye Ingia</button>
                        </div>
                    </form>
                </div>
                <div class="w-1/2 p-6 bg-[#061223] flex items-center justify-center">
                    <div class="text-center">
                        <h4 class="text-2xl font-bold mb-2">Karibu Senti16</h4>
                        <p class="text-sm text-gray-400">Tumia barua pepe yako kuingia au kujisajili. Tunaheshimu rangi na mtindo wa app.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auth modal JS (same as welcome.blade.php)
        (function(){
            const accountBtn = document.getElementById('account-btn');
            const authModal = document.getElementById('auth-modal');
            const authClose = document.getElementById('auth-close');
            const tabLogin = document.getElementById('tab-login');
            const tabRegister = document.getElementById('tab-register');
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const forgotForm = document.getElementById('forgot-form');
            const forgotLink = document.getElementById('forgot-link');
            const backToLogin = document.getElementById('back-to-login');

            function openModal(){
                authModal.classList.remove('hidden');
                authModal.classList.add('flex');
                showLogin();
            }
            function closeModal(){
                authModal.classList.remove('flex');
                authModal.classList.add('hidden');
            }
            function showLogin(){
                tabLogin.classList.add('bg-green-600');
                tabRegister.classList.remove('bg-green-600');
                loginForm.classList.remove('hidden');
                registerForm.classList.add('hidden');
                forgotForm.classList.add('hidden');
            }
            function showRegister(){
                tabRegister.classList.add('bg-green-600');
                tabLogin.classList.remove('bg-green-600');
                loginForm.classList.add('hidden');
                registerForm.classList.remove('hidden');
                forgotForm.classList.add('hidden');
            }
            function showForgot(){
                loginForm.classList.add('hidden');
                registerForm.classList.add('hidden');
                forgotForm.classList.remove('hidden');
            }

            accountBtn && accountBtn.addEventListener('click', openModal);
            authClose && authClose.addEventListener('click', closeModal);
            authModal && authModal.addEventListener('click', (e)=>{ if(e.target === authModal) closeModal(); });
            tabLogin && tabLogin.addEventListener('click', showLogin);
            tabRegister && tabRegister.addEventListener('click', showRegister);
            forgotLink && forgotLink.addEventListener('click', showForgot);
            backToLogin && backToLogin.addEventListener('click', showLogin);
            document.addEventListener('keydown', (e)=>{ if(e.key === 'Escape'){ closeModal(); } });
        })();

        // Follow/Unfollow functionality
        document.querySelectorAll('.follow-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const userId = this.dataset.userId;
                const isFollowing = this.dataset.following === 'true';

                fetch(`/users/${userId}/follow`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        if(data.following) {
                            this.textContent = 'Following';
                            this.className = 'follow-btn px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition-colors';
                            this.dataset.following = 'true';
                        } else {
                            this.textContent = 'Follow';
                            this.className = 'follow-btn px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-semibold rounded-lg transition-colors';
                            this.dataset.following = 'false';
                            // Redirect back to favorites since we're no longer following
                            window.location.href = '{{ route("favorites") }}';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Kosa katika kufuatilia mtumiaji');
                });
            });
        });
    </script>
</body>
</html>