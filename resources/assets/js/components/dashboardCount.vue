<template>
  <div class="row">
    <div class="col-xl-2 col-md-4 col-6">
      <div class="wrapper count-title d-flex">
        <div class="icon"><i class="icon-user"></i></div>
        <div class="name"><strong class="text-uppercase">Nuovi Alpaca</strong><span>Ultima Settimana</span>
          <div class="count-number">{{ultimiAlpaca}}</div>
        </div>
      </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
      <div class="wrapper count-title d-flex">
        <div class="icon"><i class="icon-padnote"></i></div>
        <div class="name"><strong class="text-uppercase">Tutti gli alpaca</strong><span>Totale</span>
          <div class="count-number">{{tuttiGliAlpaca}}</div>
        </div>
      </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
      <div class="wrapper count-title d-flex">
        <div class="icon"><i class="icon-check"></i></div>
        <div class="name"><strong class="text-uppercase">Nuovi Allevamneti</strong><span>Ultima Settimana</span>
          <div class="count-number">{{ultimiAllevamenti}}</div>
        </div>
      </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
      <div class="wrapper count-title d-flex">
        <div class="icon"><i class="icon-bill"></i></div>
        <div class="name"><strong class="text-uppercase">Tutti gli allevamenti</strong><span>Totale</span>
          <div class="count-number">{{tuttiGliAllevamenti}}</div>
        </div>
      </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
      <div class="wrapper count-title d-flex">
        <div class="icon"><i class="icon-list"></i></div>
        <div class="name"><strong class="text-uppercase">Nuovi Utenti</strong><span>Ultima Settimana</span>
          <div class="count-number">{{ultimiUtenti}}</div>
        </div>
      </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
      <div class="wrapper count-title d-flex">
        <div class="icon"><i class="icon-list-1"></i></div>
        <div class="name"><strong class="text-uppercase">Tutti gli Utenti</strong><span>Totale</span>
          <div class="count-number">{{tuttiGliUtenti}}</div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    data:function(){
      return {
        tuttiGliUtenti:0,
        ultimiUtenti:0,
        tuttiGliAlpaca:0,
        ultimiAlpaca:0,
        tuttiGliAllevamenti:0,
        ultimiAllevamenti:0
      }
    },
    mounted(){
      console.log('DashBoard Mounted');
      axios.get('/grimmadmin/user/count')
        .then(function (response) {
          console.log(response);
          this.tuttiGliUtenti = response.data;
        }.bind(this))
        .catch(function (response) {
          console.log(response.data)
        });
      axios.get('/grimmadmin/user/count?giorni=7')
        .then(function (response) {
          console.log(response);
          this.ultimiUtenti = response.data;
        }.bind(this))
        .catch(function (response) {
          console.log(response.data)
        });
      axios.get('/grimmadmin/alpaca/count')
        .then(function (response) {
          console.log(response);
          this.tuttiGliAlpaca = response.data;
        }.bind(this))
        .catch(function (response) {
          console.log(response.data)
        });
      axios.get('/grimmadmin/alpaca/count?giorni=7')
        .then(function (response) {
          console.log(response);
          this.ultimiAlpaca = response.data;
        }.bind(this))
        .catch(function (response) {
          console.log(response.data)
        });
      axios.get('/grimmadmin/allevamento/count')
        .then(function (response) {
          console.log(response);
          this.tuttiGliAllevamenti = response.data;
        }.bind(this))
        .catch(function (response) {
          console.log(response.data)
        });
      axios.get('/grimmadmin/allevamento/count?giorni=7')
        .then(function (response) {
          console.log(response);
          this.ultimiAllevamenti = response.data;
        }.bind(this))
        .catch(function (response) {
          console.log(response.data)
        });

    },
    methods:{
      
    }

  }
</script>