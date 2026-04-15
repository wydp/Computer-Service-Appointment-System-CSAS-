<x-app-layout>
<x-slot name="title">New Appointment</x-slot>

<div class="mb-8">
    <a href="{{ route('appointments.index') }}" style="font-size:13px;color:#525252;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:color 0.2s;" onmouseover="this.style.color='#1A1A1A'" onmouseout="this.style.color='#525252'">
        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Appointments
    </a>
    <h1 class="page-title mt-4">Schedule New Appointment</h1>
    <p class="page-sub">Fill in the details to book a service</p>
</div>

<div style="max-width:600px;">
    <div class="card p-7">
        <form method="POST" action="{{ route('appointments.store') }}">
            @csrf

            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Select Client *</label>
                <select name="client_id" class="input">
                    <option value="">— Choose a client —</option>
                    @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ old('client_id')==$client->id?'selected':'' }}>
                        {{ $client->full_name }}
                    </option>
                    @endforeach
                </select>
                @error('client_id')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Assign Staff *</label>
                <select name="staff_id" class="input">
                    <option value="">— Select staff member —</option>
                    @foreach($staff as $member)
                    <option value="{{ $member->id }}" {{ old('staff_id')==$member->id?'selected':'' }}>
                        {{ $member->name }}
                    </option>
                    @endforeach
                </select>
                @error('staff_id')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Service Type *</label>
                <input type="text" name="service_type" value="{{ old('service_type') }}"
                       placeholder="e.g. PC Repair, Virus Removal, Hardware Upgrade" class="input">
                @error('service_type')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Date *</label>
                    <input type="date" name="appointment_date" value="{{ old('appointment_date') }}" class="input">
                    @error('appointment_date')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Time *</label>
                    <input type="time" name="appointment_time" value="{{ old('appointment_time') }}" class="input">
                    @error('appointment_time')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Status *</label>
                <select name="status" class="input">
                    <option value="scheduled" {{ old('status')=='scheduled'?'selected':'' }}>Scheduled</option>
                    <option value="confirmed" {{ old('status')=='confirmed'?'selected':'' }}>Confirmed</option>
                    <option value="completed" {{ old('status')=='completed'?'selected':'' }}>Completed</option>
                    <option value="cancelled" {{ old('status')=='cancelled'?'selected':'' }}>Cancelled</option>
                    <option value="no_show"   {{ old('status')=='no_show'  ?'selected':'' }}>No Show</option>
                </select>
                @error('status')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:28px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Notes</label>
                <textarea name="notes" rows="3" class="input" placeholder="Add any important details about this appointment...">{{ old('notes') }}</textarea>
            </div>

            <div style="display:flex;gap:12px;padding-top:16px;border-top:1px solid #ECECEC;">
                <button type="submit" class="btn-primary px-6 py-2.5 text-sm font-medium inline-flex items-center gap-2" id="submitBtn">
                    <svg id="submitIcon" style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span id="submitText">Schedule Appointment</span>
                </button>
                <a href="{{ route('appointments.index') }}" class="btn-secondary px-6 py-2.5 text-sm font-medium">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>

<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        const submitIcon = document.getElementById('submitIcon');
        const submitText = document.getElementById('submitText');

        submitBtn.disabled = true;
        submitIcon.innerHTML = '<circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2" style="animation: spin 0.8s linear infinite;"/>';
        submitIcon.style.display = 'inline-block';
        submitText.textContent = 'Scheduling...';
    });

    const style = document.createElement('style');
    style.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
    document.head.appendChild(style);
</script>


</x-app-layout>