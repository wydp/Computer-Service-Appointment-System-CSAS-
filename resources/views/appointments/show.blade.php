<x-app-layout>
<x-slot name="title">Appointment Details</x-slot>

<div class="mb-6 flex items-start justify-between">
    <div>
        <a href="{{ route('appointments.index') }}" style="font-size:13px;color:#CACACA;text-decoration:none;">← Appointments</a>
        <h1 class="page-title mt-2">{{ $appointment->service_type }}</h1>
        <p class="page-sub">
            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}
            at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
        </p>
    </div>
    {{-- Top right action buttons --}}
    <div style="display:flex;gap:8px;align-items:center;margin-top:4px;">
        <span class="badge badge-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span>
        <a href="{{ route('appointments.edit', $appointment) }}" class="btn-secondary px-4 py-2 text-sm font-medium">
            Edit
        </a>
        <form method="POST" action="{{ route('appointments.destroy', $appointment) }}"
              onsubmit="return confirm('Delete this appointment?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-danger px-4 py-2 text-sm font-medium">Delete</button>
        </form>
    </div>
</div>

{{-- Details Card --}}
<div class="card p-6 mb-5" style="max-width:680px;">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
        <div>
            <p style="font-size:11px;font-weight:500;color:#CACACA;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">Client</p>
            <a href="{{ route('clients.show', $appointment->client) }}"
               style="font-size:14px;font-weight:500;color:#191919;text-decoration:none;"
               onmouseover="this.style.color='#CACACA'" onmouseout="this.style.color='#191919'">
                {{ $appointment->client->full_name }}
            </a>
            <p style="font-size:12px;color:#CACACA;margin-top:2px;">{{ $appointment->client->phone }}</p>
        </div>
        <div>
            <p style="font-size:11px;font-weight:500;color:#CACACA;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">Assigned Staff</p>
            <p style="font-size:14px;font-weight:500;color:#191919;">{{ $appointment->staff->name }}</p>
            <p style="font-size:12px;color:#CACACA;margin-top:2px;text-transform:capitalize;">{{ $appointment->staff->role }}</p>
        </div>
        <div>
            <p style="font-size:11px;font-weight:500;color:#CACACA;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">Date & Time</p>
            <p style="font-size:14px;font-weight:500;color:#191919;">
                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}
            </p>
            <p style="font-size:12px;color:#CACACA;margin-top:2px;">
                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
            </p>
        </div>
        <div>
            <p style="font-size:11px;font-weight:500;color:#CACACA;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">Created By</p>
            <p style="font-size:14px;font-weight:500;color:#191919;">{{ $appointment->createdBy->name }}</p>
            <p style="font-size:12px;color:#CACACA;margin-top:2px;">
                {{ $appointment->created_at->format('M d, Y') }}
            </p>
        </div>
        @if($appointment->notes)
        <div style="grid-column:span 2;">
            <p style="font-size:11px;font-weight:500;color:#CACACA;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">Notes</p>
            <p style="font-size:14px;color:#191919;">{{ $appointment->notes }}</p>
        </div>
        @endif
    </div>
</div>

{{-- Update Status --}}
@if(!$appointment->isCompleted() && !$appointment->isCancelled())
<div class="card p-6 mb-5" style="max-width:680px;">
    <p style="font-size:13px;font-weight:500;color:#191919;margin-bottom:14px;">Update Status</p>
    <form method="POST" action="{{ route('appointments.update-status', $appointment) }}">
        @csrf @method('PATCH')
        <div style="display:flex;gap:10px;align-items:center;">
            <select name="status" class="input" style="max-width:220px;">
                <option value="scheduled" {{ $appointment->status=='scheduled'?'selected':'' }}>Scheduled</option>
                <option value="confirmed" {{ $appointment->status=='confirmed'?'selected':'' }}>Confirmed</option>
                <option value="completed" {{ $appointment->status=='completed'?'selected':'' }}>Completed</option>
                <option value="cancelled" {{ $appointment->status=='cancelled'?'selected':'' }}>Cancelled</option>
                <option value="no_show"   {{ $appointment->status=='no_show'  ?'selected':'' }}>No Show</option>
            </select>
            <button type="submit" class="btn-primary px-5 py-2 text-sm font-medium">
                Update
            </button>
        </div>
    </form>
</div>
@endif

{{-- Service Record --}}
@if($appointment->isCompleted())
<div class="card p-6" style="max-width:680px;">
    <p style="font-size:13px;font-weight:500;color:#191919;margin-bottom:14px;">Service Record</p>
    @if($appointment->serviceRecord)
        <div style="background:#F5F5F5;border-radius:8px;padding:16px;">
            <p style="font-size:13px;color:#191919;margin-bottom:8px;">{{ $appointment->serviceRecord->description }}</p>
            <p style="font-size:12px;color:#CACACA;">
                Completed on {{ \Carbon\Carbon::parse($appointment->serviceRecord->service_date)->format('M d, Y') }}
            </p>
            @if($appointment->serviceRecord->remarks)
            <p style="font-size:12px;color:#CACACA;margin-top:4px;">Remarks: {{ $appointment->serviceRecord->remarks }}</p>
            @endif
        </div>
    @else
        <form method="POST" action="{{ route('service-records.store') }}">
            @csrf
            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">Description *</label>
                <textarea name="description" rows="3" class="input"
                          placeholder="What was done during the service?"></textarea>
                @error('description')<p style="color:#e53e3e;font-size:11px;margin-top:4px;">{{ $message }}</p>@enderror
            </div>
            <div style="margin-bottom:14px;">
                <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">Service Date *</label>
                <input type="date" name="service_date"
                       value="{{ $appointment->appointment_date }}" class="input" style="max-width:200px;">
                @error('service_date')<p style="color:#e53e3e;font-size:11px;margin-top:4px;">{{ $message }}</p>@enderror
            </div>
            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">Remarks</label>
                <textarea name="remarks" rows="2" class="input"
                          placeholder="Any additional remarks?"></textarea>
            </div>
            <button type="submit" class="btn-primary px-5 py-2 text-sm font-medium">
                Save Service Record
            </button>
        </form>
    @endif
</div>
@endif

</x-app-layout>