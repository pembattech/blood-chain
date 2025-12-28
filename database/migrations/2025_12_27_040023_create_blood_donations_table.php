<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
         Schema::create('blood_donations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('donor_id')
                ->constrained('donors')
                ->cascadeOnDelete();

            $table->foreignId('blood_request_id')
                ->nullable()
                ->constrained('blood_requests')
                ->nullOnDelete();

            $table->string('location')->nullable(); // Hospital/center
            $table->decimal('units', 3, 1)->default(0.5); // e.g., 0.5 units
            $table->date('date')->nullable();
            $table->enum('status', ['pending','completed','canceled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_donations');
    }
};
