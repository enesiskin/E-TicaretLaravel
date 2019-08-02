<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siparis extends Model
{
    use softDeletes;
    protected $table='siparis';

    protected $fillable=['sepet_id','siparis_tutari','banka',
                         'adres','telefon','ceptelefonu',
                         'adsoyad','taksit_sayisi','durum'];

    const  UPDATED_AT = "guncelleme_tarihi";
    const  CREATED_AT = "olusturma_tarihi"; // değiştirilemez global değişken
    const  DELETED_AT = "silinme_tarihi";

    public function sepet(){
        return $this->belongsTo('App\Models\Sepet');
    }
}
