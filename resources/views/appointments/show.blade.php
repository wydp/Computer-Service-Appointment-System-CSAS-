<x-app-layout>
<x-slot name="title">Appointment Details</x-slot>

<div class="max-w-3xl">
    <a href="{{ route('appointments.index') }}" class="text-sm text-gray-500 hover:text-gray-700 mb-4 inline-block">
        &larr; Back to Appointments
    </a>

    @php
    $colors = [
        'scheduled' => 'bg-yellow-100 text-yellow-800',
        'confirmed' => 'bg-blue-100 text-blue-800',
        'completed' => 'bg-green-100 text-green-800',
        'cancelled' => 'bg-red-100 text-red-800',
        'no_show'   => 'bg-gray-100 text-gray-800',
    ];
    @endphp

    {{-- Appointment Info --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $appointment->service_type }}</h2>
                <p class="text-gray-500 mt-1">
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}
                    at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                </p>
            </div>
            <div class="flex gap-2 items-center">
                <span class="text-sm px-3 py-1 rounded-full font-medium {{ $colors[$appointment->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($appointment->status) }}
                </span>
                <a href="{{ route('appointments.edit', $appointment) }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                    Edit
                </a>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-400">Client</p>
                <p class="font-medium text-gray-800">
                    <a href="{{ route('clients.show', $appointment->client) }}" class="hover:text-blue-600">
                        {{ $appointment->client->full_name }}
                    </a>
                </p>
            </div>
            <div>
                <p class="text-gray-400">Assigned Staff</p>
                <p class="font-medium text-gray-800">{{ $appointment->staff->name }}</p>
            </div>
            @if($appointment->notes)
            <div class="col-span-2">
                <p class="text-gray-400">Notes</p>
                <p class="text-gray-700">{{ $appointment->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Update Status --}}
    @if(!$appointment->isCompleted() && !$appointment->isCancelled())
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="font-semibold text-gray-800 mb-4">Update Status</h3>
        <form method="POST" action="{{ route('appointments.update-status', $appointment) }}">
            @csrf
            @method('PATCH')
            <div class="flex gap-3">
                <select name="status"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="scheduled" {{ $appointment->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="no_show"   {{ $appointment->status == 'no_show'   ? 'selected' : '' }}>No Show</option>
                </select>
                <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
                    Update Status
                </button>
            </div>
        </form>
    </div>
    @endif

    {{-- Service Record --}}
    @if($appointment->isCompleted())
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Service Record</h3>
        @if($appointment->serviceRecord)
            <p class="text-gray-700 mb-2">{{ $appointment->serviceRecord->description }}</p>
            <p class="text-sm text-gray-400">Date: {{ \Carbon\Carbon::parse($appointment->serviceRecord->service_date)->format('M d, Y') }}</p>
            @if($appointment->serviceRecord->remarks)
                <p class="text-sm text-gray-500 mt-2">Remarks: {{ $appointment->serviceRecord->remarks }}</p>
            @endif
        @else
            <form method="POST" action="{{ route('service-records.store') }}">
                @csrf
                <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                    <textarea name="description" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="What was done during the service?"></textarea>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Service Date *</label>
                    <input type="date" name="service_date" value="{{ $appointment->appointment_date }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                    <textarea name="remarks" rows="2"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Any additional remarks?"></textarea>
                </div>
                <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
                    Save Service Record
                </button>
            </form>
        @endif
    </div>
    @endif

</div>

</x-app-layout>
