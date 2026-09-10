<?php

namespace Database\Seeders;

use App\Models\Guest;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@bpskotabukittinggi.test',
            'password' => 'Admin@12345',
        ]);

        Guest::query()->insert([
            [
                'nama' => 'Andi Pratama',
                'nomor_hp' => '081234567801',
                'email' => 'andi.pratama@gmail.com',
                'instansi' => 'Dinas Pendidikan Kota Bukittinggi',
                'tujuan_kunjungan' => 'Koordinasi data statistik pendidikan',
                'tanggal_kunjungan' => now()->startOfMonth()->toDateString(),
                'sumber' => 'direct',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Siti Rahayu',
                'nomor_hp' => '081234567802',
                'email' => 'siti.rahayu@yahoo.co.id',
                'instansi' => 'Universitas Andalas',
                'tujuan_kunjungan' => 'Permintaan data tenaga kerja',
                'tanggal_kunjungan' => now()->toDateString(),
                'sumber' => 'whatsapp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Budi Santoso',
                'nomor_hp' => '081234567803',
                'email' => 'budi.santoso@gmail.com',
                'instansi' => 'Bappeda Kota Bukittinggi',
                'tujuan_kunjungan' => 'Konsultasi data kependudukan',
                'tanggal_kunjungan' => now()->subDays(2)->toDateString(),
                'sumber' => 'instagram',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dewi Lestari',
                'nomor_hp' => '081234567804',
                'email' => 'dewi.lestari@gmail.com',
                'instansi' => 'Mahasiswa Independen',
                'tujuan_kunjungan' => 'Survei lapangan skripsi',
                'tanggal_kunjungan' => now()->subDays(3)->toDateString(),
                'sumber' => 'facebook',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Rahmat Hidayat',
                'nomor_hp' => '081234567805',
                'email' => 'rahmat.hidayat@gmail.com',
                'instansi' => 'Kecamatan Guguk Panjang',
                'tujuan_kunjungan' => 'Pengambilan data kemiskinan',
                'tanggal_kunjungan' => now()->subMonth()->toDateString(),
                'sumber' => 'direct',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
