@extends('yonetim.layouts.master')
@section('title', 'Sipariş Yönetimi')
@section('content')
    <h1 class="page-header">Sipariş Yönetimi</h1>
    <br>
    <h2 class="sub-header"> Sipariş Listesi </h2>
    <div class="well">

        <form action="{{route('yonetim.siparis')}}" method="post" class="form-inline">
            {{csrf_field()}}
            <div class="form-group">
                <label for="aranan">Ara</label>
                <input type="text" class="form-control form-control-sm" name="aranan" id="aranan"
                       placeholder="Sipariş yada Banka Ara..." value="{{old('aranan')}}">
            </div>
            <button type="submit" class="btn btn-primary">Ara</button>
            <a href="{{route('yonetim.siparis')}}" class="btn btn-primary">Temizle</a>
        </form>
    </div>

    @include('layout.partials.alert')
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>Sipariş Kodu</th>
                <th>Kullanıcı Adı</th>
                <th>Tutar</th>
                <th>Durum</th>
                <th>Sipariş Tarihi</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @if(count($list)==0)
                <tr><td colspan="7" class="text-center">Kayıt bulunamadı.</td></tr>
            @endif
            @foreach($list as $entry)
                <tr>
                    <td>SP-{{$entry->id}}</td>
                    <td>{{$entry->adsoyad}}</td>
                    <td>{{$entry->siparis_tutari * ((100+config('cart_tax'))/100)}}</td>
                    <td>{{$entry->durum}}</td>
                    <td>{{$entry->olusturma_tarihi}}</td>


                    <td style="width: 100px">
                        <a href="{{route('yonetim.siparis.duzenle', $entry->id)}}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                            <span class="fa fa-pencil"></span>
                        </a>
                        <a href="{{route('yonetim.siparis.sil', $entry->id)}}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Emin misiniz?')">
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