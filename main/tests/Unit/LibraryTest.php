<?php

namespace Tests\Unit;

use App\Models\Library;
use App\Models\User;

use Tests\TestCase;

class LibraryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_stores_library()
    {

        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => '111111'
        ]);

        $this->assertAuthenticated();

        $response = $this->post('/libraries', [
            'name' => 'Library Unit Test',
            'city' => 'İzmir'
        ]);

        // $response->dump();

        $response->assertRedirect('libraries');
    }

    public function test_it_list_libraries()
    {
        $response = $this->get('/libraries');
 

        $response->assertRedirect('/login');
    }

    public function test_library_index_view_can_be_rendered()
    {
        $view = $this->view('libraries.index', ['libraries' => Library::paginate(10) ]);
 
        $view->assertSee('libraries');
    }

    public function test_it_updates_library()
    {
        $response = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => '111111'
        ]);

        $this->assertAuthenticated();
        
        $response = $this->put('/libraries/1', [
            'name' => 'Library Unit Test Update',
            'city' => 'İstanbul'
        ]);

        // $response->dump();

        $response->assertStatus(302);
    }
}
