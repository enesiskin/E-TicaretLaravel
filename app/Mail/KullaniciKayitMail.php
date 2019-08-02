<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Kullanici;

class KullaniciKayitMail extends Mailable
{
    use Queueable, SerializesModels;
    public $kullanici;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Kullanici $kullanici) //mail içerisinde kullanıcalak değişkenleri buraya ekliyoruz
    {
        $this->kullanici = $kullanici; // Kullanıcıkayıtan gelen kullanıcı bilgisini global  olarak kullanmamıza yarar
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('enes.170@hotmail.com') // bunları burada tanımlamak yerine mail.phpde tanımladık
            ->subject(config('app.name') . '-Kullanıcı Kaydı') // config ile uygulamanının adını aldık konu yerine
            ->view('mails.kullanici_kayit');  //mail içeriği ayarlama yeri viewdan almak için tanımlama yaptık
    }
}
