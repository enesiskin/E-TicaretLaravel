<?php

use Illuminate\Database\Seeder;
use App\Kullanici;
use App\Models\KullaniciDetay;

class KullaniciTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker\Generator $faker)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //Model Yapısı ile kodlama
        Kullanici::truncate();
        KullaniciDetay::truncate();

        $kullanici_yonetici = Kullanici::create([
            'adsoyad' => 'Enes Işkın',
            'email' => 'enes@gmail.com',
            'sifre' =>bcrypt('123456'),
            'aktif_mi' =>1,
            'yonetici_mi'=>1
        ]);
        $kullanici_yonetici->detay()->create([
            'adres' =>'Üsküdar',
            'telefon' => '(555) 555 55 55',
            'ceptelefonu' => '(216) 216 16 16'
        ]);

        for ($i=0; $i<50; $i++){
            $kullanici_musteri = Kullanici::create([
                'adsoyad' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'sifre' =>bcrypt('123456'),
                'aktif_mi' =>1,
                'yonetici_mi'=>0

            ]);
            $kullanici_musteri->detay()->create([
                'adres' =>$faker->address,
                'telefon' => $faker->e164PhoneNumber,
                'ceptelefonu' => $faker->e164PhoneNumber
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
