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
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; }

        /* Base Colors - Industrial Gray Scale */
        :root {
            --bg-primary: #F8F9FA;
            --bg-secondary: #FFFFFF;
            --bg-tertiary: #F5F6F7;
            --text-primary: #1A1A1A;
            --text-secondary: #525252;
            --text-muted: #8A8A8A;
            --border-light: #ECECEC;
            --border-med: #DCDCDC;
            --sidebar-bg: linear-gradient(180deg, #2D2D2D 0%, #0F0F0F 100%);
            --accent: #2D2D2D;
            --accent-hover: #1A1A1A;
            --gold: #FFD700;
        }

        body {
            background: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
        }

        /* Sidebar Styling - Enhanced Gradient */
        .sidebar {
            background: var(--sidebar-bg);
            box-shadow: 2px 0 12px rgba(0,0,0,0.2);
        }

        .sidebar .h-14 {
            border-bottom: 1px solid rgba(255, 215, 0, 0.1);
        }

        .nav-link {
            color: #888888;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .nav-link:hover {
            color: #FFD700;
            background: rgba(255, 215, 0, 0.08);
        }

        .nav-link.active {
            color: #FFD700;
            background: rgba(255, 215, 0, 0.12);
            border-left: 3px solid #FFD700;
        }

        .nav-dot {
            background: #FFD700;
            width: 4px;
            height: 4px;
            border-radius: 50%;
        }

        /* Cards */
        .card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-light);
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover {
            border-color: rgba(255, 215, 0, 0.3);
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #2D2D2D 0%, #0F0F0F 100%);
            color: #FFFFFF;
            border: 2px solid #FFD700;
            border-radius: 8px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1A1A1A 0%, #0F0F0F 100%);
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.3);
            transform: scale(1.05);
        }

        .btn-primary:active {
            transform: scale(1);
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.2);
        }

        .btn-primary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-secondary {
            background: var(--bg-secondary);
            color: var(--text-primary);
            border: 1.5px solid var(--border-med);
            border-radius: 8px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            font-weight: 500;
        }

        .btn-secondary:hover {
            background: var(--bg-tertiary);
            border-color: var(--gold);
            color: var(--gold);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .btn-secondary:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-danger {
            background: var(--bg-secondary);
            color: #DC2626;
            border: 1.5px solid var(--border-med);
            border-radius: 8px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            font-weight: 500;
        }

        .btn-danger:hover {
            border-color: #DC2626;
            background: #FEF2F2;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.1);
        }

        .btn-danger:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Inputs */
        .input {
            border: 1.5px solid var(--border-med);
            border-radius: 8px;
            background: var(--bg-secondary);
            color: var(--text-primary);
            width: 100%;
            padding: 10px 14px;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }

        .input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.08);
            background: var(--bg-secondary);
        }

        /* Badges */
        .badge {
            font-size: 12px;
            padding: 4px 12px;
            border-radius: 6px;
            font-weight: 600;
            display: inline-block;
            letter-spacing: 0.01em;
        }

        .badge-scheduled {
            background: #2D2D2D;
            color: #FFFFFF;
            border: 1px solid #4A4A4A;
        }

        .badge-confirmed {
            background: #4A5568;
            color: #FFFFFF;
            border: 1px solid #5A6578;
        }

        .badge-completed {
            background: #FFD700;
            color: #0F0F0F;
            border: 1px solid #DAA520;
        }

        .badge-cancelled {
            background: #6B2C2C;
            color: #FFFFFF;
            border: 1px solid #8B3A3A;
        }

        .badge-no_show {
            background: #6B7280;
            color: #FFFFFF;
            border: 1px solid #7B8290;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 14px 20px;
            text-align: left;
            border-bottom: 1.5px solid var(--border-light);
            background: var(--bg-tertiary);
        }

        tbody td {
            padding: 14px 20px;
            font-size: 14px;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-light);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover td {
            background: var(--bg-tertiary);
        }

        /* Typography */
        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.01em;
        }

        .page-sub {
            font-size: 14px;
            color: var(--text-secondary);
            margin-top: 4px;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #D1D5DB;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #9CA3AF;
        }
    </style>
</head>
<body>

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside class="sidebar w-56 flex flex-col flex-shrink-0">

        {{-- Logo --}}
        <div class="h-16 flex items-center px-5 border-b border-white/10 flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-7 h-7 bg-gradient-to-br from-white to-gray-100 rounded-lg flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4 text-[#191919]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <span class="text-white font-bold text-sm tracking-tight">CSAS</span>
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
        <div class="p-4 border-t border-white/10 flex-shrink-0">
            <div class="flex items-center gap-3 px-2 py-2">
                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 bg-gradient-to-br from-blue-400 to-blue-600 text-white font-bold text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p style="color:#FFFFFF;font-size:13px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ auth()->user()->name }}
                    </p>
                    <p style="color:#A0AEC0;font-size:11px;text-transform:capitalize;margin-top:2px;">
                        {{ auth()->user()->role }}
                    </p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Logout" class="p-1.5 hover:bg-white/10 rounded-md transition" style="background:none;border:none;">
                        <svg style="width:16px;height:16px;color:#A0AEC0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

    </aside>

    {{-- Main --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Topbar --}}
        <header class="h-16 bg-white border-b border-[#ECECEC] flex items-center justify-between px-8" style="box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div class="flex items-center gap-3">
                <span class="text-xs font-semibold text-[#8A8A8A] tracking-wider">CSAS</span>
                <svg class="w-3 h-3 text-[#D1D5DB]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                <span class="text-sm font-600 text-[#1A1A1A]">{{ $title ?? 'Dashboard' }}</span>
            </div>
            <span class="text-sm text-[#8A8A8A]">{{ now()->format('M d, Y') }}</span>
        </header>

        {{-- Content --}}
        <main class="flex-1 overflow-y-auto p-8" style="background: var(--bg-primary);">

            @if(session('success'))
            <div class="mb-6 flex items-start gap-3 px-5 py-4 bg-white border border-[#D1D5DB] text-[#1A1A1A] rounded-10 text-sm" style="background: #F0FDF4; border-color: #BBFB7D;">
                <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <div>
                    <p class="font-medium text-green-900">Success</p>
                    <p style="color: #15803d; margin-top: 2px;">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 flex items-start gap-3 px-5 py-4 bg-white border border-[#D1D5DB] text-red-600 rounded-10 text-sm" style="background: #FEF2F2; border-color: #FECACA;">
                <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <div>
                    <p class="font-medium text-red-900">Error</p>
                    <p style="color: #991B1B; margin-top: 2px;">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            {{ $slot }}

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@include('components.tracking-modal')
</body>
</html>