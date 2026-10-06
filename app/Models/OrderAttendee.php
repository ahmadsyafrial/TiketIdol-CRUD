<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAttendee extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'ticket_number',
        'attendee_name',
        'attendee_nik',
        'attendee_email',
        'seat_or_queue_number',
        'barcode_code',
        'check_in_status',
        'checked_in_at',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
