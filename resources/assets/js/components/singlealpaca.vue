<template>
    <table class="table table-striped">
    	<thead>
    		<tr class="row">
    			<th class="col-2">Img</th>
    			<th class="col-2">Alpaca</th>
    			<th class="col-2">Sesso</th>
    			<th class="col-2">Allevamento</th>
    			<th class="col-2">Microchip</th>
    			<th class="col-2">Azioni</th>
    		</tr>
    	</thead>
    	<tbody>
    		<tr v-for="alpaca in alpacas" class="row">
    			<td class="col-2">
    				<img :src="alpaca.immagine" class="img-fluid">
    			</td>
    			<td class="col-2">{{alpaca.nome}}</td>
    			<td class="col-2">{{sessi[alpaca.sesso]}}</td>
    			<td class="col-2">{{alpaca.allevatore.nome}}</td>
    			<td class="col-2">{{alpaca.microchip}}</td>
    			<td class="col-2">
    				<button class="btn btn-success btn-xs" @click='modifica(alpaca.id)'>Modifica</button>
    				<button class="btn btn-danger btn-xs" @click='cancella(alpaca.id)'> Elimina</button>
    			</td>
    		</tr>
    		<tr class="row">
    			<td class="col-12">
    				<button class="btn btn-primary btn-lg ml-3 mb-3" @click="getMoreData()">Carica altre alpaca</button>
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
				sessi:['Maschio', 'Femmina'],
				pag:0
			}
		},
		mounted:function () {
			console.log('single Alpaca Check');
			var url = '/grimmadmin/alpaca/get';
			axios.get(url,{
				params:{
					pag:this.pag
				}
			})
		        .then(function (response) {
		          console.log(response);
		          this.alpacas = response.data;
		          this.alpacaOnPage = response.data.length;
		          this.pag++;
		        }.bind(this))
		        .catch(function (err) {
		          console.log(err);
		        }.bind(this));
		},
		methods: {
			cancella(id){
				var r = confirm("Sicuro di voler cancellare l\'alpaca");
				if (r == true) {
					var url = '/grimmadmin/alpaca/cancella';
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
				var r = confirm("Sicuro di voler modificare l\'alpaca");
				if (r == true) {
					var url = '/grimmadmin/alpaca/modifica/'+id;
					window.location.href = url;
				} else {
				    console.log('No!');
				}
			},
			getMoreData(){
				var url = '/grimmadmin/alpaca/get';
				axios.get(url,{
					params:{
						pag:this.pag
					}
				})
			        .then(function (response) {
			          
			          this.alpacas = this.alpacas.concat(response.data);
			          this.alpacaOnPage = this.alpacas.length;
			          this.pag++;
			        }.bind(this))
			        .catch(function (err) {
			          console.log(err);
			        }.bind(this));
			}
		}
	}
</script>