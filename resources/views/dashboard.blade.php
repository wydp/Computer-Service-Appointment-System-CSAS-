<x-app-layout>
<x-slot name="title">Dashboard</x-slot>

<div class="mb-8">
    <h1 class="page-title">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}</h1>
    <p class="page-sub">Here's a quick overview of your business metrics</p>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-4 gap-6 mb-8">
    <div class="card p-6 hover:shadow-md transition-shadow duration-150">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;">
            <div>
                <p style="font-size:12px;font-weight:600;color:#8A8A8A;text-transform:uppercase;letter-spacing:0.05em;">Total Clients</p>
                <p style="font-size:32px;font-weight:700;color:#1A1A1A;margin-top:12px;">{{ $totalClients }}</p>
                <p style="font-size:13px;color:#8A8A8A;margin-top:6px;">Registered customers</p>
            </div>
            <div style="width:44px;height:44px;background:#F5F6F7;border:1px solid #ECECEC;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:20px;height:20px;color:#525252;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="card p-6 hover:shadow-md transition-shadow duration-150">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;">
            <div>
                <p style="font-size:12px;font-weight:600;color:#8A8A8A;text-transform:uppercase;letter-spacing:0.05em;">Today</p>
                <p style="font-size:32px;font-weight:700;color:#1A1A1A;margin-top:12px;">{{ $todayAppointments }}</p>
                <p style="font-size:13px;color:#8A8A8A;margin-top:6px;">Scheduled appointments</p>
            </div>
            <div style="width:44px;height:44px;background:#F5F6F7;border:1px solid #ECECEC;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:20px;height:20px;color:#525252;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="card p-6 hover:shadow-md transition-shadow duration-150">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;">
            <div>
                <p style="font-size:12px;font-weight:600;color:#8A8A8A;text-transform:uppercase;letter-spacing:0.05em;">Completed</p>
                <p style="font-size:32px;font-weight:700;color:#1A1A1A;margin-top:12px;">{{ $completedAppointments }}</p>
                <p style="font-size:13px;color:#8A8A8A;margin-top:6px;">All time</p>
            </div>
            <div style="width:44px;height:44px;background:#F0FDF4;border:1px solid #BBFB7D;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:20px;height:20px;color:#15803d;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="card p-6 hover:shadow-md transition-shadow duration-150">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;">
            <div>
                <p style="font-size:12px;font-weight:600;color:#8A8A8A;text-transform:uppercase;letter-spacing:0.05em;">Cancelled</p>
                <p style="font-size:32px;font-weight:700;color:#1A1A1A;margin-top:12px;">{{ $cancelledAppointments }}</p>
                <p style="font-size:13px;color:#8A8A8A;margin-top:6px;">All time</p>
            </div>
            <div style="width:44px;height:44px;background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:20px;height:20px;color:#DC2626;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 14l-2-2m0 0l-2-2m2 2l2-2m-2 2l-2 2"/>
                </svg>
            </div>
        </div>
    </div>
</div>

{{-- Charts Grid --}}
<div class="grid grid-cols-2 gap-6 mb-8">
    @include('components.status-distribution-chart')
    @include('components.weekly-trend-chart')
</div>

{{-- Quick Actions --}}
<div class="grid grid-cols-2 gap-6 mb-8">
    <a href="{{ route('clients.index') }}" style="text-decoration:none;">
        <div class="card p-6 cursor-pointer hover:shadow-lg hover:border-[#8A8A8A] transition-all duration-200">
            <div style="display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <p style="font-size:14px;font-weight:600;color:#1A1A1A;">Manage Clients</p>
                    <p style="font-size:13px;color:#8A8A8A;margin-top:4px;">View and manage customer records</p>
                </div>
                <div style="width:48px;height:48px;background:#F5F6F7;border:1px solid #ECECEC;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg style="width:22px;height:22px;color:#525252;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </a>

    <a href="{{ route('appointments.index') }}" style="text-decoration:none;">
        <div class="card p-6 cursor-pointer hover:shadow-lg hover:border-[#8A8A8A] transition-all duration-200">
            <div style="display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <p style="font-size:14px;font-weight:600;color:#1A1A1A;">Manage Appointments</p>
                    <p style="font-size:13px;color:#8A8A8A;margin-top:4px;">Schedule and track bookings</p>
                </div>
                <div style="width:48px;height:48px;background:#F5F6F7;border:1px solid #ECECEC;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg style="width:22px;height:22px;color:#525252;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </a>
</div>

{{-- Activity Sections --}}
<div class="grid grid-cols-3 gap-6">
    {{-- Upcoming Appointments --}}
    <div class="card overflow-hidden">
        <div class="px-6 py-5 border-b border-[#ECECEC] bg-[#F8F9FA] flex items-center justify-between">
            <div>
                <p style="font-size:14px;font-weight:600;color:#1A1A1A;">Upcoming Appointments</p>
                <p style="font-size:12px;color:#8A8A8A;margin-top:2px;">Next scheduled bookings</p>
            </div>
            <a href="{{ route('appointments.create') }}" class="btn-primary px-3 py-1.5 text-xs font-medium">+ New</a>
        </div>
        <div>
            @forelse($upcomingAppointments as $a)
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#ECECEC] hover:bg-[#F8F9FA] transition-colors" style="cursor:pointer;" onclick="openTrackingModal({{ $a->id }})">
                <div class="flex items-center gap-3 flex-1">
                    <div style="width:36px;height:36px;border-radius:50%;background:#F5F6F7;border:1px solid #ECECEC;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#525252;flex-shrink:0;">
                        {{ strtoupper(substr($a->client->first_name,0,1)) }}
                    </div>
                    <div>
                        <p style="font-size:13px;font-weight:600;color:#1A1A1A;">{{ $a->client->full_name }}</p>
                        <p style="font-size:12px;color:#8A8A8A;margin-top:2px;">{{ $a->service_type }}</p>
                    </div>
                </div>
                <div style="text-align:right;flex-shrink:0;">
                    <p style="font-size:13px;font-weight:600;color:#1A1A1A;">{{ \Carbon\Carbon::parse($a->appointment_date)->format('M d') }}</p>
                    <p style="font-size:11px;color:#8A8A8A;margin-top:2px;">{{ \Carbon\Carbon::parse($a->appointment_time)->format('h:i A') }}</p>
                </div>
            </div>
            @empty
            <p style="padding:40px;text-align:center;font-size:13px;color:#8A8A8A;">No upcoming appointments</p>
            @endforelse
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="card overflow-hidden">
        <div class="px-6 py-5 border-b border-[#ECECEC] bg-[#F8F9FA]">
            <p style="font-size:14px;font-weight:600;color:#1A1A1A;">Recent Activity</p>
            <p style="font-size:12px;color:#8A8A8A;margin-top:2px;">Latest appointment updates</p>
        </div>
        <div>
            @forelse($recentAppointments as $a)
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#ECECEC] hover:bg-[#F8F9FA] transition-colors" style="cursor:pointer;" onclick="openTrackingModal({{ $a->id }})">
                <div class="flex items-center gap-3 flex-1">
                    <div style="width:36px;height:36px;border-radius:50%;background:#F5F6F7;border:1px solid #ECECEC;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#525252;flex-shrink:0;">
                        {{ strtoupper(substr($a->client->first_name,0,1)) }}
                    </div>
                    <div>
                        <p style="font-size:13px;font-weight:600;color:#1A1A1A;">{{ $a->client->full_name }}</p>
                        <p style="font-size:12px;color:#8A8A8A;margin-top:2px;">{{ $a->service_type }}</p>
                    </div>
                </div>
                <span class="badge badge-{{ $a->status }}">{{ ucfirst($a->status) }}</span>
            </div>
            @empty
            <p style="padding:40px;text-align:center;font-size:13px;color:#8A8A8A;">No recent activity</p>
            @endforelse
        </div>
    </div>

    {{-- Staff Workload Chart --}}
    @include('components.staff-workload-chart')
</div>

</x-app-layout>