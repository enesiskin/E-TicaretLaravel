@extends('yonetim.layouts.master')
@section('title', 'Ürün Yönetimi')
@section('content')
    <h1 class="page-header">Ürün Yönetimi</h1>
    <br>
    <h2 class="sub-header"> Ürün Listesi </h2>
    <div class="well">
        <div class="btn-group pull-right">
            <a href="{{route('yonetim.urun.yeni')}}" class="btn btn-primary">Yeni</a>
        </div>
        <form action="{{route('yonetim.urun')}}" method="post" class="form-inline">
            {{csrf_field()}}
            <div class="form-group">
                <label for="aranan">Ara</label>
                <input type="text" class="form-control form-control-sm" name="aranan" id="aranan"
                       placeholder="Ürün Ara..." value="{{old('aranan')}}">
            </div>
            <button type="submit" class="btn btn-primary">Ara</button>
            <a href="{{route('yonetim.urun')}}" class="btn btn-primary">Temizle</a>
        </form>
    </div>

    @include('layout.partials.alert')
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Resim</th>
                <th>Ürün Adı</th>
                <th>Slug</th>
                <th>Fiyatı</th>
                <th>Kayıt Tarihi</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @if(count($list)==0)
                <tr><td colspan="7" class="text-center">Kayıt bulunamadı.</td></tr>
            @endif
            @foreach($list as $entry)
                <tr>
                    <td>{{$entry->id}}</td>
                    <td><img src="{{$entry->detay->urun_resmi !=null ?
                            asset('/uploads/urunler/'.$entry->detay->urun_resmi)
                            :'https://via.placeholder.com/120x120'}}" style="width: 120px;" alt="Resim"></td>
                    <td>{{$entry->urun_adi}}</td>
                    <td>{{$entry->slug}}</td>
                    <td>{{$entry->fiyati}}</td>
                    <td>{{$entry->olusturma_tarihi}}</td>


                    <td style="width: 100px">
                        <a href="{{route('yonetim.urun.duzenle', $entry->id)}}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                            <span class="fa fa-pencil"></span>
                        </a>
                        <a href="{{route('yonetim.urun.sil', $entry->id)}}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Emin misiniz?')">
                            <span class="fa fa-trash"></span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$list->appends('aranan', old('aranan'))->links()}}
    </div>
@endsection