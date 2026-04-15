<x-app-layout>
<x-slot name="title">Reports</x-slot>

<div class="mb-8">
    <h1 class="page-title">Reports & Analytics</h1>
    <p class="page-sub">Comprehensive overview of your business metrics</p>
</div>

<div class="grid grid-cols-4 gap-6 mb-8">
    <div class="card p-6 hover:shadow-md transition-shadow duration-150">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;">
            <div>
                <p style="font-size:12px;font-weight:600;color:#8A8A8A;text-transform:uppercase;letter-spacing:0.05em;">Total Appointments</p>
                <p style="font-size:32px;font-weight:700;color:#1A1A1A;margin-top:12px;">{{ $totalAppointments }}</p>
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
                <p style="font-size:32px;font-weight:700;color:#1A1A1A;margin-top:12px;">{{ $completedCount }}</p>
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
                <p style="font-size:12px;font-weight:600;color:#8A8A8A;text-transform:uppercase;letter-spacing:0.05em;">Scheduled</p>
                <p style="font-size:32px;font-weight:700;color:#1A1A1A;margin-top:12px;">{{ $scheduledCount }}</p>
            </div>
            <div style="width:44px;height:44px;background:#EBF8FF;border:1px solid #BEE3F8;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:20px;height:20px;color:#0C3B8D;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="card p-6 hover:shadow-md transition-shadow duration-150">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;">
            <div>
                <p style="font-size:12px;font-weight:600;color:#8A8A8A;text-transform:uppercase;letter-spacing:0.05em;">Cancelled</p>
                <p style="font-size:32px;font-weight:700;color:#1A1A1A;margin-top:12px;">{{ $cancelledCount }}</p>
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
    @include('components.performance-chart')
</div>

<div class="grid grid-cols-1 gap-6 mb-8">
    @include('components.monthly-trend-chart')
</div>

<div class="grid grid-cols-1 gap-6 mb-8">
    @include('components.service-type-chart')
</div>

<div class="grid grid-cols-2 gap-6">
    {{-- Staff Activity --}}
    <div class="card overflow-hidden">
        <div class="px-6 py-5 border-b border-[#ECECEC] bg-[#F8F9FA]">
            <p style="font-size:14px;font-weight:600;color:#1A1A1A;">Staff Activity</p>
            <p style="font-size:12px;color:#8A8A8A;margin-top:2px;">Appointment count by staff member</p>
        </div>
        @forelse($staffActivity as $member)
        <div class="flex items-center justify-between px-6 py-4 border-b border-[#ECECEC] hover:bg-[#F8F9FA] transition-colors">
            <div>
                <p style="font-size:13px;font-weight:600;color:#1A1A1A;">{{ $member->name }}</p>
                <p style="font-size:12px;color:#8A8A8A;text-transform:capitalize;margin-top:2px;">{{ $member->role }}</p>
            </div>
            <div style="text-align:right;">
                <p style="font-size:20px;font-weight:700;color:#1A1A1A;">{{ $member->appointments_count }}</p>
                <p style="font-size:11px;color:#8A8A8A;">appointments</p>
            </div>
        </div>
        @empty
        <p style="padding:32px;color:#8A8A8A;font-size:13px;text-align:center;">No staff activity available.</p>
        @endforelse
    </div>

    {{-- Completed Appointments --}}
    <div class="card overflow-hidden">
        <div class="px-6 py-5 border-b border-[#ECECEC] bg-[#F8F9FA]">
            <p style="font-size:14px;font-weight:600;color:#1A1A1A;">Recently Completed</p>
            <p style="font-size:12px;color:#8A8A8A;margin-top:2px;">Latest completed appointments</p>
        </div>
        @forelse($completedAppointments as $a)
        <div class="flex items-center justify-between px-6 py-4 border-b border-[#ECECEC] hover:bg-[#F8F9FA] transition-colors">
            <div>
                <p style="font-size:13px;font-weight:600;color:#1A1A1A;">{{ $a->client->full_name }}</p>
                <p style="font-size:12px;color:#8A8A8A;margin-top:2px;">{{ $a->service_type }} • {{ $a->staff->name }}</p>
            </div>
            <p style="font-size:12px;color:#8A8A8A;white-space:nowrap;">{{ \Carbon\Carbon::parse($a->appointment_date)->format('M d, Y') }}</p>
        </div>
        @empty
        <p style="padding:32px;color:#8A8A8A;font-size:13px;text-align:center;">No completed appointments yet.</p>
        @endforelse
    </div>
</div>

</x-app-layout>