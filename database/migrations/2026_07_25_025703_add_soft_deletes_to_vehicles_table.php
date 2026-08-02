<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $col) {
            $col->softDeletes(); // Adds the 'deleted_at' column
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $col) {
            $col->dropSoftDeletes(); // Removes the column if rolled back
        });
    }
};
