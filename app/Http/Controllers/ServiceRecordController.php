<?php

namespace App\Http\Controllers;

use App\Models\ServiceRecord;
use App\Models\Appointment;
use Illuminate\Http\Request;

class ServiceRecordController extends Controller
{
    // Show all service records
    public function index()
    {
        $records = ServiceRecord::with(['client', 'staff', 'appointment'])
            ->latest()
            ->paginate(10);
        return view('service-records.index', compact('records'));
    }

    // Save new service record
    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'description'    => 'required|string',
            'service_date'   => 'required|date',
            'remarks'        => 'nullable|string',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);

        ServiceRecord::create([
            'appointment_id' => $appointment->id,
            'client_id'      => $appointment->client_id,
            'staff_id'       => $appointment->staff_id,
            'description'    => $request->description,
            'service_date'   => $request->service_date,
            'remarks'        => $request->remarks,
        ]);

        // Mark appointment as completed
        $appointment->update(['status' => 'completed']);

        return back()->with('success', 'Service record saved!');
    }
}