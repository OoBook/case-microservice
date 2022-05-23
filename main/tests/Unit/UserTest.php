<?php

namespace Tests\Unit;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Faker\Factory;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_table_has_admin_user()
    {
        # code...
        // User::create(['name'=>'ADMIN']);
        
        $this->assertDatabaseHas('users', [
            'name' => 'ADMIN USER',
        ]);
    }

    public function test_it_stores_user()
    {

        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => '111111'
        ]);

        $this->assertAuthenticated();

        $response = $this->post('/users', [
            'name' => 'ADMIN USER',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('111111')
        ]);

        // $response->dump();

        $response->assertStatus(302);
    }

    public function test_user_index_view_can_be_rendered()
    {
        $view = $this->view('users.index', ['users' => User::paginate(10), 'roles' => Role::all() ]);
 
        $view->assertSee('users');
    }


    public function test_it_list_users_nonAuthenticated()
    {
        $response = $this->get('/users');
 

        $response->assertRedirect('/login');
    }


    public function test_it_list_users()
    {
        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => '111111'
        ]);

        $this->assertAuthenticated();

        $response = $this->get('/users');
 
        // $response->dump();


        $response->assertStatus(200);
    }

    public function test_it_updates_user()
    {
        $user = User::find(1);

        $this->actingAs($user);
        
        $response = $this->put('/users/1', [
            'name' => 'ADMIN USER',
            'email' => $user->email,
            'role_id' => 1
        ]);

        $response->assertStatus(302);
    }


}
