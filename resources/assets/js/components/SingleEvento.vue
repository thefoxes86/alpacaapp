<template>
    <table class="table table-striped">
      <thead>
        <tr class="row">
          <th class="col-2">Img</th>
          <th class="col-4">Titolo</th>
          <th class="col-2">Data</th>
          <th class="col-2">Indirizzo</th>
          <th class="col-2">Azioni</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="alpaca in alpacas" class="row">
          <td class="col-2">
            <img :src="alpaca.immagine" class="img-fluid">
          </td>
          <td class="col-4">{{alpaca.titolo}}</td>
          <td class="col-2">{{alpaca.data}}</td>
          <td class="col-2">{{alpaca.indirizzo}}</td>
          <td class="col-2">
            <button class="btn btn-success btn-xs" @click='modifica(alpaca.id)'>Modifica</button>
            <button class="btn btn-danger btn-xs" @click='cancella(alpaca.id)'> Elimina</button>
          </td>
        </tr>
      </tbody>
    </table>





</template>
<script>
  import EventBus from '../event-bus';
  
  export default{
    data: function () {
      return {
        alpacas:[],
        alpacaOnPage:0,
      }
    },
    mounted:function () {
      console.log('single Evento Check');
      var url = '/grimmadmin/eventi/get';
      axios.get(url)
            .then(function (response) {
              console.log(response);
              this.alpacas = response.data;
              this.alpacaOnPage = response.data.length;
            }.bind(this))
            .catch(function (err) {
              console.log(err);
            }.bind(this));
    },
    methods: {
      cancella(id){
        var r = confirm("Sicuro di voler cancellare l\'articolo");
        if (r == true) {
          var url = '/grimmadmin/eventi/cancella';
            axios.post(url,{
            alpaca:id,
            numeroAlpaca: this.alpacaOnPage
          })
              .then(function (response) {
                console.log(response);
                  this.alpacas = response.data;
                  this.alpacaOnPage = response.data.length;  
              }.bind(this))
              .catch(function (err) {
                console.log(err);
              }.bind(this));
        } else {
            console.log('No!');
        }
        
        
      },
      modifica(id){
        var r = confirm("Sicuro di voler modificare l\'articolo");
        if (r == true) {
          var url = '/grimmadmin/eventi/modifica/'+id;
          window.location.href = url;
        } else {
            console.log('No!');
        }
      }
    }
  }
</script>