@extends('grimmadmin.layouts.defaultAdmin')
@section('title', 'Titolo')

@section('head')
@endsection

@section('content')

<message-alert></message-alert>



<div class="breadcrumb-holder">
  <div class="container-fluid">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
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
            @if ($allevamento)
            <form-nuovo-allevamento :Lerrors="{{$errors}}" :allevamento="{{$allevamento}}" :tastomodifica="true"></form-nuovo-allevamento>   
            @else
            <form-nuovo-allevamento :Lerrors="{{$errors}}"></form-nuovo-allevamento>   
            @endif
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="row">
          <div class="card col-12">
            <div class="card-header d-flex align-items-top">
              <h2 class="h5 display">Immagini</h2>
            </div>
            <div class="card-body">
              @if ($allevamento)
              <file-upload :url="'/grimmadmin/uploadAllevamentoFoto'" :immagine="'{{$allevamento->logo}}'"></file-upload>
              @else
              <file-upload :url="'/grimmadmin/uploadAllevamentoFoto'"></file-upload>
              @endif
            </div>
          </div>
        </div>
        <div class="row">
          @if ($allevamento)
            @if($allevamento->galleria)
            <grimm-gallery :uploadto="'/grimmadmin/uplaodAllevamntoGalleria'" 
            :folder="'allevamenti'" 
            :preload="{{$allevamento->galleria}}" 
            :cancelfrom="'/grimmadmin/cancellaAllevamntoGalleria'" 
            :id="{{$allevamento->id}}"></grimm-gallery>
            @else
            <grimm-gallery :uploadto="'/grimmadmin/uplaodAllevamntoGalleria'" 
            :folder="'allevamenti'" 
            :cancelfrom="'/grimmadmin/cancellaAllevamntoGalleria'" 
            :id="{{$allevamento->id}}"></grimm-gallery>
            @endif
          @else
          <grimm-gallery :uploadto="'/grimmadmin/uplaodAllevamntoGalleria'" 
          :cancelfrom="'/grimmadmin/cancellaAllevamntoGalleria'" 
          :folder="'allevamenti'"></grimm-gallery>
          @endif
        </div>
      </div>

    </div>
  </section>

  @endsection
  @section('footer')
<script>
  window.sideBarApp.menuActive = [false,false,false,false,true,true,false,false,false,false,false,false,false,false,false,false,false,false];
  window.sideBarApp.openMenu('pages-nav-list-2');
</script>
@endsection