<?php

namespace Tests\Feature;

use App\Models\Guest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_tamu_belum_login_dialihkan_ke_halaman_login(): void
    {
        $this->get('/admin')->assertRedirect('/login');
        $this->get('/admin/tamu')->assertRedirect('/login');
    }

    public function test_admin_bisa_login_menggunakan_username(): void
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $this->post('/login', [
            'login' => 'admin',
            'password' => 'Admin@12345',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated();
    }

    public function test_admin_bisa_login_menggunakan_email(): void
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $this->post('/login', [
            'login' => 'admin@bpskotabukittinggi.test',
            'password' => 'Admin@12345',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated();
    }

    public function test_login_gagal_dengan_password_salah(): void
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $this->from('/login')->post('/login', [
            'login' => 'admin',
            'password' => 'password-salah',
        ])->assertRedirect('/login')->assertSessionHasErrors('login');

        $this->assertGuest();
    }

    public function test_admin_keluar_dari_aplikasi(): void
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
        $admin = User::query()->where('username', 'admin')->firstOrFail();

        $this->actingAs($admin)
            ->post('/logout')
            ->assertRedirect('/');

        $this->assertGuest();
    }

    public function test_dashboard_menampilkan_statistik(): void
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
        $admin = User::query()->where('username', 'admin')->firstOrFail();

        $this->actingAs($admin)->get('/admin')
            ->assertOk()
            ->assertSee('Tamu Bulan Ini')
            ->assertSee('Total Seluruh Tamu')
            ->assertSee('Rekap Sumber Kunjungan');
    }

    public function test_admin_dapat_mengedit_data_tamu(): void
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
        $admin = User::query()->where('username', 'admin')->firstOrFail();
        $tamu = Guest::query()->firstOrFail();

        $this->actingAs($admin)
            ->put("/admin/tamu/{$tamu->id}", [
                'nama' => 'Nama Diperbarui',
                'nomor_hp' => $tamu->nomor_hp,
                'email' => $tamu->email,
                'instansi' => $tamu->instansi,
                'tujuan_kunjungan' => $tamu->tujuan_kunjungan,
                'tanggal_kunjungan' => $tamu->tanggal_kunjungan->toDateString(),
            ])
            ->assertRedirect(route('admin.guests.index'))
            ->assertSessionHas('sukses');

        $this->assertDatabaseHas('guests', ['id' => $tamu->id, 'nama' => 'Nama Diperbarui']);
    }

    public function test_admin_dapat_menghapus_data_tamu(): void
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
        $admin = User::query()->where('username', 'admin')->firstOrFail();
        $tamu = Guest::query()->firstOrFail();

        $this->actingAs($admin)
            ->delete("/admin/tamu/{$tamu->id}")
            ->assertRedirect(route('admin.guests.index'))
            ->assertSessionHas('sukses');

        $this->assertDatabaseMissing('guests', ['id' => $tamu->id]);
    }

    public function test_admin_dapat_melihat_daftar_tamu(): void
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
        $admin = User::query()->where('username', 'admin')->firstOrFail();

        $this->actingAs($admin)->get('/admin/tamu')
            ->assertOk()
            ->assertSee('Administrator');
    }
}
