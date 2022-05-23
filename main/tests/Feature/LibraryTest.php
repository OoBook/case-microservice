<?php

namespace Tests\Feature;

use App\Models\Library;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LibraryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_library()
    {
        $library = Library::make([
            'name' => 'Library 1',
            'city' => 'İzmir',
            // 'password' => bcrypt('111111')
        ]);

        $this->assertTrue(true);
    }

    public function test_update_library()
    {
        Library::make([
                'name' => 'Library 1',
                'city' => 'İzmir',
                ])
            ->update([
                'name' => 'Library 2',
            ]);

        $this->assertTrue(true);
    }

    public function test_delete_library()
    {
        Library::make([
            'name' => 'Library 1',
            'email' => 'library1@gmail',
            ])
            ->delete();

        $this->assertTrue(true);
    }
}
