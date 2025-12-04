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
            $table->double('prize_money')->nullable();
            $table->string('currency_code', 3)->nullable()->index();
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

            $table->foreign('currency_code')->references('code')->on('currencies')->onDelete('set null')->onUpdate('cascade');
        });

        Schema::create('tournament_officials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id')->nullable()->index();
            $table->string('official_role_code')->nullable()->index();
            $table->string('name')->nullable();
            $table->string('country_code', 3)->nullable();
            $table->timestamps();

            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
            $table->foreign('official_role_code')->references('code')->on('official_roles')->onDelete('set null')->onUpdate('cascade');
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id')->nullable()->index();
            $table->string('event_category_code')->nullable()->index();
            $table->integer('main_draw_size')->nullable()->default(28);
            $table->integer('qualifying_positions')->nullable()->default(4);
            $table->integer('max_qualifying_entries')->nullable()->default(8);
            $table->timestamps();

            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
            $table->foreign('event_category_code')->references('code')->on('event_categories')->onDelete('set null')->onUpdate('cascade');
        });

        Schema::create('prize_distributions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id')->nullable()->index();
            $table->string('round_code')->nullable()->index();
            $table->double('amount')->nullable();
            $table->boolean('is_per_pair')->nullable()->default(false);
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('round_code')->references('code')->on('rounds')->onDelete('set null')->onUpdate('cascade');
        });

        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id')->nullable()->index();
            $table->string('name')->nullable();
            $table->text('address')->nullable();
            $table->double('rate_single')->nullable();
            $table->double('rate_double')->nullable();
            $table->double('rate_twin')->nullable();
            $table->string('currency_code', 3)->nullable()->index();
            $table->text('facilities')->nullable();
            $table->boolean('breakfast_included')->nullable()->default(false);
            $table->integer('breakfast_persons')->nullable();
            $table->boolean('is_official')->nullable()->default(true);
            $table->timestamps();

            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
            $table->foreign('currency_code')->references('code')->on('currencies')->onDelete('set null')->onUpdate('cascade');
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_id')->nullable()->index();
            $table->date('date')->nullable();
            $table->string('event_description')->nullable();
            $table->string('session_type_code')->nullable()->index();
            $table->integer('courts_available')->nullable();
            $table->time('doors_open')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->timestamps();

            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
            $table->foreign('session_type_code')->references('code')->on('session_types')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
        Schema::dropIfExists('tournament_officials');
        Schema::dropIfExists('events');
        Schema::dropIfExists('prize_distributions');
        Schema::dropIfExists('hotels');
        Schema::dropIfExists('schedules');
    }
};
