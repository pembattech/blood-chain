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
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT primary key
            $table->foreignId('recipient_id')->constrained('users')->onDelete('cascade');
            $table->enum('blood_type_needed', ['A+','A-','B+','B-','AB+','AB-','O+','O-']);
            $table->enum('urgency', ['low','medium','high']);
            $table->decimal('location_lat', 10, 8);
            $table->decimal('location_lng', 11, 8);
            $table->enum('status', ['pending','accepted','fulfilled'])->default('pending');
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_requests');
    }
};
