<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kamars', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_kamar');
            $table->integer('kapasitas_tamu');
            $table->text('fasilitas_kamar');
            $table->decimal('harga_per_malam', 12, 2);
            $table->integer('jumlah_kamar_tersedia');
            $table->string('foto_kamar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kamars');
    }
};
