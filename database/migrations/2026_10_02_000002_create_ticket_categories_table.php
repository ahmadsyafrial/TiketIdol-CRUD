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
        Schema::create('ticket_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('concert_id')->constrained('concerts')->cascadeOnDelete();
            $table->string('name'); // e.g. VIP SOUNDCHECK, CAT 1 FESTIVAL
            $table->string('code')->nullable(); // e.g. VIP-SND
            $table->enum('type', ['standing', 'seated'])->default('standing');
            $table->string('color_hex')->default('#ec4899');
            $table->unsignedBigInteger('price');
            $table->integer('quota')->default(100);
            $table->integer('available_quota')->default(100);
            $table->text('benefits')->nullable(); // JSON or newline separated perks
            $table->string('entry_gate')->default('Gate 1');
            $table->string('seat_section')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_categories');
    }
};
