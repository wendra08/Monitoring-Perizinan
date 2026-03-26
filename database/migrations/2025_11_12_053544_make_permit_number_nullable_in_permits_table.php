<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permits', function (Blueprint $table) {
            $table->string('permit_number')->nullable()->change();
            $table->dropUnique(['permit_number']); // Remove unique constraint
        });
    }

    public function down(): void
    {
        Schema::table('permits', function (Blueprint $table) {
            $table->string('permit_number')->nullable(false)->change();
            $table->unique('permit_number');
        });
    }
};
