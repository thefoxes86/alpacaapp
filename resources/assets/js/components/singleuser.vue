<template>
    <table class="table table-striped">
    	<thead>
    		<tr class="row">
    			<th class="col-2">Img</th>
    			<th class="col-2">Nome</th>
    			<th class="col-2">Ruolo</th>
    			<th class="col-2">Approvato</th>
    			<th class="col-2">Email</th>
    			<th class="col-2">Azioni</th>
    		</tr>
    	</thead>
    	<tbody>
    		<tr v-for="alpaca in alpacas" class="row">
    			<td class="col-2">
    				<img :src="alpaca.img" class="img-fluid">
    			</td>
    			<td class="col-2">{{alpaca.name}}</td>
    			<td class="col-2">{{alpaca.ruolo}}</td>
    			<td class="col-2">{{alpaca.approved}}</td>
    			<td class="col-2">{{alpaca.email}}</td>
    			
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
				sessi:['Maschio', 'Femmina']
			}
		},
		mounted:function () {
			console.log('single Alpaca Check');
			var url = '/grimmadmin/user/get';
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
				var r = confirm("Sicuro di voler cancellare l\'Utente?");
				if (r == true) {
					var url = '/grimmadmin/user/cancella';
				    axios.post(url,{
					id:id,
					numeroUser: this.alpacaOnPage
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
				var r = confirm("Sicuro di voler modificare l\'Utente");
				if (r == true) {
					var url = '/grimmadmin/user/modifica/'+id;
					window.location.href = url;
				} else {
				    console.log('No!');
				}
			}
		}
	}
</script>