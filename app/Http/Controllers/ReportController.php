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

        // Chart Data: Enhanced Status Distribution with percentages
        $statusData = [
            'scheduled'  => Appointment::where('status', 'scheduled')->count(),
            'confirmed'  => Appointment::where('status', 'confirmed')->count(),
            'completed'  => Appointment::where('status', 'completed')->count(),
            'cancelled'  => Appointment::where('status', 'cancelled')->count(),
            'no_show'    => Appointment::where('status', 'no_show')->count(),
        ];

        // Chart Data: Staff Performance (Completion rate %)
        $staffPerformance = User::where('role', 'staff')
            ->withCount('appointments')
            ->withCount(['statusHistoryChanges' => fn($q) => $q->where('new_status', 'completed')])
            ->get()
            ->mapWithKeys(fn($staff) => [
                $staff->name => [
                    'total' => $staff->appointments_count,
                    'completed' => $staff->status_history_changes_count,
                    'rate' => $staff->appointments_count > 0
                        ? round(($staff->status_history_changes_count / $staff->appointments_count) * 100)
                        : 0,
                ]
            ])
            ->toArray();

        // Chart Data: Monthly Trend (Last 12 months)
        $monthlyTrend = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = Appointment::whereYear('appointment_date', $date->year)
                ->whereMonth('appointment_date', $date->month)
                ->count();
            $monthlyTrend[$date->format('M Y')] = $count;
        }

        // Chart Data: Service Type Distribution
        $serviceTypes = Appointment::select('service_type')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('service_type')
            ->orderBy('count', 'DESC')
            ->take(8)
            ->get()
            ->mapWithKeys(fn($item) => [$item->service_type => $item->count])
            ->toArray();

        return view('reports.index', compact(
            'totalAppointments',
            'completedCount',
            'cancelledCount',
            'scheduledCount',
            'staffActivity',
            'completedAppointments',
            'statusData',
            'staffPerformance',
            'monthlyTrend',
            'serviceTypes'
        ));
    }
}