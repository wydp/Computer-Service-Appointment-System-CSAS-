<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Appointment;
use App\Models\ServiceRecord;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Count total clients
        $totalClients = Client::count();

        // Count today's appointments
        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();

        // Count completed appointments
        $completedAppointments = Appointment::where('status', 'completed')->count();

        // Count cancelled appointments
        $cancelledAppointments = Appointment::where('status', 'cancelled')->count();

        // Get upcoming appointments (today and future)
        $upcomingAppointments = Appointment::with(['client', 'staff'])
            ->whereDate('appointment_date', '>=', today())
            ->where('status', '!=', 'cancelled')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take(5)
            ->get();

        // Get recent appointments
        $recentAppointments = Appointment::with(['client', 'staff'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalClients',
            'todayAppointments',
            'completedAppointments',
            'cancelledAppointments',
            'upcomingAppointments',
            'recentAppointments'
        ));
    }
}