<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - SPARK</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root,
        [data-theme="dark"] {
            --primary: #F5A623;
            --dark: #0D0D0D;
            --card: #161616;
            --border: #2a2a2a;
            --input-bg: #1e1e1e;
            --input-bg-focus: #222;
            --text-muted: #aaaaaa;
            --text-sub: #cccccc;
            --text-label: #dddddd;
            --role-bg: #1e1e1e;
            --role-hover-bg: #222222;
            --role-active-bg: rgba(245,166,35,0.08);
            --badge-bg: rgba(245,166,35,0.1);
            --badge-border: rgba(245,166,35,0.3);
            --placeholder: #bbb;
            --shadow: 0 8px 30px rgba(245,166,35,0.3);
            --btn-text: #0D0D0D;
            --text: #ffffff;
            --grid-line: rgba(245,166,35,0.04);
            --orb-color: rgba(245,166,35,0.12);
        }

        [data-theme="light"] {
            --primary: #E09416;
            --dark: #F4F1EC;
            --card: #FFFFFF;
            --border: #E2DDD5;
            --input-bg: #F0EDE8;
            --input-bg-focus: #FFFFFF;
            --text-muted: #888888;
            --text-sub: #555555;
            --text-label: #333333;
            --role-bg: #F0EDE8;
            --role-hover-bg: #E8E4DE;
            --role-active-bg: rgba(224,148,22,0.08);
            --badge-bg: rgba(224,148,22,0.1);
            --badge-border: rgba(224,148,22,0.35);
            --placeholder: #aaaaaa;
            --shadow: 0 8px 30px rgba(224,148,22,0.25);
            --btn-text: #1a1a1a;
            --text: #1a1a1a;
            --grid-line: rgba(224,148,22,0.06);
            --orb-color: rgba(224,148,22,0.10);
        }

        @font-face {
            font-family: 'Equinox';
            src: url('/fonts/Equinox-Regular.woff') format('woff'),
                 url('/fonts/Equinox-Regular.otf') format('opentype');
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: 'Equinox';
            src: url('/fonts/Equinox-Bold.woff') format('woff'),
                 url('/fonts/Equinox-Bold.otf') format('opentype');
            font-weight: 700;
            font-style: normal;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--dark);
            margin: 0;
            min-height: 100vh;
            overflow-x: hidden;
            transition: background-color 0.4s ease;
        }

        .grid-bg {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(var(--grid-line) 1px, transparent 1px),
                linear-gradient(90deg, var(--grid-line) 1px, transparent 1px);
            background-size: 60px 60px;
            animation: gridMove 20s linear infinite;
            pointer-events: none;
        }

        @keyframes gridMove {
            0% { background-position: 0 0; }
            100% { background-position: 60px 60px; }
        }

        .orb {
            position: fixed;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, var(--orb-color) 0%, transparent 70%);
            top: -200px;
            right: -100px;
            pointer-events: none;
            animation: pulse 4s ease-in-out infinite;
            transition: background 0.4s;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.7; }
        }

        .login-card {
            background: var(--card);
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
            transition: background 0.4s, border-color 0.4s;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
        }

        .brand-title {
            font-family: 'Equinox', sans-serif;
            color: var(--primary);
            letter-spacing: 3px;
            font-size: 2.8rem;
            line-height: 1;
            transform: scaleY(0.95);
        }

        .tagline {
            color: var(--text-sub);
            font-size: 0.85rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: 300;
            transition: color 0.4s;
        }

        .input-field {
            background: var(--input-bg);
            border: 1px solid var(--border);
            color: var(--text);
            width: 100%;
            padding: 12px 16px;
            border-radius: 6px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s, background 0.3s, color 0.3s;
        }

        .input-field::placeholder { color: var(--placeholder); }

        .input-field:focus {
            border-color: var(--primary);
            background: var(--input-bg-focus);
        }

        .role-card {
            background: var(--role-bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 14px 10px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .role-card:hover {
            border-color: rgba(245,166,35,0.5);
            background: var(--role-hover-bg);
        }

        .role-card.active {
            border-color: var(--primary);
            background: var(--role-active-bg);
        }

        .role-card.active .role-icon { color: var(--primary); }
        .role-card.active .role-label { color: var(--primary); }

        .role-card.active::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: var(--primary);
        }

        .role-card.role-error {
            border-color: #ef4444 !important;
            background: rgba(239,68,68,0.05);
        }

        .role-icon {
            color: var(--text-muted);
            transition: color 0.2s;
        }

        .role-label {
            color: var(--text-sub);
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: color 0.2s;
        }

        .btn-login {
            width: 100%;
            background: var(--primary);
            color: var(--btn-text);
            border: none;
            padding: 14px;
            border-radius: 6px;
            font-family: 'Equinox', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 1.5px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-login:hover {
            background: #ffb83d;
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }

        .btn-login:active { transform: translateY(0); }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--badge-bg);
            border: 1px solid var(--badge-border);
            color: var(--primary);
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 3px;
            transition: background 0.4s, border-color 0.4s;
        }

        .dot {
            width: 6px;
            height: 6px;
            background: var(--primary);
            border-radius: 50%;
            animation: blink 1.5s ease-in-out infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.2; }
        }

        .car-icon { animation: drive 3s ease-in-out infinite; }

        @keyframes drive {
            0%, 100% { transform: translateX(0); }
            50% { transform: translateX(6px); }
        }

        .fade-in {
            animation: fadeIn 0.6s ease forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        input[type="radio"] { display: none; }
        input[type="checkbox"] { accent-color: var(--primary); }

        .form-label {
            color: var(--text-label);
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            display: block;
            margin-bottom: 8px;
            transition: color 0.4s;
        }

        .section-label {
            color: var(--text-muted);
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: color 0.4s;
        }

        .theme-toggle-wrap {
            position: fixed;
            top: 20px;
            right: 24px;
            z-index: 100;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .toggle-label {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            transition: color 0.4s;
            user-select: none;
        }

        .toggle-switch {
            position: relative;
            width: 52px;
            height: 28px;
            cursor: pointer;
        }

        .toggle-switch input { display: none; }

        .toggle-track {
            position: absolute;
            inset: 0;
            border-radius: 999px;
            background: var(--input-bg);
            border: 1px solid var(--border);
            transition: background 0.4s, border-color 0.4s;
            display: flex;
            align-items: center;
            padding: 0 4px;
        }

        .toggle-track::after {
            content: '';
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--primary);
            transition: transform 0.35s cubic-bezier(.4,0,.2,1), background 0.4s;
            transform: translateX(0);
            flex-shrink: 0;
        }

        [data-theme="light"] .toggle-track::after {
            transform: translateX(24px);
        }

        .toggle-icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            pointer-events: none;
            transition: opacity 0.3s;
        }

        .icon-moon { right: 6px; opacity: 1; }
        .icon-sun  { left:  6px; opacity: 0; }

        [data-theme="light"] .icon-moon { opacity: 0; }
        [data-theme="light"] .icon-sun  { opacity: 1; }

        @media (max-width: 768px) {
            .main-grid { grid-template-columns: 1fr !important; }
            .left-side { display: none; }
        }
    </style>
</head>
<body>
    <div class="grid-bg"></div>
    <div class="orb"></div>

    <!-- THEME TOGGLE -->
    <div class="theme-toggle-wrap">
        <span class="toggle-label" id="theme-label">Dark</span>
        <label class="toggle-switch" title="Toggle tema">
            <input type="checkbox" id="theme-checkbox" onchange="toggleTheme(this)">
            <div class="toggle-track">
                <span class="toggle-icon icon-sun">☀️</span>
                <span class="toggle-icon icon-moon">🌙</span>
            </div>
        </label>
    </div>

    <div style="min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px; position:relative; z-index:10;">
        <div class="main-grid" style="display:grid; grid-template-columns:1fr 1fr; gap:48px; max-width:960px; width:100%; align-items:center;">

            {{-- LEFT --}}
            <div class="left-side fade-in" style="animation-delay:0.05s;">
                <div class="badge" style="margin-bottom:24px;">
                    <div class="dot"></div>
                    Sistem Aktif
                </div>

                <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                    <svg class="car-icon" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="3" width="15" height="13" rx="2"/>
                        <path d="M16 8h4l3 5v3h-7V8z"/>
                        <circle cx="5.5" cy="18.5" r="2.5"/>
                        <circle cx="18.5" cy="18.5" r="2.5"/>
                    </svg>
                    <div class="brand-title">SPARK ⚡</div>
                </div>

                <div class="tagline" style="margin-bottom:32px;">Smart Parking System</div>

                <div style="color:var(--text-sub); font-size:15px; line-height:1.8; margin-bottom:40px; transition:color 0.4s;">
                    Kelola parkir dengan cepat & real-time melalui dashboard sesuai peran Anda.
                </div>
            </div>

            {{-- RIGHT - Login Card --}}
            <div class="login-card fade-in" style="border-radius:12px; padding:36px; animation-delay:0.2s;">

                <div style="margin-bottom:28px;">
                    <div class="section-label" style="margin-bottom:8px;">Portal Masuk</div>
                    <div style="font-family:'Equinox',sans-serif; font-size:1.4rem; font-weight:700; color:var(--text); letter-spacing:2px; transition:color 0.4s;">Masuk ke Sistem</div>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Alert Error (session error atau error role) --}}
                    @if (session('error') || $errors->has('role'))
                    <div id="alert-error" class="flex items-start gap-3 bg-red-500/10 border border-red-500/40 text-red-400 rounded-lg px-4 py-3 mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                        </svg>
                        <div class="flex-1 text-sm">
                            @if (session('error'))
                                <div>{{ session('error') }}</div>
                            @endif
                            @error('role')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="button" onclick="document.getElementById('alert-error').remove()" class="text-red-400 hover:text-red-300 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    @endif

                    <div style="display:flex; flex-direction:column; gap:20px;">

                        {{-- Username --}}
                        <div>
                            <label class="form-label">Username</label>
                            <input
                                name="username"
                                type="text"
                                required
                                class="input-field {{ $errors->has('username') ? 'border-red-500' : '' }}"
                                placeholder="Masukkan username"
                                value="{{ old('username') }}"
                            />
                            @error('username')
                                <p class="text-red-400 text-xs mt-1 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <label class="form-label">Password</label>
                            <div style="position:relative;">
                                <input
                                    name="password"
                                    id="password-input"
                                    type="password"
                                    required
                                    class="input-field {{ $errors->has('password') ? 'border-red-500' : '' }}"
                                    placeholder="Masukkan password"
                                    style="padding-right:44px;"
                                />
                                <button type="button" onclick="togglePassword()" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--text-muted); padding:0; display:flex; align-items:center;">
                                    <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="display:none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-red-400 text-xs mt-1 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Role --}}
                        <div>
                            <label class="form-label">Masuk Sebagai</label>
                            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:10px;">

                                <label for="role_admin" style="margin:0; cursor:pointer;">
                                    <input type="radio" name="role" id="role_admin" value="admin" required onclick="setRole('role_admin')">
                                    <div class="role-card {{ old('role') === 'admin' ? 'active' : '' }} {{ $errors->has('role') && old('role') === 'admin' ? 'role-error' : '' }}" id="card_role_admin">
                                        <svg class="role-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                        <span class="role-label">Admin</span>
                                    </div>
                                </label>

                                <label for="role_petugas" style="margin:0; cursor:pointer;">
                                    <input type="radio" name="role" id="role_petugas" value="petugas" onclick="setRole('role_petugas')">
                                    <div class="role-card {{ old('role') === 'petugas' ? 'active' : '' }} {{ $errors->has('role') && old('role') === 'petugas' ? 'role-error' : '' }}" id="card_role_petugas">
                                        <svg class="role-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span class="role-label">Petugas</span>
                                    </div>
                                </label>

                                <label for="role_owner" style="margin:0; cursor:pointer;">
                                    <input type="radio" name="role" id="role_owner" value="owner" onclick="setRole('role_owner')">
                                    <div class="role-card {{ old('role') === 'owner' ? 'active' : '' }} {{ $errors->has('role') && old('role') === 'owner' ? 'role-error' : '' }}" id="card_role_owner">
                                        <svg class="role-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="role-label">Owner</span>
                                    </div>
                                </label>

                            </div>
                        </div>

                    </div>

                    <div style="margin-top:28px;">
                        <button type="submit" class="btn-login">Masuk ke Sistem</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script>
        // Restore active state role card dari old value saat halaman reload
        document.addEventListener('DOMContentLoaded', function () {
            const oldRole = '{{ old('role') }}';
            if (oldRole) {
                const card = document.getElementById('card_role_' + oldRole);
                if (card) card.classList.add('active');
            }
        });

        function setRole(id) {
            ['role_admin', 'role_petugas', 'role_owner'].forEach(r => {
                const card = document.getElementById('card_' + r);
                card.classList.remove('active');
                card.classList.remove('role-error'); // hapus border merah saat pilih ulang
            });
            document.getElementById('card_' + id).classList.add('active');
        }

        function toggleTheme(checkbox) {
            const html = document.documentElement;
            const label = document.getElementById('theme-label');
            if (checkbox.checked) {
                html.setAttribute('data-theme', 'light');
                label.textContent = 'Light';
            } else {
                html.setAttribute('data-theme', 'dark');
                label.textContent = 'Dark';
            }
        }

        function togglePassword() {
            const input = document.getElementById('password-input');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');
            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'block';
            } else {
                input.type = 'password';
                eyeOpen.style.display = 'block';
                eyeClosed.style.display = 'none';
            }
        }
    </script>
</body>
</html>