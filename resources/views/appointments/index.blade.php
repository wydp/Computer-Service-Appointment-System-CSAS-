<x-app-layout>
<x-slot name="title">Appointments</x-slot>

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="page-title">Appointments</h1>
        <p class="page-sub">Manage all bookings and schedules</p>
    </div>
    <a href="{{ route('appointments.create') }}" class="btn-primary px-4 py-2 text-sm font-medium">+ New Appointment</a>
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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $a)
            <tr>
                <td style="font-weight:500;">{{ $a->client->full_name }}</td>
                <td style="color:#636363;">{{ $a->service_type }}</td>
                <td style="color:#636363;">{{ $a->staff->name }}</td>
                <td>
                    <span style="font-size:13px;color:#191919;">{{ \Carbon\Carbon::parse($a->appointment_date)->format('M d, Y') }}</span>
                    <span style="display:block;font-size:11px;color:#636363;">{{ \Carbon\Carbon::parse($a->appointment_time)->format('h:i A') }}</span>
                </td>
                <td><span class="badge badge-{{ $a->status }}">{{ ucfirst($a->status) }}</span></td>
                <td>
                    <div style="display:flex;gap:12px;align-items:center;">
                        <a href="{{ route('appointments.show', $a) }}" style="font-size:13px;color:#636363;text-decoration:underline;">View</a>
                        <a href="{{ route('appointments.edit', $a) }}" style="font-size:13px;color:#191919;text-decoration:underline;">Edit</a>
                        <form method="POST" action="{{ route('appointments.destroy', $a) }}" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="font-size:13px;color:#636363;background:none;border:none;cursor:pointer;text-decoration:underline;">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:#636363;padding:40px;">No appointments found.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($appointments->hasPages())
    <div style="padding:16px 20px;border-top:1px solid #F5F5F5;">{{ $appointments->links() }}</div>
    @endif
</div>

</x-app-layout>