<x-app-layout>
<x-slot name="title">Clients</x-slot>

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="page-title">Clients</h1>
        <p class="page-sub">Manage and track all customer records</p>
    </div>
    <a href="{{ route('clients.create') }}" class="btn-primary px-4 py-2.5 text-sm font-medium">+ Add Client</a>
</div>

<div class="card overflow-hidden">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clients as $client)
            <tr>
                <td>
                    <a href="{{ route('clients.show', $client) }}" style="font-weight:600;color:#1A1A1A;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#525252'" onmouseout="this.style.color='#1A1A1A'">
                        {{ $client->full_name }}
                    </a>
                </td>
                <td style="color:#525252;font-weight:500;">{{ $client->phone }}</td>
                <td style="color:#525252;">{{ $client->email ?? '—' }}</td>
                <td style="color:#525252;">{{ Str::limit($client->address ?? '—', 40) }}</td>
                <td style="text-align: right;">
                    <div style="display:flex;gap:16px;align-items:center;justify-content:flex-end;">
                        <a href="{{ route('clients.edit', $client) }}" style="font-size:13px;color:#1A1A1A;text-decoration:none;font-weight:500;transition:opacity 0.2s;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">Edit</a>
                        <form method="POST" action="{{ route('clients.destroy', $client) }}" onsubmit="return confirm('Are you sure you want to delete this client? This action cannot be undone.')" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" style="font-size:13px;color:#DC2626;background:none;border:none;cursor:pointer;text-decoration:none;font-weight:500;padding:0;transition:opacity 0.2s;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:#8A8A8A;padding:48px 20px;font-size:14px;">No clients found. <a href="{{ route('clients.create') }}" style="color:#1A1A1A;font-weight:600;text-decoration:none;">Create one</a></td></tr>
            @endforelse
        </tbody>
    </table>
    @if($clients->hasPages())
    <div style="padding:16px 20px;border-top:1px solid #ECECEC;background:#F8F9FA;">{{ $clients->links() }}</div>
    @endif
</div>

</x-app-layout>