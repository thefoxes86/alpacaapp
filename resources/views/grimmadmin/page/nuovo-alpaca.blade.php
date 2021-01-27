@extends('grimmadmin.layouts.defaultAdmin')
@section('head')

@endsection
@section('title', 'Titolo')

@section('content')

<message-alert></message-alert>



<div class="breadcrumb-holder">
  <div class="container-fluid">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Home</a></li>
      <li class="breadcrumb-item active">Titolo</li>
    </ul>
  </div>
</div>
<section class="forms">
  <div class="container-fluid">
    <header> 
      <h1 class="h3 display">Titolo</h1>
    </header>
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header d-flex align-items-center">
            <h2 class="h5 display display">Titolo</h2>
          </div>
          <div class="card-body">
            @if ($alpaca)
            <form-nuovo-alpaca :tipologie="{{$tipologie}}" :colori="{{$colori}}" :Lerrors="{{$errors}}" :alpaca="{{$alpaca}}" :tastomodifica="true"></form-nuovo-alpaca>
            @else
            <form-nuovo-alpaca :tipologie="{{$tipologie}}" :colori="{{$colori}}" :Lerrors="{{$errors}}"></form-nuovo-alpaca>
            @endif
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="row">
          <div class="card col-12">
            <div class="card-header d-flex align-items-center">
              <h2 class="h5 display">Immagine Profilo</h2>
            </div>
            <div class="card-body">
              @if ($alpaca)
              <file-upload :url="'/grimmadmin/uploadAlpacaFoto'" :immagine="'{{$alpaca->immagine}}'"></file-upload>
              @else
              <file-upload :url="'/grimmadmin/uploadAlpacaFoto'"></file-upload>
              @endif
            </div>
          </div>
        </div>
        <div class="row">
          @if ($alpaca)
            @if($alpaca->galleria)
            <grimm-gallery :uploadto="'/grimmadmin/uplaodAlpacaGalleria'" 
            :folder="'alpaca'" 
            :preload="{{$alpaca->galleria}}" 
            :cancelfrom="'/grimmadmin/cancellaAlpacaGalleria'" 
            :id="{{$alpaca->id}}"></grimm-gallery>
            @else
            <grimm-gallery :uploadto="'/grimmadmin/uplaodAlpacaGalleria'" 
            :folder="'alpaca'" 
            :cancelfrom="'/grimmadmin/cancellaAlpacaGalleria'" 
            :id="{{$alpaca->id}}"></grimm-gallery>
            @endif
          @else
          <grimm-gallery :uploadto="'/grimmadmin/uplaodAlpacaGalleria'" 
          :cancelfrom="'/grimmadmin/cancellaAlpacaGalleria'" 
          :folder="'alpaca'"></grimm-gallery>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
@section('footer')
<script>

  window.sideBarApp.menuActive = [false,true,true,false,false,false,false,false,false,false,false,false,false,false,false,false,false,false];
  window.sideBarApp.openMenu('pages-nav-list-1');

</script>
@endsection