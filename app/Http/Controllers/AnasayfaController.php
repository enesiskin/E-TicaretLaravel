<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnasayfaController extends Controller
{
    public function index(){
        $isim = 'Enes';
        $soyisim = 'Işkın';
        $isimler = ['Enes','Ali','Fikret','Semih'];

        //return view('anasayfa', ['isim'=>'Enes','soyisim'=> 'Işkın']);
        //return view('anasayfa')->with (['isim'=>$isim,'soyisim'=>$soyisim]);

        return view("anasayfa",compact('isim','soyisim','isimler'));
    }
}
