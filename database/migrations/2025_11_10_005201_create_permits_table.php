<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permits', function (Blueprint $table) {
            $table->id();
            $table->string('permit_name');
            $table->string('permit_number')->unique();
            $table->date('issue_date');
            $table->date('expiry_date');
            $table->string('boss_name');
            $table->string('boss_email');
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'expired', 'renewed'])->default('active');
            $table->json('reminders_sent')->nullable(); // Track which reminders have been sent
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permits');
    }
};
