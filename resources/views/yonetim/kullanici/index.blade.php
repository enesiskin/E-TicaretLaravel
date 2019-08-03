@extends('yonetim.layouts.master')
@section('title', 'Kullanıcı Yönetimi')
@section('content')
    <h1 class="page-header">Kullanıcı Yönetimi</h1>
    <br>
    <h2 class="sub-header"> Kullanıcı Listesi </h2>
        <div class="well">
            <div class="btn-group pull-right">
                <a href="{{route('yonetim.kullanici.yeni')}}" class="btn btn-primary">Yeni</a>
            </div>
            <form action="{{route('yonetim.kullanici')}}" method="post" class="form-inline">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="aranan">Ara</label>
                    <input type="text" class="form-control form-control-sm" name="aranan" id="aranan"
                    placeholder="Ad yada E-mail Ara..." value="{{old('aranan')}}">
                </div>
                <button type="submit" class="btn btn-primary">Ara</button>
                <a href="{{route('yonetim.kullanici')}}" class="btn btn-primary">Temizle</a>
            </form>
        </div>

    @include('layout.partials.alert')
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Ad Soyad</th>
                <th>Email</th>
                <th>Aktiflik</th>
                <th>Yöneticilik</th>
                <th>Kayıt Tarihi</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @if(count($list)==0)
                <tr><td colspan="7" class="text-center">Kayıt bulunamadı.</td></tr>
            @endif
            @foreach($list as $enrty)
            <tr>
                <td>{{$enrty->id}}</td>
                <td>{{$enrty->adsoyad}}</td>
                <td>{{$enrty->email}}</td>
                <td>
                @if($enrty->aktif_mi)
                    <span class="label label-success">Aktif</span>
                @else
                    <span class="label label-danger">Pasif</span>

                @endif
                </td>
                <td>
                @if($enrty->yonetici_mi)
                    <span class="label label-success">Yönetici</span>
                @else
                    <span class="label label-danger">Kullanıcı</span>

                    @endif
                </td>

                    <td>{{$enrty->olusturma_tarihi}}</td>


                <td style="width: 100px">
                    <a href="{{route('yonetim.kullanici.duzenle', $enrty->id)}}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                        <span class="fa fa-pencil"></span>
                    </a>
                    <a href="{{route('yonetim.kullanici.sil', $enrty->id)}}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Emin misiniz?')">
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