<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kriteria', function (Blueprint $table) {
            $table->integer('bobot')->change();
        });
    }

    public function down(): void
    {
        Schema::table('kriteria', function (Blueprint $table) {
            $table->decimal('bobot', 5, 2)->change();
        });
    }
};