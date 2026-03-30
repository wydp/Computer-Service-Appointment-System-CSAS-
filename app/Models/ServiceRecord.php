<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'client_id',
        'staff_id',
        'description',
        'service_date',
        'remarks',
    ];

    // This record belongs to one appointment
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    // This record belongs to one client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // This record belongs to one staff member
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}