<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sports Betting Tips</title>
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

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }

        /* Custom search styles from user */
        .search-container {
            position: relative;
            width: 100%;
            max-width: 320px;
            margin: 0 auto;
        }

        .search-input {
            width: 100%;
            padding: 10px 44px 10px 12px;
            border: none;
            border-radius: 22px;
            background-color: #e8e8e8;
            font-size: 13px;
            outline: none;
            transition: background-color 0.3s;
            color: #071124;
        }

        .search-input::placeholder { color: #000; }
        .search-input:focus { background-color: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }

        .search-button {
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 50%;
            background-color: #333;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
        }
        .search-button:hover { background-color: #555; }
        .search-icon { width: 18px; height: 18px; fill: white; }

        .result { margin-top: 12px; padding: 12px; background-color: white; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); display: none; color: #071124; }
        .result.show { display: block; }

        /* Form Styles */
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

        /* TIP TYPE BUTTONS */
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

        /* PRICE FIELD */
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

        /* FILE UPLOAD */
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

        /* SUBMIT BUTTON */
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
        <!-- Hero Section -->
        <div class="grid md:grid-cols-3 gap-6 mb-8">
                <div class="md:col-span-2 md:order-1 relative rounded-2xl overflow-hidden bg-black">
                    @php
                        $ads = \App\Models\Ad::where('is_active', true)
                            ->where(function($q){ $q->whereNull('starts_at')->orWhere('starts_at','<=', now()); })
                            ->where(function($q){ $q->whereNull('ends_at')->orWhere('ends_at','>=', now()); })
                            ->orderBy('created_at', 'desc')
                            ->get();
                    @endphp

                    @if($ads->count() > 0)
                        <div id="ad-hero" class="w-full h-80 relative overflow-hidden bg-black">
                            @foreach($ads as $i => $ad)
                                @php $ext = strtolower(pathinfo($ad->image_path ?? '', PATHINFO_EXTENSION)); @endphp
                                <div class="ad-slide absolute inset-0 transition-opacity duration-500" data-type="{{ in_array($ext,['mp4','webm']) ? 'video' : 'image' }}" data-src="{{ $ad->image_path ? asset('storage/'.$ad->image_path) : ($ad->link ?? '') }}" style="opacity: {{ $i===0 ? '1' : '0' }};" data-index="{{ $i }}">
                                    @if(in_array($ext,['mp4','webm']))
                                        <video class="w-full h-full object-cover" preload="metadata" playsinline muted>
                                            <source src="{{ asset('storage/'.$ad->image_path) }}" type="video/{{ $ext }}">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <img src="{{ $ad->image_path ? asset('storage/'.$ad->image_path) : 'https://via.placeholder.com/800x300' }}" class="w-full h-full object-cover" />
                                    @endif
                                    <div class="absolute inset-0 bg-black/40 flex items-end p-6">
                                        <div class="text-white max-w-lg">
                                            <h3 class="text-3xl font-bold">{{ $ad->title }}</h3>
                                            @if($ad->body)
                                                <p class="text-sm text-gray-200">{{ $ad->body }}</p>
                                            @endif
                                            @if($ad->link)
                                                <a href="{{ $ad->link }}" class="mt-3 inline-block bg-white text-black px-4 py-2 rounded">Open</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Controls -->
                            <button id="ad-prev" class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/40 text-white p-2 rounded-full hover:bg-black/60">&#x2039;</button>
                            <button id="ad-next" class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/40 text-white p-2 rounded-full hover:bg-black/60">&#x203A;</button>
                            <button id="ad-pause" class="absolute left-3 bottom-3 bg-black/40 text-white p-2 rounded-full hover:bg-black/60">⏸</button>
                            <div id="ad-dots" class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2"></div>
                        </div>

                        <script>
                            (function(){
                                const hero = document.getElementById('ad-hero');
                                const slides = Array.from(hero.querySelectorAll('.ad-slide'));
                                const prevBtn = document.getElementById('ad-prev');
                                const nextBtn = document.getElementById('ad-next');
                                const pauseBtn = document.getElementById('ad-pause');
                                const dotsContainer = document.getElementById('ad-dots');
                                if(!slides.length) return;

                                let idx = 0;
                                let timeoutId = null;
                                let isPaused = false;

                                // create dots
                                slides.forEach((s, i)=>{
                                    const d = document.createElement('button');
                                    d.className = 'w-3 h-3 rounded-full bg-gray-500/60 hover:bg-white';
                                    d.title = 'Show slide ' + (i+1);
                                    d.addEventListener('click', ()=>{ go(i); });
                                    dotsContainer.appendChild(d);
                                });

                                function updateDots(){
                                    Array.from(dotsContainer.children).forEach((d,k)=>{
                                        d.classList.toggle('bg-white', k===idx);
                                        d.classList.toggle('bg-gray-500/60', k!==idx);
                                    });
                                }

                                function showIndex(i){
                                    slides.forEach((s, k)=>{
                                        s.style.opacity = k===i ? '1' : '0';
                                        s.setAttribute('aria-hidden', k===i ? 'false' : 'true');
                                        // pause any video not active
                                        const v = s.querySelector('video'); if(v && k!==i){ try{ v.pause(); v.currentTime=0; }catch(e){} }
                                    });

                                    const s = slides[i];
                                    const type = s.dataset.type;
                                    updateDots();

                                    // clear any scheduled timeouts
                                    if(timeoutId) { clearTimeout(timeoutId); timeoutId = null; }

                                    if(type === 'video'){
                                        const v = s.querySelector('video');
                                        if(!v){ scheduleNext(5000); return; }
                                        // play from start
                                        v.currentTime = 0;
                                        v.muted = true;
                                        if(!isPaused){
                                            const p = v.play(); if(p !== undefined) p.catch(()=>{});
                                        }
                                        v.onended = ()=>{ if(!isPaused) next(); };
                                    } else {
                                        if(!isPaused) scheduleNext(5000);
                                    }
                                }

                                function scheduleNext(ms){
                                    if(timeoutId) clearTimeout(timeoutId);
                                    timeoutId = setTimeout(()=>{ next(); }, ms);
                                }

                                function next(){
                                    idx = (idx + 1) % slides.length;
                                    showIndex(idx);
                                }

                                function prev(){
                                    idx = (idx - 1 + slides.length) % slides.length;
                                    showIndex(idx);
                                }

                                function go(i){ idx = i; showIndex(idx); }

                                prevBtn && prevBtn.addEventListener('click', ()=>{ prev(); });
                                nextBtn && nextBtn.addEventListener('click', ()=>{ next(); });

                                pauseBtn && pauseBtn.addEventListener('click', ()=>{
                                    isPaused = !isPaused;
                                    pauseBtn.textContent = isPaused ? '▶' : '⏸';

                                    const current = slides[idx];
                                    const v = current.querySelector('video');
                                    if(v){ if(isPaused){ try{ v.pause(); }catch(e){} } else { try{ v.play(); }catch(e){} } }

                                    if(isPaused){ if(timeoutId) { clearTimeout(timeoutId); timeoutId = null; } }
                                    else {
                                        const type = current.dataset.type;
                                        if(type === 'video'){
                                            const v = current.querySelector('video'); if(v){ const p = v.play(); if(p !== undefined) p.catch(()=>{}); }
                                        } else {
                                            scheduleNext(5000);
                                        }
                                    }
                                });

                                // clickable slides open link
                                slides.forEach(s=>{
                                    const link = s.querySelector('a');
                                    if(link){ s.style.cursor = 'pointer'; s.addEventListener('click', ()=>{ window.location = link.href; }); }
                                });

                                // start
                                showIndex(0);
                            })();
                        </script>

                    @else
                        <img src="https://images.unsplash.com/photo-1549719386-74dfcbf7dbed?w=800" alt="Boxing" class="w-full h-64 object-cover">
                        <div class="absolute inset-0 bg-linear-to-r from-black/80 to-transparent p-8 flex flex-col justify-center">
                            <h2 class="text-4xl font-bold mb-4">
                                Bonasi<br>
                                ya hadi 600%<br>
                                kwenye uwekaji<br>
                                wako 4 za kwanza
                            </h2>
                            <button class="bg-white text-black px-6 py-3 rounded-lg font-semibold w-fit hover:bg-gray-200">
                                Pata bonasi
                            </button>
                        </div>
                    @endif
            </div>

            <!-- Search Column -->
            <div class="md:col-span-1 md:order-2 flex flex-col items-start">
                <div class="w-full">
                    <div class="search-container md:mx-0 mx-auto">
                        <input type="text" class="search-input" placeholder="Search..." aria-label="Search" />
                        <button class="search-button" aria-label="Search">
                            <svg class="search-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                        </button>
                        <div class="result" id="search-result"></div>
                    </div>

                    <!-- Category Tabs -->
                    <div id="category-tabs" class="flex flex-wrap gap-2 mt-4">
                        <button class="category-chip bg-gray-800 text-gray-300 rounded-full px-2 py-1 text-xs font-medium hover:bg-gray-700 transition-colors" data-cat="top-tipsters">Top Tipsters</button>
                        <button class="category-chip bg-gray-800 text-gray-300 rounded-full px-2 py-1 text-xs font-medium hover:bg-gray-700 transition-colors" data-cat="today-tips">Today Tips <span class="ml-1">⚡</span></button>
                        <button class="category-chip bg-gray-800 text-gray-300 rounded-full px-2 py-1 text-xs font-medium hover:bg-gray-700 transition-colors" data-cat="2.5-odds">2.5 Odds</button>
                        <button class="category-chip bg-gray-800 text-gray-300 rounded-full px-2 py-1 text-xs font-medium hover:bg-gray-700 transition-colors" data-cat="big-odds">Big Odds</button>
                        <button class="category-chip bg-gray-800 text-gray-300 rounded-full px-2 py-1 text-xs font-medium hover:bg-gray-700 transition-colors" data-cat="free-tips">Free Tips</button>
                        <button class="category-chip bg-gray-800 text-gray-300 rounded-full px-2 py-1 text-xs font-medium hover:bg-gray-700 transition-colors" data-cat="premium-tips">Premium Tips</button>
                        <button class="category-chip bg-gray-800 text-gray-300 rounded-full px-2 py-1 text-xs font-medium hover:bg-gray-700 transition-colors" data-cat="senti16-og">Senti16 OG</button>
                        <button class="category-chip bg-gray-800 text-gray-300 rounded-full px-2 py-1 text-xs font-medium hover:bg-gray-700 transition-colors" data-cat="hot">HOT</button>
                        <button class="category-chip bg-gray-800 text-gray-300 rounded-full px-2 py-1 text-xs font-medium hover:bg-gray-700 transition-colors" data-cat="today">Today</button>
                    </div>
                </div>
            </div>


        </div>

        <!-- Top Tipsters Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-6">Top Tipsters</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @foreach($topTipsters as $tipster)
                    <div class="bg-zinc-800 rounded-xl p-4 card-hover">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-12 h-12 rounded-full {{ $tipster->getBackgroundGradient() }} flex items-center justify-center mb-2">
                                @if($tipster->profile_picture)
                                    <img src="{{ asset('storage/'.$tipster->profile_picture) }}" alt="{{ $tipster->name }}" class="w-full h-full rounded-full object-cover">
                                @else
                                    <i class="fas fa-user text-white text-lg"></i>
                                @endif
                            </div>
                            <h3 class="text-white font-semibold text-sm mb-1 truncate">{{ $tipster->name }}</h3>
                            <div class="{{ $tipster->getAccentColor() }} text-white px-2 py-0.5 rounded-full text-xs font-bold mb-1">
                                {{ $tipster->getBadgeText() }}
                            </div>
                            <div class="text-gray-400 text-xs mb-1">{{ $tipster->getFollowersCount() }} followers</div>
                            <div class="text-gray-400 text-xs mb-2">{{ $tipster->getTipsterStats()['win_rate'] }}% win rate</div>
                            @auth
                                <button
                                    onclick="toggleFollow({{ $tipster->id }}, this)"
                                    data-following="{{ auth()->user()->isFollowing($tipster) ? 'true' : 'false' }}"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white py-1 px-2 rounded text-xs font-semibold transition-colors"
                                >
                                    {{ auth()->user()->isFollowing($tipster) ? 'Unfollow' : 'Follow' }}
                                </button>
                            @else
                                <button onclick="showLoginModal()" class="w-full bg-green-600 hover:bg-green-700 text-white py-1 px-2 rounded text-xs font-semibold transition-colors">
                                    Follow
                                </button>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tips Grid Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-6">Latest Tips</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($tips as $tip)
                    <div class="bg-zinc-800 rounded-2xl p-6 card-hover">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-full bg-gray-700 flex items-center justify-center">
                                @if($tip->creator && $tip->creator->profile_picture)
                                    <img src="{{ asset('storage/'.$tip->creator->profile_picture) }}" alt="{{ $tip->creator->name }}" class="w-full h-full rounded-full object-cover">
                                @else
                                    <i class="fas fa-user-circle text-gray-400"></i>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-white font-semibold">{{ $tip->creator ? $tip->creator->name : 'Unknown' }}</h4>
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

                        <button class="w-full bg-emerald-400 hover:bg-emerald-500 text-black font-bold py-3 rounded-xl flex items-center justify-center gap-2 transition-colors">
                            View Details
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <script>
            (function(){
                const searchInput = document.querySelector('.search-input');
                const searchButton = document.querySelector('.search-button');
                const resultDiv = document.getElementById('search-result');
                const tipsGrid = document.querySelector('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3');
                const categoryChips = document.querySelectorAll('.category-chip');

                function performSearch(){
                    const searchTerm = searchInput.value.trim();
                    if(!searchTerm) {
                        resultDiv.classList.remove('show');
                        return;
                    }

                    fetch(`/api/search?q=${encodeURIComponent(searchTerm)}`)
                        .then(response => response.json())
                        .then(data => {
                            displaySearchResults(data, searchTerm);
                        })
                        .catch(error => {
                            console.error('Search error:', error);
                            resultDiv.innerHTML = '<strong>Error:</strong> Search failed';
                            resultDiv.classList.add('show');
                        });
                }

                function performFilter(filter){
                    // Remove active class from all chips
                    categoryChips.forEach(chip => chip.classList.remove('bg-green-600', 'text-white'));

                    // Add active class to clicked chip
                    const clickedChip = document.querySelector(`[data-cat="${filter}"]`);
                    if(clickedChip) {
                        clickedChip.classList.add('bg-green-600', 'text-white');
                    }

                    fetch(`/api/search?filter=${encodeURIComponent(filter)}`)
                        .then(response => response.json())
                        .then(data => {
                            displayFilterResults(data);
                        })
                        .catch(error => {
                            console.error('Filter error:', error);
                        });
                }

                function displaySearchResults(data, searchTerm){
                    if(data.type === 'tipster'){
                        // Display tipster profile and tips
                        let html = `<div class="p-4 bg-white rounded-lg shadow-md">
                            <a href="/users/${data.tipster.id}/profile" class="block hover:bg-gray-50 rounded-lg p-3 -m-3 mb-4 transition-colors">
                                <h3 class="text-lg font-bold mb-2 text-blue-600 hover:text-blue-800">Tipster: ${data.tipster.name}</h3>
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center mr-3">
                                        ${data.tipster.profile_picture ?
                                            `<img src="/storage/${data.tipster.profile_picture}" class="w-full h-full rounded-full object-cover">` :
                                            '<i class="fas fa-user text-gray-600"></i>'}
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">${data.tipster.followers_count} followers</p>
                                        <p class="text-sm text-gray-600">${data.tipster.win_rate}% win rate</p>
                                    </div>
                                </div>
                            </a>
                            <h4 class="font-semibold mb-2">Their Tips:</h4>`;

                        if(data.tips.length > 0){
                            data.tips.forEach(tip => {
                                html += `<a href="/tips/${tip.id}" class="block mb-2 p-2 bg-gray-50 rounded hover:bg-gray-100 transition-colors">
                                    <p class="font-medium text-blue-600 hover:text-blue-800">${tip.title}</p>
                                    <p class="text-sm text-gray-600">${tip.company} - ${tip.odds} odds</p>
                                </a>`;
                            });
                        } else {
                            html += '<p class="text-gray-500">No tips available</p>';
                        }

                        html += '</div>';
                        resultDiv.innerHTML = html;
                    } else if(data.type === 'company'){
                        // Display company tips
                        let html = `<div class="p-4 bg-white rounded-lg shadow-md">
                            <h3 class="text-lg font-bold mb-2">Tips from ${data.company}</h3>`;

                        if(data.tips.length > 0){
                            data.tips.forEach(tip => {
                                html += `<a href="/tips/${tip.id}" class="block mb-2 p-2 bg-gray-50 rounded hover:bg-gray-100 transition-colors">
                                    <p class="font-medium text-blue-600 hover:text-blue-800">${tip.title}</p>
                                    <p class="text-sm text-gray-600">By ${tip.creator ? tip.creator.name : 'Unknown'} - ${tip.odds} odds</p>
                                </a>`;
                            });
                        } else {
                            html += '<p class="text-gray-500">No tips found for this company</p>';
                        }

                        html += '</div>';
                        resultDiv.innerHTML = html;
                    } else if(data.type === 'tips'){
                        // Display matching tips
                        let html = `<div class="p-4 bg-white rounded-lg shadow-md">
                            <h3 class="text-lg font-bold mb-2">Tips matching "${searchTerm}"</h3>`;

                        if(data.tips.length > 0){
                            data.tips.forEach(tip => {
                                html += `<a href="/tips/${tip.id}" class="block mb-2 p-2 bg-gray-50 rounded hover:bg-gray-100 transition-colors">
                                    <p class="font-medium text-blue-600 hover:text-blue-800">${tip.title}</p>
                                    <p class="text-sm text-gray-600">${tip.company} - ${tip.odds} odds - By ${tip.creator ? tip.creator.name : 'Unknown'}</p>
                                </a>`;
                            });
                        } else {
                            html += '<p class="text-gray-500">No tips found</p>';
                        }

                        html += '</div>';
                        resultDiv.innerHTML = html;
                    }

                    resultDiv.classList.add('show');
                }

                function displayFilterResults(data){
                    if(data.type === 'top-tipsters'){
                        // Display top tipsters in search results
                        let html = `<div class="p-4 bg-white rounded-lg shadow-md">
                            <h3 class="text-lg font-bold mb-2">Top Tipsters</h3>`;

                        if(data.tipsters.length > 0){
                            data.tipsters.forEach(tipster => {
                                html += `<div class="mb-3 p-3 bg-gray-50 rounded flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        ${tipster.profile_picture ?
                                            `<img src="/storage/${tipster.profile_picture}" class="w-full h-full rounded-full object-cover">` :
                                            '<i class="fas fa-user text-gray-600"></i>'}
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium">${tipster.name}</p>
                                        <p class="text-sm text-gray-600">${tipster.followers_count} followers • ${tipster.win_rate}% win rate</p>
                                    </div>
                                    <span class="bg-green-500 text-white px-2 py-1 rounded text-xs">${tipster.badge}</span>
                                </div>`;
                            });
                        } else {
                            html += '<p class="text-gray-500">No tipsters found</p>';
                        }

                        html += '</div>';
                        resultDiv.innerHTML = html;
                        resultDiv.classList.add('show');
                    } else if(data.type === 'filter' && tipsGrid){
                        // Also show filter results in search area
                        let searchHtml = `<div class="p-4 bg-white rounded-lg shadow-md">
                            <h3 class="text-lg font-bold mb-2">${data.filter.replace('-', ' ').toUpperCase()} Tips</h3>`;

                        if(data.tips.length > 0){
                            data.tips.forEach(tip => {
                                searchHtml += `<a href="/tips/${tip.id}" class="block mb-2 p-2 bg-gray-50 rounded hover:bg-gray-100 transition-colors">
                                    <p class="font-medium text-blue-600 hover:text-blue-800">${tip.title}</p>
                                    <p class="text-sm text-gray-600">${tip.company} - ${tip.odds} odds - By ${tip.creator ? tip.creator.name : 'Unknown'}</p>
                                </a>`;
                            });
                        } else {
                            searchHtml += '<p class="text-gray-500">No tips found</p>';
                        }

                        searchHtml += '</div>';
                        resultDiv.innerHTML = searchHtml;
                        resultDiv.classList.add('show');

                        // Update the tips grid
                        let html = '';
                        data.tips.forEach(tip => {
                            const badgeClass = tip.tip_type === 'premium' ? 'bg-yellow-500' :
                                             tip.tip_type === 'locked' ? 'bg-orange-500' : 'bg-green-500';
                            const badgeText = tip.tip_type.toUpperCase();

                            html += `
                                <div class="bg-zinc-800 rounded-2xl p-6 card-hover">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-12 h-12 rounded-full bg-gray-700 flex items-center justify-center">
                                            ${tip.creator && tip.creator.profile_picture ?
                                                `<img src="/storage/${tip.creator.profile_picture}" alt="${tip.creator.name}" class="w-full h-full rounded-full object-cover">` :
                                                '<i class="fas fa-user-circle text-gray-400"></i>'}
                                        </div>
                                        <div>
                                            <h4 class="text-white font-semibold">${tip.creator ? tip.creator.name : 'Unknown'}</h4>
                                            <p class="text-gray-400 text-sm">${new Date(tip.created_at).toLocaleDateString()}</p>
                                        </div>
                                        <div class="ml-auto">
                                            <span class="${badgeClass} text-black px-2 py-1 rounded text-xs font-bold">${badgeText}</span>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="text-white text-3xl font-bold">${tip.odds}</div>
                                        <div class="text-gray-400 text-sm">Odds</div>
                                    </div>

                                    <div class="flex justify-between items-center mb-4">
                                        <div class="text-gray-400 text-sm">${tip.company}</div>
                                        ${tip.tip_type !== 'free' ? `<div class="text-white font-bold">TZS ${tip.price}</div>` : ''}
                                    </div>

                                    <button class="w-full bg-emerald-400 hover:bg-emerald-500 text-black font-bold py-3 rounded-xl flex items-center justify-center gap-2 transition-colors">
                                        View Details
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                            `;
                        });

                        tipsGrid.innerHTML = html;
                    }
                }

                // Event listeners
                if(searchInput && searchButton && resultDiv){
                    searchButton.addEventListener('click', performSearch);
                    searchInput.addEventListener('keypress', function(e){
                        if(e.key === 'Enter') performSearch();
                    });
                }

                // Category filter listeners
                categoryChips.forEach(chip => {
                    chip.addEventListener('click', function(){
                        const filter = this.dataset.cat;
                        performFilter(filter);
                    });
                });
            })();
        </script>



        <!-- Social Media Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-6">Follow Us For More</h2>
            <div class="flex space-x-4">
                <a href="https://www.facebook.com/share/1DafcBWjsf/?mibextid=wwXIfr" class="bg-blue-600 p-4 rounded-full hover:bg-blue-700 card-hover flex items-center justify-center shadow-sm transform transition hover:scale-110">
                    <i class="fab fa-facebook-f text-2xl text-white"></i>
                </a>
                <a href="#" class="bg-blue-400 p-4 rounded-full hover:bg-blue-500 card-hover flex items-center justify-center shadow-sm transform transition hover:scale-110">
                    <i class="fab fa-twitter text-2xl text-white"></i>
                </a>
                <a href="#" class="bg-pink-600 p-4 rounded-full hover:bg-pink-700 card-hover flex items-center justify-center shadow-sm transform transition hover:scale-110">
                    <i class="fab fa-instagram text-2xl text-white"></i>
                </a>
                <a href="https://chat.whatsapp.com/JMjCSSr8Bey5lWOdsTDXED?mode=hqrt2" class="bg-green-600 p-4 rounded-full hover:bg-green-700 card-hover flex items-center justify-center shadow-sm transform transition hover:scale-110">
                    <i class="fab fa-whatsapp text-2xl text-white"></i>
                </a>
                <a href="#" class="bg-red-600 p-4 rounded-full hover:bg-red-700 card-hover flex items-center justify-center shadow-sm transform transition hover:scale-110">
                    <i class="fab fa-youtube text-2xl text-white"></i>
                </a>
            </div>
        </div>
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
                    <a href="#" onclick="openModal('about-modal')" class="text-gray-400 hover:text-white cursor-pointer">About</a>
                    <a href="#" onclick="openModal('contact-modal')" class="text-gray-400 hover:text-white cursor-pointer">Contact</a>
                    <a href="#" onclick="openModal('terms-modal')" class="text-gray-400 hover:text-white cursor-pointer">Terms</a>
                    <a href="#" onclick="openModal('privacy-modal')" class="text-gray-400 hover:text-white cursor-pointer">Privacy</a>
                    <a href="#" onclick="openModal('help-modal')" class="text-gray-400 hover:text-white cursor-pointer">Help</a>
                </nav>

                <!-- Copyright -->
                <div class="text-gray-400">
                    © 2026 <span class="text-white">BET<span class="text-green-500">16TIPS</span></span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Auth modal (Register / Login / Forgot) -->
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
                        <!-- illustration removed (not available) -->
                        <div class="mt-4 w-52 mx-auto text-sm text-gray-400">Karibu — ingia au jisajili kutumia barua pepe yako.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tips Modal -->
    <div id="tips-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-60 px-4 py-6" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="w-full max-w-4xl bg-zinc-800 rounded-2xl shadow-xl overflow-hidden border border-gray-800 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b border-zinc-700">
                <h3 class="text-xl font-bold text-white">Tips</h3>
                <button id="tips-close" class="text-white text-2xl leading-none">&times;</button>
            </div>
            <div id="tips-content" class="p-6">
                <!-- Tips will be loaded here -->
                <div class="text-center text-gray-400">
                    <i class="fas fa-spinner fa-spin text-2xl mb-4"></i>
                    <p>Loading tips...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Preferences Modal (first-visit) -->
    <div id="prefs-modal" class="fixed inset-0 z-40 hidden items-center justify-center bg-black bg-opacity-60 px-4 py-6" role="dialog" aria-modal="true">
        <div class="w-full max-w-lg bg-[#071124] rounded-xl shadow-xl overflow-hidden border border-gray-800 p-6">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-lg font-bold">Tunauliza: Ni kategori gani unazopendelea?</h3>
                <button id="prefs-close" class="text-gray-300">&times;</button>
            </div>
            <p class="text-sm text-gray-400 mb-4">Chagua asilimia kama unataka kuanzisha maudhui yaliyopendekezwa.</p>
            <div id="prefs-list" class="flex flex-wrap gap-2 mb-4">
                <button type="button" class="pref-btn bg-gray-800 text-gray-300 rounded-full px-3 py-1 text-sm" data-cat="top-tipsters">Top Tipsters</button>
                <button type="button" class="pref-btn bg-gray-800 text-gray-300 rounded-full px-3 py-1 text-sm" data-cat="today-tips">Today Tips</button>
                <button type="button" class="pref-btn bg-gray-800 text-gray-300 rounded-full px-3 py-1 text-sm" data-cat="2.5-odds">2.5 Odds</button>
                <button type="button" class="pref-btn bg-gray-800 text-gray-300 rounded-full px-3 py-1 text-sm" data-cat="big-odds">Big Odds</button>
            </div>
            <div class="flex justify-end">
                <button id="prefs-skip" class="px-4 py-2 bg-gray-700 rounded-md text-sm mr-2">Ruka</button>
                <button id="prefs-save" class="px-4 py-2 bg-green-600 rounded-md text-sm">Hifadhi</button>
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

    <!-- About Modal -->
    <div id="about-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-60 px-4 py-6">
        <div class="w-full max-w-2xl bg-[#071124] rounded-xl shadow-xl overflow-hidden border border-gray-800 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b border-gray-800">
                <h3 class="text-xl font-bold text-white flex items-center gap-3">
                    <i class="fas fa-info-circle text-green-500 text-2xl"></i>
                    About Us
                </h3>
                <button onclick="closeModal('about-modal')" class="text-white text-2xl leading-none hover:text-gray-300">&times;</button>
            </div>
            <div class="p-6 text-gray-300">
                <h4 class="text-lg font-semibold text-white mb-4">About tipsAPP</h4>
                <p class="mb-4">tipsAPP ni jukwaa la kisasa la michezo ya kubashiri linalowaunganisha tipsters waliothibitishwa na wapenzi wa michezo wanaotafuta taarifa sahihi na tips zenye ubora.</p>

                <h5 class="text-md font-semibold text-white mb-2">Lengo letu ni:</h5>
                <ul class="list-disc list-inside mb-4 space-y-1">
                    <li>Kutoa tips zilizoandaliwa kwa uchambuzi wa kitaalamu</li>
                    <li>Kuwapa nafasi tipsters kuonesha uwezo wao</li>
                    <li>Kujenga uwazi, uaminifu, na ushindani wa haki</li>
                </ul>

                <h5 class="text-md font-semibold text-white mb-2">Katika tipsAPP utapata:</h5>
                <ul class="list-disc list-inside mb-4 space-y-1">
                    <li>Free tips</li>
                    <li>Premium tips</li>
                    <li>Tipsters waliopimwa kwa win rate</li>
                    <li>Mfumo wa kufollow tipster unayemwamini</li>
                </ul>

                <div class="bg-yellow-600 text-black p-3 rounded-lg">
                    <strong>⚠️ Kumbuka:</strong> Kubashiri kuna hatari. Cheza kwa kiasi na kwa uwajibikaji.
                </div>
            </div>
            <div class="p-6 border-t border-gray-800 text-center">
                <button onclick="closeModal('about-modal')" class="px-6 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">Close</button>
            </div>
        </div>
    </div>

    <!-- Contact Modal -->
    <div id="contact-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-60 px-4 py-6">
        <div class="w-full max-w-2xl bg-[#071124] rounded-xl shadow-xl overflow-hidden border border-gray-800 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b border-gray-800">
                <h3 class="text-xl font-bold text-white flex items-center gap-3">
                    <i class="fas fa-phone text-blue-500 text-2xl"></i>
                    Contact Us
                </h3>
                <button onclick="closeModal('contact-modal')" class="text-white text-2xl leading-none hover:text-gray-300">&times;</button>
            </div>
            <div class="p-6 text-gray-300">
                <h4 class="text-lg font-semibold text-white mb-4">Contact tipsAPP</h4>
                <p class="mb-4">Tuko tayari kukusaidia.</p>

                <div class="space-y-3 mb-4">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-envelope text-green-500"></i>
                        <span><strong>Email:</strong> <a href="mailto:senti16@gmail.com" class="text-blue-400 hover:text-blue-300">senti16@gmail.com</a></span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fab fa-whatsapp text-green-500"></i>
                        <span><strong>WhatsApp:</strong> <a href="https://chat.whatsapp.com/JMjCSSr8Bey5lWOdsTDXED?mode=hqrt2" target="_blank" class="text-blue-400 hover:text-blue-300">Join Group</a></span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fas fa-globe text-purple-500"></i>
                        <span><strong>Website:</strong> <a href="https://senti16.netlify.app/" target="_blank" class="text-blue-400 hover:text-blue-300">https://senti16.netlify.app/</a></span>
                    </div>
                </div>

                <h5 class="text-md font-semibold text-white mb-2">Kwa:</h5>
                <ul class="list-disc list-inside mb-4 space-y-1">
                    <li>Maswali</li>
                    <li>Malamaliko</li>
                    <li>Ushirikiano (partnership)</li>
                    <li>Kuwa tipster</li>
                </ul>

                <div class="bg-blue-600 text-white p-3 rounded-lg text-center">
                    <strong>👉 Tafadhali wasiliana nasi wakati wowote.</strong>
                </div>
            </div>
            <div class="p-6 border-t border-gray-800 text-center">
                <button onclick="closeModal('contact-modal')" class="px-6 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">Close</button>
            </div>
        </div>
    </div>

    <!-- Terms Modal -->
    <div id="terms-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-60 px-4 py-6">
        <div class="w-full max-w-2xl bg-[#071124] rounded-xl shadow-xl overflow-hidden border border-gray-800 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b border-gray-800">
                <h3 class="text-xl font-bold text-white flex items-center gap-3">
                    <i class="fas fa-file-contract text-yellow-500 text-2xl"></i>
                    Terms & Conditions
                </h3>
                <button onclick="closeModal('terms-modal')" class="text-white text-2xl leading-none hover:text-gray-300">&times;</button>
            </div>
            <div class="p-6 text-gray-300">
                <h4 class="text-lg font-semibold text-white mb-4">Terms and Conditions</h4>
                <p class="mb-4">Kwa kutumia tipsAPP, unakubali masharti yafuatayo:</p>

                <ul class="list-disc list-inside space-y-2">
                    <li>tipsAPP hutoa taarifa za michezo, hatuhakikishi ushindi.</li>
                    <li>Mtumiaji anawajibika kikamilifu kwa maamuzi yake ya kubashiri.</li>
                    <li>Premium content inapatikana baada ya kufungua kwa access code au subscription.</li>
                    <li>Kushiriki, kunakili au kuuza content bila ruhusa ni marufuku.</li>
                    <li>Akaunti inayokiuka masharti inaweza kusimamishwa au kufutwa.</li>
                    <li>tipsAPP haina dhamana ya faida yoyote itakayopatikana.</li>
                </ul>
            </div>
            <div class="p-6 border-t border-gray-800 text-center">
                <button onclick="closeModal('terms-modal')" class="px-6 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">Close</button>
            </div>
        </div>
    </div>

    <!-- Privacy Modal -->
    <div id="privacy-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-60 px-4 py-6">
        <div class="w-full max-w-2xl bg-[#071124] rounded-xl shadow-xl overflow-hidden border border-gray-800 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b border-gray-800">
                <h3 class="text-xl font-bold text-white flex items-center gap-3">
                    <i class="fas fa-shield-alt text-red-500 text-2xl"></i>
                    Privacy Policy
                </h3>
                <button onclick="closeModal('privacy-modal')" class="text-white text-2xl leading-none hover:text-gray-300">&times;</button>
            </div>
            <div class="p-6 text-gray-300">
                <h4 class="text-lg font-semibold text-white mb-4">Privacy Policy</h4>
                <p class="mb-4">Tunathamini faragha yako.</p>

                <h5 class="text-md font-semibold text-white mb-2">Tunachokusanya:</h5>
                <ul class="list-disc list-inside mb-4 space-y-1">
                    <li>Jina la mtumiaji</li>
                    <li>Email senti16@gmail.com</li>
                    <li>Activity ya matumizi ya mfumo</li>
                </ul>

                <h5 class="text-md font-semibold text-white mb-2">Tunachohakikisha:</h5>
                <ul class="list-disc list-inside mb-4 space-y-1">
                    <li>Hatugawani taarifa zako kwa watu wa tatu</li>
                    <li>Taarifa zako zinalindwa kwa usalama wa kiwango cha juu</li>
                    <li>Malipo (kama yapo) hufanywa nje ya mfumo</li>
                </ul>

                <div class="bg-green-600 text-white p-3 rounded-lg">
                    Kwa kutumia tipsAPP, unakubali sera yetu ya faragha.
                </div>
            </div>
            <div class="p-6 border-t border-gray-800 text-center">
                <button onclick="closeModal('privacy-modal')" class="px-6 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">Close</button>
            </div>
        </div>
    </div>

    <!-- Help Modal -->
    <div id="help-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-60 px-4 py-6">
        <div class="w-full max-w-2xl bg-[#071124] rounded-xl shadow-xl overflow-hidden border border-gray-800 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b border-gray-800">
                <h3 class="text-xl font-bold text-white flex items-center gap-3">
                    <i class="fas fa-question-circle text-purple-500 text-2xl"></i>
                    Help & Support
                </h3>
                <button onclick="closeModal('help-modal')" class="text-white text-2xl leading-none hover:text-gray-300">&times;</button>
            </div>
            <div class="p-6 text-gray-300">
                <h4 class="text-lg font-semibold text-white mb-4">Help Center</h4>
                <p class="mb-4">Je, unahitaji msaada?</p>

                <h5 class="text-md font-semibold text-white mb-3">Maswali Yanayoulizwa Mara kwa Mara (FAQ)</h5>

                <div class="space-y-4">
                    <div>
                        <p class="font-semibold text-white">Q: Free tips ni nini?</p>
                        <p class="text-gray-400">A: Ni tips zinazopatikana bure kwa watumiaji wote.</p>
                    </div>
                    <div>
                        <p class="font-semibold text-white">Q: Premium tips zinafungukaje?</p>
                        <p class="text-gray-400">A: Kwa kutumia access code au subscription halali.</p>
                    </div>
                    <div>
                        <p class="font-semibold text-white">Q: Nitawezaje kuwa tipster?</p>
                        <p class="text-gray-400">A: Wasiliana nasi kupitia Contact page.</p>
                    </div>
                    <div>
                        <p class="font-semibold text-white">Q: Je, tipsAPP inahakikisha ushindi?</p>
                        <p class="text-gray-400">A: Hapana. Kubashiri kuna hatari.</p>
                    </div>
                </div>

                <div class="bg-purple-600 text-white p-3 rounded-lg mt-4 text-center">
                    <strong>Kwa msaada zaidi, tafadhali wasiliana nasi.</strong>
                </div>
            </div>
            <div class="p-6 border-t border-gray-800 text-center">
                <button onclick="closeModal('help-modal')" class="px-6 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">Close</button>
            </div>
        </div>
    </div>

    <!-- Small Preferences open button -->
    <button id="prefs-open-button" title="Badilisha mapendekezo" class="fixed bottom-6 right-6 z-30 bg-gray-800 text-white p-3 rounded-full shadow-lg hidden md:block">
        ⚙️
    </button>

    <!-- Font Awesome for Icons -->
    <script src="https://kit.fontawesome.com/your-kit-code.js" crossorigin="anonymous"></script>

    <!-- Auth modal JS -->
    <script>
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
                // default to login
                showLogin();
            }
            function closeModal(){
                authModal.classList.remove('flex');
                authModal.classList.add('hidden');
            }
            function showLogin(){
                tabLogin.classList.add('bg-transparent');
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

            // Global function for login modal
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

            // Auto-open modal if validation errors exist + preferences modal
            document.addEventListener('DOMContentLoaded', function(){
                // Preference helpers
                function getCookie(name){
                    const v = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
                    return v ? v.pop() : null;
                }
                function setCookie(name,value,days){
                    const d = new Date(); d.setTime(d.getTime() + (days*24*60*60*1000));
                    document.cookie = name + "=" + encodeURIComponent(value) + ";expires=" + d.toUTCString() + ";path=/";
                }

                const prefsModal = document.getElementById('prefs-modal');
                const prefButtons = document.querySelectorAll('.pref-btn');
                const prefsSave = document.getElementById('prefs-save');
                const prefsSkip = document.getElementById('prefs-skip');
                const prefsClose = document.getElementById('prefs-close');
                const prefsOpen = document.getElementById('prefs-open-button');
                const categoryContainer = document.getElementById('category-tabs');

                function reorderCategoriesFromPrefs(){
                    const v = getCookie('senti_prefs');
                    if(!v || v === 'skipped') return;
                    const preferred = v.split(',');
                    const all = Array.from(categoryContainer.querySelectorAll('.category-chip'));
                    const ordered = [];
                    // add preferred in order
                    preferred.forEach(cat => {
                        const el = categoryContainer.querySelector('[data-cat="' + cat + '"]');
                        if(el) ordered.push(el);
                    });
                    // then the rest
                    all.forEach(el=>{ if(!preferred.includes(el.dataset.cat)) ordered.push(el); });
                    // append in new order
                    ordered.forEach(el => categoryContainer.appendChild(el));
                }

                // init prefs modal if no cookie found
                if(!getCookie('senti_prefs')){
                    prefsModal.classList.remove('hidden');
                    prefsModal.classList.add('flex');
                } else {
                    reorderCategoriesFromPrefs();
                }

                // toggle selection
                prefButtons.forEach(b => b.addEventListener('click', ()=>{
                    b.classList.toggle('bg-green-600');
                    b.classList.toggle('text-white');
                    b.classList.toggle('bg-gray-800');
                }));

                prefsSave && prefsSave.addEventListener('click', ()=>{
                    const selected = Array.from(prefButtons).filter(b=>b.classList.contains('bg-green-600')).map(b=>b.dataset.cat);
                    if(selected.length) setCookie('senti_prefs', selected.join(','), 365);
                    else setCookie('senti_prefs', '', 365);
                    prefsModal.classList.remove('flex'); prefsModal.classList.add('hidden');
                    reorderCategoriesFromPrefs();
                });

                prefsSkip && prefsSkip.addEventListener('click', ()=>{
                    setCookie('senti_prefs', 'skipped', 365);
                    prefsModal.classList.remove('flex'); prefsModal.classList.add('hidden');
                });

                prefsClose && prefsClose.addEventListener('click', ()=>{ prefsModal.classList.remove('flex'); prefsModal.classList.add('hidden'); setCookie('senti_prefs', 'skipped', 365); });

                prefsOpen && prefsOpen.addEventListener('click', ()=>{ prefsModal.classList.remove('hidden'); prefsModal.classList.add('flex'); });

                @if($errors->any())
                    authModal.classList.remove('hidden');
                    authModal.classList.add('flex');
                    @if(old('name'))
                        showRegister();
                    @elseif(old('email') && !old('name'))
                        showLogin();
                    @endif
                @elseif(session('show_login'))
                    authModal.classList.remove('hidden');
                    authModal.classList.add('flex');
                    showLogin();
                @endif
            });
        })();

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

                    // Form submit - actual submission to server
                    document.getElementById('tipForm').addEventListener('submit', function(e) {
                        e.preventDefault();

                        const formData = new FormData(this);
                        const submitBtn = this.querySelector('.submit-btn');
                        const originalText = submitBtn.innerHTML;

                        // Show loading state
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Inatuma...';
                        submitBtn.disabled = true;

                        // Submit via AJAX
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
                                this.reset(); // Clear form
                            } else {
                                alert('❌ Kosa: ' + (data.message || 'Hakuna maelezo'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('❌ Kosa la mtandao. Jaribu tena.');
                        })
                        .finally(() => {
                            // Reset button
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        });
                    });
                })();
            @endif
        @endauth

        // Tips modal functionality
        (function(){
            const tipsBtn = document.getElementById('tipsBtn');
            const tipsModal = document.getElementById('tips-modal');
            const tipsClose = document.getElementById('tips-close');
            const tipsContent = document.getElementById('tips-content');

            function openTipsModal(){
                tipsModal.classList.remove('hidden');
                tipsModal.classList.add('flex');
                loadTips();
            }

            function closeTipsModal(){
                tipsModal.classList.remove('flex');
                tipsModal.classList.add('hidden');
            }

            function loadTips(){
                tipsContent.innerHTML = '<div class="text-center text-gray-400"><i class="fas fa-spinner fa-spin text-2xl mb-4"></i><p>Loading tips...</p></div>';

                fetch('/tips')
                .then(response => response.json())
                .then(tips => {
                    if(tips.length === 0) {
                        tipsContent.innerHTML = '<div class="text-center text-gray-400"><p>No tips available</p></div>';
                        return;
                    }

                    let html = '';
                    tips.forEach(tip => {
                        const timeRemaining = calculateTimeRemaining(tip.validity_time);
                        const badgeClass = getBadgeClass(tip.tip_type);
                        const badgeText = getBadgeText(tip.tip_type);
                        const tipsterName = tip.creator ? tip.creator.name : 'Unknown';
                        const profileIcon = '<i class="fas fa-user-circle text-gray-400 text-4xl"></i>';
                        const stakeDisplay = tip.tip_type === 'free' ? '' : `Tzs ${tip.stake}/=`;

                        html += `
                            <div class="bg-zinc-800 rounded-2xl p-6 mb-6">
                                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-zinc-700">
                                    <div class="w-16 h-16 rounded-full flex items-center justify-center bg-gray-700">
                                        ${profileIcon}
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-white text-2xl font-bold">${tipsterName}</h3>
                                        <p class="text-gray-400 text-sm">Net Follows • 4.5k</p>
                                    </div>
                                    <div class="${badgeClass} px-4 py-2 rounded-lg text-sm font-bold">
                                        ${badgeText}
                                    </div>
                                </div>

                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <div class="text-white text-5xl font-bold mb-2">${tip.odds}</div>
                                        <div class="text-gray-400 text-sm">Odds</div>
                                    </div>
                                    <div class="bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                                        active
                                    </div>
                                </div>

                                <div class="flex justify-between items-center mb-6">
                                    <div class="text-gray-400 text-sm">
                                        Validity Time • <span class="text-white">${timeRemaining}</span>
                                    </div>
                                    ${stakeDisplay ? `<div class="text-white text-3xl font-bold">${stakeDisplay}</div>` : ''}
                                </div>

                                <div class="mb-6">
                                    <div class="bg-white px-4 py-2 rounded inline-block">
                                        <span class="font-bold text-sm">${tip.company}</span>
                                    </div>
                                </div>

                                <button class="w-full bg-emerald-400 hover:bg-emerald-500 text-black font-bold text-xl py-4 rounded-xl flex items-center justify-center gap-2 transition-colors">
                                    View full
                                    <div class="bg-emerald-300 rounded-full p-1">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                                        </svg>
                                    </div>
                                </button>
                            </div>
                        `;
                    });
                    tipsContent.innerHTML = html;

                    // Start countdown timers
                    startCountdowns();
                })
                .catch(error => {
                    console.error('Error loading tips:', error);
                    tipsContent.innerHTML = '<div class="text-center text-red-400"><p>Error loading tips</p></div>';
                });
            }

            function calculateTimeRemaining(validityTime) {
                // For now, assume validity_time is seconds from now
                const now = Math.floor(Date.now() / 1000);
                const remaining = validityTime - now;
                if (remaining <= 0) return '00h 00m 00s';

                const h = Math.floor(remaining / 3600);
                const m = Math.floor((remaining % 3600) / 60);
                const s = remaining % 60;
                return `${h.toString().padStart(2,'0')}h ${m.toString().padStart(2,'0')}m ${s.toString().padStart(2,'0')}s`;
            }

            function getBadgeClass(tipType) {
                switch(tipType) {
                    case 'premium': return 'bg-yellow-500 text-black';
                    case 'locked': return 'bg-orange-500 text-black';
                    default: return 'bg-white text-black';
                }
            }

            function getBadgeText(tipType) {
                switch(tipType) {
                    case 'premium': return 'PREMIUM';
                    case 'locked': return 'LOCKED';
                    default: return 'FREE';
                }
            }

            function startCountdowns() {
                setInterval(() => {
                    const timeElements = tipsContent.querySelectorAll('.text-white');
                    timeElements.forEach(el => {
                        if (el.textContent.includes('h') && el.textContent.includes('m') && el.textContent.includes('s')) {
                            // This is a time element, update it
                            const currentTime = el.textContent;
                            const match = currentTime.match(/(\d+)h (\d+)m (\d+)s/);
                            if (match) {
                                let [_, h, m, s] = match.map(Number);
                                s--;
                                if (s < 0) {
                                    s = 59;
                                    m--;
                                    if (m < 0) {
                                        m = 59;
                                        h--;
                                        if (h < 0) {
                                            h = 0;
                                            m = 0;
                                            s = 0;
                                        }
                                    }
                                }
                                el.textContent = `${h.toString().padStart(2,'0')}h ${m.toString().padStart(2,'0')}m ${s.toString().padStart(2,'0')}s`;
                            }
                        }
                    });
                }, 1000);
            }

            tipsBtn && tipsBtn.addEventListener('click', openTipsModal);
            tipsClose && tipsClose.addEventListener('click', closeTipsModal);
            tipsModal && tipsModal.addEventListener('click', (e) => { if(e.target === tipsModal) closeTipsModal(); });
            document.addEventListener('keydown', (e) => { if(e.key === 'Escape' && tipsModal.classList.contains('flex')) closeTipsModal(); });
        })();

        // Follow functionality
        function toggleFollow(userId, buttonElement) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const isFollowing = buttonElement.dataset.following === 'true';

            // Update button text immediately for better UX
            const originalText = buttonElement.textContent;
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
                    // Update button text and state
                    buttonElement.textContent = data.following ? 'Unfollow' : 'Follow';
                    buttonElement.dataset.following = data.following ? 'true' : 'false';

                    // Optional: Show a brief success message
                    console.log(data.following ? 'Now following' : 'Unfollowed');
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

        // Details toggle functionality for tipster cards
        function toggleDetails(buttonElement) {
            const card = buttonElement.closest('.relative');
            const detailsPanel = card.querySelector('.details-panel');
            const detailsText = buttonElement.querySelector('.details-text');

            if (detailsPanel.classList.contains('hidden')) {
                detailsPanel.classList.remove('hidden');
                detailsText.textContent = 'Hide performance';
            } else {
                detailsPanel.classList.add('hidden');
                detailsText.textContent = 'View performance';
            }
        }

        // Modal functionality for footer links
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        }

        // Add event listeners for modal close on outside click and ESC
        document.addEventListener('DOMContentLoaded', function() {
            const modalIds = ['about-modal', 'contact-modal', 'terms-modal', 'privacy-modal', 'help-modal'];
            modalIds.forEach(id => {
                const modal = document.getElementById(id);
                if (modal) {
                    modal.addEventListener('click', (e) => {
                        if (e.target === modal) closeModal(id);
                    });
                }
            });
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const modalIds = ['about-modal', 'contact-modal', 'terms-modal', 'privacy-modal', 'help-modal'];
                modalIds.forEach(id => {
                    const modal = document.getElementById(id);
                    if (modal && modal.classList.contains('flex')) {
                        closeModal(id);
                    }
                });
            }
        });
    </script>
</body>
</html>
