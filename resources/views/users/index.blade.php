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
                    <span class="badge" style="@if($user->role === 'admin')background:#1A1A1A;color:#FFFFFF;border:1px solid #1A1A1A;@else background:#F5F6F7;color:#525252;border:1px solid #ECECEC;@endif">{{ ucfirst($user->role) }}</span>
                </td>
                <td style="color:#525252;font-weight:500;">{{ $user->created_at->format('M d, Y') }}</td>
                <td style="text-align: right;">
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Are you sure you want to delete this user?')" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" style="font-size:13px;color:#DC2626;background:none;border:none;cursor:pointer;text-decoration:none;font-weight:500;padding:0;transition:opacity 0.2s;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">Delete</button>
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