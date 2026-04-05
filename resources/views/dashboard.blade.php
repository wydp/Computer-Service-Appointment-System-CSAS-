<x-app-layout>
<x-slot name="title">Dashboard</x-slot>

<div class="mb-8">
    <h1 class="page-title">Good day, {{ explode(' ', auth()->user()->name)[0] }}</h1>
    <p class="page-sub">Here's your overview for today.</p>
</div>

{{-- Stats --}}
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="card p-5">
        <p style="font-size:11px;font-weight:500;color:#CACACA;text-transform:uppercase;letter-spacing:.06em;">Clients</p>
        <p style="font-size:32px;font-weight:600;color:#191919;margin-top:8px;">{{ $totalClients }}</p>
        <p style="font-size:12px;color:#CACACA;margin-top:4px;">Total registered</p>
    </div>
    <div class="card p-5">
        <p style="font-size:11px;font-weight:500;color:#CACACA;text-transform:uppercase;letter-spacing:.06em;">Today</p>
        <p style="font-size:32px;font-weight:600;color:#191919;margin-top:8px;">{{ $todayAppointments }}</p>
        <p style="font-size:12px;color:#CACACA;margin-top:4px;">Appointments</p>
    </div>
    <div class="card p-5">
        <p style="font-size:11px;font-weight:500;color:#CACACA;text-transform:uppercase;letter-spacing:.06em;">Completed</p>
        <p style="font-size:32px;font-weight:600;color:#191919;margin-top:8px;">{{ $completedAppointments }}</p>
        <p style="font-size:12px;color:#CACACA;margin-top:4px;">All time</p>
    </div>
    <div class="card p-5">
        <p style="font-size:11px;font-weight:500;color:#CACACA;text-transform:uppercase;letter-spacing:.06em;">Cancelled</p>
        <p style="font-size:32px;font-weight:600;color:#191919;margin-top:8px;">{{ $cancelledAppointments }}</p>
        <p style="font-size:12px;color:#CACACA;margin-top:4px;">All time</p>
    </div>
</div>

{{-- Quick Links --}}
<div class="grid grid-cols-2 gap-4 mb-8">
    <a href="{{ route('clients.index') }}" style="text-decoration:none;">
        <div class="card p-5 flex items-center justify-between"
             style="cursor:pointer;transition:border-color 0.15s;"
             onmouseover="this.style.borderColor='#191919'"
             onmouseout="this.style.borderColor='#EBEBEB'">
            <div class="flex items-center gap-4">
                <div style="width:40px;height:40px;background:#F5F5F5;border:1px solid #CACACA;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg style="width:18px;height:18px;" fill="none" stroke="#191919" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p style="font-size:14px;font-weight:500;color:#191919;">Manage Clients</p>
                    <p style="font-size:12px;color:#CACACA;margin-top:2px;">View, add, and edit client records</p>
                </div>
            </div>
            <svg style="width:15px;height:15px;" fill="none" stroke="#CACACA" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
    </a>

    <a href="{{ route('appointments.index') }}" style="text-decoration:none;">
        <div class="card p-5 flex items-center justify-between"
             style="cursor:pointer;transition:border-color 0.15s;"
             onmouseover="this.style.borderColor='#191919'"
             onmouseout="this.style.borderColor='#EBEBEB'">
            <div class="flex items-center gap-4">
                <div style="width:40px;height:40px;background:#F5F5F5;border:1px solid #CACACA;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg style="width:18px;height:18px;" fill="none" stroke="#191919" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p style="font-size:14px;font-weight:500;color:#191919;">Manage Appointments</p>
                    <p style="font-size:12px;color:#CACACA;margin-top:2px;">Schedule and track bookings</p>
                </div>
            </div>
            <svg style="width:15px;height:15px;" fill="none" stroke="#CACACA" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
    </a>
</div>

{{-- Tables --}}
<div class="grid grid-cols-2 gap-6">
    <div class="card overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid #F5F5F5;">
            <div>
                <p style="font-size:14px;font-weight:500;color:#191919;">Upcoming Appointments</p>
                <p style="font-size:12px;color:#CACACA;margin-top:2px;">Next scheduled bookings</p>
            </div>
            <a href="{{ route('appointments.create') }}" class="btn-primary px-3 py-1.5 text-xs font-medium">+ New</a>
        </div>
        <div>
            @forelse($upcomingAppointments as $a)
            <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid #F5F5F5;">
                <div class="flex items-center gap-3">
                    <div style="width:32px;height:32px;border-radius:50%;background:#F5F5F5;border:1px solid #CACACA;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;color:#191919;flex-shrink:0;">
                        {{ strtoupper(substr($a->client->first_name,0,1)) }}
                    </div>
                    <div>
                        <p style="font-size:13px;font-weight:500;color:#191919;">{{ $a->client->full_name }}</p>
                        <p style="font-size:12px;color:#CACACA;">{{ $a->service_type }}</p>
                    </div>
                </div>
                <div style="text-align:right;">
                    <p style="font-size:12px;font-weight:500;color:#191919;">{{ \Carbon\Carbon::parse($a->appointment_date)->format('M d') }}</p>
                    <p style="font-size:11px;color:#CACACA;">{{ \Carbon\Carbon::parse($a->appointment_time)->format('h:i A') }}</p>
                </div>
            </div>
            @empty
            <p style="padding:32px;text-align:center;font-size:13px;color:#CACACA;">No upcoming appointments</p>
            @endforelse
        </div>
    </div>

    <div class="card overflow-hidden">
        <div class="px-6 py-4" style="border-bottom:1px solid #F5F5F5;">
            <p style="font-size:14px;font-weight:500;color:#191919;">Recent Activity</p>
            <p style="font-size:12px;color:#CACACA;margin-top:2px;">Latest appointment updates</p>
        </div>
        <div>
            @forelse($recentAppointments as $a)
            <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid #F5F5F5;">
                <div class="flex items-center gap-3">
                    <div style="width:32px;height:32px;border-radius:50%;background:#F5F5F5;border:1px solid #CACACA;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;color:#191919;flex-shrink:0;">
                        {{ strtoupper(substr($a->client->first_name,0,1)) }}
                    </div>
                    <div>
                        <p style="font-size:13px;font-weight:500;color:#191919;">{{ $a->client->full_name }}</p>
                        <p style="font-size:12px;color:#CACACA;">{{ $a->service_type }}</p>
                    </div>
                </div>
                <span class="badge badge-{{ $a->status }}">{{ ucfirst($a->status) }}</span>
            </div>
            @empty
            <p style="padding:32px;text-align:center;font-size:13px;color:#CACACA;">No recent activity</p>
            @endforelse
        </div>
    </div>
</div>

</x-app-layout>