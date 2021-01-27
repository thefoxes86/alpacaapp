@extends('grimmadmin.layouts.defaultAdmin')
@section('title', 'Titolo')

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
                  @if (!isset($user))
                  <form action="/grimmadmin/newUser" method="POST" enctype="multipart/form-data" autocomplete="nodiocane">
                  @else
                  <form action="/grimmadmin/modificaUser" method="POST" enctype="multipart/form-data" autocomplete="nodiocane">
                  <input type="hidden" id="_id" name="_id" value="{{$user->id}}">
                  @endif
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label>Nome</label>
                      @if (!isset($user))
                      <input type="text" name="name" placeholder="Nome" class="form-control" value="">
                      @else
                      <input type="text" name="name" placeholder="Nome" class="form-control" value="{{$user->name}}">
                      @endif
                    </div>
                    <div class="form-group">
                      <label>Mail</label>
                      @if (!isset($user))
                      <input type="text" name="mail" placeholder="Mail" autocomplete="nope" class="form-control" value="">
                      @else
                      <input type="text" name="mail" placeholder="Mail" class="form-control" value="{{$user->email}}">
                      @endif
                    </div>
                    @if (!isset($user))
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" name="password" autocomplete="new-password" class="form-control" value="">
                    </div>
                    @endif
                    <div class="form-group">
                      <label>Ruolo</label>
                      <div class="select">
                        <select name="ruolo" class="form-control">
                          @if (isset($user))
                            @if ($user->ruolo == 'Admin')
                            <option value="Admin" selected>Admin</option>
                            <option value="Manager">Manager</option>
                            <option value="Allevatore">Allevatore</option>
                            @else
                            <option selected value="Allevatore">Allevatore</option>
                            @endif
                          @else
                            @if (Auth::user()->ruolo == 'Admin')
                              <option value="Admin">Admin</option>
                              <option value="Manager">Manager</option>
                            @endif
                          <option value="Allevatore">Allevatore</option>
                          @endif
                        </select>
                      </div>  
                    </div>
                    <div class="form-group">   
                      <input type="hidden" name="id" value=""> 
                      @if (!isset($user))                    
                      <input type="submit" value="Registra" class="btn btn-primary">
                      @else
                      <input type="submit" value="Modifica" class="btn btn-primary">
                      @endif
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h2 class="h5 display">Immagine Profilo</h2>
                </div>
                <div class="card-body">
                    @if (!empty($user))
                    <file-upload :url="'/grimmadmin/uploadUserFoto'" :immagine="'{{$user->immagine}}'"></file-upload>
                    @else
                    <file-upload :url="'/grimmadmin/uploadUserFoto'"></file-upload>
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
  true,true,false,
  false,false,false,
  false,false,false,
  false,false,false];
  window.sideBarApp.openMenu('pages-nav-list-3');
</script>
@endsection