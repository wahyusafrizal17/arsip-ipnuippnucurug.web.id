<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('joint_letters', function (Blueprint $table) {
            $table->id();
            $table->string('klasifikasi');
            $table->string('indeks');
            $table->date('tanggal_surat');
            $table->string('pengirim');
            $table->text('perihal');
            $table->string('file_path')->nullable();
            $table->timestamps();

            $table->index('tanggal_surat');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('joint_letters');
    }
};
