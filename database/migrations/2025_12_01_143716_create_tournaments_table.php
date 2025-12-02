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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->decimal('prize_money', 12, 2)->nullable();
            $table->string('currency', 3)->nullable(); // ISO 4217 currency code, e.g., USD, EUR
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('venue_name')->nullable();
            $table->text('venue_address')->nullable();
            $table->string('organizer')->nullable();
            $table->text('organizer_address')->nullable();
            $table->string('sanction')->nullable(); // e.g., BWF, Badminton Europe
            $table->string('official_shuttlecock')->nullable();
            $table->string('status')->default('INACTIVE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
