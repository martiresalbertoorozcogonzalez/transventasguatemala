<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'type', 'brand', 'model', 'year',
        'price', 'mileage', 'color', 'engine', 'transmission',
        'fuel_type', 'capacity', 'description', 'features',
        'images', 'status', 'featured', 'sold_at','views'
    ];

    protected $casts = [
        'features' => 'array',
        'images' => 'array',
        'price' => 'decimal:2',
        'year' => 'integer',
        'mileage' => 'integer',
        'capacity' => 'integer',
        'featured' => 'boolean',
    ];

      public function getRouteKeyName()
    {
        return 'slug';
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'disponible');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Accessors
    public function getPriceFormattedAttribute()
    {
        return '$' . number_format($this->price, 0, ',', '.');
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


    public function getFirstImageAttribute()
    {
        if ($this->images && count($this->images) > 0) {
            return Storage::url('vehicles/' . $this->images[0]);
        }
        return asset('images/no-image.jpg');
    }

    public function getAllImagesAttribute()
    {
        if ($this->images) {
            return collect($this->images)->map(function($image) {
                return Storage::url('vehicles/' . $image);
            });
        }
        return collect([]);
    }

        public static function boot()
    {
        parent::boot();
        
        static::creating(function ($vehicle) {
            $vehicle->slug = Str::slug($vehicle->title . '-' . uniqid());
        });
    }

 
        public function incrementViews()
    {
            $this->increment('views');
    }

}