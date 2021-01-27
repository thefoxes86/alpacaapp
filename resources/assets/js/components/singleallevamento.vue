<template>
    <table class="table table-striped">
    	<thead>
    		<tr class="row">
    			<th class="col-2">Img</th>
    			<th class="col-4">Allevamento</th>
    			<th class="col-2">Citta</th>
    			<th class="col-2">Alpaca Registrati</th>
    			<th class="col-2">Azioni</th>
    		</tr>
    	</thead>
    	<tbody>
    		<tr v-for="allevamento in allevamenti" class="row">
    			<td class="col-2">
    				<img :src="allevamento.allevamento.logo" class="img-fluid">
    			</td>
    			<td class="col-4">{{allevamento.allevamento.nome}}</td>
    			<td class="col-2">{{allevamento.allevamento.citta}}</td>
    			<td class="col-2">{{allevamento.numero}}</td>
    			<td class="col-2">
    				<button class="btn btn-success btn-xs" @click='modifica(allevamento.allevamento.id)'>Modifica</button>
    				<button class="btn btn-danger btn-xs" @click='cancella(allevamento.allevamento.id)'> Elimina</button>
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
				allevamenti:[],
				allevamentoOnPage:0,
				sessi:['Maschio', 'Femmina']
			}
		},
		mounted:function () {
			console.log('single Alpaca Check');
			var url = '/grimmadmin/allevamenti/get';
			axios.get(url)
		        .then(function (response) {
		          console.log(response);
		          this.allevamenti = response.data;
		          this.allevamentoOnPage = response.data.length;
		        }.bind(this))
		        .catch(function (err) {
		          console.log(err);
		        }.bind(this));
		},
		methods: {
			cancella(id){
				var r = confirm("Sicuro di voler cancellare l\'allevamento");
				if (r == true) {
					var url = '/grimmadmin/allevamento/cancella';
				    axios.post(url,{
					allevamento:id,
					numeroAlevamenti: this.allevamento
					})
			        .then(function (response) {
			          console.log(response);
			          	this.allevamenti = response.data;
			          	this.allevamentoOnPage = response.data.length;  
			        }.bind(this))
			        .catch(function (err) {
			          console.log(err);
			        }.bind(this));
				} else {
				    console.log('No!');
				}
				
				
			},
			modifica(id){
				var r = confirm("Sicuro di voler modificare l\'allevamento");
				if (r == true) {
					var url = '/grimmadmin/allevamento/modifica/'+id;
					window.location.href = url;
				} else {
				    console.log('No!');
				}
			}
		}
	}
</script>