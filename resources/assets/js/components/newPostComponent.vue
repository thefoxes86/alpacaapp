<template>
	<section class="forms">
        <div class="container-fluid">
          <header> 
            <h1 class="h3 display">Titolo</h1>
          </header>
          <div class="row">
            <div class="col-lg-8">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h2 class="h5 display display">Titolo</h2>
                </div>
                
                <div class="card-body">
                
                  <div  method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                      <label>Titolo</label>
                      <input type="text" name="titolo" placeholder="Titolo" v-model="titolo" class="form-control" value="">
                    </div>
                    <div class="form-group">
                      <label>Sottotitolo</label>
                      <input type="text" name="sottotitolo" placeholder="Sottotitolo" v-model="sottotitolo" class="form-control" value="">
                    </div>
                    
                    <div class="form-group">
                      <label>Contenuto</label>
                      <textarea type="text" rows="20" placeholder="" name="testo" v-model="testo" class="form-control" value=""></textarea>
                    </div>
                  
                    
                    
                    <div class="form-group">  
                      <input type="hidden" value="" name="categoria">                  

                      <input type="submit" value="Salva" v-if="!modifica" class="btn btn-primary" @click="sendForm()">
                      <input type="submit" value="Aggiorna" v-if="modifica" class="btn btn-primary" @click="sendForm()">

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">

              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h2 class="h5 display">Categorie e Immagini</h2>
                </div>
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
					
			        <file-upload :url="'/grimmadmin/uploadPostFoto'" :immagine="immagine" v-if='modifica'></file-upload>
			        
			        <file-upload :url="'/grimmadmin/uploadPostFoto'" v-if='!modifica'></file-upload>
			        
				</div>
              </div>
            </div>
           </div>
           
        </div>
    </section>
</template>
<script>
	export default{
		data:function(){
			return {
				categorie:[],
				aggiungiCat:false,
				cat:'',
				categoria:'',
				titolo:'',
				sottotitolo:'',
				testo:'',
				modifica:false
				
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
				});
			if (this.post != null) {
				this.titolo = this.post.titolo;
				this.sottotitolo = this.post.sottotitolo;
				this.testo = this.post.testo;
				this.categoria = this.post.categoria;
				this.modifica = true;
			}
		},
		props:{
			modifica:{
				type: Boolean,
				Default: false
			},
			post:{
	        	type:Object,
	        	default: ()=>(null),
	        },
	        immagine:{
	        	type:String,
	        	default: ''
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
			},
			sendForm(){
				var url = '';
				if (this.modifica) {
					var id = window.location.href;
					id = id.split('/');
					id = id[id.length-1];
					url = '/grimmadmin/articoli/update/'+id;
				}else{
					url = '/grimmadmin/articoli/nuovo';
				}
				axios.post(url, {
        			titolo: this.titolo,
        			sottotitolo:this.sottotitolo,
        			testo:this.testo,
        			categoria: this.categoria
				}).then(function(response){
					if (response.data == 'hey.') {
						window.location.href = '/grimmadmin/articoli';
					}
				}.bind(this))
				.catch(function(response){
					console.log(response);
				}.bind(this))
			}
		}
	}
</script>