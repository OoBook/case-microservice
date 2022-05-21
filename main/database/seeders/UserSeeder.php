<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'ADMIN',
                'email' => 'oguz.bukcuoglu@gmail.com',
                'password' => bcrypt('111111')
            ],
            [
                'name' => 'USER',
                'email' => 'test@gmail.com',
                'password' => bcrypt('111111')
            ]
        ];

        User::insert($data);
    }
}
