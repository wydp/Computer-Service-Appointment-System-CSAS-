<x-app-layout>
<x-slot name="title">Add User</x-slot>

<div class="mb-8">
    <a href="{{ route('users.index') }}" style="font-size:13px;color:#525252;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:color 0.2s;" onmouseover="this.style.color='#1A1A1A'" onmouseout="this.style.color='#525252'">
        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Users
    </a>
</div>

<div style="max-width:560px;">
    <div class="card p-7">
        <h2 style="font-size:18px;font-weight:700;color:#1A1A1A;margin-bottom:28px;">Create New User Account</h2>
        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" class="input" placeholder="John Doe">
                @error('name')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Email Address *</label>
                <input type="email" name="email" value="{{ old('email') }}" class="input" placeholder="john@example.com">
                @error('email')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Role *</label>
                <select name="role" class="input">
                    <option value="">— Select a role —</option>
                    <option value="admin" {{ old('role')=='admin' ? 'selected':'' }}>Admin</option>
                    <option value="receptionist" {{ old('role')=='receptionist' ? 'selected':'' }}>Receptionist</option>
                    <option value="staff" {{ old('role')=='staff' ? 'selected':'' }}>Staff</option>
                </select>
                @error('role')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Password *</label>
                <input type="password" name="password" class="input" placeholder="At least 8 characters">
                @error('password')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:28px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Confirm Password *</label>
                <input type="password" name="password_confirmation" class="input" placeholder="Confirm password">
            </div>

            <div style="display:flex;gap:12px;padding-top:16px;border-top:1px solid #ECECEC;">
                <button type="submit" class="btn-primary px-6 py-2.5 text-sm font-medium">Create User</button>
                <a href="{{ route('users.index') }}" class="btn-secondary px-6 py-2.5 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>

</x-app-layout>