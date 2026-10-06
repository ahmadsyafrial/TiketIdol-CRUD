<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'concert_id',
        'name',
        'code',
        'type',
        'color_hex',
        'price',
        'quota',
        'available_quota',
        'benefits',
        'entry_gate',
        'seat_section',
        'is_active',
    ];

    protected $casts = [
        'price' => 'integer',
        'quota' => 'integer',
        'available_quota' => 'integer',
        'is_active' => 'boolean',
    ];

    public function concert()
    {
        return $this->belongsTo(Concert::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getBenefitsListAttribute()
    {
        if (empty($this->benefits)) {
            return [];
        }
        return array_map('trim', explode("\n", str_replace("\r", "", $this->benefits)));
    }
}
