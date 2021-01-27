<template>
	<div class="card-body">
		<div class="form-group">
			<label>Categoria</label>
			<div class="select">
				<select name="categoria" class="form-control" v-if="categorie.length>0" v-model="categoria">
					<option :value="categoria.id" v-for="categoria in categorie">{{categoria.nome}}</option>
				</select>
			</div> 
		</div>
		<div class="form-control" v-if="aggiungiCat">
			<input type="text" name="nome" v-model='cat'>
		</div>
		<div class="">
			<button class="btn btn-primary" @click='toggleInput()'>Aggiungi Categoria</button>
		</div>            
		
        <file-upload :url="'/grimmadmin/uploadPostFoto'" :immagine="'{{$alpaca->immagine}}'" v-if='modifica'></file-upload>
        
        <file-upload :url="'/grimmadmin/uploadPostFoto'" v-if='!modifica'></file-upload>
        
	</div>
</template>

<script>
	export default{
		data: function () {
			return {
				categorie:[],
				aggiungiCat:false,
				cat:'',
				categoria:''
			}
		},
		mounted(){
			var url = '/grimmadmin/categorie/get';
			axios.get(url)
				.then(function (response) {
					this.categorie = response.data;
				}.bind(this))
				.catch(function (response) {
					console.log(response);
				})
		},
		props:{
			modifica:{
				type: Boolean,
				Default: false
			}
		},
		methods:{
			toggleInput(){
				if (!this.aggiungiCat) {
					this.aggiungiCat = !this.aggiungiCat;
				}else{
					axios.post('/grimmadmin/categoria/nuovo',{
						nome:this.cat
					})
					.then(function (response) {
						this.categorie = response.data;
						this.cat = '';
						this.aggiungiCat = false;
						console.log('salvato');
					}.bind(this))
					.catch(function(reponse){
						console.log(reponse);
					})
				}
			}
		}
	}
</script>