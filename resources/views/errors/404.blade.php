@extends('layout.partials.master')
@section('content')
    <div class="container">
        <div class="jumbotron text-center">
            <h1>404</h1>
            <h2>Aradığınız sayfa bulunamamaktadır.</h2>
            <a href="{{route('anasayfa')}}" class="btn btn-primary">Anasayfaya Dön</a>
        </div>

    </div>

    @endsection