<x-app-layout>
<x-slot name="title">Dashboard</x-slot>

<div class="mb-8">
    <h1 class="page-title">Good day, {{ explode(' ', auth()->user()->name)[0] }}</h1>
    <p class="page-sub">Here's your overview for today.</p>
</div>

<div class="grid grid-cols-4 gap-4 mb-8">
    <div class="card p-5">
        <p style="font-size:11px;font-weight:500;color:#636363;text-transform:uppercase;letter-spacing:.06em;">Clients</p>
        <p style="font-size:32px;font-weight:600;color:#191919;margin-top:8px;">{{ $totalClients }}</p>
        <p style="font-size:12px;color:#636363;margin-top:4px;">Total registered</p>
    </div>
    <div class="card p-5">
        <p style="font-size:11px;font-weight:500;color:#636363;text-transform:uppercase;letter-spacing:.06em;">Today</p>
        <p style="font-size:32px;font-weight:600;color:#191919;margin-top:8px;">{{ $todayAppointments }}</p>
        <p style="font-size:12px;color:#636363;margin-top:4px;">Appointments</p>
    </div>
    <div class="card p-5">
        <p style="font-size:11px;font-weight:500;color:#636363;text-transform:uppercase;letter-spacing:.06em;">Completed</p>
        <p style="font-size:32px;font-weight:600;color:#191919;margin-top:8px;">{{ $completedAppointments }}</p>
        <p style="font-size:12px;color:#636363;margin-top:4px;">All time</p>
    </div>
    <div class="card p-5">
        <p style="font-size:11px;font-weight:500;color:#636363;text-transform:uppercase;letter-spacing:.06em;">Cancelled</p>
        <p style="font-size:32px;font-weight:600;color:#191919;margin-top:8px;">{{ $cancelledAppointments }}</p>
        <p style="font-size:12px;color:#636363;margin-top:4px;">All time</p>
    </div>
</div>

<div class="grid grid-cols-2 gap-6">

    <div class="card overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid #F5F5F5;">
            <div>
                <p style="font-size:14px;font-weight:500;color:#191919;">Upcoming Appointments</p>
                <p style="font-size:12px;color:#636363;margin-top:2px;">Next scheduled bookings</p>
            </div>
            <a href="{{ route('appointments.create') }}" class="btn-primary px-3 py-1.5 text-xs font-medium">+ New</a>
        </div>
        <div>
            @forelse($upcomingAppointments as $a)
            <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid #F5F5F5;">
                <div class="flex items-center gap-3">
                    <div style="width:32px;height:32px;border-radius:50%;background:#F5F5F5;border:1px solid #636363;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;color:#191919;flex-shrink:0;">
                        {{ strtoupper(substr($a->client->first_name,0,1)) }}
                    </div>
                    <div>
                        <p style="font-size:13px;font-weight:500;color:#191919;">{{ $a->client->full_name }}</p>
                        <p style="font-size:12px;color:#636363;">{{ $a->service_type }}</p>
                    </div>
                </div>
                <div style="text-align:right;">
                    <p style="font-size:12px;font-weight:500;color:#191919;">{{ \Carbon\Carbon::parse($a->appointment_date)->format('M d') }}</p>
                    <p style="font-size:11px;color:#636363;">{{ \Carbon\Carbon::parse($a->appointment_time)->format('h:i A') }}</p>
                </div>
            </div>
            @empty
            <p style="padding:24px;text-align:center;font-size:13px;color:#636363;">No upcoming appointments</p>
            @endforelse
        </div>
    </div>

    <div class="card overflow-hidden">
        <div class="px-6 py-4" style="border-bottom:1px solid #F5F5F5;">
            <p style="font-size:14px;font-weight:500;color:#191919;">Recent Activity</p>
            <p style="font-size:12px;color:#636363;margin-top:2px;">Latest appointment updates</p>
        </div>
        <div>
            @forelse($recentAppointments as $a)
            <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid #F5F5F5;">
                <div class="flex items-center gap-3">
                    <div style="width:32px;height:32px;border-radius:50%;background:#F5F5F5;border:1px solid #636363;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;color:#191919;flex-shrink:0;">
                        {{ strtoupper(substr($a->client->first_name,0,1)) }}
                    </div>
                    <div>
                        <p style="font-size:13px;font-weight:500;color:#191919;">{{ $a->client->full_name }}</p>
                        <p style="font-size:12px;color:#636363;">{{ $a->service_type }}</p>
                    </div>
                </div>
                <span class="badge badge-{{ $a->status }}">{{ ucfirst($a->status) }}</span>
            </div>
            @empty
            <p style="padding:24px;text-align:center;font-size:13px;color:#636363;">No recent activity</p>
            @endforelse
        </div>
    </div>

</div>

</x-app-layout>