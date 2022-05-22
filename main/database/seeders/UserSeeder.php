<?php

namespace Database\Seeders;

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
        foreach ($data as $model) {
            // dd($model);
            User::create($model);
        }

        $role1 = Role::create(['name' => 'ADMIN']);
        $role1->users()->attach(1);
        $role2 = Role::create(['name' => 'USER']);
        $role2->users()->attach(2);

    }
}
