<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('incoming_letters', function (Blueprint $table) {
            $table->date('tanggal_penerimaan')->nullable()->after('tanggal_surat');
        });

        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->date('tanggal_pengiriman')->nullable()->after('tanggal_surat');
        });

        foreach (DB::table('incoming_letters')->select('id', 'tanggal_surat')->cursor() as $row) {
            DB::table('incoming_letters')->where('id', $row->id)->update([
                'tanggal_penerimaan' => $row->tanggal_surat,
            ]);
        }

        foreach (DB::table('outgoing_letters')->select('id', 'tanggal_surat')->cursor() as $row) {
            DB::table('outgoing_letters')->where('id', $row->id)->update([
                'tanggal_pengiriman' => $row->tanggal_surat,
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('incoming_letters', function (Blueprint $table) {
            $table->dropColumn('tanggal_penerimaan');
        });

        Schema::table('outgoing_letters', function (Blueprint $table) {
            $table->dropColumn('tanggal_pengiriman');
        });
    }
};
