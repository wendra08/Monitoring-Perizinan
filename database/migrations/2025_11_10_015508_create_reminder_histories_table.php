<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reminder_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permit_id')->constrained()->onDelete('cascade');
            $table->enum('reminder_type', ['6_months', '3_months', '1_month', 'manual']);
            $table->string('sent_to');
            $table->string('sent_by')->nullable(); // For future: track who sent it
            $table->boolean('status')->default(true); // true = success, false = failed
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reminder_histories');
    }
};
