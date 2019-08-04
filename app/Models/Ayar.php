<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ayar extends Model
{
    protected $table='ayar';
    public $timestamps= false;
    protected  $fillable=['anahtar','deger'];
}
/* foreach (Ayar::all() as $ayar){
        \Config::set('ayar.', $ayar->anahtar, $ayar->deger);
    }
}  config ve ayarı namespaces e yazarak helperstaki aynı işi yapar cache almaz*/
