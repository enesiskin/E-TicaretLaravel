@extends('yonetim.layouts.master')
@section('title', 'Kategori Yönetimi')
@section('content')
    <h1 class="page-header">Kategori Yönetimi</h1>
    <br>
    <h2 class="sub-header">Kategori  Listesi </h2>
    @include('layout.partials.alert')
        <div class="well">
            <div class="btn-group pull-right">
                <a href="{{route('yonetim.kategori.yeni')}}" class="btn btn-primary">Yeni</a>
            </div>
            <form action="{{route('yonetim.kategori')}}" method="post" class="form-inline">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="aranan">Ara</label>
                    <input type="text" class="form-control form-control-sm" name="aranan" id="aranan"
                    placeholder="Kategori Ara..." value="{{old('aranan')}}">

                    <label for="ust_id">Üst Kategori</label>
                    <select name="ust_id" id="ust_id">
                        <option value="">Seçiniz</option>
                        @foreach($anakategoriler as $kategori)
                            <option value="{{$kategori->id}}" {{old('ust_id') == $kategori->id ? 'selected' : ''}}>
                                {{$kategori->kategori_adi}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Ara</button>
                <a href="{{route('yonetim.kategori')}}" class="btn btn-primary">Temizle</a>
            </form>
        </div>


    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Üst Kategori</th>
                <th>Kategori Adı</th>
                <th>Slug</th>
                <th>Kayıt Tarihi</th>

                <th></th>
            </tr>
            </thead>
            <tbody>
            @if(count($list)==0)
                <tr><td colspan="6" class="text-center">Kayıt bulunamadı.</td></tr>
                @endif
            @foreach($list as $enrty)
            <tr>
                <td>{{$enrty->id}}</td>
                <td>{{$enrty->ust_kategori->kategori_adi}}</td>
                <td>{{$enrty->kategori_adi}}</td>
                <td>{{$enrty->slug}}</td>
                <td>{{$enrty->olusturma_tarihi}}</td>




                <td style="width: 100px">
                    <a href="{{route('yonetim.kategori.duzenle', $enrty->id)}}" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Düzenle">
                        <span class="fa fa-pencil"></span>
                    </a>
                    <a href="{{route('yonetim.kategori.sil', $enrty->id)}}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Sil" onclick="return confirm('Emin misiniz?')">
                        <span class="fa fa-trash"></span>
                    </a>
                </td>
            </tr>
                @endforeach
            </tbody>
        </table>
        {{$list->links()}}
    </div>
    @endsection