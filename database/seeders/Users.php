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
        $units = DB::table('tbl_unit')->get();

        foreach ($units as $unit) {

            $username = Str::slug($unit->nama_unit, '');

            // Tentukan role
            if ($unit->nama_unit == 'Administrator') {
                $roleId = 1;
            } elseif ($unit->nama_unit == 'Mutu') {
                $roleId = 2;
            } else {
                $roleId = 3;
            }

            DB::table('users')->insert([
                'nama_lengkap' => $unit->nama_unit,
                'username' => $username,
                'email' => $username . '@rsazra.co.id',
                'password' => Hash::make($username . '123'),
                'role_id' => $roleId,
                'unit_id' => $unit->id,
                'status_user' => 'aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
