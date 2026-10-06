<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Concert extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'artist_name',
        'fandom_name',
        'venue_name',
        'city',
        'concert_date',
        'gate_open_time',
        'poster_url',
        'banner_url',
        'description',
        'terms_conditions',
        'promoter_name',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'concert_date' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function ticketCategories()
    {
        return $this->hasMany(TicketCategory::class)->orderBy('price', 'desc');
    }

    public function activeCategories()
    {
        return $this->hasMany(TicketCategory::class)->where('is_active', true)->orderBy('price', 'desc');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getLowestPriceAttribute()
    {
        return $this->ticketCategories()->min('price') ?? 0;
    }

    public function getHighestPriceAttribute()
    {
        return $this->ticketCategories()->max('price') ?? 0;
    }

    public function getFormattedDateAttribute()
    {
        return $this->concert_date ? $this->concert_date->translatedFormat('l, d F Y') : '-';
    }

    public function getFormattedTimeAttribute()
    {
        return $this->concert_date ? $this->concert_date->format('H:i') . ' WIB' : '-';
    }

    public function getFormattedLowestPriceAttribute()
    {
        return 'Rp ' . number_format($this->lowest_price, 0, ',', '.');
    }

    public function getTotalAvailableQuotaAttribute()
    {
        return $this->ticketCategories()->sum('available_quota');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($concert) {
            if (empty($concert->slug)) {
                $concert->slug = Str::slug($concert->title) . '-' . Str::random(5);
            }
        });
    }
}
