<?php

namespace Tests\Feature;

use App\Models\IncomingLetter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BersamaLetterVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_ipnu_user_sees_bersama_letter_under_ipnu_ippnu_organization(): void
    {
        $user = User::factory()->ipnu()->create();
        IncomingLetter::factory()->create([
            'organization' => 'ipnu_ippnu',
            'klasifikasi' => 'bersama',
            'perihal' => 'Surat rapat gabungan khusus test',
        ]);

        $response = $this->actingAs($user)->get(route('incoming-letters.index'));

        $response->assertOk();
        $response->assertSee('Surat rapat gabungan khusus test');
    }

    public function test_ippnu_user_sees_bersama_letter_under_ipnu_ippnu_organization(): void
    {
        $user = User::factory()->ippnu()->create();
        IncomingLetter::factory()->create([
            'organization' => 'ipnu_ippnu',
            'klasifikasi' => 'bersama',
            'perihal' => 'Bersama IPPNU visibility test',
        ]);

        $response = $this->actingAs($user)->get(route('incoming-letters.index'));

        $response->assertOk();
        $response->assertSee('Bersama IPPNU visibility test');
    }

    public function test_ipnu_user_does_not_see_ippnu_only_letter(): void
    {
        $user = User::factory()->ipnu()->create();
        IncomingLetter::factory()->create([
            'organization' => 'ippnu',
            'klasifikasi' => 'ippnu',
            'perihal' => 'Rahasia IPPNU saja',
        ]);

        $response = $this->actingAs($user)->get(route('incoming-letters.index'));

        $response->assertOk();
        $response->assertDontSee('Rahasia IPPNU saja');
    }
}
