@extends('grimmadmin.layouts.defaultAdmin')
@section('title', 'Titolo')

@section('content')

<message-alert></message-alert>



<div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="/grimmadmin">Home</a></li>
            <li class="breadcrumb-item active">Opzioni</li>
          </ul>
        </div>
      </div>
      <section class="forms">
        <div class="container-fluid">
          <header> 
            <h1 class="h3 display">Opzioni Admin</h1>
          </header>
          <div class="row">
            <div class="col-12">
              <form-nuova-opzione :nomeopzione="'Colore'" 
              :saveurl="'/grimmadmin/aggiungiColore'" 
              :geturl="'/grimmadmin/colori'"
              :cancellaurl="'/grimmadmin/cancellaColore'"
              modificaurl="/grimmadmin/modificaColore"></form-nuova-opzione>
            </div>
           </div>
          <div class="row">
            <div class="col-12">
              <form-nuova-opzione :nomeopzione="'Tipologia'" 
              :saveurl="'/grimmadmin/aggiungiTipo'" 
              :geturl="'/grimmadmin/tipologie'"
              :cancellaurl="'/grimmadmin/cancellaTipo'"
              modificaurl="/grimmadmin/modificaTipo"></form-nuova-opzione>
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
  false,false,false,
  true,true];
  window.sideBarApp.openMenu('pages-nav-list-6');
</script>
@endsection