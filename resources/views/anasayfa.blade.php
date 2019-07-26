<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>E-Ticaret Projesi</title>


    </head>
    <body>

    @if($isim == 'Enes')
        Hoşgeldin {{$isim. ' '.$soyisim}}
        @else
        Sen kimsin?
    @endif
        <hr>
    @for($i=0;$i<=10;$i++)
        Döngü Değeri: {{$i}}
    @endfor
        <hr>
    @php
    $i=0
    @endphp
    @while($i<=10)
        Döngü Değeri: {{$i}} <br>
        @php
        $i++;
        @endphp
    @endwhile
        <hr>
    @foreach($isimler as $isim)
        {{$isim.($isim!==end($isimler)? ',' : '')}}
    @endforeach

    {{--Yorum Satırı CTRL + /--}}

    <br>
    @php
    $html = "<b>Test</b>";
    @endphp

    {!! $html !!}


    </body>
</html>
