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

Route::get('/','AnasayfaController@index')->name('anasayfa');
Route::get('/kategori/{slug_kategoriadi}','KategoriController@index')->name('kategori');
Route::get('/urun/{slug_urunadi}','UrunController@index')->name('urun');
Route::get('/sepet','SepetController@index')->name('sepet');
Route::group(['middleware'=>'auth'],function () {
    Route::get('/odeme', 'OdemeController@index')->name('odeme'); //yada ->middleware('auth');
    Route::get('/siparisler', 'SiparislerController@index')->name('siparisler');
    Route::get('/siparisler/{id}', 'SiparislerController@detay')->name('siparisdetay');
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