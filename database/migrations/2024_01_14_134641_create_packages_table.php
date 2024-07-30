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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('period')->nullable();
            $table->string('single_room_price')->nullable();
            $table->string('double_room_price')->nullable();
            $table->string('triple_room_price')->nullable();
            $table->string('quadruple_room_price')->nullable();
            $table->string('children_price_deduction')->nullable();
            $table->string('infant_price')->nullable();
            $table->string('mecca_hotel')->nullable();
            $table->string('madina_hotel')->nullable();
            $table->text('description')->nullable();
            $table->date('departure')->nullable();
            $table->date('return')->nullable();
            $table->text('image')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
