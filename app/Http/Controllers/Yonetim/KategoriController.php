<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Auth;
use Hash;

class KategoriController extends Controller
{
    public function index(){
        /* ARAMA ALANI*/
        if (request()->filled('aranan') || request()->filled('ust_id')){
            request()->flash();
            $aranan=  request('aranan');
            $ust_id=  request('ust_id');
            $list = Kategori::with('ust_kategori')
                ->where('kategori_adi', 'like', "%$aranan%")
                ->where('ust_id', $ust_id)
                ->orderByDesc('id')
                ->paginate(8)
                ->appends(['aranan'=> $aranan,'ust_id'=>$ust_id]); //links'e eklemek yerine bu şekildede kullanılabilir
        }else{
            request()->flush();
            $list=Kategori::with('ust_kategori')->orderByDesc('id')
                ->paginate(8);
        }

        $anakategoriler = Kategori::whereRaw('ust_id is null')->get();

        return view('yonetim.kategori.index', compact('list','anakategoriler'));

    }

    public function form($id = 0){ // id her zaman gelmeyeceği için 0 yazdık yeni kayıt ve düzenleme function u bu

        $entry = new  Kategori(); // id gelmezse entry null gelir o yüzden tanımlama yaptık

        if ($id>0){
            $entry = Kategori::find($id);

        }
        $kategoriler=Kategori::all();
        return view('yonetim.kategori.form' , compact('entry','kategoriler'));
    }

    public function kaydet($id = 0){


        $data=request()->only('kategori_adi','slug', 'ust_id');

        if (!request()->filled('slug')){
            $data['slug']=str_slug(request('kategori_adi'));
            request()->merge(['slug' => $data['slug']]);
        }

        $this->validate(request(),[
            'kategori_adi'=>'required',
            'slug'        => (request('orijinal_slug')!= request('slug') ? 'unique:kategori,slug' : '')

        ]);

       /* if (Kategori::whereSlug($data['slug'])->count()>0){
            return back()->withInput()->withErrors(['slug'=>'Slug değeri önceden kayıtlıdır.']);
        }*/

        if ($id>0){
            $entry=Kategori::where('id',$id)->firstOrFail();
            $entry->update($data);

        }else{
            $entry=Kategori::create($data);
        }

        return redirect()->route('yonetim.kategori.duzenle', $entry->id)
            ->with('mesaj', ($id>0 ? 'Güncellendi.' : 'Kaydedildi.'))
            ->with('mesaj_tur', 'success');
    }

    public  function sil($id){
        $kategori=Kategori::find($id);
        $kategori->urunler()->detach(); //bağlı olduğu tablodan sildi
        $kategori->delete();

       // Kategori::destroy($id); delete ile buna gerek kalmadı

        return redirect()->route('yonetim.kategori')
            ->with('mesaj','Kayıt silindi.')
            ->with('mesaj_tur', 'success');
    }
}
