@extends('grimmadmin.layouts.defaultAdmin')
@section('title', 'Articolo')

@section('content')

<message-alert></message-alert>


<div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Articolo</li>
          </ul>
        </div>
      </div>
      @if(isset($post))
      <nuovo-post :post="{{$post}}" :modifica="true" :immagine="'{{$post->immagine}}'"></nuovo-post>
      @else
      <nuovo-post></nuovo-post>
      @endif

@endsection
@section('footer')
<script>
  window.sideBarApp.menuActive = [false,
  false,false,false,
  false,false,false,
  false,false,false,
  true,true,false,
  false,false,false,
  false,false,false];
  window.sideBarApp.openMenu('pages-nav-list-4');
</script>
@endsection