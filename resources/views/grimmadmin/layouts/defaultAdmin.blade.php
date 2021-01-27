<!DOCTYPE html>
<html>
  <head>
    @include('grimmadmin.includes.head',['title'=>'Alpaca']);
    @yield('head');
  </head>
  <body>
    <!-- Side Navbar -->

  <nav id="sideBarApp" class="side-navbar" v-bind:class="{'sideActive':sideBarActive}">
    <div class="side-navbar-wrapper">
      <div class="sidenav-header d-flex align-items-center justify-content-center">
        <div class="sidenav-header-inner text-center"><img src="{{Auth::user()->img}}" alt="person" class="img-fluid rounded-circle">
          <h2 class="h5 text-uppercase">{{Auth::user()->name}}</h2><span class="text-uppercase">{{Auth::user()->ruolo}}</span>
        </div>
        <div class="sidenav-header-logo"><a href="index.html" class="brand-small text-center"> <strong>B</strong><strong class="text-primary">D</strong></a></div>
      </div>

      <div >@include('grimmadmin.includes.sidebar')</div>
      
    </div>
  </nav>
  <div class="page home-page app">
    <!-- navbar-->
    <header id="headerApp" class="header">
      <nav class="navbar">
        <div class="container-fluid">
          <div class="navbar-holder d-flex flex-row justify-content-between">
            <div class="navbar-header">
              <button class="btn btn-success menuToggle" :class="{'opened':open}" @click="log">
                <p style="margin:0"><i style="font-size:15px" class="fas fa-bars icon-fixed-width"></i> Menu</p>  
              </button>
            </div>
            <div class="navbar-header">
              <button class="btn btn-success" @click="logout">
                <p style="margin:0">Disconnettiti <i style="font-size:15px" class="fas fa-sign-out-alt icon-fixed-width"></i></p>
              </a>
            </div>
          </div>
        </div>
      </nav>
    </header>
    <div id="app">
      @yield('content')
    </div>

    @include('grimmadmin.includes.footer');
    @yield('footer')
  </body>
</html>