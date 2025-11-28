<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('reviews');
        
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('reviewID');
            
            // Foreign keys - all unsignedBigInteger to match primary keys
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('passenger_id');
            $table->unsignedBigInteger('driver_id');
            
            $table->integer('rating')->unsigned();
            $table->text('comment')->nullable();
            $table->enum('type', ['passenger_to_driver', 'driver_to_passenger'])->default('passenger_to_driver');
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('booking_id')->references('bookingID')->on('bookings')->onDelete('cascade');
            $table->foreign('passenger_id')->references('passengerID')->on('passengers')->onDelete('cascade');
            $table->foreign('driver_id')->references('driverID')->on('drivers')->onDelete('cascade');
            
            // Unique constraint
            $table->unique(['booking_id', 'type']);
            
            // Indexes
            $table->index(['driver_id', 'rating']);
            $table->index(['passenger_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};