<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'type', 'brand', 'model', 'year',
        'price', 'mileage', 'color', 'engine', 'transmission',
        'fuel_type', 'capacity', 'description', 'features',
        'images', 'status', 'featured', 'sold_at', 'views'
    ];

    protected $casts = [
        'features' => 'array',
        'images' => 'array',
        'price' => 'decimal:2',
        'featured' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'disponible');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    // ✅ PRECIO EN QUETZALES (SIN DECIMALES)
    public function getPriceFormattedAttribute()
    {
        return 'Q' . number_format($this->price, 0, '.', ',');
    }

    // ✅ PRECIO EN QUETZALES (CON DECIMALES)
    public function getPriceFullAttribute()
    {
        return 'Q' . number_format($this->price, 2, '.', ',');
    }

    // ✅ PRECIO SOLO NÚMERO (para filtros)
    public function getPriceNumberAttribute()
    {
        return number_format($this->price, 0, '.', ',');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'disponible' => 'success',
            'vendido' => 'danger',
            'reservado' => 'warning'
        ];
        return $badges[$this->status] ?? 'secondary';
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites()->count();
    }

    public function isFavoritedBy($userId)
    {
        return $this->favorites()->where('user_id', $userId)->exists();
    }
}