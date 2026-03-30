<x-app-layout>
<x-slot name="title">Users</x-slot>

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="page-title">User Management</h1>
        <p class="page-sub">Manage system accounts and roles</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn-primary px-4 py-2 text-sm font-medium">+ Add User</a>
</div>

<div class="card overflow-hidden">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            @php
            $roleStyle = [
                'admin'        => 'background:#191919;color:#F5F5F5;',
                'receptionist' => 'background:#F5F5F5;color:#191919;border:1px solid #191919;',
                'staff'        => 'background:#F5F5F5;color:#191919;border:1px solid #191919;',
            ];
            @endphp
            <tr>
                <td style="font-weight:500;">
                    {{ $user->name }}
                    @if($user->id === auth()->id())
                    <span style="font-size:11px;color:#191919;"> (you)</span>
                    @endif
                </td>
                <td style="color:#191919;">{{ $user->email }}</td>
                <td>
                    <span class="badge" style="{{ $roleStyle[$user->role] ?? '' }}">{{ ucfirst($user->role) }}</span>
                </td>
                <td style="color:#191919;">{{ $user->created_at->format('M d, Y') }}</td>
                <td>
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Delete {{ $user->name }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="font-size:13px;color:#191919;background:none;border:none;cursor:pointer;text-decoration:underline;">Delete</button>
                    </form>
                    @else
                    <span style="color:#191919;font-size:13px;">—</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</x-app-layout>
