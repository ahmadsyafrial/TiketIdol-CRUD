<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'concert_id',
        'ticket_category_id',
        'quantity',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_nik',
        'subtotal_price',
        'tax_fee',
        'admin_fee',
        'discount_amount',
        'promo_code',
        'total_price',
        'payment_method',
        'payment_status',
        'payment_deadline',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'payment_deadline' => 'datetime',
        'paid_at' => 'datetime',
        'subtotal_price' => 'integer',
        'tax_fee' => 'integer',
        'admin_fee' => 'integer',
        'discount_amount' => 'integer',
        'total_price' => 'integer',
        'quantity' => 'integer',
    ];

    public function concert()
    {
        return $this->belongsTo(Concert::class);
    }

    public function ticketCategory()
    {
        return $this->belongsTo(TicketCategory::class);
    }

    public function attendees()
    {
        return $this->hasMany(OrderAttendee::class);
    }

    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format($this->subtotal_price, 0, ',', '.');
    }

    public function getFormattedTaxAttribute()
    {
        return 'Rp ' . number_format($this->tax_fee, 0, ',', '.');
    }

    public function getFormattedAdminFeeAttribute()
    {
        return 'Rp ' . number_format($this->admin_fee, 0, ',', '.');
    }

    public function getFormattedDiscountAttribute()
    {
        return 'Rp ' . number_format($this->discount_amount, 0, ',', '.');
    }

    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->payment_status) {
            'paid' => '<span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle-fill me-1"></i> Terkonfirmasi / Lunas</span>',
            'unpaid' => '<span class="badge bg-warning-subtle text-warning border border-warning px-3 py-2 rounded-pill"><i class="bi bi-clock-history me-1"></i> Menunggu Pembayaran</span>',
            'cancelled' => '<span class="badge bg-danger-subtle text-danger border border-danger px-3 py-2 rounded-pill"><i class="bi bi-x-circle me-1"></i> Dibatalkan</span>',
            'expired' => '<span class="badge bg-secondary-subtle text-secondary border border-secondary px-3 py-2 rounded-pill"><i class="bi bi-hourglass-bottom me-1"></i> Kadaluarsa</span>',
            default => '<span class="badge bg-light text-dark px-3 py-2 rounded-pill">' . ucfirst($this->payment_status) . '</span>',
        };
    }
}
