<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Kullanici extends Authenticatable
{
    use SoftDeletes;
    protected $table='kullanici';
    //protected $guarded=[];
    protected $fillable = ['adsoyad', 'email', 'sifre','aktivasyon_anahtari','aktif_mi'];
    protected $hidden = ['sifre','aktivasyon_anahtari'];
    const  UPDATED_AT = "guncelleme_tarihi";
    const  CREATED_AT = "olusturma_tarihi"; // değiştirilemez global değişken
    const  DELETED_AT = "silinme_tarihi";

    public  function  getAuthPassword()
    {
        return $this->sifre ;
    }
}
