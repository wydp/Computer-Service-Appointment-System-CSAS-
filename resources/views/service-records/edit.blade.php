<x-app-layout>
<x-slot name="title">Edit Service Record</x-slot>

<div class="mb-8 flex items-start justify-between">
    <div>
        <a href="{{ route('service-records.index') }}" style="font-size:13px;color:#525252;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:color 0.2s;" onmouseover="this.style.color='#1A1A1A'" onmouseout="this.style.color='#525252'">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Service Records
        </a>
        <h1 class="page-title mt-4">Edit Service Description</h1>
        <p class="page-sub">Only the description can be modified</p>
    </div>
</div>

<div class="card p-7" style="max-width:780px;">
    {{-- Read-only section --}}
    <div style="background:#F8F9FA;border:1px solid #ECECEC;border-radius:10px;padding:20px;margin-bottom:24px;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:20px;">
            <div>
                <p style="font-size:11px;font-weight:600;color:#8A8A8A;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Client</p>
                <p style="font-size:14px;font-weight:600;color:#1A1A1A;">{{ $serviceRecord->client->full_name }}</p>
            </div>
            <div>
                <p style="font-size:11px;font-weight:600;color:#8A8A8A;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Service Staff</p>
                <p style="font-size:14px;font-weight:600;color:#1A1A1A;">{{ $serviceRecord->staff->name }}</p>
            </div>
        </div>
        <div>
            <p style="font-size:11px;font-weight:600;color:#8A8A8A;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Service Date</p>
            <p style="font-size:14px;font-weight:600;color:#1A1A1A;">{{ \Carbon\Carbon::parse($serviceRecord->service_date)->format('F d, Y') }}</p>
        </div>
        @if($serviceRecord->remarks)
        <div style="margin-top:20px;">
            <p style="font-size:11px;font-weight:600;color:#8A8A8A;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:6px;">Remarks</p>
            <p style="font-size:14px;color:#525252;">{{ $serviceRecord->remarks }}</p>
        </div>
        @endif
    </div>

    {{-- Edit form --}}
    <form method="POST" action="{{ route('service-records.update', $serviceRecord) }}">
        @csrf @method('PATCH')

        <div style="margin-bottom:20px;">
            <label style="display:block;font-size:12px;font-weight:600;color:#1A1A1A;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.05em;">Description *</label>
            <textarea name="description" rows="6" class="input" placeholder="Edit the service description...">{{ $serviceRecord->description }}</textarea>
            @error('description')
            <p style="color:#DC2626;font-size:12px;margin-top:6px;">{{ $message }}</p>
            @enderror
        </div>

        <div style="display:flex;gap:12px;align-items:center;">
            <button type="submit" class="btn-primary px-6 py-2.5 text-sm font-medium">Save Changes</button>
            <a href="{{ route('service-records.index') }}" style="display:inline-flex;align-items:center;justify-content:center;padding:10px 24px;font-size:14px;font-weight:500;color:#525252;background:#F5F5F5;border:1px solid #E5E5E5;border-radius:8px;text-decoration:none;transition:all 0.2s;" onmouseover="this.style.background='#E5E5E5'" onmouseout="this.style.background='#F5F5F5'">Cancel</a>
        </div>
    </form>
</div>

</x-app-layout>
