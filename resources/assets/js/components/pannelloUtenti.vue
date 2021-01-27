<template>
	<ul class="check-lists list-unstyled pannelloEventi">
      <li class="d-flex align-items-center" v-for="user in users"> 
        <label><a :href="'/grimmadmin/users/modifica/'+user.id">{{user.name}}</a> ha fatto richiesta di iscrizione in data {{formatData(user.created_at)}}</label>
        <button class="btn btn-success btn-sm" @click="confirmNotification(user.id)">Accetta</button>
        <button class="btn btn-danger btn-sm" @click="deleteNotification(user.id)">Cancella</button>
      </li>
      <li v-if="this.users.length < 1">
      	<h3>Non ci sono utenti da approvare</h3>
      </li>
    </ul>
</template>
<script>
	import moment from 'moment';
	export default {
		data: function (){
			return{
				users:new Array(),
			}
		},
		mounted(){
			var url = '/grimmadmin/users/getNumber/'+this.number;
			axios.get(url)
				.then(function(response){
					this.users = response.data;
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
						this.users = response.data;
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
						this.users = response.data;
					}.bind(this))
					.catch(function(response){
						console.log(response);
					}.bind(this));
			},
			formatData(date){
				return moment(date).format('MMMM Do YYYY');
			}
		}

	}
</script>