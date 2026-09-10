<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('nomor_hp', 20);
            $table->string('email', 100);
            $table->string('instansi', 150);
            $table->string('tujuan_kunjungan', 255);
            $table->date('tanggal_kunjungan')->index();
            $table->enum('sumber', ['direct', 'whatsapp', 'instagram', 'facebook'])
                ->default('direct')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
