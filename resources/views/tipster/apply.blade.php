<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Become a Tipster - BETTIPS</title>
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

    <!-- Application Form -->
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-zinc-800 rounded-2xl p-8">
                <div class="text-center mb-8">
                    <i class="fas fa-star text-yellow-400 text-4xl mb-4"></i>
                    <h1 class="text-3xl font-bold text-white mb-4">Become a Tipster</h1>
                    <p class="text-gray-400">Fill out the form below to apply for tipster status. Your application will be reviewed by our admin team.</p>
                </div>

                @if(session('error'))
                    <div class="mb-4 p-3 rounded-md bg-red-600 text-white">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('tipster.submit') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Display Name -->
                    <div>
                        <label for="display_name" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-user mr-2"></i>Display Name
                        </label>
                        <input type="text" id="display_name" name="display_name" value="{{ old('display_name', $user->name) }}" required
                               class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Experience -->
                    <div>
                        <label for="experience" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-clock mr-2"></i>Experience (Years)
                        </label>
                        <input type="number" id="experience" name="experience" value="{{ old('experience') }}" min="0" required
                               class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Sports Type -->
                    <div>
                        <label for="sports" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-futbol mr-2"></i>Sports Type
                        </label>
                        <select id="sports" name="sports" required
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select Sport</option>
                            <option value="football" {{ old('sports') == 'football' ? 'selected' : '' }}>Football</option>
                            <option value="basketball" {{ old('sports') == 'basketball' ? 'selected' : '' }}>Basketball</option>
                            <option value="tennis" {{ old('sports') == 'tennis' ? 'selected' : '' }}>Tennis</option>
                            <option value="other" {{ old('sports') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <!-- Short Bio -->
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-comment mr-2"></i>Short Bio
                        </label>
                        <textarea id="bio" name="bio" rows="4" required
                                  class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"
                                  placeholder="Tell us about yourself and your tipping experience...">{{ old('bio') }}</textarea>
                    </div>

                    <!-- Contact -->
                    <div>
                        <label for="contact" class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-phone mr-2"></i>Contact
                        </label>
                        <input type="text" id="contact" name="contact" value="{{ old('contact', $user->phone) }}" required
                               class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Phone number or email">
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="gradient-blue hover:opacity-90 text-white font-bold py-3 px-8 rounded-lg transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-paper-plane mr-2"></i>Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const displayName = document.getElementById('display_name').value.trim();
            const experience = document.getElementById('experience').value;
            const sports = document.getElementById('sports').value;
            const bio = document.getElementById('bio').value.trim();
            const contact = document.getElementById('contact').value.trim();

            if (!displayName || !experience || !sports || !bio || !contact) {
                e.preventDefault();
                alert('Please fill in all required fields.');
                return false;
            }

            if (bio.length > 1000) {
                e.preventDefault();
                alert('Bio must be less than 1000 characters.');
                return false;
            }
        });
    </script>
</body>
</html>
