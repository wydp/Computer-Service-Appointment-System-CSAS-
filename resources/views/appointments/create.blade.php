<x-app-layout>
<x-slot name="title">New Appointment</x-slot>

<div class="mb-6">
    <a href="{{ route('appointments.index') }}" style="font-size:13px;color:#CACACA;text-decoration:none;">← Appointments</a>
    <h1 class="page-title mt-2">New Appointment</h1>
    <p class="page-sub">Fill in the details to schedule a booking</p>
</div>

<div style="max-width:560px;">
    <div class="card p-6">
        <form method="POST" action="{{ route('appointments.store') }}">
            @csrf

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">Client *</label>
                <select name="client_id" class="input">
                    <option value="">Select a client</option>
                    @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ old('client_id')==$client->id?'selected':'' }}>
                        {{ $client->full_name }}
                    </option>
                    @endforeach
                </select>
                @error('client_id')<p style="color:#e53e3e;font-size:11px;margin-top:4px;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">Assign Staff *</label>
                <select name="staff_id" class="input">
                    <option value="">Select staff</option>
                    @foreach($staff as $member)
                    <option value="{{ $member->id }}" {{ old('staff_id')==$member->id?'selected':'' }}>
                        {{ $member->name }}
                    </option>
                    @endforeach
                </select>
                @error('staff_id')<p style="color:#e53e3e;font-size:11px;margin-top:4px;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">Service Type *</label>
                <input type="text" name="service_type" value="{{ old('service_type') }}"
                       placeholder="e.g. PC Repair, Virus Removal" class="input">
                @error('service_type')<p style="color:#e53e3e;font-size:11px;margin-top:4px;">{{ $message }}</p>@enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                <div>
                    <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">Date *</label>
                    <input type="date" name="appointment_date" value="{{ old('appointment_date') }}" class="input">
                    @error('appointment_date')<p style="color:#e53e3e;font-size:11px;margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">Time *</label>
                    <input type="time" name="appointment_time" value="{{ old('appointment_time') }}" class="input">
                    @error('appointment_time')<p style="color:#e53e3e;font-size:11px;margin-top:4px;">{{ $message }}</p>@enderror
                </div>
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">Status *</label>
                <select name="status" class="input">
                    <option value="scheduled" {{ old('status')=='scheduled'?'selected':'' }}>Scheduled</option>
                    <option value="confirmed" {{ old('status')=='confirmed'?'selected':'' }}>Confirmed</option>
                    <option value="completed" {{ old('status')=='completed'?'selected':'' }}>Completed</option>
                    <option value="cancelled" {{ old('status')=='cancelled'?'selected':'' }}>Cancelled</option>
                    <option value="no_show"   {{ old('status')=='no_show'  ?'selected':'' }}>No Show</option>
                </select>
                @error('status')<p style="color:#e53e3e;font-size:11px;margin-top:4px;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">Notes</label>
                <textarea name="notes" rows="3" class="input" placeholder="Any notes about this appointment...">{{ old('notes') }}</textarea>
            </div>

            {{-- Action Buttons --}}
            <div style="display:flex;gap:10px;padding-top:8px;border-top:1px solid #F5F5F5;">
                <button type="submit" class="btn-primary px-6 py-2 text-sm font-medium">
                    Save Appointment
                </button>
                <a href="{{ route('appointments.index') }}" class="btn-secondary px-6 py-2 text-sm font-medium">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>

</x-app-layout>