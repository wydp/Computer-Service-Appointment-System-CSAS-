<x-app-layout>
<x-slot name="title">Service Records</x-slot>

<div class="mb-8">
    <h1 class="page-title">Service Records</h1>
    <p class="page-sub">Complete history of all completed services</p>
</div>

<div class="card overflow-hidden">
    <table>
        <thead>
            <tr>
                <th>Client</th>
                <th>Service</th>
                <th>Staff</th>
                <th>Date</th>
                <th>Description</th>
                <th>Remarks</th>
                <th style="text-align:center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $r)
            <tr style="cursor:pointer;transition:background-color 0.2s;" onmouseover="this.style.backgroundColor='#F5F5F5'" onmouseout="this.style.backgroundColor='transparent'">
                <td style="font-weight:600;color:#1A1A1A;">
                    <a href="{{ route('clients.show', $r->client) }}" style="color:#1A1A1A;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#525252'" onmouseout="this.style.color='#1A1A1A'">{{ $r->client->full_name }}</a>
                </td>
                <td style="color:#525252;">{{ $r->appointment->service_type }}</td>
                <td style="color:#525252;">{{ $r->staff->name }}</td>
                <td style="color:#525252;font-weight:500;">{{ \Carbon\Carbon::parse($r->service_date)->format('M d, Y') }}</td>
                <td style="color:#8A8A8A;max-width:200px;" class="truncate">{{ $r->description }}</td>
                <td style="color:#8A8A8A;max-width:160px;" class="truncate">{{ $r->remarks ?? '—' }}</td>
                <td style="text-align:center;">
                    <div style="display:flex;gap:8px;align-items:center;justify-content:center;">
                        <button type="button" onclick="openTrackingModal({{ $r->appointment_id }})" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;background:#F5F5F5;border:1px solid #D5D5D5;border-radius:6px;color:#525252;cursor:pointer;transition:all 0.2s;font-size:14px;" title="View tracking" onmouseover="this.style.background='#000000';this.style.color='#FFF'" onmouseout="this.style.background='#F5F5F5';this.style.color='#525252'">
                            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </button>
                        @if(auth()->id() === $r->staff_id || auth()->user()->isAdmin())
                        <a href="{{ route('service-records.edit', $r) }}" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;background:#F5F5F5;border:1px solid #D5D5D5;border-radius:6px;color:#525252;text-decoration:none;transition:all 0.2s;font-size:14px;" title="Edit description" onmouseover="this.style.background='#000000';this.style.color='#FFF'" onmouseout="this.style.background='#F5F5F5';this.style.color='#525252'">
                            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:#8A8A8A;padding:48px 20px;font-size:14px;">No service records found.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($records->hasPages())
    <div style="padding:16px 20px;border-top:1px solid #ECECEC;background:#F8F9FA;">{{ $records->links() }}</div>
    @endif
</div>

</x-app-layout>