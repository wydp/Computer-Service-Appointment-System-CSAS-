<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Appointment;
use App\Models\ServiceRecord;
use App\Models\AppointmentStatusHistory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@circuithub.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'email_verified_at' => now()
            ]
        );

        // Create staff users
        $staff1 = User::updateOrCreate(
            ['email' => 'tech1@circuithub.com'],
            [
                'name' => 'John Doe',
                'password' => bcrypt('password'),
                'role' => 'staff',
                'email_verified_at' => now()
            ]
        );

        $staff2 = User::updateOrCreate(
            ['email' => 'tech2@circuithub.com'],
            [
                'name' => 'Jane Smith',
                'password' => bcrypt('password'),
                'role' => 'staff',
                'email_verified_at' => now()
            ]
        );

        $staff3 = User::updateOrCreate(
            ['email' => 'tech3@circuithub.com'],
            [
                'name' => 'Mike Johnson',
                'password' => bcrypt('password'),
                'role' => 'staff',
                'email_verified_at' => now()
            ]
        );

        // Create clients
        $clients = [];
        $clientData = [
            ['first' => 'Sarah', 'last' => 'Wilson', 'phone' => '555-0101', 'email' => 'sarah@example.com', 'address' => '123 Main St'],
            ['first' => 'Robert', 'last' => 'Brown', 'phone' => '555-0102', 'email' => 'robert@example.com', 'address' => '456 Oak Ave'],
            ['first' => 'Emily', 'last' => 'Davis', 'phone' => '555-0103', 'email' => 'emily@example.com', 'address' => '789 Pine Rd'],
            ['first' => 'James', 'last' => 'Miller', 'phone' => '555-0104', 'email' => 'james@example.com', 'address' => '321 Elm St'],
            ['first' => 'Lisa', 'last' => 'Anderson', 'phone' => '555-0105', 'email' => 'lisa@example.com', 'address' => '654 Maple Dr'],
        ];

        foreach ($clientData as $data) {
            $clients[] = Client::updateOrCreate(
                ['email' => $data['email']],
                [
                    'first_name' => $data['first'],
                    'last_name' => $data['last'],
                    'phone' => $data['phone'],
                    'address' => $data['address']
                ]
            );
        }

        echo "✓ Created users and clients\n";

        // Create appointments
        $serviceTypes = ['Computer Repair', 'Network Setup', 'System Upgrade', 'Hardware Installation', 'Data Recovery'];
        $appointmentData = [
            // Completed appointments
            ['client' => 0, 'staff' => $staff1, 'service' => 0, 'status' => 'completed', 'days_offset' => -15, 'time' => '09:00'],
            ['client' => 1, 'staff' => $staff2, 'service' => 1, 'status' => 'completed', 'days_offset' => -12, 'time' => '14:00'],
            ['client' => 2, 'staff' => $staff3, 'service' => 2, 'status' => 'completed', 'days_offset' => -10, 'time' => '10:30'],
            ['client' => 3, 'staff' => $staff1, 'service' => 3, 'status' => 'completed', 'days_offset' => -8, 'time' => '13:00'],
            ['client' => 4, 'staff' => $staff2, 'service' => 4, 'status' => 'completed', 'days_offset' => -6, 'time' => '11:00'],

            // Confirmed appointments
            ['client' => 0, 'staff' => $staff2, 'service' => 4, 'status' => 'confirmed', 'days_offset' => 5, 'time' => '11:00'],
            ['client' => 4, 'staff' => $staff3, 'service' => 0, 'status' => 'confirmed', 'days_offset' => 3, 'time' => '15:00'],

            // Scheduled appointments
            ['client' => 1, 'staff' => $staff1, 'service' => 1, 'status' => 'scheduled', 'days_offset' => 8, 'time' => '09:30'],
            ['client' => 2, 'staff' => $staff2, 'service' => 2, 'status' => 'scheduled', 'days_offset' => 7, 'time' => '16:00'],
            ['client' => 3, 'staff' => $staff3, 'service' => 3, 'status' => 'scheduled', 'days_offset' => 10, 'time' => '10:00'],

            // Cancelled appointment
            ['client' => 4, 'staff' => $staff1, 'service' => 4, 'status' => 'cancelled', 'days_offset' => -5, 'time' => '12:00'],

            // No show appointment
            ['client' => 0, 'staff' => $staff2, 'service' => 0, 'status' => 'no_show', 'days_offset' => -3, 'time' => '14:30'],
        ];

        $appointments = [];
        foreach ($appointmentData as $data) {
            $date = Carbon::now()->addDays($data['days_offset']);
            $appointment = Appointment::create([
                'client_id' => $clients[$data['client']]->id,
                'staff_id' => $data['staff']->id,
                'created_by' => $admin->id,
                'service_type' => $serviceTypes[$data['service']],
                'appointment_date' => $date->format('Y-m-d'),
                'appointment_time' => $data['time'],
                'status' => $data['status'],
                'notes' => 'Sample appointment for demonstration'
            ]);
            $appointments[] = [
                'appointment' => $appointment,
                'status' => $data['status'],
                'base_date' => $date,
                'staff' => $data['staff']
            ];
        }

        echo "✓ Created " . count($appointments) . " appointments\n";

        // Create status histories
        foreach ($appointments as $item) {
            $appointment = $item['appointment'];
            $status = $item['status'];
            $baseDate = $item['base_date'];

            // Initial scheduled
            AppointmentStatusHistory::create([
                'appointment_id' => $appointment->id,
                'old_status' => null,
                'new_status' => 'scheduled',
                'changed_by_user_id' => $admin->id,
                'service_completed_by_id' => null,
                'changed_at' => $baseDate->subDays(5),
                'notes' => null
            ]);

            if ($status === 'completed') {
                AppointmentStatusHistory::create([
                    'appointment_id' => $appointment->id,
                    'old_status' => 'scheduled',
                    'new_status' => 'confirmed',
                    'changed_by_user_id' => $admin->id,
                    'service_completed_by_id' => null,
                    'changed_at' => $baseDate->subDays(3),
                    'notes' => 'Client confirmed appointment'
                ]);

                AppointmentStatusHistory::create([
                    'appointment_id' => $appointment->id,
                    'old_status' => 'confirmed',
                    'new_status' => 'completed',
                    'changed_by_user_id' => $admin->id,
                    'service_completed_by_id' => $item['staff']->id,
                    'changed_at' => $baseDate->addHours(2),
                    'notes' => 'Service completed successfully'
                ]);
            } elseif ($status === 'confirmed') {
                AppointmentStatusHistory::create([
                    'appointment_id' => $appointment->id,
                    'old_status' => 'scheduled',
                    'new_status' => 'confirmed',
                    'changed_by_user_id' => $admin->id,
                    'service_completed_by_id' => null,
                    'changed_at' => $baseDate->subDays(2),
                    'notes' => 'Pending service'
                ]);
            } elseif ($status === 'cancelled') {
                AppointmentStatusHistory::create([
                    'appointment_id' => $appointment->id,
                    'old_status' => 'scheduled',
                    'new_status' => 'cancelled',
                    'changed_by_user_id' => $admin->id,
                    'service_completed_by_id' => null,
                    'changed_at' => $baseDate->subDays(1),
                    'notes' => 'Client cancelled appointment'
                ]);
            } elseif ($status === 'no_show') {
                AppointmentStatusHistory::create([
                    'appointment_id' => $appointment->id,
                    'old_status' => 'scheduled',
                    'new_status' => 'no_show',
                    'changed_by_user_id' => $admin->id,
                    'service_completed_by_id' => null,
                    'changed_at' => $baseDate->addHours(1),
                    'notes' => 'Client did not show up'
                ]);
            }
        }

        echo "✓ Created appointment status histories\n";

        // Create service records
        foreach ($appointments as $item) {
            if ($item['status'] === 'completed') {
                $appointment = $item['appointment'];
                ServiceRecord::create([
                    'appointment_id' => $appointment->id,
                    'client_id' => $appointment->client_id,
                    'staff_id' => $item['staff']->id,
                    'service_date' => $appointment->appointment_date,
                    'description' => $appointment->service_type . ' - Service completed successfully. All diagnostics performed and issues resolved. System optimized and tested.',
                    'remarks' => 'Client satisfied. No further issues detected.'
                ]);
            }
        }

        echo "✓ Created service records\n";

        echo "\n✅ Sample data seeded successfully!\n";
        echo "\n📧 Test Login Credentials:\n";
        echo "Admin: admin@circuithub.com\n";
        echo "Staff 1: tech1@circuithub.com\n";
        echo "Staff 2: tech2@circuithub.com\n";
        echo "Staff 3: tech3@circuithub.com\n";
        echo "Password (all): password\n";
    }
}
