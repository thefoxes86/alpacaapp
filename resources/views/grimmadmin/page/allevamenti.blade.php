@extends('grimmadmin.layouts.defaultAdmin')
@section('title', 'Lista Alpaca')

@section('content')
<div class="flash-message">
    

      {{-- <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p> --}}
      
  </div> <!-- end .flash-message -->
    <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/grimmadmin')}}">Home</a></li>
            <li class="breadcrumb-item active">Lista Alpaca</li>
          </ul>
        </div>
      </div>
      <section class="forms">
        <div class="container-fluid">
          <header> 
            <h1 class="h3 display">Lista Alpaca</h1>
          </header>
          <div class="col-xs-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h2 class="h5 display">Lista Alpaca</h2>
                </div>
                <div class="card-body">
                  <single-allevamento></single-allevamento>
                </div>
              </div>
            
          </div>
      </div>
      </section>
      


@endsection
@section('footer')
<script>
  window.sideBarApp.menuActive = [false,false,false,false,true,false,true,false,false,false,false,false,false,false,false,false,false,false];
  window.sideBarApp.openMenu('pages-nav-list-2');
</script>
@endsection