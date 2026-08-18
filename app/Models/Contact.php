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

    public function responses()
    {
        return $this->hasMany(MessageResponse::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pendiente');
    }

    public function scopeUnread($query)
    {
        return $query->where('status', 'pendiente')->orWhere('status', 'leido');
    }

    public function hasResponses()
    {
        return $this->responses()->count() > 0;
    }

    public function getLastResponseAttribute()
    {
        return $this->responses()->latest()->first();
    }

    public function getConversationAttribute()
    {
        $conversation = [];
        
        $conversation[] = [
            'type' => 'user',
            'name' => $this->name,
            'message' => $this->message,
            'created_at' => $this->created_at->toISOString(),
            'is_original' => true
        ];
        
        foreach ($this->responses as $response) {
            $conversation[] = [
                'type' => 'admin',
                'name' => $response->user->name,
                'message' => $response->message,
                'created_at' => $response->created_at->toISOString(),
                'is_original' => false
            ];
        }
        
        usort($conversation, function($a, $b) {
            return strtotime($a['created_at']) - strtotime($b['created_at']);
        });
        
        return $conversation;
    }
}