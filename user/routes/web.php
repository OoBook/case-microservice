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

$router->get('/ana-sayfa', 'HomeController@index');
$router->get('/hata', 'HomeController@error');

$router->group(['prefix' => 'users', 'as' => 'users.'], function() use ($router)
{
    $router->get('/', function(){
        $users = User::all();
        // dd( view('users.index', compact('users')));
        return view('users.index', compact('users'));
    });

});
// $router->get('/users', 'UserController@index');

$router->post('/users', 'UserController@store');
$router->get('/users/create', 'UserController@create');
$router->get('/users/{user}/edit', 'UserController@edit');
$router->put('/users/{user}', 'UserController@update');
$router->get('/users/{user}', 'UserController@show');
$router->delete('/users/{user}', 'UserController@destroy');

