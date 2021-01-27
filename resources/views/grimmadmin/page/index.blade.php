@extends('grimmadmin.layouts.defaultAdmin')
@section('head')
    <link rel="stylesheet" href="{{url('/')}}/admin/css/grasp_mobile_progress_circle-1.0.0.min.css">
@endsection
@section('title', 'Titolo')

@section('content')
<!-- Counts Section -->
      <section class="dashboard-counts section-padding">
        <div class="container-fluid">
          <dashboard-count></dashboard-count>
        </div>
      </section>
      <!-- Header Section-->
      <section class="dashboard-header section-padding">
        <div class="container-fluid">
          <div class="row d-flex align-items-md-stretch">
            <!-- To Do List-->
            @if (Auth::user()->ruolo == 'Admin')
            <div class="col-lg-6 col-md-12">
              <div class="wrapper to-do">
                <header>
                  <h2 class="display h4">Eventi da approvare</h2>
                  <p>Lista degli eventi inseriti che devono ancora essere approvati.</p>
                </header>
                <pannello-eventi :number="10" :approva="'/grimmadmin/evento/approva'" :cancella="'/grimmadmin/evento/elimina'"></pannello-eventi>
              </div>
            </div>

            <!-- Pie Chart-->
            <div class="col-lg-6 col-md-12">
              <div class="wrapper to-do">
                <header>
                  <h2 class="display h4">Utenti da approvare</h2>
                  <p>Lista degli Utenti che hanno fatto richiesta di ammissione.</p>
                </header>
                <pannello-utenti :number="10" :approva="'/grimmadmin/user/approva'" :cancella="'/grimmadmin/user/elimina'"></pannello-utenti>
              </div>
            </div>
            @endif
          </div>
        </div>
      </section>
      <!-- Updates Section -->
      <section class="updates section-padding">
        <div class="container-fluid">
          <div class="row">

            <!-- Daily Feed-->
            <pannello-notifiche></pannello-notifiche>
            
            
          </div>
        </div>
      </section>

@endsection
@section('footer')
<script>
  window.sideBarApp.menuActive = [true,false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,];
</script>
@endsection