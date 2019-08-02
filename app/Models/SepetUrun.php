<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SepetUrun extends Model
{
    use SoftDeletes;
    protected $table='sepet_urun';
    protected $guarded=[];
    const  UPDATED_AT = "guncelleme_tarihi";
    const  CREATED_AT = "olusturma_tarihi"; // değiştirilemez global değişken
    const  DELETED_AT = "silinme_tarihi";

    // composer require gloudemans/shoppingcart kullanılmıştır.
    //php artisan vendor:publish --provider="Gloudemans\Shoppingcart\ShoppingcartServiceProvider" --tag="config"
    // kendi config dosyasıyla geldiği için projeye bu config dosyasını eklememize yarıyor

    public function urun(){ // detay bilgisine ait urun çekmek için

        return $this->belongsTo('App\Models\Urun');
    }

}
