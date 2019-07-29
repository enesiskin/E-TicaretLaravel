<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table="kategori";
    //  protected  $fillable= ['kategori_adi','slug']; doldurulabilir alanlar
    protected  $guarded = []; // veritabnına eklenmesini istemediğimiz column
    const  CREATED_AT = "olusturma_tarihi"; // değiştirilemez global değişken, boş bırakırsak tüm columnlar eklenilebilir hala gelir
    const  UPDATED_AT = "guncelleme_tarihi";
}
