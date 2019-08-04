<?php

namespace App\Http\Controllers\Yonetim;

use App\Models\Kategori;
use App\Models\UrunDetay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Urun;

class UrunController extends Controller
{
    public function index()
    {
        /* ARAMA ALANI*/
        if (request()->filled('aranan')) {
            request()->flash();
            $aranan = request('aranan');
            $list = Urun::where('urun_adi', 'like', "%$aranan%")
                ->orWhere('aciklama', 'like', "%$aranan%")
                ->orderByDesc('id')
                ->paginate(8)
                ->appends('aranan', $aranan);
        } else {
            request()->flush();
            $list = Urun::orderByDesc('id')
                ->paginate(8);
        }

        return view('yonetim.urun.index', compact('list'));
    }

    public function form($id = 0)// id her zaman gelmeyeceği için 0 yazdık yeni kayıt ve düzenleme function u bu
    {
        $urun_kategoriler=[];
        $entry = new  Urun; // id gelmezse entry null gelir o yüzden tanımlama yaptık
        if ($id > 0) {
            $entry = Urun::find($id);
            $urun_kategoriler =$entry->kategoriler()->pluck('kategori_id')->all(); // pluck bir tablodan berlirli değeri almaya yarar

        }
        $kategoriler= Kategori::all();
        return view('yonetim.urun.form', compact('entry','kategoriler','urun_kategoriler'));
    }

    public function kaydet($id = 0)
    {
        $data=request()->only('urun_adi','slug', 'aciklama', 'fiyati');

        if (!request()->filled('slug')){
            $data['slug']=str_slug(request('urun_adi'));
            request()->merge(['slug' => $data['slug']]);
        }

        $this->validate(request(),[
            'urun_adi'=>'required',
            'fiyati'=>'required',
            'slug'        => (request('orijinal_slug')!= request('slug') ? 'unique:urun,slug' : '')

        ]);


        /* if (Kategori::whereSlug($data['slug'])->count()>0){
             return back()->withInput()->withErrors(['slug'=>'Slug değeri önceden kayıtlıdır.']);
         }*/
        $data_detay= request()->only(
            'goster_slider','goster_gunun_firsati','goster_one_cikan','goster_cok_satan','goster_indirimli'
        );
        $kategoriler= request('kategoriler');


        // KAYIT İŞLEMİ //
        if ($id>0){
            $entry=Urun::where('id',$id)->firstOrFail();
            $entry->update($data);

           $entry->detay()->update($data_detay);
           $entry->kategoriler()->sync($kategoriler); // öncesinde db de 1 nolu kategori varsa onu silip seçtiklerimizi dbye ekler


        }else{
            $entry=Urun::create($data);
            $entry->detay()->create($data_detay);
            $entry->kategoriler()->attach($kategoriler); // detach in tersi ilişkili tabloya ekleme yapar
        }

        // RESİM YÜKLEME ALANI //
        if (request()->hasFile('urun_resmi')){

            $this->validate(request(),[
                'urun_resmi'=> 'image|mimes:jpg,png,jpeg,gif|max:2048' //2mb a kadar yükleme ve sadece bu uzantılar
            ]);

                $urun_resmi=request()->file('urun_resmi');
               // $urun_resmi=request()->urun_resmi;
                //$urun_resmi->extension_loaded();  uzantı çekme
               //$urun_resmi->getClientOriginalName(); dosya adı
               //$urun_resmi->hashName();

                $dosyaadi= $entry->id . "-" .time(). "." .$urun_resmi->extension();
                //$dosyaadi= $urun_resmi->getClientOriginalName();
                //$dosyaadi= $urun_resmi->hashName();

            if($urun_resmi->isValid()){ // geçici olarak cache atıyor
                $urun_resmi->move('uploads/urunler', $dosyaadi);  // yüklemeyi yapan yer

                UrunDetay::updateOrCreate(
                            ['urun_id'=> $entry->id],
                            ['urun_resmi'=>$dosyaadi]
                );
            }

        }

        return redirect()->route('yonetim.urun.duzenle', $entry->id)
            ->with('mesaj', ($id>0 ? 'Güncellendi.' : 'Kaydedildi.'))
            ->with('mesaj_tur', 'success');
    }

    public function sil($id)
    {
        $urun=Urun::find($id);
        $urun->kategoriler()->detach(); //bağlı olduğu tablodan sildi
       // $urun->detay()->delete();   //detaynı sildi
        $urun->delete();        //softdelete ile urunlerden sildi


        return redirect()->route('yonetim.urun')
            ->with('mesaj', 'Kayıt silindi.')
            ->with('mesaj_tur', 'success');

    }
}
