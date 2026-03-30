<x-app-layout>
<x-slot name="title">Service Records</x-slot>

<div class="mb-8">
    <h1 class="page-title">Service Records</h1>
    <p class="page-sub">History of completed services</p>
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
            </tr>
        </thead>
        <tbody>
            @forelse($records as $r)
            <tr>
                <td style="font-weight:500;">
                    <a href="{{ route('clients.show', $r->client) }}" style="color:#191919;text-decoration:none;">{{ $r->client->full_name }}</a>
                </td>
                <td style="color:#636363;">{{ $r->appointment->service_type }}</td>
                <td style="color:#636363;">{{ $r->staff->name }}</td>
                <td style="color:#636363;">{{ \Carbon\Carbon::parse($r->service_date)->format('M d, Y') }}</td>
                <td style="color:#191919;max-width:200px;" class="truncate">{{ $r->description }}</td>
                <td style="color:#636363;max-width:160px;" class="truncate">{{ $r->remarks ?? '—' }}</td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:#636363;padding:40px;">No service records yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($records->hasPages())
    <div style="padding:16px 20px;border-top:1px solid #F5F5F5;">{{ $records->links() }}</div>
    @endif
</div>

</x-app-layout>