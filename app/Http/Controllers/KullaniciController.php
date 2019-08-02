<?php

namespace App\Http\Controllers;

use App\Kullanici;
use App\Mail\KullaniciKayitMail;
use Illuminate\Support\Facades\Hash;// hash kullacaksan ekle
use Illuminate\Support\Facades\Mail; //mail sınıfı çağırmak için ekle
use Illuminate\Support\Str; // str kullanacaksan ekle


class KullaniciController extends Controller
{
    // Böylece sadece giriş yapmamış kullaniciler bu controllerdaki
    //(oturumukapat hariç) functionlara ulaşabilir
    //Middleware/Redirectifauth home anasayfa olmalı hata almamak için
    public function __construct()
    {
        $this->middleware('guest')->except('oturumukapat');
    }

    public function giris_form(){
        return view('kullanici.oturumac');
    }
    public  function giris(){
        $this->validate(request(),[
            'email'=>'required|email',
            'sifre'=>'required'
            ]);
        if(auth()->attempt(['email' => request('email'), 'password' => request('sifre')], request()->has('benihatirla'))){
                \request()->session()->regenerate(); // sessionu yenile
                return redirect()->intended('/'); // giriş yapılmışsa istenlen sayfaya yapılmamış ise anasayfaya yönlendir
        }else{
            $errors =['email' => 'Hatalı Giriş.'];
            return back()->withErrors($errors);
        }
    }


    public function kaydol_form(){
        return view('kullanici.kaydol');
    }
    public  function kaydol(){
        $this->validate(request(),[
            'adsoyad'=> 'required|min:5|max:60', //5-60 arası girilmesi zorunlu alan
            'email' => 'required|email|unique:kullanici', //email olarak eşsiz olmalı
            'sifre'=> 'required|confirmed|min:6|max:10'  // doğrulanacak alan
        ]);
        $kullanici = Kullanici::create([
            'adsoyad'=>request('adsoyad'),
            'sifre'=>Hash::make(request('sifre')),
            'email'=>request('email'),
            'aktivasyon_anahtari'=>Str::random(60), // 60 karakterlik string oluşturmasını sağlar
            'aktif_mi'=>0
        ]);

       Mail::to(request('email'))->send(new KullaniciKayitMail($kullanici));
       auth()->login($kullanici); // login gerçekleşir

       return redirect()->route('anasayfa');
    }



    public function aktiflestir($anahtar){
        $kullanici= Kullanici::where('aktivasyon_anahtari', $anahtar)->first();
        if(!is_null($kullanici)){
            $kullanici->aktivasyon_anahtari= null;
            $kullanici->aktif_mi = 1;
            $kullanici->save();
            return redirect()->to('anasayfa')
            ->with('mesaj','Kaydınız aktifleştirildi.')
            ->with('mesaj_tur', 'success');
        }else{
            return redirect()->to('anasayfa')
                ->with('mesaj','Kaydınız bulunamadı.')
                ->with('mesaj_tur', 'warning');
        }
    }


    public  function  oturumukapat(){
        auth()->logout();
        request()->session()->regenerate(); // session id değerini 0lıyoruz
        request()->session()->flush(); // session içini temizler
        return redirect()->route('anasayfa');
    }
}
