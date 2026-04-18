<x-app-layout>
<x-slot name="title">Edit Appointment</x-slot>

<div class="mb-8">
    <a href="{{ route('appointments.show', $appointment) }}" style="font-size:13px;color:#525252;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:color 0.2s;" onmouseover="this.style.color='#1A1A1A'" onmouseout="this.style.color='#525252'">
        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Appointment
    </a>
    <h1 class="page-title mt-4">Edit Appointment</h1>
    <p class="page-sub">Update appointment details and status</p>
</div>

<div style="max-width:1000px;margin:0 auto;">
    <div class="card p-7">
        <form method="POST" action="{{ route('appointments.update', $appointment) }}">
            @csrf @method('PUT')

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Client *</label>
                    <select name="client_id" class="input" style="width:100%;">
                        @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id',$appointment->client_id)==$client->id?'selected':'' }}>
                            {{ $client->full_name }}
                        </option>
                        @endforeach
                    </select>
                    @error('client_id')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Staff *</label>
                    <select name="staff_id" class="input" style="width:100%;">
                        @foreach($staff as $member)
                        <option value="{{ $member->id }}" {{ old('staff_id',$appointment->staff_id)==$member->id?'selected':'' }}>
                            {{ $member->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('staff_id')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Assign Staff *</label>
                <select name="staff_id" class="input">
                    @foreach($staff as $member)
                    <option value="{{ $member->id }}" {{ old('staff_id',$appointment->staff_id)==$member->id?'selected':'' }}>
                        {{ $member->name }}
                    </option>
                    @endforeach
                </select>
                @error('staff_id')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Service Type *</label>
                <input type="text" name="service_type" value="{{ old('service_type',$appointment->service_type) }}" class="input">
                @error('service_type')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Date *</label>
                    <input type="date" name="appointment_date" value="{{ old('appointment_date',$appointment->appointment_date) }}" class="input">
                    @error('appointment_date')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Time *</label>
                    <input type="time" name="appointment_time" value="{{ old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')) }}" class="input">
                    @error('appointment_time')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Status *</label>
                <select name="status" class="input">
                    <option value="scheduled" {{ old('status',$appointment->status)=='scheduled'?'selected':'' }}>Scheduled</option>
                    <option value="confirmed" {{ old('status',$appointment->status)=='confirmed'?'selected':'' }}>Confirmed</option>
                    <option value="completed" {{ old('status',$appointment->status)=='completed'?'selected':'' }}>Completed</option>
                    <option value="cancelled" {{ old('status',$appointment->status)=='cancelled'?'selected':'' }}>Cancelled</option>
                    <option value="no_show"   {{ old('status',$appointment->status)=='no_show'  ?'selected':'' }}>No Show</option>
                </select>
                @error('status')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:28px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Notes</label>
                <textarea name="notes" rows="3" class="input">{{ old('notes',$appointment->notes) }}</textarea>
            </div>

            <div style="display:flex;justify-content:space-between;align-items:center;padding-top:16px;border-top:1px solid #ECECEC;">
                <div style="display:flex;gap:12px;">
                    <button type="submit" class="btn-primary px-6 py-2.5 text-sm font-medium">Update Appointment</button>
                    <a href="{{ route('appointments.show', $appointment) }}" class="btn-secondary px-6 py-2.5 text-sm font-medium">Cancel</a>
                </div>
                <form method="POST" action="{{ route('appointments.destroy', $appointment) }}" onsubmit="return confirm('Are you sure you want to delete this appointment?')" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger px-5 py-2.5 text-sm font-medium">Delete</button>
                </form>
            </div>

        </form>
    </div>
</div>

</x-app-layout>