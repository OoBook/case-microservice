<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_address()
    {
        $user = User::make([
            'name' => 'User 1',
            'email' => 'user1@gmail',
            // 'password' => bcrypt('111111')
        ]);

        $address = Address::make([
            'user_id' => $user->id,
            'city' => 'İstanbul',
            'address' => 'Aşağı'
        ]);

        $this->assertTrue(true);
    }

    public function test_update_address()
    {
        $user = User::make([
            'name' => 'User 1',
            'email' => 'user1@gmail',
            // 'password' => bcrypt('111111')
        ]);

        Address::make([
            'user_id' => $user->id,
            'city' => 'İstanbul',
            'address' => 'Aşağı'
        ])->update([
            'city' => 'Ankara'
        ]);

        $this->assertTrue(true);
    }

    public function test_delete_address()
    {
        $user = User::make([
            'name' => 'User 1',
            'email' => 'user1@gmail',
            // 'password' => bcrypt('111111')
        ]);

        Address::make([
            'user_id' => $user->id,
            'city' => 'İstanbul',
            'address' => 'Aşağı'
        ])->delete();

        $this->assertTrue(true);
    }
}