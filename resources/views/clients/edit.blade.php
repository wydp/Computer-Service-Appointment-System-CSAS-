<x-app-layout>
<x-slot name="title">Edit Client</x-slot>

<div class="mb-6">
    <a href="{{ route('clients.index') }}" style="font-size:13px;color:#191919;text-decoration:none;">← Back to Clients</a>
</div>

<div style="max-width:560px;">
    <div class="card p-6">
        <h2 style="font-size:16px;font-weight:600;color:#191919;margin-bottom:24px;">Edit Client</h2>
        <form method="POST" action="{{ route('clients.update', $client) }}">
            @csrf @method('PUT')
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                <div>
                    <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">First Name *</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $client->first_name) }}" class="input">
                    @error('first_name')<p style="color:#e53e3e;font-size:11px;margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">Last Name *</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $client->last_name) }}" class="input">
                    @error('last_name')<p style="color:#e53e3e;font-size:11px;margin-top:4px;">{{ $message }}</p>@enderror
                </div>
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">Phone *</label>
                <input type="text" name="phone" value="{{ old('phone', $client->phone) }}" class="input">
                @error('phone')<p style="color:#e53e3e;font-size:11px;margin-top:4px;">{{ $message }}</p>@enderror
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">Email</label>
                <input type="email" name="email" value="{{ old('email', $client->email) }}" class="input">
                @error('email')<p style="color:#e53e3e;font-size:11px;margin-top:4px;">{{ $message }}</p>@enderror
            </div>
            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">Address</label>
                <textarea name="address" rows="2" class="input">{{ old('address', $client->address) }}</textarea>
            </div>
            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:12px;font-weight:500;color:#191919;margin-bottom:6px;">Notes</label>
                <textarea name="notes" rows="2" class="input">{{ old('notes', $client->notes) }}</textarea>
            </div>
            <div style="display:flex;gap:10px;">
                <button type="submit" class="btn-primary px-5 py-2 text-sm font-medium">Update Client</button>
                <a href="{{ route('clients.index') }}" class="btn-secondary px-5 py-2 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>

</x-app-layout>