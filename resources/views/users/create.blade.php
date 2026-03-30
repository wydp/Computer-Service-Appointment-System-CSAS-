<x-app-layout>
<x-slot name="title">Add User</x-slot>

<div class="mb-6">
    <a href="{{ route('users.index') }}" style="font-size:13px;color:#191919;text-decoration:none;">← Back to Users</a>
</div>

<div style="max-width:480px;">
    <div class="card p-6">
        <h2 style="font-size:16px;font-weight:600;color:#191919;margin-bottom:24px;">Create New User</h2>
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" class="input">
                @error('name')<p style="color:#e53e3e;font-size:11px;margin-top:4px;">{{ $message }}</p>@enderror
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" class="input">
                @error('email')<p style="color:#e53e3e;font-size:11px;margin-top:4px;">{{ $message }}</p>@enderror
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">Role *</label>
                <select name="role" class="input">
                    <option value="">Select role</option>
                    <option value="admin"        {{ old('role')=='admin'        ? 'selected':'' }}>Admin</option>
                    <option value="receptionist" {{ old('role')=='receptionist' ? 'selected':'' }}>Receptionist</option>
                    <option value="staff"        {{ old('role')=='staff'        ? 'selected':'' }}>Staff</option>
                </select>
                @error('role')<p style="color:#e53e3e;font-size:11px;margin-top:4px;">{{ $message }}</p>@enderror
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">Password *</label>
                <input type="password" name="password" class="input">
                @error('password')<p style="color:#e53e3e;font-size:11px;margin-top:4px;">{{ $message }}</p>@enderror
            </div>
            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">Confirm Password *</label>
                <input type="password" name="password_confirmation" class="input">
            </div>
            <div style="display:flex;gap:10px;">
                <button type="submit" class="btn-primary px-5 py-2 text-sm font-medium">Create User</button>
                <a href="{{ route('users.index') }}" class="btn-secondary px-5 py-2 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>

</x-app-layout>
