<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Models\Library;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {

    // User::create([
    //     'name' => 'ADMIN',
    //     'normalized_name' => 'admin',
    //     'email' => 'oguz.bukcuoglu@gmail.com',
    //     'password' => Hash::make('111111')
    // ]);
    // Library::create([
    //     'name' => 'West',
    //     'city' => 'İstanbul'
    // ]);
    $user = User::find(1);
    $library = Library::find(1);

    dd($user->libraries);

    dd( $user->libraries()->attach($library->id));
    $users = User::all();
    dd($users);
    return 'user';
    return $router->app->version();
});
