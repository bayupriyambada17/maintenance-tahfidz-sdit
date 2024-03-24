<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'guru',
            'guard_name' => 'web'
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'foto' => '',
            'email' => 'admin@gmail.com',
            'telepon' => '0987654321',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
        ]);
        $admin->assignRole('admin');

        $guru = User::create([
            'name' => 'Guru',
            'foto' => '',
            'email' => 'guru@gmail.com',
            'telepon' => '1234567890',
            'username' => 'guru',
            'password' => Hash::make('guru123'),
        ]);
        $guru->assignRole('guru');

        $guru2 = User::create([
            'name' => 'Hafidz',
            'foto' => '',
            'email' => 'hafidz@gmail.com',
            'telepon' => '1234567890',
            'username' => 'hafidz',
            'password' => Hash::make('hafidz123'),
        ]);
        $guru2->assignRole('guru');

        $kelas1 = Kelas::create([
            'name' => '1 A'
        ]);

        $kelas2 = Kelas::create([
            'name' => '1 B'
        ]);

        $kelas3 = Kelas::create([
            'name' => '2 A'
        ]);

        $kelas4 = Kelas::create([
            'name' => '2 B'
        ]);

        $kelas5 = Kelas::create([
            'name' => '3 A'
        ]);

        $kelas6 = Kelas::create([
            'name' => '3 B'
        ]);

        $siswa1 = Siswa::create([
            'name' => 'Iqbal Ramadhan',
            'nis' => 10232312,
            'nisn' => 12345678,
            'user_id' => $guru->id,
        ]);

        $siswa2 = Siswa::create([
            'name' => 'Muhammad Ramadhan',
            'nis' => 31230090,
            'nisn' => 87654321,
            'user_id' => $guru2->id,
        ]);

    }
}
