<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]


class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


        public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function hasFavorited($vehicleId)
    {
        return $this->favorites()->where('vehicle_id', $vehicleId)->exists();
    }

    public function toggleFavorite($vehicleId)
    {
        $favorite = $this->favorites()->where('vehicle_id', $vehicleId);
        
        if ($favorite->exists()) {
            $favorite->delete();
            return false;
        } else {
            $this->favorites()->create(['vehicle_id' => $vehicleId]);
            return true;
        }
    }


    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function hasActiveAlerts()
    {
        return $this->alerts()->where('is_active', true)->exists();
    }


    public function messageNotifications()
    {
        return $this->hasMany(UserMessageNotification::class);
    }

    public function unreadMessageNotifications()
    {
        return $this->messageNotifications()->where('is_read', false);
    }

    public function getUnreadMessagesCountAttribute()
    {
        return $this->unreadMessageNotifications()->count();
    }


}
