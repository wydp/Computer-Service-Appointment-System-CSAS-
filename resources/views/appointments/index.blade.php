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
                    <div style="display:flex;gap:8px;align-items:center;justify-content:flex-end;">
                        <!-- Tracking -->
                        <button type="button" onclick="openTrackingModal({{ $a->id }})" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;background:#F5F5F5;border:1px solid #D5D5D5;border-radius:6px;color:#525252;cursor:pointer;transition:all 0.2s;font-size:14px;" title="View tracking" onmouseover="this.style.background='#000000';this.style.color='#FFF'" onmouseout="this.style.background='#F5F5F5';this.style.color='#525252'">
                            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </button>
                        <!-- View -->
                        <a href="{{ route('appointments.show', $a) }}" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;background:#F5F5F5;border:1px solid #D5D5D5;border-radius:6px;color:#525252;text-decoration:none;transition:all 0.2s;font-size:14px;" title="View details" onmouseover="this.style.background='#000000';this.style.color='#FFF'" onmouseout="this.style.background='#F5F5F5';this.style.color='#525252'">
                            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                        <!-- Edit -->
                        <a href="{{ route('appointments.edit', $a) }}" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;background:#F5F5F5;border:1px solid #D5D5D5;border-radius:6px;color:#525252;text-decoration:none;transition:all 0.2s;font-size:14px;" title="Edit" onmouseover="this.style.background='#000000';this.style.color='#FFF'" onmouseout="this.style.background='#F5F5F5';this.style.color='#525252'">
                            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <!-- Delete -->
                        <form method="POST" action="{{ route('appointments.destroy', $a) }}" onsubmit="return confirm('Are you sure you want to delete this appointment?')" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;background:#F5F5F5;border:1px solid #D5D5D5;border-radius:6px;color:#DC2626;cursor:pointer;transition:all 0.2s;font-size:14px;" title="Delete" onmouseover="this.style.background='#DC2626';this.style.color='#FFF'" onmouseout="this.style.background='#F5F5F5';this.style.color='#DC2626'">
                                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
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