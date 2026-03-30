<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Appointments grouped by status
        $totalAppointments     = Appointment::count();
        $completedCount        = Appointment::where('status', 'completed')->count();
        $cancelledCount        = Appointment::where('status', 'cancelled')->count();
        $scheduledCount        = Appointment::where('status', 'scheduled')->count();

        // Staff activity
        $staffActivity = User::where('role', 'staff')
            ->withCount('appointments')
            ->get();

        // Recent completed appointments
        $completedAppointments = Appointment::with(['client', 'staff'])
            ->where('status', 'completed')
            ->latest()
            ->take(10)
            ->get();

        return view('reports.index', compact(
            'totalAppointments',
            'completedCount',
            'cancelledCount',
            'scheduledCount',
            'staffActivity',
            'completedAppointments'
        ));
    }
}