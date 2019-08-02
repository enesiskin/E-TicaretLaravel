<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SepetController extends Controller
{
    // Construct yapısını oluşturarakta giriş yapılmadan erişim engellenir
    public  function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('sepet');
    }
}
