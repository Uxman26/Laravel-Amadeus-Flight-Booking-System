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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->string("pnr");
            $table->string("pnr_ts")->nullable();
            $table->string("trip_type");
            $table->string("status");
            $table->string("date_status")->nullable();
            $table->string("ticket_status")->default('Pending');
            $table->string("email");
            $table->string("phone");
            $table->string("payment_method")->default('cash');
            $table->string("last_ticketing_date");
            $table->double("amount");
            $table->string("bags")->nullable();
            $table->string("nego")->nullable();
            $table->string("received")->nullable();
            $table->string("agent_margin")->nullable();
            $table->string("admin_buy_price")->nullable();
            $table->string("issued_from")->nullable();
            $table->string("remarks")->nullable();
            $table->longText("routes");
            $table->longText("live_data")->nullable();
            $table->string("pnr_track_id")->nullable();
            $table->string("pnr_status")->default('test');
            $table->longText("uri");
            $table->boolean("track_price")->default(false);
            $table->integer("adults");
            $table->integer("children");
            $table->integer("infants");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
