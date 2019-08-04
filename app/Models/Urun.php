<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Urun extends Model
{
    use SoftDeletes;
    protected $table="urun";
    //  protected  $fillable= ['kategori_adi','slug']; doldurulabilir alanlar
    protected  $guarded = []; // veritabanına eklenmesini istemediğimiz column,boş bırakırsak tüm columnlar eklenilebilir hala gelir
    const  UPDATED_AT = "guncelleme_tarihi";
    const  CREATED_AT = "olusturma_tarihi"; // değiştirilemez global değişken
    const  DELETED_AT = "silinme_tarihi";

    public function kategoriler(){ //bir ürüne ait kategoriler çekilir
        return $this->belongsToMany('App\Models\Kategori', 'kategori_urun');
    }

    public function detay(){ // ürüne ait detay bilgisi çekmek için

        return $this->hasOne('App\Models\UrunDetay')->withDefault();
    }
}
