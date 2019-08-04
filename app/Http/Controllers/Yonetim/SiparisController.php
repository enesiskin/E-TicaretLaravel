<?php

namespace App\Http\Controllers\Yonetim;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Siparis;

class SiparisController extends Controller
{
    public function index()
    {
        /* ARAMA ALANI*/
        if (request()->filled('aranan')) {
            request()->flash();
            $aranan = request('aranan');
            // sepet üzerinden kullaniciya eriştmek için performans arttırır
            $list = Siparis::with('sepet.kullanici')
                ->where('adsoyad', 'like', "%$aranan%")
                ->orWhere('id', $aranan)
                ->orderByDesc('id')
                ->paginate(8)
                ->appends('aranan', $aranan);
        } else {
            request()->flush();
            $list = Siparis::with('sepet.kullanici')
                ->orderByDesc('id')
                ->paginate(8);
        }

        return view('yonetim.siparis.index', compact('list'));
    }

    public function form($id = 0)// id her zaman gelmeyeceği için 0 yazdık yeni kayıt ve düzenleme function u bu
    {
       /* $urun_kategoriler=[];
        $entry = new  Urun; id sipariş gelmeyeceği içib bunlara gerek yok */
        if ($id > 0) {
            $entry = Siparis::with('sepet.sepet_urunler.urun')
            ->find($id);

        }

        return view('yonetim.siparis.form', compact('entry'));
    }

    public function kaydet($id = 0)
    {
        $data=request()->only('adsoyad','adres', 'telefon', 'ceptelefonu','durum');

        $this->validate(request(),[
            'adsoyad'=>'required',
            'adres'=>'required',
            'telefon'=>'required',
            'durum'=>'required'

        ]);

        // KAYIT İŞLEMİ //
        if ($id>0){
            $entry=Siparis::where('id',$id)->firstOrFail();
            $entry->update($data);
        }
        return redirect()->route('yonetim.siparis.duzenle', $entry->id)
            ->with('mesaj','Güncellendi.')
            ->with('mesaj_tur','success');
    }

    public function sil($id)
    {
       Siparis::destroy($id);

        return redirect()->route('yonetim.siparis')
            ->with('mesaj', 'Kayıt silindi.')
            ->with('mesaj_tur', 'success');

    }
}
