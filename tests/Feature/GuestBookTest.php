<?php

namespace Tests\Feature;

use App\Models\Guest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestBookTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_form_tampil_pada_url_langsung(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Silakan Isi Buku Tamu')
            ->assertSee('Kunjungan Langsung');
    }

    public function test_halaman_form_tampil_dengan_badge_sumber_yang_benar(): void
    {
        $this->get('/whatsapp')->assertOk()->assertSee('Dari WhatsApp');
        $this->get('/instagram')->assertOk()->assertSee('Dari Instagram');
        $this->get('/facebook')->assertOk()->assertSee('Dari Facebook');
    }

    public function test_url_sumber_tidak_dikenal_mengembalikan_404(): void
    {
        $this->get('/tiktok')->assertNotFound();
    }

    public function test_tamu_dari_url_whatsapp_tersimpan_dengan_sumber_whatsapp(): void
    {
        $data = $this->dataTamuValid();

        $this->post('/tamu', $data + ['sumber' => 'whatsapp'])
            ->assertRedirect('/whatsapp')
            ->assertSessionHas('sukses');

        $this->assertDatabaseHas('guests', [
            'nama' => 'Sari Rahmadani',
            'sumber' => 'whatsapp',
        ]);
    }

    public function test_tamu_dari_halaman_utama_tersimpan_dengan_sumber_langsung(): void
    {
        $this->post('/tamu', $this->dataTamuValid() + ['sumber' => 'direct'])
            ->assertRedirect('/');

        $this->assertDatabaseHas('guests', ['sumber' => 'direct']);
    }

    public function test_sumber_tidak_valid_dari_luar_akan_dipersilakan_default_langsung(): void
    {
        // Sumber dimanipulasi lewat request — tetap aman karena dibatasi daftar sumber
        $this->post('/tamu', $this->dataTamuValid() + ['sumber' => 'hack'])
            ->assertRedirect('/');

        $this->assertDatabaseHas('guests', ['sumber' => 'direct']);
    }

    public function test_validasi_nama_wajib_diisi(): void
    {
        $data = $this->dataTamuValid();
        $data['nama'] = '';

        $this->post('/tamu', $data + ['sumber' => 'direct'])
            ->assertSessionHasErrors('nama');

        $this->assertDatabaseCount('guests', 0);
    }

    public function test_validasi_email_harus_format_benar(): void
    {
        $data = $this->dataTamuValid();
        $data['email'] = 'bukan-format-email';

        $this->post('/tamu', $data + ['sumber' => 'direct'])
            ->assertSessionHasErrors('email');

        $this->assertDatabaseCount('guests', 0);
    }

    public function test_validasi_nomor_hp_wajib_diisi(): void
    {
        $data = $this->dataTamuValid();
        $data['nomor_hp'] = '';

        $this->post('/tamu', $data + ['sumber' => 'direct'])
            ->assertSessionHasErrors('nomor_hp');

        $this->assertDatabaseCount('guests', 0);
    }

    public function test_validasi_nomor_hp_hanya_menerima_format_nomor(): void
    {
        $data = $this->dataTamuValid();
        $data['nomor_hp'] = 'nomor-tidak-valid-abc';

        $this->post('/tamu', $data + ['sumber' => 'direct'])
            ->assertSessionHasErrors('nomor_hp');
    }

    public function test_tanggal_kunjungan_tidak_boleh_dari_masa_depan(): void
    {
        $data = $this->dataTamuValid();
        $data['tanggal_kunjungan'] = now()->addDay()->toDateString();

        $this->post('/tamu', $data + ['sumber' => 'direct'])
            ->assertSessionHasErrors('tanggal_kunjungan');
    }

    public function test_pencarian_tamu_berdasarkan_nama(): void
    {
        Guest::query()->create($this->dataTamuValid() + ['sumber' => 'direct']);
        Guest::query()->create([
            'nama' => 'Zulkifli Amin',
            'nomor_hp' => '081200000002',
            'email' => 'zulkifli@example.com',
            'instansi' => 'Polres Bukittinggi',
            'tujuan_kunjungan' => 'Rapat koordinasi',
            'tanggal_kunjungan' => now()->toDateString(),
            'sumber' => 'facebook',
        ]);

        $this->actingAsAdmin()
            ->get('/admin/tamu?q=sari')
            ->assertOk()
            ->assertSee('Sari Rahmadani')
            ->assertDontSee('Zulkifli Amin');
    }

    private function dataTamuValid(): array
    {
        return [
            'nama' => 'Sari Rahmadani',
            'nomor_hp' => '081200000001',
            'email' => 'sari.rahmadani@example.com',
            'instansi' => 'Universitas Negeri Padang',
            'tujuan_kunjungan' => 'Permintaan data statistik',
            'tanggal_kunjungan' => now()->toDateString(),
        ];
    }

    private function actingAsAdmin()
    {
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        return $this->actingAs(\App\Models\User::query()->where('username', 'admin')->firstOrFail());
    }
}
