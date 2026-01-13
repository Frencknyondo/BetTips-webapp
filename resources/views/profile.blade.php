<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $user->name }} - Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    <a href="/" class="text-2xl font-bold">BET<span class="text-green-500">TIPS</span></a>
                </div>

                <!-- Navigation -->
                <nav class="flex items-center justify-center space-x-2 md:space-x-4 flex-1">
                    <a href="/" class="p-2 md:p-3 bg-gray-800 rounded-full hover:bg-gray-700 shadow-sm transform transition hover:scale-110"><i class="fas fa-home text-white text-xl"></i></a>
                    @guest
                        <button onclick="showLoginModal()" class="p-2 md:p-3 bg-gray-800 rounded-full hover:bg-gray-700 shadow-sm transform transition hover:scale-110" title="Login required"><i class="fas fa-lightbulb text-white text-xl"></i></button>
                        <button onclick="showLoginModal()" class="p-2 md:p-3 bg-gray-800 rounded-full hover:bg-gray-700 shadow-sm transform transition hover:scale-110" title="Login required"><i class="fas fa-heart text-white text-xl"></i></button>
                        <button onclick="showLoginModal()" class="p-2 md:p-3 bg-gray-800 rounded-full hover:bg-gray-700 shadow-sm transform transition hover:scale-110" title="Login required"><i class="fas fa-bell text-white text-xl"></i></button>
                        <button id="account-btn" class="p-2 md:p-3 bg-gray-800 rounded-full hover:bg-gray-700 shadow-sm transform transition hover:scale-110" aria-haspopup="dialog" aria-controls="auth-modal">
                            <i class="fas fa-user text-white text-xl"></i>
                        </button>
                    @endguest
                    @auth
                        <a href="/tips" class="p-2 md:p-3 bg-gray-800 rounded-full hover:bg-gray-700 shadow-sm transform transition hover:scale-110"><i class="fas fa-lightbulb text-white text-xl"></i></a>
                        <a href="{{ route('favorites') }}" class="p-2 md:p-3 bg-gray-800 rounded-full hover:bg-gray-700 shadow-sm transform transition hover:scale-110"><i class="fas fa-heart text-white text-xl"></i></a>
                        <a href="{{ route('notifications') }}" class="p-2 md:p-3 bg-gray-800 rounded-full hover:bg-gray-700 shadow-sm transform transition hover:scale-110 relative">
                            <i class="fas fa-bell text-white text-xl"></i>
                            @php $unreadCount = auth()->user()->getUnreadNotificationsCount(); @endphp
                            @if($unreadCount > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
                            @endif
                        </a>
                        @if(!auth()->user()->isAdmin())
                            <a href="{{ route('account') }}" class="p-2 md:p-3 bg-gray-800 rounded-full hover:bg-gray-700 shadow-sm transform transition hover:scale-110">
                                <i class="fas fa-user text-white text-xl"></i>
                            </a>
                        @endif
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

    <!-- Profile Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Profile Header -->
        <div class="bg-zinc-800 rounded-2xl p-6 mb-8">
            <div class="flex items-center gap-6">
                <div class="w-24 h-24 rounded-full {{ $user->getBackgroundGradient() }} flex items-center justify-center">
                    @if($user->profile_picture)
                        <img src="{{ asset('storage/'.$user->profile_picture) }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                    @else
                        <i class="fas fa-user text-white text-3xl"></i>
                    @endif
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-white mb-2">{{ $user->name }}</h1>
                    <div class="flex items-center gap-4 mb-4">
                        <div class="{{ $level_color }}-500 text-black px-3 py-1 rounded-full text-sm font-bold">
                            {{ $level }}
                        </div>
                        <div class="text-gray-400">
                            <i class="fas fa-users mr-1"></i>{{ $followers_count }} followers
                        </div>
                    </div>
                    @auth
                        @if(auth()->user()->id !== $user->id)
                            <button
                                onclick="toggleFollow({{ $user->id }}, this)"
                                data-following="{{ $is_following ? 'true' : 'false' }}"
                                class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg font-semibold transition-colors"
                            >
                                {{ $is_following ? 'Unfollow' : 'Follow' }}
                            </button>
                        @endif
                    @else
                        <button onclick="showLoginModal()" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg font-semibold transition-colors">
                            Follow
                        </button>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="bg-zinc-800 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-white mb-2">{{ $stats['total_tips'] }}</div>
                <div class="text-gray-400">Total Tips</div>
            </div>
            <div class="bg-zinc-800 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-white mb-2">{{ $stats['rated_tips'] }}</div>
                <div class="text-gray-400">Rated Tips</div>
            </div>
            <div class="bg-zinc-800 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-white mb-2">{{ $stats['win_rate'] }}%</div>
                <div class="text-gray-400">Win Rate</div>
            </div>
        </div>

        <!-- Tips Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-6">Latest Tips by {{ $user->name }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($user->tips()->where('is_active', true)->orderBy('created_at', 'desc')->take(12)->get() as $tip)
                    <div class="bg-zinc-800 rounded-2xl p-6 card-hover">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-full bg-gray-700 flex items-center justify-center">
                                @if($user->profile_picture)
                                    <img src="{{ asset('storage/'.$user->profile_picture) }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                                @else
                                    <i class="fas fa-user-circle text-gray-400"></i>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-white font-semibold">{{ $user->name }}</h4>
                                <p class="text-gray-400 text-sm">{{ \Carbon\Carbon::parse($tip->created_at)->diffForHumans() }}</p>
                            </div>
                            <div class="ml-auto">
                                @if($tip->tip_type === 'premium')
                                    <span class="bg-yellow-500 text-black px-2 py-1 rounded text-xs font-bold">PREMIUM</span>
                                @elseif($tip->tip_type === 'locked')
                                    <span class="bg-orange-500 text-black px-2 py-1 rounded text-xs font-bold">LOCKED</span>
                                @else
                                    <span class="bg-green-500 text-white px-2 py-1 rounded text-xs font-bold">FREE</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="text-white text-3xl font-bold">{{ $tip->odds }}</div>
                            <div class="text-gray-400 text-sm">Odds</div>
                        </div>

                        <div class="flex justify-between items-center mb-4">
                            <div class="text-gray-400 text-sm">{{ $tip->company }}</div>
                            @if($tip->tip_type !== 'free')
                                <div class="text-white font-bold">TZS {{ $tip->price }}</div>
                            @endif
                        </div>

                        <a href="/tips/{{ $tip->id }}" class="w-full bg-emerald-400 hover:bg-emerald-500 text-black font-bold py-3 rounded-xl flex items-center justify-center gap-2 transition-colors">
                            View Details
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    <!-- Auth modal (same as index.blade.php) -->
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

    <!-- Add Tip Form Modal (for tipsters only) -->
    @auth
        @if(auth()->user()->isTipster())
            <!-- Form Container -->
            <div id="formContainer" class="form-container">
                <div class="form-wrapper">
                    <button id="closeFormBtn" class="close-btn" title="Close">
                        <i class="fas fa-times"></i>
                    </button>

                    <div class="form-header">
                        <h1><i class="fas fa-bolt"></i> Add New Tip</h1>
                        <p>Jaza taarifa zote kwa usahihi</p>
                    </div>

                    <div class="form-content">
                        <form id="tipForm">
                            <!-- TITLE -->
                            <div class="form-group">
                                <label><i class="fas fa-pencil icon"></i> Jina la Tip</label>
                                <input type="text" name="title" placeholder="Weekend Sure Tips" required>
                            </div>

                            <!-- COMPANY & BET CODE -->
                            <div class="form-row">
                                <div class="form-group">
                                    <label><i class="fas fa-building icon"></i> Kampuni</label>
                                    <select name="company" required>
                                        <option value="">Chagua...</option>
                                        <option value="sportpesa">SportPesa</option>
                                        <option value="betway">BetWay</option>
                                        <option value="1xbet">1xBet</option>
                                        <option value="helabet">HelaBet</option>
                                        <option value="betin">BetIn</option>
                                        <option value="mozzartbet">MozzartBet</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><i class="fas fa-ticket icon"></i> Bet Code</label>
                                    <input type="text" name="bet_code" placeholder="SP894322" required>
                                </div>
                            </div>

                            <!-- ODDS & START TIME -->
                            <div class="form-row">
                                <div class="form-group">
                                    <label><i class="fas fa-chart-line icon"></i> Odds</label>
                                    <input type="number" name="odds" step="0.01" min="1.50" placeholder="2.15" required>
                                </div>

                                <div class="form-group">
                                    <label><i class="fas fa-clock icon"></i> Muda</label>
                                    <input type="datetime-local" name="start_time" required>
                                </div>
                            </div>

                            <!-- STAKE -->
                            <div class="form-group">
                                <label><i class="fas fa-star icon"></i> Stake (1-10)</label>
                                <input type="number" name="stake" min="1" max="10" placeholder="6">
                            </div>

                            <!-- VALIDITY TIME -->
                            <div class="form-group">
                                <label><i class="fas fa-clock icon"></i> Validity Time (seconds)</label>
                                <input type="number" name="validity_time" min="1" placeholder="3600" required>
                            </div>

                            <!-- TIP TYPE BUTTONS -->
                            <div class="form-group">
                                <label><i class="fas fa-bullseye icon"></i> Aina ya Tip</label>
                                <div class="tip-type-container">
                                    <label class="tip-btn free">
                                        <input type="radio" name="tip_type" value="free" checked>
                                        <div class="tip-content">
                                            <div class="tip-icon"><i class="fas fa-unlock"></i></div>
                                            <div class="tip-label">Free</div>
                                        </div>
                                        <div class="bg-overlay"></div>
                                    </label>

                                    <label class="tip-btn locked">
                                        <input type="radio" name="tip_type" value="locked">
                                        <div class="tip-content">
                                            <div class="tip-icon"><i class="fas fa-lock"></i></div>
                                            <div class="tip-label">Locked</div>
                                        </div>
                                        <div class="bg-overlay"></div>
                                    </label>

                                    <label class="tip-btn premium">
                                        <input type="radio" name="tip_type" value="premium">
                                        <div class="tip-content">
                                            <div class="tip-icon"><i class="fas fa-gem"></i></div>
                                            <div class="tip-label">Premium</div>
                                        </div>
                                        <div class="bg-overlay"></div>
                                    </label>
                                </div>

                                <!-- PRICE FIELD (SHOWS FOR LOCKED/PREMIUM) -->
                                <div class="price-field" id="priceField">
                                    <label><i class="fas fa-money-bill-wave icon"></i> Bei (TZS)</label>
                                    <input type="number" name="price" placeholder="2000" min="0">
                                </div>

                                <!-- NUMBER OF CODES FIELD (SHOWS FOR PREMIUM) -->
                                <div class="price-field" id="codesField">
                                    <label><i class="fas fa-hashtag icon"></i> Idadi ya Malipo (1-100)</label>
                                    <input type="number" name="number_of_codes" placeholder="20" min="1" max="100">
                                </div>
                            </div>

                            <!-- IMAGE UPLOAD -->
                            <div class="form-group">
                                <label><i class="fas fa-camera icon"></i> Picha ya Mkeka</label>
                                <div class="file-upload-wrapper">
                                    <input type="file" id="slip-image" name="slip_image" accept="image/*">
                                    <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                    <div class="upload-text">Click to upload</div>
                                    <div class="upload-subtext">PNG, JPG - Max 5MB</div>
                                </div>
                            </div>

                            <!-- DESCRIPTION -->
                            <div class="form-group">
                                <label><i class="fas fa-comment-dots icon"></i> Maelezo (Optional)</label>
                                <textarea name="description" placeholder="Analysis ya tip..."></textarea>
                            </div>

                            <button type="submit" class="submit-btn"><i class="fas fa-check-circle"></i>POST</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    <style>
        /* Same styles as index.blade.php for forms */
        .form-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(10, 14, 26, 0.95);
            backdrop-filter: blur(10px);
            display: none;
            z-index: 999;
            overflow-y: auto;
        }
        .form-container.show {
            display: block;
        }

        .form-wrapper {
            max-width: 600px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .form-header {
            background: linear-gradient(135deg, #10b981 0%, #065f46 100%);
            padding: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .form-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .form-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .form-header h1 i {
            font-size: 32px;
        }

        .form-header p {
            color: rgba(255,255,255,0.9);
            font-size: 14px;
            position: relative;
            z-index: 1;
        }

        .form-content {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-content label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #e5e7eb;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-content .icon {
            font-size: 16px;
            color: #10b981;
            width: 20px;
            text-align: center;
        }

        .form-content input[type="text"],
        .form-content input[type="number"],
        .form-content input[type="datetime-local"],
        .form-content select,
        .form-content textarea {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid #374151;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
            font-family: inherit;
            background: #1f2937;
            color: white;
        }

        .form-content input:focus,
        .form-content select:focus,
        .form-content textarea:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .form-content input::placeholder,
        .form-content textarea::placeholder {
            color: #9ca3af;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .form-content textarea {
            resize: vertical;
            min-height: 100px;
        }

        .tip-type-container {
            display: flex;
            gap: 10px;
            margin-bottom: 16px;
            align-items: stretch;
        }

        .tip-btn {
            width: 110px;
            padding: 10px 14px;
            border: 2px solid #374151;
            border-radius: 8px;
            background: #1f2937;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .tip-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .tip-btn input[type="radio"] {
            display: none;
        }

        .tip-btn .tip-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            z-index: 1;
        }

        .tip-btn .tip-icon {
            font-size: 16px;
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }

        .tip-btn .tip-icon i {
            font-size: 16px;
        }

        .tip-btn .tip-label {
            font-weight: 600;
            font-size: 12px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .tip-btn input[type="radio"]:checked + .tip-content {
            color: white;
        }

        .tip-btn input[type="radio"]:checked + .tip-content .tip-label {
            color: white;
        }

        .tip-btn input[type="radio"]:checked ~ .bg-overlay {
            opacity: 1;
        }

        .tip-btn.free input[type="radio"]:checked ~ .bg-overlay {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .tip-btn.locked input[type="radio"]:checked ~ .bg-overlay {
            background: linear-gradient(135deg, #4169e1, #1e3a8a);
        }

        .tip-btn.premium input[type="radio"]:checked ~ .bg-overlay {
            background: linear-gradient(135deg, #d4a574, #8b6914);
        }

        .bg-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 0;
        }

        .price-field {
            display: none;
            margin-top: 14px;
        }

        .price-field.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .file-upload-wrapper {
            position: relative;
            border: 2px dashed #4b5563;
            border-radius: 10px;
            padding: 30px 16px;
            text-align: center;
            background: #1f2937;
            cursor: pointer;
            transition: all 0.3s;
        }

        .file-upload-wrapper:hover {
            border-color: #10b981;
            background: #374151;
        }

        .file-upload-wrapper input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            cursor: pointer;
        }

        .upload-icon {
            font-size: 40px;
            margin-bottom: 10px;
            color: #10b981;
        }

        .upload-icon i {
            font-size: 40px;
        }

        .upload-text {
            font-weight: 600;
            color: #e5e7eb;
            margin-bottom: 4px;
        }

        .upload-subtext {
            font-size: 12px;
            color: #9ca3af;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #10b981 0%, #065f46 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 24px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.5);
        }

        .submit-btn:active {
            transform: translateY(-1px);
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .close-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .tip-type-container {
                flex-direction: column;
            }

            .form-header h1 {
                font-size: 24px;
            }

            .form-content {
                padding: 20px;
            }
        }
    </style>

    <script>
        // Auth modal functionality (same as index.blade.php)
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
                tabRegister.classList.add('bg-transparent');
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

            window.showLoginModal = function(){
                openModal();
            };

            accountBtn && accountBtn.addEventListener('click', openModal);
            authClose && authClose.addEventListener('click', closeModal);
            authModal && authModal.addEventListener('click', (e)=>{ if(e.target === authModal) closeModal(); });
            tabLogin && tabLogin.addEventListener('click', showLogin);
            tabRegister && tabRegister.addEventListener('click', showRegister);
            forgotLink && forgotLink.addEventListener('click', showForgot);
            backToLogin && backToLogin.addEventListener('click', showLogin);
            document.addEventListener('keydown', (e)=>{ if(e.key === 'Escape'){ closeModal(); } });
        })();

        // Follow functionality
        function toggleFollow(userId, buttonElement) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const isFollowing = buttonElement.dataset.following === 'true';

            buttonElement.textContent = 'Processing...';
            buttonElement.disabled = true;

            fetch(`/users/${userId}/follow`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    buttonElement.textContent = data.following ? 'Unfollow' : 'Follow';
                    buttonElement.dataset.following = data.following ? 'true' : 'false';
                } else {
                    alert('Error: ' + (data.error || 'Something went wrong'));
                    buttonElement.textContent = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Network error. Please try again.');
                buttonElement.textContent = originalText;
            })
            .finally(() => {
                buttonElement.disabled = false;
            });
        }

        // Form toggle functionality (only for tipsters)
        @auth
            @if(auth()->user()->isTipster())
                (function(){
                    const addTipBtn = document.getElementById('addTipBtn');
                    const formContainer = document.getElementById('formContainer');
                    const closeFormBtn = document.getElementById('closeFormBtn');

                    addTipBtn.addEventListener('click', () => {
                        formContainer.classList.add('show');
                    });

                    closeFormBtn.addEventListener('click', () => {
                        formContainer.classList.remove('show');
                    });

                    formContainer.addEventListener('click', (e) => {
                        if (e.target === formContainer) {
                            formContainer.classList.remove('show');
                        }
                    });

                    // Tip type selection
                    const tipTypeRadios = document.querySelectorAll('input[name="tip_type"]');
                    const priceField = document.getElementById('priceField');
                    const codesField = document.getElementById('codesField');

                    tipTypeRadios.forEach(radio => {
                        radio.addEventListener('change', function() {
                            if (this.value === 'locked' || this.value === 'premium') {
                                priceField.classList.add('show');
                            } else {
                                priceField.classList.remove('show');
                            }

                            if (this.value === 'premium') {
                                codesField.classList.add('show');
                            } else {
                                codesField.classList.remove('show');
                            }
                        });
                    });

                    // File upload preview
                    document.getElementById('slip-image').addEventListener('change', function(e) {
                        if (e.target.files.length > 0) {
                            const fileName = e.target.files[0].name;
                            const wrapper = e.target.closest('.file-upload-wrapper');
                            wrapper.querySelector('.upload-icon').innerHTML = '<i class="fas fa-check-circle"></i>';
                            wrapper.querySelector('.upload-text').textContent = fileName;
                            wrapper.querySelector('.upload-subtext').textContent = 'File uploaded successfully';
                            wrapper.style.borderColor = '#10b981';
                            wrapper.style.background = '#065f46';
                        }
                    });

                    // Form submit
                    document.getElementById('tipForm').addEventListener('submit', function(e) {
                        e.preventDefault();

                        const formData = new FormData(this);
                        const submitBtn = this.querySelector('.submit-btn');
                        const originalText = submitBtn.innerHTML;

                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Inatuma...';
                        submitBtn.disabled = true;

                        fetch('/tips', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                alert('✅ ' + data.message);
                                formContainer.classList.remove('show');
                                this.reset();
                            } else {
                                alert('❌ Kosa: ' + (data.message || 'Hakuna maelezo'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('❌ Kosa la mtandao. Jaribu tena.');
                        })
                        .finally(() => {
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        });
                    });
                })();
            @endif
        @endauth
    </script>
</body>
</html>
