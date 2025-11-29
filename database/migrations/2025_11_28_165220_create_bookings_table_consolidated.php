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
        Schema::dropIfExists('bookings');
        
        Schema::create('bookings', function (Blueprint $table) {
            // Primary key - using regular id() which creates unsignedBigInteger
            $table->id('bookingID');
            
            // Foreign keys - make sure these match the primary key types of passengers and drivers
            $table->unsignedBigInteger('passengerID');
            $table->unsignedBigInteger('driverID')->nullable();
            
            // Location information
            $table->string('pickupLocation');
            $table->string('dropoffLocation');
            $table->decimal('pickupLatitude', 10, 8)->nullable();
            $table->decimal('pickupLongitude', 11, 8)->nullable();
            $table->decimal('dropoffLatitude', 10, 8)->nullable();
            $table->decimal('dropoffLongitude', 11, 8)->nullable();
            
            // Booking details
            $table->enum('status', [
                'pending', 
                'accepted', 
                'in_progress', 
                'completed', 
                'cancelled'
            ])->default('pending');
            
            $table->decimal('fare', 10, 2)->default(0.00);
            $table->timestamp('timeStamp')->useCurrent();
            
            // Service and payment
            $table->enum('serviceType', [
                'booking_to_go', 
                'for_delivery'
            ])->default('booking_to_go');
            
            $table->text('description')->nullable();
            $table->enum('paymentMethod', ['cash', 'gcash'])->default('cash');
            $table->timestamp('scheduleTime')->nullable();
            
            // Completion verification fields
            $table->timestamp('driver_completed_at')->nullable();
            $table->timestamp('passenger_completed_at')->nullable();
            $table->enum('completion_verified', [
                'pending', 
                'driver_confirmed', 
                'passenger_confirmed', 
                'both_confirmed'
            ])->default('pending');
            
            // Timestamps
            $table->timestamps();
            
            $table->foreign('passengerID')->references('id')->on('passengers')->onDelete('cascade');
            $table->foreign('driverID')->references('id')->on('drivers')->onDelete('set null');
            // Indexes for better performance
            $table->index(['status', 'driverID']);
            $table->index(['passengerID', 'created_at']);
            $table->index(['scheduleTime', 'status']);
            $table->index(['completion_verified', 'status']);
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