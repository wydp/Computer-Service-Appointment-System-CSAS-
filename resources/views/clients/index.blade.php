<x-app-layout>
<x-slot name="title">Clients</x-slot>

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="page-title">Clients</h1>
        <p class="page-sub">Manage your client records</p>
    </div>
    <a href="{{ route('clients.create') }}" class="btn-primary px-4 py-2 text-sm font-medium">+ Add Client</a>
</div>

<div class="card overflow-hidden">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clients as $client)
            <tr>
                <td>
                    <a href="{{ route('clients.show', $client) }}" style="font-weight:500;color:#191919;text-decoration:none;" onmouseover="this.style.color='#191919'" onmouseout="this.style.color='#191919'">
                        {{ $client->full_name }}
                    </a>
                </td>
                <td style="color:#191919;">{{ $client->phone }}</td>
                <td style="color:#191919;">{{ $client->email ?? '—' }}</td>
                <td style="color:#191919;">{{ $client->address ?? '—' }}</td>
                <td>
                    <div style="display:flex;gap:8px;align-items:center;">
                        <a href="{{ route('clients.edit', $client) }}" style="font-size:13px;color:#191919;text-decoration:underline;">Edit</a>
                        <form method="POST" action="{{ route('clients.destroy', $client) }}" onsubmit="return confirm('Delete this client?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="font-size:13px;color:#191919;background:none;border:none;cursor:pointer;text-decoration:underline;">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:#191919;padding:40px;">No clients found. <a href="{{ route('clients.create') }}" style="color:#191919;">Add one</a></td></tr>
            @endforelse
        </tbody>
    </table>
    @if($clients->hasPages())
    <div style="padding:16px 20px;border-top:1px solid #F5F5F5;">{{ $clients->links() }}</div>
    @endif
</div>

</x-app-layout>