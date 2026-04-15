<x-app-layout>
<x-slot name="title">Appointments</x-slot>

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="page-title">Appointments</h1>
        <p class="page-sub">Manage all bookings and schedules</p>
    </div>
    <a href="{{ route('appointments.create') }}" class="btn-primary px-4 py-2.5 text-sm font-medium">+ New Appointment</a>
</div>

<div class="card overflow-hidden">
    <table>
        <thead>
            <tr>
                <th>Client</th>
                <th>Service</th>
                <th>Staff</th>
                <th>Date & Time</th>
                <th>Status</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $a)
            <tr style="cursor:pointer;transition:background-color 0.2s;" onmouseover="this.style.backgroundColor='#F5F5F5'" onmouseout="this.style.backgroundColor='transparent'">
                <td style="font-weight:600;color:#1A1A1A;">{{ $a->client->full_name }}</td>
                <td style="color:#525252;">{{ $a->service_type }}</td>
                <td style="color:#525252;">{{ $a->staff->name }}</td>
                <td>
                    <span style="font-size:13px;color:#1A1A1A;font-weight:500;">{{ \Carbon\Carbon::parse($a->appointment_date)->format('M d, Y') }}</span>
                    <span style="display:block;font-size:12px;color:#8A8A8A;margin-top:2px;">{{ \Carbon\Carbon::parse($a->appointment_time)->format('h:i A') }}</span>
                </td>
                <td><span class="badge badge-{{ $a->status }}">{{ ucfirst($a->status) }}</span></td>
                <td style="text-align: right;">
                    <div style="display:flex;gap:16px;align-items:center;justify-content:flex-end;">
                        <button type="button" onclick="openTrackingModal({{ $a->id }})" style="font-size:13px;color:#000000;background:none;border:none;cursor:pointer;text-decoration:none;font-weight:500;padding:0;transition:opacity 0.2s;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">Tracking</button>
                        <a href="{{ route('appointments.show', $a) }}" style="font-size:13px;color:#525252;text-decoration:none;font-weight:500;transition:color 0.2s;" onmouseover="this.style.color='#1A1A1A'" onmouseout="this.style.color='#525252'">View</a>
                        <a href="{{ route('appointments.edit', $a) }}" style="font-size:13px;color:#1A1A1A;text-decoration:none;font-weight:500;transition:opacity 0.2s;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">Edit</a>
                        <form method="POST" action="{{ route('appointments.destroy', $a) }}" onsubmit="return confirm('Are you sure you want to delete this appointment?')" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" style="font-size:13px;color:#DC2626;background:none;border:none;cursor:pointer;text-decoration:none;font-weight:500;padding:0;transition:opacity 0.2s;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:#8A8A8A;padding:48px 20px;font-size:14px;">No appointments found. <a href="{{ route('appointments.create') }}" style="color:#1A1A1A;font-weight:600;text-decoration:none;">Create one</a></td></tr>
            @endforelse
        </tbody>
    </table>
    @if($appointments->hasPages())
    <div style="padding:16px 20px;border-top:1px solid #ECECEC;background:#F8F9FA;">{{ $appointments->links() }}</div>
    @endif
</div>

</x-app-layout>