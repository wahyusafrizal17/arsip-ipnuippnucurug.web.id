<?php

namespace Tests\Feature;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryJointOrganizationVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_ipnu_user_sees_inventory_with_organization_ipnu_ippnu(): void
    {
        $user = User::factory()->ipnu()->create();
        Inventory::factory()->create([
            'organization' => 'ipnu_ippnu',
            'nama_barang' => 'ITEM_GABUNGAN_IPNU_VIEW',
        ]);

        $this->actingAs($user)
            ->get(route('inventories.index'))
            ->assertOk()
            ->assertSee('ITEM_GABUNGAN_IPNU_VIEW');
    }

    public function test_ippnu_user_sees_inventory_with_organization_ipnu_ippnu(): void
    {
        $user = User::factory()->ippnu()->create();
        Inventory::factory()->create([
            'organization' => 'ipnu_ippnu',
            'nama_barang' => 'ITEM_GABUNGAN_IPPNU_VIEW',
        ]);

        $this->actingAs($user)
            ->get(route('inventories.index'))
            ->assertOk()
            ->assertSee('ITEM_GABUNGAN_IPPNU_VIEW');
    }

    public function test_ipnu_user_does_not_see_inventory_scoped_to_ippnu_only(): void
    {
        $user = User::factory()->ipnu()->create();
        Inventory::factory()->create([
            'organization' => 'ippnu',
            'nama_barang' => 'ITEM_IPPNU_SAHAJA',
        ]);

        $this->actingAs($user)
            ->get(route('inventories.index'))
            ->assertOk()
            ->assertDontSee('ITEM_IPPNU_SAHAJA');
    }

    public function test_ipnu_user_update_preserves_joint_inventory_organization(): void
    {
        $user = User::factory()->ipnu()->create();
        $inventory = Inventory::factory()->create([
            'organization' => 'ipnu_ippnu',
            'nama_barang' => 'Joint keep org',
            'jumlah' => 5,
            'status_barang' => 'baik',
            'lokasi_penyimpanan' => 'Rak X',
        ]);

        $this->actingAs($user)
            ->put(route('inventories.update', $inventory), [
                'nama_barang' => 'Joint keep org',
                'jumlah' => 7,
                'status_barang' => 'baik',
                'lokasi_penyimpanan' => 'Rak Y',
            ])
            ->assertRedirect(route('inventories.index'));

        $this->assertSame('ipnu_ippnu', $inventory->fresh()->organization);
        $this->assertSame(7, $inventory->fresh()->jumlah);
    }
}
