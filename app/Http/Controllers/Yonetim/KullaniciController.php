<?php

namespace App\Http\Controllers\Yonetim;

use App\Kullanici;
use App\Models\KullaniciDetay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;


class KullaniciController extends Controller
{
    public function index(){
        /* ARAMA ALANI*/
        if (request()->filled('aranan')){
            request()->flash();
            $aranan=  request('aranan');
            $list = Kullanici::where('adsoyad', 'like', "%$aranan%")
                ->orWhere('email', 'like', "%$aranan%")
                ->orderByDesc('olusturma_tarihi')
                ->paginate(8);
                //->appends('aranan', $aranan) links'e eklemek yerine bu şekildede kullanılabilir
        }else{
            request()->flush();
        $list=Kullanici::orderByDesc('olusturma_tarihi')
                        ->paginate(8);
        }

        return view('yonetim.kullanici.index', compact('list'));
    }
    public  function  oturumac(){

        if (request()->isMethod('POST')){//gelen methodu tespit eder
            $this->validate(request(),[
                'email'=> 'required|email',
                'sifre'=>'required'
            ]);

            $credentials =[
                'email'=>request()->get('email'),
                'password'=>request()->get('sifre'),
                'yonetici_mi'=>1,
                'aktif_mi' =>1
            ];

            // guard ile müşteri arayüzünden bağımsız giriş yaptık bunu config.auth a tanımlamak gerek
            if (Auth::guard('yonetim')->attempt($credentials, request()->has('benihatirla'))){
                return redirect()->route('yonetim.anasayfa');
            }
            else{
                return back()->withInput()->withErrors(['email' => 'Giriş hatalı.']);
            }
        }


        return view('yonetim.oturumac');
    }
    public function oturumukapat(){
        Auth::guard('yonetim')->logout();
        request()->session()->flush();
        request()->session()->regenerate();

        return redirect()->route('yonetim.oturumac');

    }

    public function form($id=0){ // id her zaman gelmeyeceği için 0 yazdık yeni kayıt ve düzenleme function u bu

        $entry = new  Kullanici; // id gelmezse enrty null gelir o yüzden tanımlama yaptık

            if ($id>0){
                $entry = Kullanici::find($id);

            }
            return view('yonetim.kullanici.form' , compact('entry'));
    }

    public function kaydet($id=0){
        $this->validate(request(),[
           'adsoyad'=>'required',
            'email'=>'required|email'
        ]);

        $data=request()->only('adsoyad','email');


        if(request()->filled('sifre')){  //şifre kontrol  varsa diziye ekle
           $data['sifre']= Hash::make(request('sifre'));
        }

        //aktif ve yonetici checkli mi kontrol
        $data['aktif_mi']= request()->has('aktif_mi') && request('aktif_mi')==1 ? '1' : '0';
        $data['yonetici_mi']= request()->has('yonetici_mi') && request('yonetici_mi')==1 ? '1' : '0';


        if ($id>0){
            $entry=Kullanici::where('id',$id)->firstOrFail();
            $entry->update($data);

        }else{
            $entry=Kullanici::create($data);
        }
        KullaniciDetay::updateOrCreate(
            ['kullanici_id' => $entry->id],
            ['adres' =>\request('adres'), 'telefon' => \request('telefon'), 'ceptelefonu' => \request('ceptelefonu')]
        );
        return redirect()->route('yonetim.kullanici.duzenle', $entry->id)
            ->with('mesaj', ($id>0 ? 'Güncellendi.' : 'Kaydedildi.'))
            ->with('mesaj_tur', 'success');
    }

    public  function sil($id){
        Kullanici::destroy($id);

        return redirect()->route('yonetim.kullanici')
            ->with('mesaj','Kayıt silindi.')
            ->with('mesaj_tur', 'success');
    }
}
