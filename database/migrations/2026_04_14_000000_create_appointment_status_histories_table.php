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
        Schema::create('appointment_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained('appointments')->cascadeOnDelete();

            // Status information
            $table->enum('old_status', ['scheduled', 'confirmed', 'completed', 'cancelled', 'no_show'])->nullable();
            $table->enum('new_status', ['scheduled', 'confirmed', 'completed', 'cancelled', 'no_show']);

            // User information
            $table->foreignId('changed_by_user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('service_completed_by_id')->nullable()->constrained('users')->nullOnDelete();

            // Additional data
            $table->timestamp('changed_at')->useCurrent();
            $table->text('notes')->nullable();

            $table->timestamps();

            // Indexes for faster queries
            $table->index('appointment_id');
            $table->index('changed_by_user_id');
            $table->index('changed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_status_histories');
    }
};
