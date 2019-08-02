<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use SoftDeletes;
    protected $table="kategori";
    //  protected  $fillable= ['kategori_adi','slug']; doldurulabilir alanlar
    protected  $guarded = []; // veritabanına eklenmesini istemediğimiz columnboş bırakırsak tüm columnlar eklenilebilir
    const  CREATED_AT = "olusturma_tarihi"; // değiştirilemez global değişken
    const  UPDATED_AT = "guncelleme_tarihi";
    const  DELETED_AT = "silinme_tarihi";

    public function urunler(){ //bir kategoriye ait ürünler çekilir
        return $this->belongsToMany('App\Models\Urun', 'kategori_urun');
    }
}
