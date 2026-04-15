<x-app-layout>
<x-slot name="title">Appointment Details</x-slot>

<div class="mb-8 flex items-start justify-between">
    <div>
        <a href="{{ route('appointments.index') }}" style="font-size:13px;color:#525252;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:color 0.2s;" onmouseover="this.style.color='#1A1A1A'" onmouseout="this.style.color='#525252'">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Appointments
        </a>
        <h1 class="page-title mt-4">{{ $appointment->service_type }}</h1>
        <p class="page-sub">
            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }} at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
        </p>
    </div>
    <div style="display:flex;gap:10px;align-items:center;margin-top:4px;flex-wrap:wrap;">
        <span class="badge badge-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span>
        <a href="{{ route('appointments.edit', $appointment) }}" class="btn-secondary px-4 py-2.5 text-sm font-medium">Edit</a>
        <form method="POST" action="{{ route('appointments.destroy', $appointment) }}" onsubmit="return confirm('Are you sure you want to delete this appointment?')" style="display:inline;">
            @csrf @method('DELETE')
            <button type="submit" class="btn-danger px-4 py-2.5 text-sm font-medium">Delete</button>
        </form>
    </div>
</div>

{{-- Details Card --}}
<div class="card p-7 mb-6" style="max-width:780px;">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:28px;">
        <div>
            <p style="font-size:11px;font-weight:600;color:#8A8A8A;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Client</p>
            <a href="{{ route('clients.show', $appointment->client) }}" style="font-size:14px;font-weight:600;color:#1A1A1A;text-decoration:none;display:block;transition:color 0.2s;" onmouseover="this.style.color='#525252'" onmouseout="this.style.color='#1A1A1A'">
                {{ $appointment->client->full_name }}
            </a>
            <p style="font-size:13px;color:#8A8A8A;margin-top:4px;">{{ $appointment->client->phone }}</p>
        </div>
        <div>
            <p style="font-size:11px;font-weight:600;color:#8A8A8A;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Assigned Staff</p>
            <p style="font-size:14px;font-weight:600;color:#1A1A1A;">{{ $appointment->staff->name }}</p>
            <p style="font-size:13px;color:#8A8A8A;margin-top:4px;text-transform:capitalize;">{{ $appointment->staff->role }}</p>
        </div>
        <div>
            <p style="font-size:11px;font-weight:600;color:#8A8A8A;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Date & Time</p>
            <p style="font-size:14px;font-weight:600;color:#1A1A1A;">
                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}
            </p>
            <p style="font-size:13px;color:#8A8A8A;margin-top:4px;">
                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
            </p>
        </div>
        <div>
            <p style="font-size:11px;font-weight:600;color:#8A8A8A;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Created By</p>
            <p style="font-size:14px;font-weight:600;color:#1A1A1A;">{{ $appointment->createdBy->name }}</p>
            <p style="font-size:13px;color:#8A8A8A;margin-top:4px;">
                {{ $appointment->created_at->format('M d, Y') }}
            </p>
        </div>
        @if($appointment->notes)
        <div style="grid-column:span 2;">
            <p style="font-size:11px;font-weight:600;color:#8A8A8A;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Notes</p>
            <p style="font-size:14px;color:#525252;">{{ $appointment->notes }}</p>
        </div>
        @endif
    </div>
</div>

{{-- Update Status --}}
@if(!$appointment->isCompleted() && !$appointment->isCancelled())
<div class="card p-7 mb-6" style="max-width:780px;">
    <p style="font-size:13px;font-weight:600;color:#000000;margin-bottom:20px;">Update Status</p>
    <form method="POST" action="{{ route('appointments.update-status', $appointment) }}" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
        @csrf @method('PATCH')

        <input type="hidden" id="statusInput" name="status" value="{{ $appointment->status }}">

        <div style="display:flex;gap:8px;border:1px solid #E5E5E5;border-radius:8px;padding:4px;background:#F8F9FA;">
            <button type="button" class="status-btn" data-status="scheduled" style="padding:8px 16px;border:none;background:{{ $appointment->status === 'scheduled' ? '#000000' : '#FFFFFF' }};color:{{ $appointment->status === 'scheduled' ? '#FFFFFF' : '#000000' }};border-radius:6px;cursor:pointer;font-size:13px;font-weight:600;transition:all 0.2s;border:1px solid {{ $appointment->status === 'scheduled' ? '#000000' : '#E5E5E5' }};" onclick="selectStatus(event, 'scheduled')">Scheduled</button>

            <button type="button" class="status-btn" data-status="confirmed" style="padding:8px 16px;border:none;background:{{ $appointment->status === 'confirmed' ? '#0066CC' : '#FFFFFF' }};color:{{ $appointment->status === 'confirmed' ? '#FFFFFF' : '#000000' }};border-radius:6px;cursor:pointer;font-size:13px;font-weight:600;transition:all 0.2s;border:1px solid {{ $appointment->status === 'confirmed' ? '#0066CC' : '#E5E5E5' }};" onclick="selectStatus(event, 'confirmed')">Confirmed</button>

            <button type="button" class="status-btn" data-status="completed" style="padding:8px 16px;border:none;background:{{ $appointment->status === 'completed' ? '#00AA00' : '#FFFFFF' }};color:{{ $appointment->status === 'completed' ? '#FFFFFF' : '#000000' }};border-radius:6px;cursor:pointer;font-size:13px;font-weight:600;transition:all 0.2s;border:1px solid {{ $appointment->status === 'completed' ? '#00AA00' : '#E5E5E5' }};" onclick="selectStatus(event, 'completed')">Completed</button>

            <button type="button" class="status-btn" data-status="cancelled" style="padding:8px 16px;border:none;background:{{ $appointment->status === 'cancelled' ? '#CC0000' : '#FFFFFF' }};color:{{ $appointment->status === 'cancelled' ? '#FFFFFF' : '#000000' }};border-radius:6px;cursor:pointer;font-size:13px;font-weight:600;transition:all 0.2s;border:1px solid {{ $appointment->status === 'cancelled' ? '#CC0000' : '#E5E5E5' }};" onclick="selectStatus(event, 'cancelled')">Cancelled</button>

            <button type="button" class="status-btn" data-status="no_show" style="padding:8px 16px;border:none;background:{{ $appointment->status === 'no_show' ? '#FF6600' : '#FFFFFF' }};color:{{ $appointment->status === 'no_show' ? '#FFFFFF' : '#000000' }};border-radius:6px;cursor:pointer;font-size:13px;font-weight:600;transition:all 0.2s;border:1px solid {{ $appointment->status === 'no_show' ? '#FF6600' : '#E5E5E5' }};" onclick="selectStatus(event, 'no_show')">No Show</button>
        </div>

        <button type="submit" style="padding:8px 24px;background:#000000;color:#FFFFFF;border:none;border-radius:6px;cursor:pointer;font-size:13px;font-weight:600;transition:all 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">Update</button>
    </form>
</div>
@endif

<script>
function selectStatus(event, status) {
    event.preventDefault();

    // Update hidden input
    document.getElementById('statusInput').value = status;

    // Update button styles
    const buttons = document.querySelectorAll('.status-btn');
    const statusColors = {
        'scheduled': { bg: '#000000', text: '#FFFFFF', border: '#000000' },
        'confirmed': { bg: '#0066CC', text: '#FFFFFF', border: '#0066CC' },
        'completed': { bg: '#00AA00', text: '#FFFFFF', border: '#00AA00' },
        'cancelled': { bg: '#CC0000', text: '#FFFFFF', border: '#CC0000' },
        'no_show': { bg: '#FF6600', text: '#FFFFFF', border: '#FF6600' }
    };

    buttons.forEach(btn => {
        const btnStatus = btn.getAttribute('data-status');
        if (btnStatus === status) {
            btn.style.background = statusColors[status].bg;
            btn.style.color = statusColors[status].text;
            btn.style.borderColor = statusColors[status].border;
        } else {
            btn.style.background = '#FFFFFF';
            btn.style.color = '#000000';
            btn.style.borderColor = '#E5E5E5';
        }
    });
}
</script>

{{-- Status History Timeline --}}
<div class="card p-7 mb-6" style="max-width:780px;">
    <p style="font-size:13px;font-weight:600;color:#1A1A1A;margin-bottom:20px;">Status History</p>
    <div style="position:relative;">
        @forelse($appointment->statusHistories as $history)
        <div style="display:flex;gap:16px;margin-bottom:{{ $loop->last ? '0' : '20px' }};">
            {{-- Timeline dot --}}
            <div style="display:flex;flex-direction:column;align-items:center;">
                <div style="width:12px;height:12px;background:#FFD700;border:3px solid #F5F5F5;border-radius:50%;position:relative;z-index:2;"></div>
                @if(!$loop->last)
                <div style="width:2px;height:32px;background:#E5E5E5;margin-top:8px;"></div>
                @endif
            </div>

            {{-- Content --}}
            <div style="flex:1;padding-top:2px;">
                <p style="font-size:13px;font-weight:600;color:#1A1A1A;margin-bottom:4px;">
                    {{ $history->getStatusChangeLabel() }}
                </p>
                <p style="font-size:12px;color:#8A8A8A;margin-bottom:6px;">
                    Changed by <span style="font-weight:600;color:#1A1A1A;">{{ $history->changedByUser->name }}</span>
                </p>
                @if($history->serviceCompletedByUser)
                <p style="font-size:12px;color:#8A8A8A;margin-bottom:6px;">
                    Service completed by <span style="font-weight:600;color:#1A1A1A;">{{ $history->serviceCompletedByUser->name }}</span>
                </p>
                @endif
                <p style="font-size:12px;color:#8A8A8A;">
                    {{ $history->changed_at->format('M d, Y \a\t h:i A') }}
                </p>
                @if($history->notes)
                <p style="font-size:12px;color:#525252;margin-top:8px;font-style:italic;">
                    {{ $history->notes }}
                </p>
                @endif
            </div>
        </div>
        @empty
        <p style="font-size:13px;color:#8A8A8A;text-align:center;padding:20px;">No status history available</p>
        @endforelse
    </div>
</div>

{{-- Service Record --}}
@if($appointment->isCompleted())
<div class="card p-7" style="max-width:780px;">
    <p style="font-size:13px;font-weight:600;color:#1A1A1A;margin-bottom:16px;">Service Record</p>
    @if($appointment->serviceRecord)
        <div style="background:#F8F9FA;border:1px solid #ECECEC;border-radius:10px;padding:16px;">
            <p style="font-size:13px;color:#525252;margin-bottom:8px;">{{ $appointment->serviceRecord->description }}</p>
            <p style="font-size:12px;color:#8A8A8A;">
                Completed on {{ \Carbon\Carbon::parse($appointment->serviceRecord->service_date)->format('M d, Y') }}
            </p>
            @if($appointment->serviceRecord->remarks)
            <p style="font-size:12px;color:#8A8A8A;margin-top:4px;"><strong>Remarks:</strong> {{ $appointment->serviceRecord->remarks }}</p>
            @endif
        </div>
    @else
        <form method="POST" action="{{ route('service-records.store') }}">
            @csrf
            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Description *</label>
                <textarea name="description" rows="3" class="input" placeholder="What was done during the service?"></textarea>
                @error('description')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Service Date *</label>
                <input type="date" name="service_date" value="{{ $appointment->appointment_date }}" class="input" style="max-width:240px;">
                @error('service_date')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
            </div>
            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Remarks</label>
                <textarea name="remarks" rows="2" class="input" placeholder="Any additional remarks?"></textarea>
            </div>
            <button type="submit" class="btn-primary px-6 py-2.5 text-sm font-medium">Save Service Record</button>
        </form>
    @endif
</div>
@endif

</x-app-layout>