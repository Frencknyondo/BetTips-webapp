<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $tip->title }} - BETTIPS</title>
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
                    <a href="/tips" class="p-2 md:p-3 bg-green-600 rounded-full hover:bg-green-700 shadow-sm transform transition hover:scale-110"><i class="fas fa-lightbulb text-white text-xl"></i></a>
                    <a href="{{ route('favorites') }}" class="p-2 md:p-3 bg-gray-800 rounded-full hover:bg-gray-700 shadow-sm transform transition hover:scale-110"><i class="fas fa-heart text-white text-xl"></i></a>
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

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('tips.index') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-colors">
                <i class="fas fa-arrow-left"></i>
                Back to Tips
            </a>
        </div>

        <!-- Tip Title -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $tip->title }}</h1>
            <div class="flex items-center gap-4 text-gray-400">
                <span>By {{ $tip->creator ? $tip->creator->name : 'Unknown' }}</span>
                <span class="px-3 py-1 rounded-lg text-sm font-bold text-black {{ $tip->tip_type === 'premium' ? 'bg-yellow-500' : ($tip->tip_type === 'locked' ? 'bg-orange-500' : 'bg-white') }}">
                    {{ strtoupper($tip->tip_type) }}
                </span>
                <span>{{ $tip->starts_at ? $tip->starts_at->format('M d, Y H:i') : 'N/A' }}</span>
            </div>
        </div>

        <!-- Tip Details Cards -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Odds Card -->
            <div class="bg-zinc-800 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold">Odds</h3>
                    <i class="fas fa-chart-line text-green-500 text-2xl"></i>
                </div>
                <div class="text-4xl font-bold text-white">{{ $tip->odds }}</div>
            </div>

            <!-- Company Card -->
            <div class="bg-zinc-800 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold">Company</h3>
                    <i class="fas fa-building text-blue-500 text-2xl"></i>
                </div>
                <div class="bg-white px-4 py-2 rounded inline-block">
                    <span class="font-bold text-sm text-black">{{ $tip->company }}</span>
                </div>
            </div>

            <!-- Stake Card -->
            <div class="bg-zinc-800 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold">Stake</h3>
                    <i class="fas fa-star text-yellow-500 text-2xl"></i>
                </div>
                <div class="text-3xl font-bold text-white">{{ $tip->stake ?? 'N/A' }}/10</div>
            </div>

            <!-- Validity Card -->
            <div class="bg-zinc-800 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold">Valid Until</h3>
                    <i class="fas fa-clock text-purple-500 text-2xl"></i>
                </div>
                <div class="text-lg font-semibold text-white">
                    @if($tip->validity_time)
                        {{ \Carbon\Carbon::createFromTimestamp($tip->validity_time)->format('M d, Y H:i') }}
                    @else
                        N/A
                    @endif
                </div>
            </div>

            <!-- Status Card -->
            <div class="bg-zinc-800 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold">Status</h3>
                    <i class="fas fa-info-circle text-green-500 text-2xl"></i>
                </div>
                <div class="bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold inline-block">
                    Active
                </div>
            </div>

            <!-- Price Card (if applicable) -->
            @if($tip->price)
                <div class="bg-zinc-800 rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold">Price</h3>
                        <i class="fas fa-money-bill-wave text-green-500 text-2xl"></i>
                    </div>
                    <div class="text-2xl font-bold text-white">{{ number_format($tip->price) }} TZS</div>
                </div>
            @endif
        </div>

        <!-- Bet Code Card -->
        <div class="bg-zinc-800 rounded-2xl p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold">Bet Code</h3>
                <i class="fas fa-ticket-alt text-orange-500 text-2xl"></i>
            </div>
            @if($tip->tip_type === 'free')
                <div class="bg-gray-900 px-4 py-3 rounded-lg flex items-center justify-between">
                    <span class="font-mono text-lg text-white">{{ $tip->bet_code }}</span>
                    <button onclick="copyToClipboard('{{ $tip->bet_code }}')" class="ml-4 bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition-colors">
                        <i class="fas fa-copy"></i> Copy
                    </button>
                </div>
            @elseif($tip->tip_type === 'premium')
                @php
                    $isUnlocked = auth()->check() && $tip->accessCodes()->where('used_by', auth()->id())->where('is_used', true)->exists();
                @endphp
                @if($isUnlocked)
                    <div class="bg-gray-900 px-4 py-3 rounded-lg flex items-center justify-between">
                        <span class="font-mono text-lg text-white">{{ $tip->bet_code }}</span>
                        <button onclick="copyToClipboard('{{ $tip->bet_code }}')" class="ml-4 bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition-colors">
                            <i class="fas fa-copy"></i> Copy
                        </button>
                    </div>
                @else
                    <div class="bg-gray-900 px-4 py-3 rounded-lg flex items-center justify-between cursor-pointer" onclick="showUnlockModal()">
                        <span class="font-mono text-lg text-white">{{ substr($tip->bet_code, 0, 3) }}****</span>
                        <span class="text-gray-400 text-sm">Enter Access Code to unlock</span>
                    </div>
                @endif
            @else
                <div class="bg-gray-900 px-4 py-3 rounded-lg flex items-center justify-between">
                    <span class="font-mono text-lg text-white">{{ substr($tip->bet_code, 0, 3) }}****</span>
                    <span class="text-gray-400 text-sm">Subscribe to view full code</span>
                </div>
            @endif
        </div>

        <!-- Description Card -->
        @if($tip->body)
            <div class="bg-zinc-800 rounded-2xl p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold">Description</h3>
                    <i class="fas fa-comment text-blue-500 text-2xl"></i>
                </div>
                <p class="text-gray-300 leading-relaxed">{{ $tip->body }}</p>
            </div>
        @endif

        <!-- Image Card -->
        @if($tip->image_path)
            <div class="bg-zinc-800 rounded-2xl p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold">Bet Slip</h3>
                    <i class="fas fa-image text-purple-500 text-2xl"></i>
                </div>
                @if($tip->tip_type === 'free')
                    <img src="{{ asset('storage/' . $tip->image_path) }}" alt="Bet Slip" class="w-full rounded-lg">
                @elseif($tip->tip_type === 'premium')
                    @php
                        $isUnlocked = auth()->check() && $tip->accessCodes()->where('used_by', auth()->id())->where('is_used', true)->exists();
                    @endphp
                    @if($isUnlocked)
                        <img src="{{ asset('storage/' . $tip->image_path) }}" alt="Bet Slip" class="w-full rounded-lg">
                    @else
                        <div class="relative cursor-pointer" onclick="showUnlockModal()">
                            <img src="{{ asset('storage/' . $tip->image_path) }}" alt="Bet Slip" class="w-full rounded-lg filter blur-sm">
                            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded-lg">
                                <div class="text-center">
                                    <i class="fas fa-lock text-4xl text-white mb-2"></i>
                                    <p class="text-white font-semibold">Enter Access Code to unlock</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="relative">
                        <img src="{{ asset('storage/' . $tip->image_path) }}" alt="Bet Slip" class="w-full rounded-lg filter blur-sm">
                        <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded-lg">
                            <div class="text-center">
                                <i class="fas fa-lock text-4xl text-white mb-2"></i>
                                <p class="text-white font-semibold">Subscribe to view full slip</p>
                            </div>
                        </div>
                    </div>
                @endif
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

    <!-- Unlock Modal -->
    <div id="unlock-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-60 px-4 py-6" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="w-full max-w-md bg-zinc-800 rounded-2xl shadow-xl overflow-hidden border border-gray-700">
            <div class="flex items-center justify-between p-6 border-b border-zinc-700">
                <h3 class="text-xl font-bold text-white">Enter Access Code</h3>
                <button id="unlock-close" class="text-white text-2xl leading-none">&times;</button>
            </div>
            <div class="p-6">
                <form id="unlock-form">
                    <div class="mb-4">
                        <label class="block text-sm text-gray-400 mb-2">Access Code</label>
                        <input type="text" id="access-code" name="code" placeholder="Enter your access code" class="w-full px-3 py-2 rounded-lg bg-gray-900 border border-gray-700 text-white" required>
                    </div>
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg font-semibold transition-colors">
                        Unlock Tip
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Auth modal (same as tips.blade.php) -->
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
        // Auth modal JS (same as tips.blade.php)
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

        // Copy to clipboard function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success message
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                notification.textContent = 'Bet code copied to clipboard!';
                document.body.appendChild(notification);
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 3000);
            }).catch(function(err) {
                console.error('Failed to copy: ', err);
                alert('Failed to copy bet code');
            });
        }

        // Unlock modal functionality
        (function(){
            const unlockModal = document.getElementById('unlock-modal');
            const unlockClose = document.getElementById('unlock-close');
            const unlockForm = document.getElementById('unlock-form');
            const accessCodeInput = document.getElementById('access-code');

            function showUnlockModal(){
                unlockModal.classList.remove('hidden');
                unlockModal.classList.add('flex');
                accessCodeInput.focus();
            }

            function hideUnlockModal(){
                unlockModal.classList.remove('flex');
                unlockModal.classList.add('hidden');
                unlockForm.reset();
            }

            function unlockTip(code){
                fetch('/tips/{{ $tip->id }}/unlock', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ code: code })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Reload the page to show unlocked content
                        location.reload();
                    } else {
                        alert('❌ ' + (data.message || 'Invalid access code'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('❌ Network error. Please try again.');
                });
            }

            // Event listeners
            window.showUnlockModal = showUnlockModal;
            unlockClose && unlockClose.addEventListener('click', hideUnlockModal);
            unlockModal && unlockModal.addEventListener('click', (e) => { if(e.target === unlockModal) hideUnlockModal(); });
            document.addEventListener('keydown', (e) => { if(e.key === 'Escape' && unlockModal.classList.contains('flex')) hideUnlockModal(); });

            unlockForm && unlockForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const code = accessCodeInput.value.trim();
                if(code) {
                    unlockTip(code);
                }
            });
        })();
    </script>
</body>
</html></html>
