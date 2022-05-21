<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        return 'Hello Enrich MainPage';
    }
    
    public function error()
    {
        return 'Sistemde bir hata oluştu';
    }


}
