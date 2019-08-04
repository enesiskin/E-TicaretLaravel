<?php

namespace App\Providers;

use App\Models\Kategori;
use App\Models\Urun;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Siparis;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Kullanici;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Schema::defaultStingLength(191);
/*
        $bitisZamani = now()->addMinute(10);
        $istatistikler=Cache::remember('istatistikler',$bitisZamani, function (){
            return[
                'bekleyensiparis'=> Siparis::where('durum','Siparişiniz alındı.')->count()
            ];
        });
        View::share('istatistikler',$istatistikler);*/

        View::composer(['yonetim.*'],function($view){
            $bitisZamani = now()->addMinute(10);
            $istatistikler=Cache::remember('istatistikler',$bitisZamani, function (){
                return[
                    'bekleyen_siparis'=> Siparis::where('durum','Siparişiniz alındı.')->count(),
                    'tamamlanan_siparis'=> Siparis::where('durum','Sipariş tamamlandı.')->count(),
                    'toplam_urun' => Urun::count(),
                    'toplam_kategori' => Kategori::count(),
                    'toplam_kullanici' => Kullanici::count()
                ];
            });
            $view->with('istatistikler',$istatistikler);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
