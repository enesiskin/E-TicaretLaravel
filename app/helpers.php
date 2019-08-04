<?php
use App\Models\Ayar;
use Illuminate\Support\Facades\Cache;

 if (!function_exists('get_ayar')){
     function get_ayar($anahtar){

         $tumAyarlar =Cache::rememberForever('tumAyarlar', function (){
             return Ayar::all();
         });

         return $tumAyarlar->where('anahtar', $anahtar)->first()->deger;
     }
 }