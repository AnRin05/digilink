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
        Schema::table('bookings', function (Blueprint $table) {
            // Add new completion fields
            $table->timestamp('driver_completed_at')->nullable()->after('scheduleTime');
            $table->timestamp('passenger_completed_at')->nullable()->after('driver_completed_at');
            $table->enum('completion_verified', [
                'pending', 
                'driver_confirmed', 
                'passenger_confirmed', 
                'both_confirmed'
            ])->default('pending')->after('passenger_completed_at');
            
            // Add index for better performance
            $table->index(['status', 'completion_verified']);
            $table->index(['driver_completed_at', 'passenger_completed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Drop the new columns
            $table->dropColumn([
                'driver_completed_at',
                'passenger_completed_at',
                'completion_verified'
            ]);
            
            // Drop indexes
            $table->dropIndex(['status', 'completion_verified']);
            $table->dropIndex(['driver_completed_at', 'passenger_completed_at']);
        });
    }
};