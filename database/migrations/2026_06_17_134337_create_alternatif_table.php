<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alternatif', function (Blueprint $table) {
            $table->id();
            $table->string('kode_alternatif', 10)->unique();
            $table->string('nama_ewallet', 100);
            $table->string('logo')->nullable(); // path logo, nullable
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alternatif');
    }
};