<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMessageNotification extends Model
{
    protected $fillable = [
        'user_id', 'contact_id', 'is_read'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}