<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CSAS — {{ $title ?? 'Dashboard' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #F5F5F5; color: #191919; }
        .sidebar { background: #191919; }
        .nav-link { color: #636363; transition: all 0.15s ease; }
        .nav-link:hover { color: #F5F5F5; background: rgba(245,245,245,0.06); }
        .nav-link.active { color: #F5F5F5; background: rgba(245,245,245,0.10); }
        .nav-dot { background: #636363; width:5px; height:5px; border-radius:50%; }
        .card { background: #fff; border: 1px solid #EBEBEB; border-radius: 12px; }
        .btn-primary { background: #191919; color: #F5F5F5; border-radius: 8px; transition: all 0.15s ease; }
        .btn-primary:hover { background: #2a2a2a; }
        .btn-secondary { background: #F5F5F5; color: #191919; border: 1px solid #636363; border-radius: 8px; transition: all 0.15s ease; }
        .btn-secondary:hover { background: #ebebeb; }
        .btn-danger { background: #fff; color: #e53e3e; border: 1px solid #636363; border-radius: 8px; transition: all 0.15s ease; }
        .btn-danger:hover { border-color: #e53e3e; background: #fff5f5; }
        .input { border: 1px solid #636363; border-radius: 8px; background: #fff; color: #191919; width: 100%; padding: 8px 12px; font-size: 14px; outline: none; transition: border 0.15s; }
        .input:focus { border-color: #191919; }
        .badge-scheduled { background: #F5F5F5; color: #191919; border: 1px solid #636363; }
        .badge-confirmed  { background: #191919; color: #F5F5F5; }
        .badge-completed  { background: #F5F5F5; color: #191919; border: 1px solid #636363; }
        .badge-cancelled  { background: #fff; color: #e53e3e; border: 1px solid #636363; }
        .badge-no_show    { background: #F5F5F5; color: #636363; border: 1px solid #636363; }
        .badge { font-size: 11px; padding: 3px 10px; border-radius: 99px; font-weight: 500; display: inline-block; }
        table { width: 100%; border-collapse: collapse; }
        thead th { font-size: 11px; font-weight: 500; color: #636363; text-transform: uppercase; letter-spacing: 0.06em; padding: 12px 20px; text-align: left; border-bottom: 1px solid #EBEBEB; }
        tbody td { padding: 14px 20px; font-size: 14px; color: #191919; border-bottom: 1px solid #F5F5F5; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: #FAFAFA; }
        .page-title { font-size: 20px; font-weight: 600; color: #191919; }
        .page-sub { font-size: 13px; color: #636363; margin-top: 2px; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #636363; border-radius: 99px; }
    </style>
</head>
<body>

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside class="sidebar w-56 flex flex-col flex-shrink-0">

        {{-- Logo --}}
        <div class="h-14 flex items-center px-5 border-b border-white/10">
            <div class="flex items-center gap-2.5">
                <div class="w-6 h-6 bg-white rounded flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-[#191919]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <span class="text-white font-semibold text-sm tracking-tight">CSAS</span>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">

            <p class="text-[10px] font-medium text-[#555] uppercase tracking-widest px-2 pb-2">Menu</p>

            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Dashboard</span>
                @if(request()->routeIs('dashboard'))<span class="nav-dot ml-auto"></span>@endif
            </a>

            <a href="{{ route('clients.index') }}"
               class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }} flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>Clients</span>
                @if(request()->routeIs('clients.*'))<span class="nav-dot ml-auto"></span>@endif
            </a>

            <a href="{{ route('appointments.index') }}"
               class="nav-link {{ request()->routeIs('appointments.*') ? 'active' : '' }} flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>Appointments</span>
                @if(request()->routeIs('appointments.*'))<span class="nav-dot ml-auto"></span>@endif
            </a>

            <a href="{{ route('service-records.index') }}"
               class="nav-link {{ request()->routeIs('service-records.*') ? 'active' : '' }} flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Service Records</span>
                @if(request()->routeIs('service-records.*'))<span class="nav-dot ml-auto"></span>@endif
            </a>

            <a href="{{ route('reports.index') }}"
               class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }} flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span>Reports</span>
                @if(request()->routeIs('reports.*'))<span class="nav-dot ml-auto"></span>@endif
            </a>

            @if(auth()->user()->isAdmin())
            <div class="pt-4 pb-2 px-2">
                <p class="text-[10px] font-medium text-[#555] uppercase tracking-widest">Admin</p>
            </div>
            <a href="{{ route('users.index') }}"
               class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }} flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span>Users</span>
                @if(request()->routeIs('users.*'))<span class="nav-dot ml-auto"></span>@endif
            </a>
            @endif

        </nav>

        {{-- User --}}
        <div class="p-3 border-t border-white/10">
            <div class="flex items-center gap-2.5 px-2 py-2">
                <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0" style="background:#CACACA;">
                    <span style="color:#191919;font-size:11px;font-weight:600;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p style="color:#F5F5F5;font-size:12px;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ auth()->user()->name }}
                    </p>
                    <p style="color:#CACACA;font-size:10px;text-transform:capitalize;">
                        {{ auth()->user()->role }}
                    </p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Logout">
                        <svg style="width:15px;height:15px;color:#CACACA;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Topbar --}}
        <header class="h-14 bg-white border-b border-[#EBEBEB] flex items-center justify-between px-8">
            <div class="flex items-center gap-2">
                <span class="text-xs text-[#636363]">CSAS</span>
                <span class="text-[#636363]">/</span>
                <span class="text-sm font-medium text-[#191919]">{{ $title ?? 'Dashboard' }}</span>
            </div>
            <span class="text-xs text-[#636363]">{{ now()->format('M d, Y') }}</span>
        </header>

        {{-- Content --}}
        <main class="flex-1 overflow-y-auto p-8">

            @if(session('success'))
            <div class="mb-6 flex items-center gap-3 px-4 py-3 bg-white border border-[#636363] text-[#191919] rounded-xl text-sm">
                <svg class="w-4 h-4 text-[#191919] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 flex items-center gap-3 px-4 py-3 bg-white border border-[#636363] text-red-600 rounded-xl text-sm">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                {{ session('error') }}
            </div>
            @endif

            {{ $slot }}

        </main>
    </div>
</div>

</body>
</html>