<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
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
                'name' => 'ADMINISTRATOR',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('111111')
            ],
            [
                'name' => 'TEST      USER',
                'email' => 'test@gmail.com',
                'password' => bcrypt('111111')
            ]
        ];

        $addresses = [
            [
                'user_id' => 1,
                'city' => 'İstanbul',
                'address' => 'Levent no:1'
            ],
            [
                'user_id' => 1,
                'city' => 'İstanbul',
                'address' => 'Beşiktaş no:2'
            ],
            [
                'user_id' => 2,
                'city' => 'Ankara',
                'address' => 'Aşti no:1'
            ]
        ];

        
        foreach ($data as $model) {
            // dd($model);
            User::create($model);
        }

        $role1 = Role::create(['name' => 'admin']);
        $role1->users()->attach(1);
        $role2 = Role::create(['name' => 'user']);
        $role2->users()->attach(2);

        foreach ($addresses as $key => $address) {
            Address::create($address);
        }
    }
}
