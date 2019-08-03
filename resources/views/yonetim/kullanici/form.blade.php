@extends('yonetim.layouts.master')
@section('title', 'Kullanıcı Yönetimi')
@section('content')
    <h1 class="page-header">Kullanıcı Yönetimi</h1>

    <form method="post" action="{{route('yonetim.kullanici.kaydet', @$entry->id)}}">
        {{csrf_field()}}
        <div class="pull-right">
        <button type="submit" class="btn btn-primary">
            {{@$entry->id > 0 ? 'Güncelle' : 'Kaydet'}}
        </button>
        </div>
        <h2 class="sub-header">Kullanıcı {{@$entry->id > 0 ? 'Güncelleme' : 'Kayıt'}} Formu</h2>
        @include('layout.partials.errors')

        <div class="row">
            @include('layout.partials.alert')
            <div class="col-md-6">
                <div class="form-group">
                    <label for="adsoyad">Ad Soyad</label>
                    <input type="text" class="form-control" id="adsoyad" name="adsoyad" placeholder="Ad Soyad" value="{{
                    old('adsoyad',$entry->adsoyad)}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{
                    old('email',$entry->email)}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sifre">Şifre</label>
                    <input type="password" class="form-control" id="sifre" name="sifre" placeholder="Şifre"  >
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="adres">Adres</label>
                    <input type="text" class="form-control" id="adres" placeholder="Adres" name="adres" value="{{
                    old('adres',$entry->adres)}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="telefon">Telefon</label>
                    <input type="text" class="form-control" id="telefon" placeholder="Telefon" name="telefon" value="{{
                    old('telefon',$entry->telefon)}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="ceptelefonu">Cep Telefonu</label>
                    <input type="text" class="form-control" id="ceptelefonu" placeholder="Cep Telefonu" name="ceptelefonu" value="{{
                    old('ceptelefonu',$entry->ceptelefonu)}}">
                </div>
            </div>
        </div>
        <div class="checkbox">
            <label>
                <input type="hidden" name="aktif_mi" value="0">
                <input type="checkbox" name="aktif_mi" value="1" {{old('aktif_mi',$entry->aktif_mi ? 'checked' : '')}}> Aktif mi?
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="hidden" name="aktif_mi" value="0">
                <input type="checkbox" name="yonetici_mi" value="1" {{old('yonetici_mi',$entry->yonetici_mi ? 'checked' : '')}}> Yönetici mi?
            </label>
        </div>

    </form>
@endsection
<!-- <div class="form-group">
    <label for="exampleInputFile">File input</label>
    <input type="file" id="exampleInputFile">
    <p class="help-block">Example block-level help text here.</p>
</div>  -->