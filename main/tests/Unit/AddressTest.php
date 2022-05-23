<?php

namespace Tests\Unit;

use App\Models\Address;
use App\Models\User;
use Tests\TestCase;

class AddressTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_stores_address()
    {

        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => '111111'
        ]);

        $this->assertAuthenticated();

        $response = $this->post('/users/1/addresses', [
            'city' => 'İzmir',
            'address' => 'Address Unit Test',
        ]);


        $response->assertRedirect('/users/1/addresses');
    }

    public function test_it_list_addresses()
    {
        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => '111111'
        ]);

        $this->assertAuthenticated();

        $response = $this->get('/users/1/addresses');
 
        $response->assertStatus(200);
    }

    public function test_address_index_view_can_be_rendered()
    {
        $view = $this->view('addresses.index', ['user' =>  User::find(1), 'addresses' => User::find(1)->addresses ]);
 
        $view->assertSee('addresses');
    }

    public function test_it_updates_address()
    {
        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => '111111'
        ]);

        $this->assertAuthenticated();

        $user = User::find(1);
        $address_id = $user->addresses[0]->id;

        $response = $this->put('/users/1/addresses/'.$address_id, [
            'city' => 'İstanbul',
            'address' => 'Address Unit Test Update',
        ]);

        // $response->dump();

        $response->assertStatus(302);
    }
}
