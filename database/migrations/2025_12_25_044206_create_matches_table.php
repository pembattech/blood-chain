<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT

            // Foreign Keys
            $table->foreignId('blood_request_id')
                ->constrained('blood_requests')
                ->onDelete('cascade');

            $table->foreignId('donor_id')
                ->constrained('donors')
                ->onDelete('cascade');

            // Status Enum
            $table->enum('status', ['pending', 'accepted', 'rejected'])
                ->default('pending');

            // Timestamps (created_at and updated_at)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};