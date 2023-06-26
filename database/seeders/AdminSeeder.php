<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            [
                'firstname' =>      'Hasan',
                'lastname' =>       'Karadiya',
                'email'     =>      'admin@gmail.com',
                'user_type' =>      1,
                'password'  =>      Hash::make(123456),
                'status'    =>      1,
            ],
        ];

        Admin::insert($admins);
    }
}
