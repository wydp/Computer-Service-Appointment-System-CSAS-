<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppointmentStatusHistory extends Model
{
    protected $fillable = [
        'appointment_id',
        'old_status',
        'new_status',
        'changed_by_user_id',
        'service_completed_by_id',
        'changed_at',
        'notes',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
    ];

    /**
     * Get the appointment this history entry belongs to.
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Get the user who changed the status.
     */
    public function changedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by_user_id');
    }

    /**
     * Get the user who completed the service (if applicable).
     */
    public function serviceCompletedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'service_completed_by_id');
    }

    /**
     * Get a human-readable format of the status change.
     */
    public function getStatusChangeLabel(): string
    {
        $from = $this->old_status ? ucfirst(str_replace('_', ' ', $this->old_status)) : 'Created';
        $to = ucfirst(str_replace('_', ' ', $this->new_status));
        return "{$from} → {$to}";
    }

    /**
     * Get the scoped changes for a specific appointment.
     */
    public function scopeForAppointment($query, int $appointmentId)
    {
        return $query->where('appointment_id', $appointmentId)
                     ->orderByDesc('changed_at');
    }
}
