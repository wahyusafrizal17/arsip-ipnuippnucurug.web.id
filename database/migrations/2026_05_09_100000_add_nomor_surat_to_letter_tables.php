<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('incoming_letters', function (Blueprint $table) {
            $table->string('nomor_surat', 128)->nullable()->after('indeks');
            $table->index('nomor_surat');
        });

        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->string('nomor_surat', 128)->nullable()->after('indeks');
            $table->index('nomor_surat');
        });

        Schema::table('joint_letters', function (Blueprint $table) {
            $table->string('nomor_surat', 128)->nullable()->after('indeks');
            $table->index('nomor_surat');
        });
    }

    public function down(): void
    {
        Schema::table('incoming_letters', function (Blueprint $table) {
            $table->dropIndex(['nomor_surat']);
            $table->dropColumn('nomor_surat');
        });

        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->dropIndex(['nomor_surat']);
            $table->dropColumn('nomor_surat');
        });

        Schema::table('joint_letters', function (Blueprint $table) {
            $table->dropIndex(['nomor_surat']);
            $table->dropColumn('nomor_surat');
        });
    }
};
