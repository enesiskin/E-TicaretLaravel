<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix'=>'yonetim', 'namespace' =>'Yonetim'],function () {
   // Route::redirect('/','/yonetim/oturumac');
    Route::match(['get','post'], '/oturumac', 'KullaniciController@oturumac')->name('yonetim.oturumac');
    //hem get hem postu kullanmak için için match yazdık
    Route::get('/oturumukapat', 'KullaniciController@oturumukapat')->name('yonetim.oturumukapat');
    Route::get('/anasayfa', 'AnasayfaController@index')->name('yonetim.anasayfa');



Route::group(['middleware'=>'yonetim'],function () { // ekstra bir middleware yapacaksak kernele 'yonetim' => \App\Http\Middleware\Yonetim::class, tanımalamak lazım

        Route::get('/anasayfa', 'AnasayfaController@index')->name('yonetim.anasayfa');

        Route::group(['prefix'=>'kullanici'],function (){
            Route::match(['get','post'],'/', 'KullaniciController@index')->name('yonetim.kullanici');
            Route::get( '/yeni', 'KullaniciController@form')->name('yonetim.kullanici.yeni');
            Route::get('/duzenle/{id}', 'KullaniciController@form')->name('yonetim.kullanici.duzenle');
            Route::post('/kaydet/{id}', 'KullaniciController@kaydet')->name('yonetim.kullanici.kaydet');
            Route::get('/sil/{id}', 'KullaniciController@sil')->name('yonetim.kullanici.sil');

        });

    Route::group(['prefix'=>'kategori'],function (){
        Route::match(['get','post'],'/', 'KategoriController@index')->name('yonetim.kategori');
        Route::get( '/yeni', 'KategoriController@form')->name('yonetim.kategori.yeni');
        Route::get('/duzenle/{id}', 'KategoriController@form')->name('yonetim.kategori.duzenle');
        Route::post('/kaydet/{id}', 'KategoriController@kaydet')->name('yonetim.kategori.kaydet');
        Route::get('/sil/{id}', 'KategoriController@sil')->name('yonetim.kategori.sil');

    });

    });
});
Route::get('/','AnasayfaController@index')->name('anasayfa');
Route::get('/kategori/{slug_kategoriadi}','KategoriController@index')->name('kategori');
Route::get('/urun/{slug_urunadi}','UrunController@index')->name('urun');

Route::get('/odeme', 'OdemeController@index')->name('odeme');
Route::post('/odemeyap', 'OdemeController@odemeyap')->name('odemeyap');

Route::group(['prefix'=>'sepet'],function () {
    Route::get('/','SepetController@index')->name('sepet');
    Route::post('/ekle','SepetController@ekle')->name('sepet.ekle');
    Route::delete('/kaldir/{rowid}','SepetController@kaldir')->name('sepet.kaldir');
    Route::delete('/bosalt','SepetController@bosalt')->name('sepet.bosalt');
    Route::patch('/guncelle/{rowid}','SepetController@guncelle')->name('sepet.guncelle');

});
Route::group(['middleware'=>'auth'],function () {

    Route::get('/siparisler', 'SiparislerController@index')->name('siparisler');//yada ->middleware('auth');
    Route::get('/siparisler/{id}', 'SiparislerController@detay')->name('siparis');
});


Route::post('/ara','UrunController@ara')->name('urun_ara');
Route::get('/ara','UrunController@ara')->name('urun_ara');


Route::group(['prefix'=>'kullanici'],function (){
    Route::get('/oturumac', 'KullaniciController@giris_form')->name('kullanici.oturumac');
    Route::post('/oturumac', 'KullaniciController@giris');
    Route::get('/kaydol', 'KullaniciController@kaydol_form')->name('kullanici.kaydol');
    Route::post('/kaydol', 'KullaniciController@kaydol')->name('kullanici.kaydol');
    Route::get('/aktiflestir/{anahtar}', 'KullaniciController@aktiflestir')->name('aktiflestir');
    Route::post('/oturumukapat','KullaniciController@oturumukapat')->name('kullanici.oturumukapat');
});

Route::get('test/mail', function(){
    $kullanici = \App\Models\Kullanici::find(1);
    return new App\Mail\KullaniciKayitMail($kullanici);
});