@extends ('layout.partials.master')
@section ('title','Sipariş Detay')
@section('content')
    <div class="container">
        <div class="bg-content">
            <a href="{{route('siparisler')}}" class="btn  btn-primary btn-sm">
                <i class="glyphicon glyphicon-arrow-left"></i> Siparişlere Dön
            </a>
            <h2>Sipariş (SP-{{$siparis->id}})</h2>
            <table class="table table-bordererd table-hover">
                <tr>
                    <th colspan="2">Ürün</th>
                    <th>Tutar</th>
                    <th>Adet</th>
                    <th>Ara Toplam</th>
                    <th>Durum</th>
                </tr>
                @foreach($siparis->sepet->sepet_urunler as $sepet_urun)
                <tr>
                    <td style="width: 120px;">
                        <a href="{{route('urun', $sepet_urun->urun->slug)}}">
                            <img src="{{$sepet_urun->urun->detay->urun_resmi !=null ?
                            asset('/uploads/urunler/'.$sepet_urun->urun->detay->urun_resmi)
                            :'https://via.placeholder.com/120x100'}}" style="width: 120px;">
                        </a>
                    </td>
                    <td><a href="{{route('urun', $sepet_urun->urun->slug)}}">
                        {{$sepet_urun->urun->urun_adi}}</a></td>
                    <td>{{$sepet_urun->fiyati}}</td>
                    <td>{{$sepet_urun->adet}}</td>
                    <td>{{$sepet_urun->fiyati * $sepet_urun->adet}} </td>
                    <td>{{$sepet_urun->durum}}</td>
                </tr>
                @endforeach
                <tr>

                    <th colspan="5" class="text-right">Toplam Tutar</th>
                    <td  >{{$siparis->siparis_tutari}} TL</td>

                </tr>
                <tr>

                    <th colspan="5" class="text-right">Toplam Tutar (KDV'li)</th>
                    <td>{{$siparis-> siparis_tutari * (100+config('cart.tax'))/100}} TL</td>

                </tr>
                <tr>

                    <th colspan="5" class="text-right">Sipariş Durumu</th>
                    <td>{{$siparis->durum}}</td>
                </tr>

            </table>
        </div>
    </div>

@endsection
