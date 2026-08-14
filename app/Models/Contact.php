<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'vehicle_id', 'name', 'email', 'phone', 'message', 'status', 'read_at'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pendiente');
    }

    public function scopeUnread($query)
    {
        return $query->where('status', 'pendiente')->orWhere('status', 'leido');
    }
}