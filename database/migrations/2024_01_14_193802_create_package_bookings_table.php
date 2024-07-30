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
        Schema::create('package_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->onDelete("cascade");
            $table->foreignId('user_id')->constrained()->onDelete('null');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('nationality')->nullable();
            $table->string('rooms')->nullable();
            $table->integer('adults')->nullable();
            $table->integer('childrens')->nullable();
            $table->integer('infants')->nullable();
            $table->bigInteger('price')->nullable();
            $table->bigInteger('received')->nullable();
            $table->bigInteger('remaining')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('status')->nullable();
            $table->string('invoice_no')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_bookings');
    }
};
