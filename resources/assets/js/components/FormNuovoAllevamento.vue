<template>
	<form @submit.prevent="sendForm()">
		<div class="form-group">
			<label>Nome</label>
			<input type="text" name="name" placeholder="Nome" class="form-control" v-model="nome"  autofocus>
		</div>
		</div>
		<div class="form-group">
			<label>Partita Iva</label>
			<input type="text" name="premi" placeholder="P.Iva" class="form-control" v-model="piva">
		</div>
		<div class="form-group">
			<label>Indirizzo</label>
			<!-- <input type="text" name="indirizzo" placeholder="Indirizzo" class="form-control" v-model="indirizzo" v-validate="'required'" ref="autocomplete"> -->
			<gmap-autocomplete
		        @place_changed="setPlace" 
		        class="form-control"
		        v-model="indirizzo_sint"
		        >
		    </gmap-autocomplete>
		</div>
		<div class="form-group v-select-group">
			<label>Utente</label>
			<v-select :options="users" label="email" :filterable="false" v-model="user">
				<template slot="no-options">
			    	Inizia a digitare per cercare l'Utente da abbinare all'allevamento
			    </template>
			    <template slot="option" slot-scope="option">
			    	<div class="d-center">
			    		<img :src='option.img' /> 
			        	{{option.email}}
			        </div>
			    </template>
			</v-select>
			<div class="help-block alert alert-danger" v-if="errors.has('madre')">
				<span>Devi sciegliere una madre delle presenti, se non la trovi nella lista scegli l'opzione "La madre non é presente nel database", potrai modificare in seguito</span>
			</div>
		</div>
	
		<div class="form-group">
			<GmapMap
			  :center="coord"
			  :zoom="7"
			  map-type-id="terrain"
			  style="width: 100%; height: 300px"
			  ref="mapRef">
				  <GmapMarker
				    :position="coord"
				    :clickable="true"
				    :draggable="true"
				    @click="center=coord" 
				    @dragend="getMarkerPosition($event.latLng)"
				    />
			</GmapMap>

		</div>
		
		<div class="form-group" v-if="!errors.any() && !modifica">                   
			<input type="submit" value="Registra" class="btn btn-primary" >
		</div>
		<div class="form-group" v-if="!errors.any() && modifica">                   
			<input type="submit" value="Modifica" class="btn btn-primary" >
		</div>
	</form>
</template>
<script>
	import permissions from '../permissions'
	import EventBus from '../event-bus';
	import {gmapApi} from 'vue2-google-maps';
	var VueScrollTo = require('vue-scrollto');
	export default{
		data:function(){
			return{
				nome:'',
				indirizzo:'',
				piva:'',
				cap:'',
				coord:{lat:44,lng:10},
				provincia:'',
				citta:'',
				mapLoaded: true,
				modifica:false,
				marker:null,
				places: [],
      			currentPlace: null,
      			indirizzo_sint:'',
      			users:[],
      			user:'',
			}
		},
		props: {
	        allevamento:{
	        	type:Object,
	        	default: ()=>(null),
	        },
	        tastomodifica:{
	        	type:Boolean,
	        	default:false
	        }
		},
		computed:{
			google:gmapApi,

		},
		mounted() {
			console.log(permissions);
			//console.log(this.google);
			if (this.allevamento != null) {

				this.nome = this.allevamento.nome;
				this.indirizzo = this.allevamento.indirizzo;
				this.indirizzo_sint = this.indirizzo;
				this.piva = this.allevamento.piva;
				this.cap = this.allevamento.cap;
				this.citta = this.allevamento.citta;
				this.provincia = this.allevamento.provincia;
				this.modifica = this.tastomodifica;
				this.user = this.allevamento.user;
				this.coord = {lat: Number(this.allevamento.lat),lng:Number(this.allevamento.lon)};
			}
			this.geolocate();
			this.$refs.mapRef.$mapPromise.then((map) => {
		      console.log(map);
		    }),
		    axios.get('/grimmadmin/user/get')
		    	.then(function (response) {
		    		this.users = response.data;
		    	}.bind(this))
		    	.catch(function (error) {
		    		console.log(error);
		    	});
		},
		methods:{
			getMarkerPosition(marker){
				this.coord.lat = marker.lat();
				this.coord.lng = marker.lng();
			},
			sendForm(event){
				//console.log(this.$data);
				var url = '';
				if (this.modifica) {
					var id = window.location.href;
					id = id.split('/');
					id = id[id.length-1];
					url = '/grimmadmin/allevamento/update/'+id;
				}else{
					url = '/grimmadmin/allevamento/nuovo';
				}
				axios.post(url, {
				    nome: this.nome,
				    indirizzo: this.indirizzo,
				    citta:this.citta,
				    provincia: this.provincia,
				    lng: this.coord.lng,
				    lat: this.coord.lat,
				    cap: this.cap,
				    piva: this.piva
				  })
				.then(function (response) {
				    var resp = [];
				    if (response.data == 'hey.') {
				    	resp["success"] = 1;
				    	resp["message"] = 'L\'allevamento é stato aggiunto al Database';
				    	window.location.href = '/grimmadmin/allevamenti';
				    } else {
				    	resp["success"] = 0;
				    	resp["message"] =response.data;
				    	EventBus.$emit('Comunication', resp);
				    	var options = {
						    container: 'body',
						    easing: 'ease-in',
						    offset:-60,
						    x: false,
						    y: true
						}
						 
						VueScrollTo.scrollTo('#app', 400, options);
						
				    }
				    //this.emiCom(resp);
				}.bind(this))
				.catch(function (error) {
				  	var resp = [];
				    resp["success"] = 0;
				    resp["message"] = 'L\'operazione non ha avuto successo, ripetere ricontrollando i parametri, se questo messaggio si ripete contattare l\'amministratore' ;
				    console.log(error);
				    EventBus.$emit('Comunication', resp);
				    //this.emiCom(resp);
				}.bind(this));
			},
			setPlace(place) {
     			this.currentPlace = place;
     			var self = this;
     			this.currentPlace.address_components.forEach( function(element, index) {
     				element.types.forEach( function(elementChild, indexChild) {

     					switch (elementChild) {
     				 	case 'locality':
     				 		self.citta = element.long_name;
     				 		break;
     				 	case 'administrative_area_level_2':
     				 		self.provincia = element.short_name;
     				 		break;
     				 	case 'postal_code':
     				 		self.cap = element.short_name;
     				 		break;
     				 	default:
     				 		// statements_def
     				 		break;
     				 }
     				});
     				 
     			});
     			this.indirizzo = this.currentPlace.formatted_address;
     			this.coord.lat = this.currentPlace.geometry.location.lat();
     			this.coord.lng = this.currentPlace.geometry.location.lng();
     			this.$refs.mapRef.$mapPromise.then((map) => {
			      map.setZoom(15);
			    })

		    },
		    addMarker() {
		      if (this.currentPlace) {
		        const marker = {
		          lat: this.currentPlace.geometry.location.lat(),
		          lng: this.currentPlace.geometry.location.lng()
		        };
		        this.markers.push({ position: marker });
		        this.places.push(this.currentPlace);
		        this.center = marker;
		        this.currentPlace = null;
		      }
		    },
		    geolocate: function() {
		      navigator.geolocation.getCurrentPosition(position => {
		        this.center = {
		          lat: position.coords.latitude,
		          lng: position.coords.longitude
		        };
		      });
		    }
		}
	}
</script>