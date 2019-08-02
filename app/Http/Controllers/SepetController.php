<?php

namespace App\Http\Controllers;

use App\Models\Sepet;
use App\Models\SepetUrun;
use Illuminate\Http\Request;
use App\Models\Urun;
use Cart;
use Validator; // validation kullanacaksak sınıfı unutmamalıyız

class SepetController extends Controller
{
    // Construct yapısını oluşturarakta giriş yapılmadan erişim engellenir
    /*public  function __construct()
    {
        $this->middleware('auth');
    }*/

    public function index(){
        return view('sepet');
    }


    public function ekle(){


        $urun=Urun::find(request('id'));
        $cartItem=Cart::add($urun->id,$urun->urun_adi,1,$urun->fiyati, ['slug'=>$urun->slug]);  // sepete ekleme işlemi yeri 1 yazan yer adet dışarıdanda alabilir

        if(auth()->check()){  //giriş yapılmışsa if e girer
            $aktif_sepet_id = session('aktif_sepet_id');
            if (!isset($aktif_sepet_id)){
            $aktif_sepet=Sepet::create([
               'kullanici_id' => auth()->id() //giriş yapan kullanıcının idsin ibelirler
            ]);
            $aktif_sepet_id = $aktif_sepet->id; // veritabanında oluşan kaydın idsini aldık
            session()->put('aktif_sepet_id', $aktif_sepet_id);
            }
            // idler doğru ise 2. satırdakileri günceller idler yoksa yeni kayıt açar
            SepetUrun::updateOrCreate(
                ['sepet_id'=> $aktif_sepet_id, 'urun_id' => $urun->id],
                ['adet'=>$cartItem->qty,'fiyati'=>$urun->fiyati, 'durum' =>'Beklemede']
            );
        }

        return redirect()->route('sepet')
            ->with('mesaj', 'Sepete eklendi')
            ->with('mesaj_tur', 'success');

    }




    public  function kaldir($rowid){
        if (auth()->check()){
            $aktif_sepet_id = session('aktif_sepet_id');
            $cardItem= Cart::get($rowid);
            SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $cardItem->id)->delete();
        }
        Cart::remove($rowid);
        return redirect()->route('sepet')
            ->with('mesaj', 'Sepetten kaldırıldı.')
            ->with('mesaj_tur', 'success');
    }


    public function bosalt(){
        if (auth()->check()){
            $aktif_sepet_id = session('aktif_sepet_id');
            SepetUrun::where('sepet_id', $aktif_sepet_id)->delete();
        }
        Cart::destroy();
        return redirect()->route('sepet');

    }



    public  function guncelle($rowid){
        $validator= Validator::make(request()->all(),[
            'adet' =>'required|numeric|between:0,5'

        ]);
        if ($validator->fails())
        {
            session()->flash('mesaj', 'Adet bilgisi 1-5 arasında olmalıdır.');
            session()->flash('mesaj_tur', 'danger');
            return response()->json(['succes'=>false]);
        }


        if (auth()->check()){
            $aktif_sepet_id = session('aktif_sepet_id');
            $cardItem= Cart::get($rowid);

            if (request('adet')== 0)
                SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $cardItem->id)->delete();
            else
            SepetUrun::where('sepet_id', $aktif_sepet_id)->where('urun_id', $cardItem->id)
            ->update(['adet' => request('adet')]);

        }

        Cart::update($rowid, request('adet'));
        /*AJAX KULLANDIĞIMIZ İÇİN SESSİON İLE GÖNDEREBİLİRİZ MESAJLARI DA FLASH YARDIMIYLA GÖNDEREBİLİRİZ */
        session()->flash('mesaj', 'Adet bilgisi güncellendi');
        session()->flash('mesaj_tur', 'success');

       return response()->json(['succes'=>true]);
    }
}
