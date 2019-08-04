<div class="list-group">
    <a href="{{route('yonetim.anasayfa')}}" class="list-group-item">
        <span class="fa fa-fw fa-dashboard"></span> Giriş</a>
    <a href="{{route('yonetim.urun')}}" class="list-group-item">
        <span class="fa fa-fw fa-cubes"></span> Ürünler
        <span class="badge badge-dark badge-pill pull-right">{{$istatistikler['toplam_urun']}}</span>
    </a>
    <a href="{{route('yonetim.kategori')}}" class="list-group-item collapsed" data-target="#submenu1" data-toggle="collapse" data-parent="#sidebar">
        <span class="fa fa-fw fa-bars"></span> Kategoriler<span class="badge badge-dark badge-pill">{{$istatistikler['toplam_kategori']}}</span>
        <!--<span class="caret arrow pull-right"></span></a>
    <div class="list-group collapse" id="submenu1">
        <a href="#" class="list-group-item">Category</a>
        <a href="#" class="list-group-item">Category</a>
    </div>-->
    <a href="{{route('yonetim.kullanici')}}" class="list-group-item">
        <span class="fa fa-fw fa-users"></span> Kullanıcılar
        <span class="badge badge-dark badge-pill pull-right">{{$istatistikler['toplam_kullanici']}}</span>
    </a>
    <a href="{{route('yonetim.siparis')}}" class="list-group-item">
        <span class="fa fa-fw fa-shopping-basket"></span> Siparisler
        <span class="badge badge-dark badge-pill pull-right">{{$istatistikler['bekleyen_siparis']}}</span>
    </a>
</div>