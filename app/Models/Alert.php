<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = [
        'user_id', 'name', 'type', 'brand', 'min_price', 'max_price',
        'year_from', 'year_to', 'keyword', 'frequency', 'is_active', 'last_sent_at'
    ];

    protected $casts = [
        'min_price' => 'decimal:2',
        'max_price' => 'decimal:2',
        'is_active' => 'boolean',
        'last_sent_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFrequencyLabelAttribute()
    {
        $frequencies = [
            'daily' => 'Diaria',
            'weekly' => 'Semanal',
        ];
        return $frequencies[$this->frequency] ?? $this->frequency;
    }

    public function getCriteriaDescriptionAttribute()
    {
        $parts = [];
        
        if ($this->type) {
            $parts[] = 'Tipo: ' . ucfirst($this->type);
        }
        if ($this->brand) {
            $parts[] = 'Marca: ' . $this->brand;
        }
        if ($this->min_price && $this->max_price) {
            $parts[] = 'Precio: Q' . number_format($this->min_price) . ' - Q' . number_format($this->max_price);
        } elseif ($this->min_price) {
            $parts[] = 'Precio mínimo: Q' . number_format($this->min_price);
        } elseif ($this->max_price) {
            $parts[] = 'Precio máximo: Q' . number_format($this->max_price);
        }
        if ($this->year_from && $this->year_to) {
            $parts[] = 'Años: ' . $this->year_from . ' - ' . $this->year_to;
        }
        if ($this->keyword) {
            $parts[] = 'Palabra clave: "' . $this->keyword . '"';
        }
        
        return implode(' | ', $parts) ?: 'Sin criterios específicos';
    }
}