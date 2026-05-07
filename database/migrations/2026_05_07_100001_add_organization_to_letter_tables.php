<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('incoming_letters', function (Blueprint $table) {
            $table->string('organization', 16)->default('ipnu')->after('id');
            $table->index(['organization', 'tanggal_surat']);
        });

        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->string('organization', 16)->default('ipnu')->after('id');
            $table->index(['organization', 'tanggal_surat']);
        });
    }

    public function down(): void
    {
        Schema::table('incoming_letters', function (Blueprint $table) {
            $table->dropColumn('organization');
        });

        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->dropColumn('organization');
        });
    }
};
