<?php

namespace Tests\Feature;

use App\Models\IncomingLetter;
use App\Models\OutgoingLetter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LetterIndexFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_incoming_date_range_uses_tanggal_penerimaan_when_tanggal_surat_is_outside_range(): void
    {
        $admin = User::factory()->admin()->create();
        IncomingLetter::factory()->create([
            'organization' => 'ipnu',
            'klasifikasi' => 'ipnu',
            'tanggal_surat' => '2000-01-01',
            'tanggal_penerimaan' => '2025-06-10',
            'perihal' => 'MASUK_FILTER_PENERIMAAN',
        ]);

        $response = $this->actingAs($admin)->get(route('incoming-letters.index', [
            'date_from' => '2025-01-01',
            'date_to' => '2025-12-31',
        ]));

        $response->assertOk();
        $response->assertSee('MASUK_FILTER_PENERIMAAN');
    }

    public function test_outgoing_date_range_uses_tanggal_pengiriman_when_tanggal_surat_is_outside_range(): void
    {
        $admin = User::factory()->admin()->create();
        OutgoingLetter::factory()->create([
            'organization' => 'ipnu',
            'klasifikasi' => 'ipnu',
            'tanggal_surat' => '2000-01-01',
            'tanggal_pengiriman' => '2025-07-15',
            'perihal' => 'KELUAR_FILTER_PENGIRIMAN',
        ]);

        $response = $this->actingAs($admin)->get(route('outgoing-letters.index', [
            'date_from' => '2025-01-01',
            'date_to' => '2025-12-31',
        ]));

        $response->assertOk();
        $response->assertSee('KELUAR_FILTER_PENGIRIMAN');
    }

    public function test_incoming_organization_filter_limits_results(): void
    {
        $admin = User::factory()->admin()->create();
        IncomingLetter::factory()->create([
            'organization' => 'ipnu',
            'klasifikasi' => 'ipnu',
            'perihal' => 'MASUK_IPNU_ONLY',
        ]);
        IncomingLetter::factory()->create([
            'organization' => 'ippnu',
            'klasifikasi' => 'ippnu',
            'perihal' => 'MASUK_IPPNU_ONLY',
        ]);

        $this->actingAs($admin)
            ->get(route('incoming-letters.index', ['organization' => 'ipnu']))
            ->assertOk()
            ->assertSee('MASUK_IPNU_ONLY')
            ->assertDontSee('MASUK_IPPNU_ONLY');
    }

    public function test_incoming_search_finds_by_indeks_label_shown_in_table(): void
    {
        $admin = User::factory()->admin()->create();
        IncomingLetter::factory()->create([
            'indeks' => 'a',
            'perihal' => 'CARI_LABEL_INDEKS_INTERNAL',
        ]);

        $this->actingAs($admin)
            ->get(route('incoming-letters.index', ['q' => 'A (internal)']))
            ->assertOk()
            ->assertSee('CARI_LABEL_INDEKS_INTERNAL');
    }
}
