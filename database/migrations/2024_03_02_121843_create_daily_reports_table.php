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
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('flexible_date')->nullable();
            $table->string('preffered_airline')->nullable();
            $table->string('trip_type')->nullable();
            $table->string('flight_type')->nullable();
            $table->string('origin1')->nullable();
            $table->string('destination1')->nullable();
            $table->string('departureDate1')->nullable();
            $table->string('returnDate1')->nullable();
            $table->string('origin2')->nullable();
            $table->string('destination2')->nullable();
            $table->string('departureDate2')->nullable();
            $table->string('origin3')->nullable();
            $table->string('destination3')->nullable();
            $table->string('departureDate3')->nullable();
            $table->string('origin4')->nullable();
            $table->string('destination4')->nullable();
            $table->string('departureDate4')->nullable();
            $table->integer('adults')->nullable();
            $table->integer('children')->nullable();
            $table->integer('infants')->nullable();
            $table->text('remark')->nullable();
            $table->integer('user_id')->nullable();
            $table->text('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};
