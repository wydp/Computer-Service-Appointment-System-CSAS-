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

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Service Type *</label>
                    <input type="text" name="service_type" value="{{ old('service_type',$appointment->service_type) }}" class="input" style="width:100%;">
                    @error('service_type')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Status *</label>
                    @error('status')<p style="color:#DC2626;font-size:12px;margin-bottom:6px;">{{ $message }}</p>@enderror
                    <input type="hidden" id="statusInput" name="status" value="{{ old('status', $appointment->status) }}">
                    <div style="display:flex;gap:8px;flex-wrap:wrap;">
                        <button type="button" onclick="setStatus('scheduled', this)" style="padding:8px 16px;border-radius:6px;font-size:13px;font-weight:500;border:none;cursor:pointer;transition:all 0.2s;{{ old('status', $appointment->status) === 'scheduled' ? 'background:#1A1A1A;color:#FFFFFF;' : 'background:#F5F5F5;color:#525252;' }}" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">Scheduled</button>
                        <button type="button" onclick="setStatus('confirmed', this)" style="padding:8px 16px;border-radius:6px;font-size:13px;font-weight:500;border:none;cursor:pointer;transition:all 0.2s;{{ old('status', $appointment->status) === 'confirmed' ? 'background:#1A1A1A;color:#FFFFFF;' : 'background:#F5F5F5;color:#525252;' }}" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">Confirmed</button>
                        <button type="button" onclick="setStatus('completed', this)" style="padding:8px 16px;border-radius:6px;font-size:13px;font-weight:500;border:none;cursor:pointer;transition:all 0.2s;{{ old('status', $appointment->status) === 'completed' ? 'background:#00AA00;color:#FFFFFF;' : 'background:#F0FDF4;color:#15803d;' }}" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">Completed</button>
                        <button type="button" onclick="setStatus('cancelled', this)" style="padding:8px 16px;border-radius:6px;font-size:13px;font-weight:500;border:none;cursor:pointer;transition:all 0.2s;{{ old('status', $appointment->status) === 'cancelled' ? 'background:#DC2626;color:#FFFFFF;' : 'background:#FEF2F2;color:#DC2626;' }}" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">Cancelled</button>
                        <button type="button" onclick="setStatus('no_show', this)" style="padding:8px 16px;border-radius:6px;font-size:13px;font-weight:500;border:none;cursor:pointer;transition:all 0.2s;{{ old('status', $appointment->status) === 'no_show' ? 'background:#FF6600;color:#FFFFFF;' : 'background:#FEF3F2;color:#FF6600;' }}" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">No Show</button>
                    </div>
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Date & Time *</label>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
                    <div>
                        <input type="date" name="appointment_date" value="{{ old('appointment_date',$appointment->appointment_date) }}" class="input" style="width:100%;">
                        @error('appointment_date')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <input type="time" name="appointment_time" value="{{ old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')) }}" class="input" style="width:100%;">
                        @error('appointment_time')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div style="margin-bottom:28px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Notes</label>
                <textarea name="notes" rows="2" class="input" style="width:100%;">{{ old('notes',$appointment->notes) }}</textarea>
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

<script>
    function setStatus(status, button) {
        event.preventDefault();
        document.getElementById('statusInput').value = status;

        // Remove active state from all buttons
        const allButtons = button.parentElement.querySelectorAll('button');
        allButtons.forEach(btn => {
            btn.style.background = '#F5F5F5';
            btn.style.color = '#525252';
        });

        // Add active state to clicked button
        if (status === 'completed') {
            button.style.background = '#00AA00';
            button.style.color = '#FFFFFF';
        } else if (status === 'cancelled') {
            button.style.background = '#DC2626';
            button.style.color = '#FFFFFF';
        } else if (status === 'no_show') {
            button.style.background = '#FF6600';
            button.style.color = '#FFFFFF';
        } else {
            button.style.background = '#1A1A1A';
            button.style.color = '#FFFFFF';
        }
    }
</script>

</x-app-layout>