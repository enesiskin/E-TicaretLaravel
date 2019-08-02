<h1>{{ config('app.name') }}</h1>
<p>Merhaba {{$kullanici->adsoyad}}, kaydınız yapıldı.</p>
<p>Aktifleştirmek için <a href="{{config_path('app.url')}}/kullanici/aktiflestir/{{$kullanici->aktivasyon_anahtari}}">
        tıklayın</a>veya bağlantıyı açın.</p>
<p>{{config('app.url')}}/kullanici/aktiflestir/{{$kullanici->aktivasyon_anahtari}}</p>