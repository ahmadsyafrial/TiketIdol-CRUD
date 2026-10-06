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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique(); // e.g. TIKET-BBM-849204
            $table->foreignId('concert_id')->constrained('concerts')->cascadeOnDelete();
            $table->foreignId('ticket_category_id')->constrained('ticket_categories')->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            
            // Customer / Pemesan Details (tiket.com style)
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('customer_nik'); // NIK KTP / Passport
            
            // Rincian Biaya (Price Breakdown)
            $table->unsignedBigInteger('subtotal_price');
            $table->unsignedBigInteger('tax_fee')->default(0); // Pajak Hiburan 10%
            $table->unsignedBigInteger('admin_fee')->default(0); // Platform fee
            $table->unsignedBigInteger('discount_amount')->default(0);
            $table->string('promo_code')->nullable();
            $table->unsignedBigInteger('total_price');
            
            // Payment info
            $table->string('payment_method')->default('qris');
            $table->enum('payment_status', ['unpaid', 'paid', 'cancelled', 'expired'])->default('unpaid');
            $table->dateTime('payment_deadline');
            $table->dateTime('paid_at')->nullable();
            $table->text('notes')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
