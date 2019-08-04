@extends('yonetim.layouts.master')
@section('title', 'Ürün Yönetimi')
@section('content')
    @section('head')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
        @endsection
    <h1 class="page-header">Ürün Yönetimi</h1>

    <form method="post" action="{{route('yonetim.urun.kaydet', @$entry->id)}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="pull-right">
            <button type="submit" class="btn btn-primary">
                {{$entry->id > 0 ? 'Güncelle' : 'Kaydet'}}
            </button>
        </div>
        <h2 class="sub-header">Ürün {{$entry->id > 0 ? 'Güncelleme' : 'Kayıt'}} Formu</h2>
        @include('layout.partials.errors')
        @include('layout.partials.alert')
    <!-- RESİM YÜKLEME -->

        @if($entry->detay->urun_resmi!=null)
            <img src="/uploads/urunler/{{$entry->detay->urun_resmi}}" alt="{{$entry->detay->urun_resmi}}"
            style="height: 100px; margin-right: 20px;" class="thumbnail pull-left">
        @endif
        <div class="form-group">
            <label for="urun_resmi">Ürün Resmi</label>
            <input type="file" id="urun_resmi" name="urun_resmi" >
        </div>
        <!-- RESİM YÜKLEME -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="urun_adi">Ürün Adı</label>
                    <input type="text" class="form-control" id="urun_adi" name="urun_adi" placeholder="Ürün Adı" value="{{
                    old('urun_adi',$entry->urun_adi)}}">
                </div>
            </div>
        </div>
        <div class="row">
               <div class="col-md-6">
                   <div class="form-group">
                       <label for="slug">Slug</label>
                       <input type="hidden" name="orijinal_slug" value="{{
                    old('slug',$entry->slug)}}">
                       <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug" value="{{
                    old('slug',$entry->slug)}}">
                   </div>
               </div>
           </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="aciklama">Açıklama</label>
                    <textarea class="form-control" id="aciklama" name="aciklama" placeholder="Ürün Açıklaması">{{
                    old('aciklama',$entry->aciklama)}} </textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fiyati">Ürün Fiyatı</label>
                    <input type="text" class="form-control" id="fiyati" placeholder="Fiyat" name="fiyati" value="{{
                    old('fiyati',$entry->fiyati)}}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="kategoriler">Kategoriler</label>
                    <!--MULTİPLE SEÇİMLERİ ALMAK İÇİN NAME DİZİ YAPTIK -->
                    <select name="kategoriler[]" id="kategoriler" multiple class="form-control">
                        @foreach($kategoriler as $kategori)
                            <option value="{{$kategori->id}}"
                            {{collect(old('kategoriler',$urun_kategoriler))->contains($kategori->id) ? 'selected' : ''}}
                            >{{$kategori->kategori_adi}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <hr>
        <div class="checkbox">
            <label>
                <input type="hidden" name="goster_slider" value="0">
                <input type="checkbox" name="goster_slider" value="1" {{old('goster_slider',$entry->detay->goster_slider) ? 'checked' : ''}}> Sliderda Göster
            </label>
            <label>
                <input type="hidden" name="goster_gunun_firsati" value="0">
                <input type="checkbox" name="goster_gunun_firsati" value="1" {{
                old('goster_gunun_firsati',$entry->detay->goster_gunun_firsati) ? 'checked' : ''}}> Günün Fırsatında Göster
            </label>
            <label>
                <input type="hidden" name="goster_one_cikan" value="0">
                <input type="checkbox" name="goster_one_cikan" value="1" {{old('goster_one_cikan',$entry->detay->goster_one_cikan) ? 'checked' : ''}}> Öne Çıkanlarda Göster
            </label>
            <label>
                <input type="hidden" name="goster_cok_satan" value="0">
                <input type="checkbox" name="goster_cok_satan" value="1" {{old('goster_cok_satan',$entry->detay->goster_cok_satan) ? 'checked' : ''}}> Çok Satanlarda Göster
            </label>
            <label>
                <input type="hidden" name="goster_indirimli" value="0">
                <input type="checkbox" name="goster_indirimli" value="1" {{old('goster_indirimli',$entry->detay->goster_indirimli) ? 'checked' : ''}}> İndirimli Ürünlerde Göster
            </label>
        </div>


    </form>

@section('footer')
<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<script>
    $(function () {
        $('#kategoriler').select2({
            placeholder: 'Kategori seçiniz.'
        });

        var options={
            uiColor:'#2F4583',
            language: 'tr'
            //extractPlugins: autogrow//
        };
        CKEDITOR.replace('aciklama',options);
    });

</script>
        @endsection
@endsection
<!-- <div class="form-group">
    <label for="exampleInputFile">File input</label>
    <input type="file" id="exampleInputFile">
    <p class="help-block">Example block-level help text here.</p>
</div>  -->