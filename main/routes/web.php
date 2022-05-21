<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
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
    // $user = User::find(1);
    // $library = Library::find(1);

    // dd($user->libraries);

    // dd( $user->libraries()->attach($library->id));
    // $users = User::all();
    // dd($users);
    // return 'user';
    // return $router->app->version();
});

Route::resource('users',UserController::class); // <-- what is the name of this route


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
