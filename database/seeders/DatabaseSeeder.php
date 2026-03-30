<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Client;
use App\Models\Appointment;
use App\Models\ServiceRecord;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Create Users ───────────────────────────────────────

        $admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@csas.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        $receptionist = User::create([
            'name'     => 'Rica Santos',
            'email'    => 'receptionist@csas.com',
            'password' => Hash::make('password'),
            'role'     => 'receptionist',
        ]);

        $staff = User::create([
            'name'     => 'Juan Dela Cruz',
            'email'    => 'staff@csas.com',
            'password' => Hash::make('password'),
            'role'     => 'staff',
        ]);

        // ─── Create Clients ──────────────────────────────────────

        $client1 = Client::create([
            'first_name' => 'Maria',
            'last_name'  => 'Garcia',
            'email'      => 'maria@email.com',
            'phone'      => '09171234567',
            'address'    => 'Davao City',
            'notes'      => 'Prefers morning appointments',
        ]);

        $client2 = Client::create([
            'first_name' => 'Pedro',
            'last_name'  => 'Reyes',
            'email'      => 'pedro@email.com',
            'phone'      => '09281234567',
            'address'    => 'Davao City',
            'notes'      => null,
        ]);

        $client3 = Client::create([
            'first_name' => 'Ana',
            'last_name'  => 'Lopez',
            'email'      => null,
            'phone'      => '09391234567',
            'address'    => 'Tagum City',
            'notes'      => 'Walk-in client',
        ]);

        // ─── Create Appointments ─────────────────────────────────

        $appointment1 = Appointment::create([
            'client_id'        => $client1->id,
            'staff_id'         => $staff->id,
            'created_by'       => $receptionist->id,
            'service_type'     => 'PC Repair',
            'appointment_date' => '2026-04-01',
            'appointment_time' => '09:00:00',
            'status'           => 'confirmed',
            'notes'            => 'Laptop not booting',
        ]);

        $appointment2 = Appointment::create([
            'client_id'        => $client2->id,
            'staff_id'         => $staff->id,
            'created_by'       => $receptionist->id,
            'service_type'     => 'Data Recovery',
            'appointment_date' => '2026-04-02',
            'appointment_time' => '10:00:00',
            'status'           => 'scheduled',
            'notes'            => 'Hard drive failure',
        ]);

        $appointment3 = Appointment::create([
            'client_id'        => $client3->id,
            'staff_id'         => $staff->id,
            'created_by'       => $admin->id,
            'service_type'     => 'Virus Removal',
            'appointment_date' => '2026-03-25',
            'appointment_time' => '14:00:00',
            'status'           => 'completed',
            'notes'            => 'Multiple malware detected',
        ]);

        // ─── Create Service Record (for completed appointment) ───

        ServiceRecord::create([
            'appointment_id' => $appointment3->id,
            'client_id'      => $client3->id,
            'staff_id'       => $staff->id,
            'description'    => 'Removed 3 malware threats, installed antivirus',
            'service_date'   => '2026-03-25',
            'remarks'        => 'System clean, advised client to avoid suspicious downloads',
        ]);
    }
}