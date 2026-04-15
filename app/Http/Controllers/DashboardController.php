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

        // Chart Data: Status Distribution
        $statusData = [
            'scheduled'  => Appointment::where('status', 'scheduled')->count(),
            'confirmed'  => Appointment::where('status', 'confirmed')->count(),
            'completed'  => Appointment::where('status', 'completed')->count(),
            'cancelled'  => Appointment::where('status', 'cancelled')->count(),
            'no_show'    => Appointment::where('status', 'no_show')->count(),
        ];

        // Chart Data: Weekly Trend (Last 7 days)
        $weeklyTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $count = Appointment::whereDate('appointment_date', $date)->count();
            $weeklyTrend[$date->format('M d')] = $count;
        }

        // Chart Data: Staff Workload
        $staffWorkload = \App\Models\User::where('role', 'staff')
            ->withCount('appointments')
            ->get()
            ->mapWithKeys(fn($staff) => [$staff->name => $staff->appointments_count])
            ->toArray();

        return view('dashboard', compact(
            'totalClients',
            'todayAppointments',
            'completedAppointments',
            'cancelledAppointments',
            'upcomingAppointments',
            'recentAppointments',
            'statusData',
            'weeklyTrend',
            'staffWorkload'
        ));
    }
}