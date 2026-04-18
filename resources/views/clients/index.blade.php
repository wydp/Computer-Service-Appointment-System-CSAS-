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
                    <div style="display:flex;gap:8px;align-items:center;justify-content:flex-end;">
                        <!-- Edit -->
                        <a href="{{ route('clients.edit', $client) }}" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;background:#F5F5F5;border:1px solid #D5D5D5;border-radius:6px;color:#525252;text-decoration:none;transition:all 0.2s;font-size:14px;" title="Edit" onmouseover="this.style.background='#000000';this.style.color='#FFF'" onmouseout="this.style.background='#F5F5F5';this.style.color='#525252'">
                            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <!-- Delete -->
                        <form method="POST" action="{{ route('clients.destroy', $client) }}" onsubmit="return confirm('Are you sure you want to delete this client? This action cannot be undone.')" style="display:inline;">
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
            <tr><td colspan="5" style="text-align:center;color:#8A8A8A;padding:48px 20px;font-size:14px;">No clients found. <a href="{{ route('clients.create') }}" style="color:#1A1A1A;font-weight:600;text-decoration:none;">Create one</a></td></tr>
            @endforelse
        </tbody>
    </table>
    @if($clients->hasPages())
    <div style="padding:16px 20px;border-top:1px solid #ECECEC;background:#F8F9FA;">{{ $clients->links() }}</div>
    @endif
</div>

</x-app-layout>