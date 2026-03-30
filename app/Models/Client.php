<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'notes',
    ];

    // One client can have many appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // One client can have many service records
    public function serviceRecords()
    {
        return $this->hasMany(ServiceRecord::class);
    }

    // Helper: get full name as one string
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}