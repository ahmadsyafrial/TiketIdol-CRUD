<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_attendees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('ticket_number')->unique(); // e.g. TK-BBM-VIP-0021
            $table->string('attendee_name');
            $table->string('attendee_nik');
            $table->string('attendee_email')->nullable();
            $table->string('seat_or_queue_number'); // e.g. QN-0128 or SEC-A-ROW3-15
            $table->string('barcode_code');
            $table->enum('check_in_status', ['pending', 'checked_in'])->default('pending');
            $table->dateTime('checked_in_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_attendees');
    }
};
