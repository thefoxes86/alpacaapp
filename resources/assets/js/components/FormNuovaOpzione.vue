<template>
	<div class="card">
	    <div class="card-header d-flex align-items-center">
	      <h2 class="h5 display display">Tabella Tipologie</h2>
	    </div>
	    <div class="card-body">
	      <table class="table table-striped">
	        <thead>
	          <tr class="row">
	            <th class="col-2">{{nomeopzione}}</th>
	            <th class="col-8">Descrizione</th>
	            <th class="col-2">Azioni</th>
	          </tr>
	        </thead>
	        <tbody>
	          <tr class="row" v-for="(element, index) in elements">
	            <th class="col-2">{{element.titolo}}</th>
	            <th class="col-8">{{element.descrizione}}</th>
	            <th class="col-2">
	              <button class="btn btn-success btn-xs" @click='Modifica(index)'>Modifica</button>
	              <button class="btn btn-danger btn-xs" @click='Cancella(element.id)'> Elimina</button>
	            </th>

	           

	          </tr>
	          <tr class="row" v-if="aggiungi">
	          	<th class="col-2">
	          		<input v-model="titolo" type="text" style="width:100%;">
	          	</th> 
	          	<th class="col-8">
	          		<textarea v-model="descrizione" rows="4" style="width:100%; border-color:#d5d5d5 !important"></textarea>
	          	</th>
	          	<th class="col-2">
	          		<button class="btn btn-success" @click="saveElement()">Salva</button>
	          	</th>
	          </tr>
	        </tbody>
	      </table>
	      <div class="row" v-if="!aggiungi">
	      	<div class="col-12">
	      		<button class="btn btn-success float-right" @click='Nuovo()'>
	      			Aggiungi {{nomeopzione}}
	      		</button>
	      	</div>
	      </div>
	      <div class="row" v-if="aggiungi">
	      	<div class="col-12">
	      		<button class="btn btn-danger float-right" @click='annulla()'>
	      			Annulla
	      		</button>
	      	</div>
	      </div>
	  </div>
	</div>
</template>

<script>
var Vue = require('vue');
var VueScrollTo = require('vue-scrollto');
	export default{
		data:function(){
			return {
				elements:[],
				aggiungi:false,
				titolo:'',
				descrizione:'',
				mod: 0
			}
		},
		props:{
			nomeopzione:{
				type:String,
				default:'Titolo'
			},
			geturl:{
				type:String,
				default:'/'
			},
			saveurl:{
				type:String,
				default:'/'
			},
			cancellaurl:{
				type:String,
				default:'/'
			},
			modificaurl:{
				type:String,
				default:'/'
			}
		},
		methods:{
			Modifica(i){
				console.log(i);
				this.aggiungi = true;
				this.titolo = this.elements[i].titolo;
				this.descrizione = this.elements[i].descrizione;
				this.mod = this.elements[i].id;
			},
			Cancella(id, conferma= true){
				if (conferma == true) {
					var r = confirm('Sei sicuro di voler cancellare questo elemento?');
					if (r == true) {
						axios.post(this.cancellaurl,{
							id:id
						}).then(function (response) {
							this.elements = response.data;
							
						}.bind(this))
						.catch(function (response) {
							console.log(response.data);
						})
					}
				}else{
					axios.post(this.cancellaurl,{
						id:id
					}).then(function (response) {
						this.elements = response.data;
					}.bind(this))
					.catch(function (response) {
						console.log(response.data);
					});
				}
				

			},
			Nuovo(){
				this.titolo = '';
				this.descrizione = '';
				this.aggiungi = true;
			},
			getElements(){
				if (this.geturl == '/') {
					return;
				};
				console.log(this.geturl);
				axios.get(this.geturl).then(function(response){
					this.elements = response.data;
					
				}.bind(this))
			},
			saveElement(){
				if (this.mod>0) {
					var r = confirm('Sei sicuro di voler modificare questo elemento?');
					if (!r) {return 0};
					axios.post(this.modificaurl,{
						titolo:this.titolo,
						descrizione:this.descrizione,
						id:this.mod
					}).then(function (response) {
						console.log(response.data);
						this.aggiungi = false;
						this.elements = response.data;

						
					}.bind(this))
					.catch(function (response) {
						console.log(response.data);
					});
					this.mod = 0;
					return 0;
				}
				axios.post(this.saveurl,{
					titolo:this.titolo,
					descrizione:this.descrizione
				}).then(function (response) {
					this.aggiungi = false;
					this.elements = response.data;
					
				}.bind(this))
				.catch(function (response) {
					console.log(response.data);
				})

			},
			annulla(){
				this.aggiungi = false;
			}
		},
		mounted(){
			this.getElements();
		}
	}
</script>