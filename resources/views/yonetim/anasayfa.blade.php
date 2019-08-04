@extends('yonetim.layouts.master')
@section('title', 'Anasayfa')
@section('content')
    <h1 class="page-header">Dashboard</h1>

    <section class="row text-center placeholders">
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Bekleyen Sipariş</div>
                <div class="panel-body">
                    <h4>{{$istatistikler['bekleyen_siparis']}}</h4>
                    <p>Adet</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Tamamlanan Sipariş</div>
                <div class="panel-body">
                    <h4>{{$istatistikler['tamamlanan_siparis']}}</h4>
                    <p>Adet</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Ürün</div>
                <div class="panel-body">
                    <h4>{{$istatistikler['toplam_urun']}}</h4>
                    <p>Adet</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Kullanıcı</div>
                <div class="panel-body">
                    <h4>{{$istatistikler['toplam_kullanici']}}</h4>
                    <p>Adet</p>
                </div>
            </div>
        </div>
    </section>

    <section class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Çok Satan Ürünler</div>
                <div class="panel-body">
                    <canvas id="chartCokSatan" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Aylara Göre Satışlar</div>
                <div class="panel-body">
                    <canvas id="chartAylaraGoreSatislar" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </section>

    @endsection

@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>

        <script>
            @php
            $keys="";
            $values="";

            foreach ($cok_satan_urunler as $rapor)
            {
            $keys .="\"$rapor->urun_adi\", ";
            $values.="$rapor->adet,";
            }

            @endphp
        var ctx1 = document.getElementById('chartCokSatan');
        var chartCokSatan = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: [{!!$keys!!}],
                datasets: [{
                    label: 'Çok Satan Ürünler',
                    data: [{!!$values!!}],

                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                legend:{
                    position:'bottom',
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
  //////////////////////////////////////////////////////////
            @php
                $keys="";
                $values="";

                foreach ($aylara_gore_satislar as $rapor)
                {
                $keys .="\"$rapor->ay\", ";
                $values.="$rapor->adet,";
                }

            @endphp
            var ctx2 = document.getElementById('chartAylaraGoreSatislar');
            var chartAylaraGoreSatislar = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: [{!!$keys!!}],
                    datasets: [{
                        label: 'Aylara Göre Satılan Ürünler',
                        data: [{!!$values!!}],

                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    legend:{
                        position:'bottom'

                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
    </script>
@endsection
