<?php

use Illuminate\Database\Seeder;

class KategoriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Query Builder Yapısı ile kodlama
        DB::table('kategori')->truncate(); //çalıştığında tabloyu temizler
        $id = DB::table('kategori')->insertGetId(['kategori_adi'=> 'Elektronik','slug'=>'elektronik']);
        DB::table('kategori')->insert(['kategori_adi'=> 'Bilgisayar','slug'=>'bilgisayar', 'ust_id'=>$id]);
        DB::table('kategori')->insert(['kategori_adi'=> 'Televizyon','slug'=>'televizyon', 'ust_id'=>$id]);
        DB::table('kategori')->insert(['kategori_adi'=> 'Telefon','slug'=>'telefon', 'ust_id'=>$id]);

        $id = DB::table('kategori')->insertGetId(['kategori_adi'=> 'Kitap','slug'=>'kitap']);
        DB::table('kategori')->insert(['kategori_adi'=> 'Tarih','slug'=>'tarih', 'ust_id'=>$id]);
        DB::table('kategori')->insert(['kategori_adi'=> 'Kişisel Gelişim','slug'=>'kişisel-gelişim', 'ust_id'=>$id]);
        DB::table('kategori')->insert(['kategori_adi'=> 'Roman','slug'=>'roman', 'ust_id'=>$id]);
        DB::table('kategori')->insert(['kategori_adi'=> 'Dergi','slug'=>'dergi']);
        DB::table('kategori')->insert(['kategori_adi'=> 'Kozmetik','slug'=>'kozmetik']);
        DB::table('kategori')->insert(['kategori_adi'=> 'Mobilya','slug'=>'mobilya']);
        DB::table('kategori')->insert(['kategori_adi'=> 'Beyaz Eşya','slug'=>'beyaz-eşya']);
        DB::table('kategori')->insert(['kategori_adi'=> 'Giyim ve Moda','slug'=>'giyim-moda']);
        DB::table('kategori')->insert(['kategori_adi'=> 'Bahçe','slug'=>'bahçe']);
    }
}
