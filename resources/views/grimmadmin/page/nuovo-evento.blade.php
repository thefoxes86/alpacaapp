@extends('grimmadmin.layouts.defaultAdmin')
@section('title', 'Evento')

@section('content')

<message-alert></message-alert>


<div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Evento</li>
          </ul>
        </div>
      </div>
      <section class="forms">
        <div class="container-fluid">
          <header> 
            <h1 class="h3 display">Evento</h1>
          </header>
          <div class="row">
            <div class="col-lg-8">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h2 class="h5 display display">Evento</h2>
                </div>
                
                <div class="card-body">
                  @if (isset($evento))
                    <form-nuovo-evento :Lerrors="{{$errors}}" :evento="{{$evento}}" :tastomodifica="true"></form-nuovo-evento>   
                  @else
                    <form-nuovo-evento :Lerrors="{{$errors}}"></form-nuovo-evento>   
                  @endif
                </div>
              </div>
            </div>
            <div class="col-lg-4">

              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h2 class="h5 display">Immagine Principale</h2>
                </div>
                <div class="card-body">
                 @if (isset($evento))
                  <file-upload :url="'/grimmadmin/uploadFotoEvento'" :immagine="'{{$evento->immagine}}'"></file-upload>
                  @else
                  <file-upload :url="'/grimmadmin/uploadFotoEvento'"></file-upload>
                  @endif
                </div>
              </div>
            </div>
           </div>
        </div>
    </section>

@endsection

@section('footer')
<script>
  window.sideBarApp.menuActive = [false,
  false,false,false,
  false,false,false,
  false,false,false,
  false,false,false,
  true,true,false,
  false,false,false];
  window.sideBarApp.openMenu('pages-nav-list-5');
</script>
@endsection