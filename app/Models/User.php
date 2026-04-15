<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // One user (staff) can handle many appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'staff_id');
    }

    // One user can create many appointments
    public function createdAppointments()
    {
        return $this->hasMany(Appointment::class, 'created_by');
    }

    // One user can make many status history changes
    public function statusHistoryChanges()
    {
        return $this->hasMany(AppointmentStatusHistory::class, 'changed_by_user_id');
    }

    // One user can complete many services
    public function completedServices()
    {
        return $this->hasMany(AppointmentStatusHistory::class, 'service_completed_by_user_id');
    }

    // Helper functions to check role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isReceptionist()
    {
        return $this->role === 'receptionist';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }
}