<?php

namespace App\Http\Controllers;

use Cart;
use Illuminate\Http\Request;
use App\Models\Siparis;

class OdemeController extends Controller
{
     public function  index(){
         if (!auth()->check()){
             return redirect()->route('kullanici.oturumac')
                 ->with('mesaj_tur', 'info')
                 ->with('mesaj','Lütfen kayıt olun veya oturum açın.');
         }elseif (count(Cart::content())==0){
             return redirect()->route('anasayfa')
                 ->with('mesaj_tur', 'info')
                 ->with('mesaj','Ödeme işlemi için sepetinizde ürün bulunmalıdır.');
         }
         $kullanici_detay= auth()->user()->detay;
         return view('odeme', compact('kullanici_detay'));
     }

     public function odemeyap(){

         $siparis = request()->all();
         $siparis['sepet_id']= session('aktif_sepet_id');
         $siparis['banka']= 'Garanti';
         $siparis['taksit_sayısı']=1;
         $siparis['durum']='Siparişiniz alındı.';
         $siparis['siparis_tutari']= Cart::subtotal();

         Siparis::create($siparis);
         Cart::destroy();
         session()->forget('aktif_sepet_id');

         return redirect()->route('siparisler')
             ->with('mesaj','Ödemeniz başarılı bir şekilde gerçekleşti')
             ->with('mesaj_turu','success');

     }
}
