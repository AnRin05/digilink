<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('system_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('passenger_id')->nullable()->constrained('passengers')->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->onDelete('cascade');
            $table->enum('user_type', ['passenger', 'driver']);
            $table->integer('satisfaction_rating');
            $table->string('satisfaction_level');
            $table->enum('feedback_type', ['general', 'booking', 'payment', 'driver', 'passenger', 'technical']);
            $table->text('reason')->nullable();
            $table->text('improvements')->nullable();
            $table->text('positive_feedback')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->boolean('can_contact')->default(false);
            $table->string('contact_email')->nullable();
            $table->timestamps();
            
            $table->index(['user_type', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('system_feedback');
    }
};