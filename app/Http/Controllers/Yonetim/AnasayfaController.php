<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class AnasayfaController extends Controller
{
    public function index(){
            // Tüm view larda göstermek için aşağıdaki cache yapısını düzenleyerek Providers\AppService içine yazdık
            $cok_satan_urunler= DB::select("
                SELECT u.urun_adi, SUM(su.adet) adet
                FROM siparis si
                INNER JOIN sepet s on si.sepet_id
                INNER  JOIN sepet_urun su on s.id = su.sepet_id
                INNER JOIN urun u on u.id=su.urun_id
                GROUP BY u.urun_adi
                ORDER BY SUM(su.adet) DESC
            ");

        $aylara_gore_satislar= DB::select("
                SELECT DATE_FORMAT(si.olusturma_tarihi,'%Y-%m') ay, SUM(su.adet) adet
                FROM siparis si
                INNER JOIN sepet s on s.id=si.sepet_id
                INNER  JOIN sepet_urun su on s.id = su.sepet_id              
                GROUP BY DATE_FORMAT(si.olusturma_tarihi,'%Y-%m')
                ORDER BY DATE_FORMAT(si.olusturma_tarihi,'%Y-%m')
            ");
            return view('yonetim.anasayfa', compact('cok_satan_urunler', 'aylara_gore_satislar'));
    }
}
/* Cache yapısı diğer örnek
if (!Cache::has('istatistikler')){
    $istatistikler=[
        'bekleyensiparis'=> Siparis::where('durum','Siparişiniz alındı.')->count()

    ];

    $bitiszamani=now()->addMinutes(10);
    Cache::put('istatistikler',$istatistikler,$bitiszamani);
    //Cache::add('istatistikler',$istatistikler,$bitiszamani); // cache varsa ekleme yoksa ekler
}

else{
    // yoksa cache den al
    $istatistikler=Cache::get('istatistikler');
}

//Cache::forget('istatistikler'); belirli cache i siler
//Cache::flush(); tüm cacheleri siler */