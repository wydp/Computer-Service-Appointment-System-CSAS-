<x-app-layout>
<x-slot name="title">Edit Client</x-slot>

<div class="mb-8">
    <a href="{{ route('clients.index') }}" style="font-size:13px;color:#525252;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:color 0.2s;" onmouseover="this.style.color='#1A1A1A'" onmouseout="this.style.color='#525252'">
        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Clients
    </a>
</div>

<div style="max-width:600px;">
    <div class="card p-7">
        <h2 style="font-size:18px;font-weight:700;color:#1A1A1A;margin-bottom:28px;">Edit Client Information</h2>
        <form method="POST" action="{{ route('clients.update', $client) }}">
            @csrf @method('PUT')

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">First Name *</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $client->first_name) }}" class="input">
                    @error('first_name')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Last Name *</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $client->last_name) }}" class="input">
                    @error('last_name')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Phone Number *</label>
                <input type="text" name="phone" value="{{ old('phone', $client->phone) }}" class="input">
                @error('phone')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $client->email) }}" class="input">
                @error('email')<p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Address</label>
                <textarea name="address" rows="2" class="input">{{ old('address', $client->address) }}</textarea>
            </div>

            <div style="margin-bottom:28px;">
                <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Notes</label>
                <textarea name="notes" rows="2" class="input">{{ old('notes', $client->notes) }}</textarea>
            </div>

            <div style="display:flex;gap:12px;padding-top:16px;border-top:1px solid #ECECEC;">
                <button type="submit" class="btn-primary px-6 py-2.5 text-sm font-medium">Save Changes</button>
                <a href="{{ route('clients.index') }}" class="btn-secondary px-6 py-2.5 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>

</x-app-layout>