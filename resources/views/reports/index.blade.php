<x-app-layout>
<x-slot name="title">Reports</x-slot>

<div class="mb-8">
    <h1 class="page-title">Reports</h1>
    <p class="page-sub">Overview of appointment activity</p>
</div>

<div class="grid grid-cols-4 gap-4 mb-8">
    <div class="card p-5">
        <p style="font-size:11px;font-weight:500;color:#191919;text-transform:uppercase;letter-spacing:.06em;">Total</p>
        <p style="font-size:32px;font-weight:600;color:#191919;margin-top:8px;">{{ $totalAppointments }}</p>
    </div>
    <div class="card p-5">
        <p style="font-size:11px;font-weight:500;color:#191919;text-transform:uppercase;letter-spacing:.06em;">Completed</p>
        <p style="font-size:32px;font-weight:600;color:#191919;margin-top:8px;">{{ $completedCount }}</p>
    </div>
    <div class="card p-5">
        <p style="font-size:11px;font-weight:500;color:#191919;text-transform:uppercase;letter-spacing:.06em;">Scheduled</p>
        <p style="font-size:32px;font-weight:600;color:#191919;margin-top:8px;">{{ $scheduledCount }}</p>
    </div>
    <div class="card p-5">
        <p style="font-size:11px;font-weight:500;color:#191919;text-transform:uppercase;letter-spacing:.06em;">Cancelled</p>
        <p style="font-size:32px;font-weight:600;color:#191919;margin-top:8px;">{{ $cancelledCount }}</p>
    </div>
</div>

<div class="grid grid-cols-2 gap-6">
    <div class="card overflow-hidden">
        <div class="px-6 py-4" style="border-bottom:1px solid #F5F5F5;">
            <p style="font-size:14px;font-weight:500;color:#191919;">Staff Activity</p>
        </div>
        @forelse($staffActivity as $member)
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid #F5F5F5;">
            <div>
                <p style="font-size:13px;font-weight:500;color:#191919;">{{ $member->name }}</p>
                <p style="font-size:11px;color:#191919;text-transform:capitalize;">{{ $member->role }}</p>
            </div>
            <div style="text-align:right;">
                <p style="font-size:20px;font-weight:600;color:#191919;">{{ $member->appointments_count }}</p>
                <p style="font-size:11px;color:#191919;">appointments</p>
            </div>
        </div>
        @empty
        <p style="padding:24px;color:#191919;font-size:13px;text-align:center;">No staff data.</p>
        @endforelse
    </div>

    <div class="card overflow-hidden">
        <div class="px-6 py-4" style="border-bottom:1px solid #F5F5F5;">
            <p style="font-size:14px;font-weight:500;color:#191919;">Completed Appointments</p>
        </div>
        @forelse($completedAppointments as $a)
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid #F5F5F5;">
            <div>
                <p style="font-size:13px;font-weight:500;color:#191919;">{{ $a->client->full_name }}</p>
                <p style="font-size:12px;color:#191919;">{{ $a->service_type }} — {{ $a->staff->name }}</p>
            </div>
            <p style="font-size:12px;color:#191919;">{{ \Carbon\Carbon::parse($a->appointment_date)->format('M d, Y') }}</p>
        </div>
        @empty
        <p style="padding:24px;color:#191919;font-size:13px;text-align:center;">No completed appointments.</p>
        @endforelse
    </div>
</div>

</x-app-layout>
