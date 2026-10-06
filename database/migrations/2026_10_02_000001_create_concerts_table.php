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
        Schema::create('concerts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('artist_name');
            $table->string('fandom_name')->nullable();
            $table->string('venue_name');
            $table->string('city')->default('Jakarta');
            $table->dateTime('concert_date');
            $table->string('gate_open_time')->default('16:00 WIB');
            $table->text('poster_url')->nullable();
            $table->text('banner_url')->nullable();
            $table->longText('description');
            $table->longText('terms_conditions')->nullable();
            $table->string('promoter_name')->default('Live Nation / YG Entertainment');
            $table->enum('status', ['upcoming', 'active', 'sold_out', 'completed'])->default('active');
            $table->boolean('is_featured')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concerts');
    }
};
