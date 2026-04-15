<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'staff_id',
        'created_by',
        'service_type',
        'appointment_date',
        'appointment_time',
        'status',
        'notes',
    ];

    // This appointment belongs to one client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // This appointment is assigned to one staff
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    // This appointment was created by one user
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // This appointment may have one service record
    public function serviceRecord()
    {
        return $this->hasOne(ServiceRecord::class);
    }

    // This appointment has many status history records
    public function statusHistories()
    {
        return $this->hasMany(AppointmentStatusHistory::class)->orderByDesc('changed_at');
    }

    // Helper: check if appointment is completed
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    // Helper: check if appointment is cancelled
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }
}