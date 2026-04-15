<x-app-layout>
<x-slot name="title">Client Details</x-slot>

<div class="mb-8">
    <a href="{{ route('clients.index') }}" style="font-size:13px;color:#525252;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:color 0.2s;" onmouseover="this.style.color='#1A1A1A'" onmouseout="this.style.color='#525252'">
        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Clients
    </a>
</div>

<div class="max-w-3xl">
    <div class="card p-7 mb-6">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;">
            <div>
                <h2 style="font-size:24px;font-weight:700;color:#1A1A1A;">{{ $client->full_name }}</h2>
                <p style="font-size:14px;color:#525252;margin-top:8px;display:flex;align-items:center;gap:6px;">
                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 00.948-.684l1.498-4.493a1 1 0 011.502-.684l1.498 4.493a1 1 0 00.948.684H19a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"/>
                    </svg>
                    {{ $client->phone }}
                </p>
                @if($client->email)
                <p style="font-size:14px;color:#525252;margin-top:6px;display:flex;align-items:center;gap:6px;">
                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    {{ $client->email }}
                </p>
                @endif
                @if($client->address)
                <p style="font-size:14px;color:#525252;margin-top:6px;display:flex;align-items:flex-start;gap:6px;">
                    <svg style="width:16px;height:16px;flex-shrink:0;margin-top:2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>{{ $client->address }}</span>
                </p>
                @endif
                @if($client->notes)
                <p style="font-size:13px;color:#8A8A8A;margin-top:8px;padding-top:8px;border-top:1px solid #ECECEC;font-style:italic;">{{ $client->notes }}</p>
                @endif
            </div>
            <a href="{{ route('clients.edit', $client) }}" class="btn-primary px-4 py-2.5 text-sm font-medium flex-shrink-0">Edit</a>
        </div>
    </div>

    <div class="card overflow-hidden">
        <div class="px-6 py-5 border-b border-[#ECECEC] bg-[#F8F9FA]">
            <h3 style="font-size:14px;font-weight:600;color:#1A1A1A;">Appointment History</h3>
            <p style="font-size:12px;color:#8A8A8A;margin-top:2px;">Complete record of all appointments</p>
        </div>
        <div>
            @forelse($client->appointments as $appointment)
            <div class="px-6 py-4 border-b border-[#ECECEC] hover:bg-[#F8F9FA] transition-colors flex items-center justify-between">
                <div style="flex:1;">
                    <p style="font-size:13px;font-weight:600;color:#1A1A1A;">{{ $appointment->service_type }}</p>
                    <p style="font-size:12px;color:#8A8A8A;margin-top:4px;">
                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                        <span style="margin:0 8px;">•</span>
                        {{ $appointment->staff->name }}
                    </p>
                </div>
                <span class="badge badge-{{ $appointment->status }}" style="flex-shrink:0;">{{ ucfirst($appointment->status) }}</span>
            </div>
            @empty
            <p style="padding:32px;text-align:center;font-size:13px;color:#8A8A8A;">No appointments yet.</p>
            @endforelse
        </div>
    </div>
</div>

</x-app-layout>