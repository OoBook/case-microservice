<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_form()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_create_user()
    {
        $user = User::make([
            'name' => 'User 1',
            'email' => 'user1@gmail',
            // 'password' => bcrypt('111111')
        ]);

        $this->assertTrue(true);
    }

    public function test_update_user()
    {
        User::make([
                'name' => 'User 1',
                'email' => 'user1@gmail',
            ])
            ->update([
                'name' => 'User 2',
            ]);

        $this->assertTrue(true);
    }

    public function test_delete_user()
    {
        User::make([
            'name' => 'User 1',
            'email' => 'user1@gmail',
            ])
            ->delete();

        $this->assertTrue(true);
    }

    public function test_see_enrich_main_page()
    {
        $response = $this->get('/ana-sayfa');

        $response->assertSee('Hello Enrich MainPage');
    }

    public function test_see_enrich_error_page()
    {
        $response = $this->get('/hata');

        $response->assertSee('Sistemde bir hata oluştu');
    }
}
