<x-app-layout>
<x-slot name="title">Users</x-slot>

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="page-title">User Management</h1>
        <p class="page-sub">Manage system accounts, roles, and permissions</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn-primary px-4 py-2.5 text-sm font-medium">+ Add User</a>
</div>

<div class="card overflow-hidden">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Joined</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td style="font-weight:600;color:#1A1A1A;">
                    {{ $user->name }}
                    @if($user->id === auth()->id())
                    <span style="font-size:11px;color:#8A8A8A;font-weight:500;margin-left:8px;">(you)</span>
                    @endif
                </td>
                <td style="color:#525252;">{{ $user->email }}</td>
                <td>
                    <span class="badge" style="@if($user->role === 'admin')background:#1A1A1A;color:#FFFFFF;border:1px solid #1A1A1A;padding:6px 12px;border-radius:4px;display:inline-block;font-size:12px;font-weight:600;@elseif($user->role === 'receptionist')background:transparent;color:#525252;border:1px solid #525252;padding:6px 12px;border-radius:4px;display:inline-block;font-size:12px;font-weight:600;@else color:#525252;padding:6px 12px;display:inline-block;font-size:12px;font-weight:600;@endif">{{ ucfirst($user->role) }}</span>
                </td>
                <td style="color:#525252;font-weight:500;">{{ $user->created_at->format('M d, Y') }}</td>
                <td style="text-align: right;">
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Are you sure you want to delete this user?')" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;background:#F5F5F5;border:1px solid #D5D5D5;border-radius:6px;color:#DC2626;cursor:pointer;transition:all 0.2s;font-size:14px;" title="Delete" onmouseover="this.style.background='#DC2626';this.style.color='#FFF'" onmouseout="this.style.background='#F5F5F5';this.style.color='#DC2626'">
                            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                    @else
                    <span style="color:#8A8A8A;font-size:13px;">—</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</x-app-layout>