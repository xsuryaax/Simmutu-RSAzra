<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            'nama_lengkap' => 'Administrator',
            'nip' => '1234567890',
            'username' => 'admin',
            'email' => 'administrator@rsazra.co.id',
            'password' => Hash::make('rsazra'),
            'role_id' => 1,
            'unit_id' => 1,
            'profesi' => 'Non Medis',
            'atasan_langsung' => 'Direktur Utama',
            'status_user' => 'aktif',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'nama_lengkap' => 'Mutu',
            'nip' => '0987654321',
            'username' => 'mutu',
            'email' => 'mutu@rsazra.co.id',
            'password' => Hash::make('rsazra'),
            'role_id' => 2,
            'unit_id' => 2,
            'profesi' => 'Medis',
            'atasan_langsung' => 'Ketua Komite Mutu',
            'status_user' => 'aktif',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // $units = DB::table('tbl_unit')->get();

        // foreach ($units as $unit) {

        //     $username = Str::slug($unit->nama_unit, '');

        //     // Tentukan role
        //     if ($unit->nama_unit == 'Administrator') {
        //         $roleId = 1;
        //     } elseif ($unit->nama_unit == 'Mutu') {
        //         $roleId = 2;
        //     } else {
        //         $roleId = 3;
        //     }

        //     DB::table('users')->insert([
        //         'nama_lengkap' => $unit->nama_unit,
        //         'nip' => '1111111111',
        //         'username' => $username,
        //         'email' => $username . '@rsazra.co.id',
        //         'password' => Hash::make($username . '123'),
        //         'role_id' => $roleId,
        //         'unit_id' => $unit->id,
        //         'profesi' => 'Non Medis',
        //         'atasan_langsung' => 'Manajer',
        //         'status_user' => 'aktif',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ]);
        // }
    }
}
