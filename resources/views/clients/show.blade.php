<x-app-layout>
<x-slot name="title">Client Details</x-slot>

<div class="max-w-3xl">
    <a href="{{ route('clients.index') }}" class="text-sm text-gray-500 hover:text-gray-700 mb-4 inline-block">
        &larr; Back to Clients
    </a>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $client->full_name }}</h2>
                <p class="text-gray-500 mt-1">{{ $client->phone }}</p>
                <p class="text-gray-500">{{ $client->email ?? 'No email provided' }}</p>
                <p class="text-gray-500">{{ $client->address ?? 'No address provided' }}</p>
                @if($client->notes)
                    <p class="text-gray-400 text-sm mt-2 italic">{{ $client->notes }}</p>
                @endif
            </div>
            <a href="{{ route('clients.edit', $client) }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                Edit
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Appointment History</h3>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($client->appointments as $appointment)
            <div class="px-6 py-4 flex justify-between items-center">
                <div>
                    <p class="font-medium text-gray-800">{{ $appointment->service_type }}</p>
                    <p class="text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                        at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                        — {{ $appointment->staff->name }}
                    </p>
                </div>
                @php
                $colors = [
                    'scheduled' => 'bg-yellow-100 text-yellow-800',
                    'confirmed' => 'bg-blue-100 text-blue-800',
                    'completed' => 'bg-green-100 text-green-800',
                    'cancelled' => 'bg-red-100 text-red-800',
                    'no_show'   => 'bg-gray-100 text-gray-800',
                ];
                @endphp
                <span class="text-xs px-2 py-1 rounded-full font-medium {{ $colors[$appointment->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($appointment->status) }}
                </span>
            </div>
            @empty
            <p class="px-6 py-4 text-sm text-gray-400">No appointments yet.</p>
            @endforelse
        </div>
    </div>
</div>

</x-app-layout>
