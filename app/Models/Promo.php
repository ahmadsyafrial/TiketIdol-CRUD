<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'discount_percentage',
        'discount_amount',
        'min_purchase',
        'max_discount',
        'valid_until',
        'is_active',
    ];

    protected $casts = [
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
        'discount_percentage' => 'integer',
        'discount_amount' => 'integer',
        'min_purchase' => 'integer',
        'max_discount' => 'integer',
    ];

    public function calculateDiscount($subtotal)
    {
        if ($subtotal < $this->min_purchase) {
            return 0;
        }

        if ($this->discount_percentage > 0) {
            $discount = ($subtotal * $this->discount_percentage) / 100;
            if ($this->max_discount > 0 && $discount > $this->max_discount) {
                $discount = $this->max_discount;
            }
            return (int) $discount;
        }

        return (int) min($this->discount_amount, $subtotal);
    }
}
