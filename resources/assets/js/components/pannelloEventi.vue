<template>
	<ul class="check-lists list-unstyled pannelloEventi">
      <li class="d-flex align-items-center" v-for="evento in eventi"> 
        <label><a :href="'/grimmadmin/eventi/modifica/'+evento.id">{{evento.titolo}}</a> in data {{evento.data}} inserito da <a href="/">{{evento.user.name}}</a> </label>
        <button class="btn btn-success btn-sm" @click="confirmNotification(evento.id)">Accetta</button>
        <button class="btn btn-danger btn-sm" @click="deleteNotification(evento.id)">Cancella</button>
      </li>
      <li v-if="this.eventi.length < 1">
      	<h3>Non ci sono eventi da approvare</h3>
      </li>
    </ul>
</template>
<script>
	export default {
		data: function (){
			return{
				eventi:new Array(),
			}
		},
		mounted(){
			var url = '/grimmadmin/eventi/getNumber/'+this.number;
			axios.get(url)
				.then(function(response){
					this.eventi = response.data;
				}.bind(this))
				.catch(function(response){
					console.log(response);
				}.bind(this));

		},
		props:{
			number:{
				type:Number,																			
				default:10
			},
			approva:{
				type:String,
				default:''
			},
			cancella:{
				type:String,
				default:''
			}
		},
		methods:{
			confirmNotification(id){
				var url = this.approva;
				axios.post(url,{
					numero: this.number,
					id: id
				})
					.then(function(response){
						this.eventi = response.data;
					}.bind(this))
					.catch(function(response){
						console.log(response);
					}.bind(this));
			},
			deleteNotification(id){
				var url = this.cancella;
				axios.post(url,{
					numero: this.number,
					id: id
				})
					.then(function(response){
						this.eventi = response.data;
					}.bind(this))
					.catch(function(response){
						console.log(response);
					}.bind(this));
			}
		}

	}
</script>