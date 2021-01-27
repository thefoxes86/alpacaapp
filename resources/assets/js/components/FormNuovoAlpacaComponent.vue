<template>

	<form @submit.prevent="sendForm()">
			
		<div class="form-group">
			<label>Nome</label>
			<input type="text" name="name" placeholder="Nome" class="form-control" 
					v-model="nome"
					v-validate="'required'"
					autofocus
					>
			<div class="help-block alert alert-danger" v-if="errors.has('name')">
				<span>Devi inserire un nome valido</span>
			</div>
		</div>
		<div class="form-group">
			<label>Colore</label>
			<div class="select">
				<v-select :options="colori" name="colore" label="titolo" v-model="colore" v-validate="'required'"></v-select>
			</div>
			<div class="help-block alert alert-danger" v-if="errors.has('colore')">
				<span>Scegli uno dei colori presenti</span>
			</div>
		</div>
		<div class="form-group">
			<label>Microchip</label>
			<input type="text" name="name" placeholder="Microchip" class="form-control" 
					v-model="microchip"
					v-validate="'required'" 
					>
			<div class="help-block alert alert-danger" v-if="errors.has('microchip') || existingMicro">
				<span>C'é qualcosa che non va con il Microchip</span>
			</div>
		</div>
		<div class="form-group">
			<label>Data di Nascita</label>
			<datepicker v-model="dataNascita" name="dataNascita" bootstrap-styling :format="customFormatter" v-validate="'required'"></datepicker>
			<div class="help-block alert alert-danger" v-if="errors.has('dataNascita')">
				<span>Devi inserire una data di nascita valida.</span>
			</div>
		</div>
		<div class="form-group">
			<label for="">L'Alpaca é deceduto</label>
			<input type="checkbox" v-model="alpacaMorto">
		</div>
		<div class="form-group" v-if="alpacaMorto">
			<label>Data di Morte</label>
			<datepicker v-model="dataMorte" bootstrap-styling :format="customFormatter"></datepicker>
		</div>

		<div class="form-group v-select-group">
			<label>Padre</label>
			<v-select :options="padri" label="nome" :filterable="false" v-model="padre" name="padre" @search="onSearchPadre">
				<template slot="no-options">
			    	Inizia a digitare per cercare l'alpaca
			    </template>
			    <template slot="option" slot-scope="option">
			    	<div class="d-center">
			    		<img :src='option.immagine' /> 
			        	<strong> {{ option.nome }} </strong> <div class="bornOn" v-if="option.nascita">nato il {{option.nascita}} </div> 
			        </div>
			    </template>
			</v-select>
			<div class="help-block alert alert-danger" v-if="errors.has('padre')">
				<span>Devi scegliere un padre delle presenti, se non lo trovi nella lista scegli l'opzione "Il padre non é presente nel database", potrai modificare in seguito</span>
			</div>
		</div>
		<div class="form-group v-select-group">
			<label>Madre</label>
			<v-select :options="madri" label="nome" :filterable="false" v-model="madre" @search="onSearchMadre">
				<template slot="no-options">
			    	Inizia a digitare per cercare l'alpaca
			    </template>
			    <template slot="option" slot-scope="option">
			    	<div class="d-center">
			    		<img :src='option.immagine' /> 
			        	<strong> {{ option.nome }} </strong> <div class="bornOn" v-if="option.nascita">nato il {{option.nascita}} </div> 
			        </div>
			    </template>
			</v-select>
			<div class="help-block alert alert-danger" v-if="errors.has('madre')">
				<span>Devi sciegliere una madre delle presenti, se non la trovi nella lista scegli l'opzione "La madre non é presente nel database", potrai modificare in seguito</span>
			</div>
		</div>
		<div class="form-group v-select-group">
			<label>Allevamento</label>
			<v-select :options="allevamenti" :filterable="false" label="nome" v-model="allevamento" @search="onSearchAllevamento" v-validate="'required'" data-vv-name="allevamento">
				<template slot="no-options">
			    	Inizia a digitare per cercare l'allevamento
			    </template>
			    <template slot="option" slot-scope="option">
			    	<div class="d-center">
			    		<img :src='option.logo' /> 
			        	<strong> {{ option.nome }} </strong> <div class="bornOn" v-if="option.citta">a {{option.citta}} </div> 
			        </div>
			    </template>
			</v-select>
			<div class="help-block alert alert-danger" v-if="errors.has('allevamento')">
				<span>Devi sciegliere un allevamento dei presenti</span>
			</div>
		</div>
		<div class="form-group">
			<label>Tipologia</label>
			<v-select :options="tipologie" label="titolo" v-model="tipo"></v-select>
		</div>
		<div class="form-group">
			<label>Sesso</label>
			<div class="sesso">
				<v-select :options="[{label: 'Maschio', value: 0},{label: 'Femmina', value: 1}]" v-model="sesso"></v-select>
			</div>
		</div>
		<div class="form-group">
			<label>DNA</label>
			<input type="text" name="dna" placeholder="Dna Code" class="form-control" v-model="dna">
		</div>
		<div class="form-group">
			<label>Premi</label>
			<input type="text" name="premi" placeholder="Premi" class="form-control" v-model="premi">
		</div>
		<div class="form-group">
			<label>Note</label>
			<textarea type="text" name="note" placeholder="Inserisci una nota" class="form-control" v-model="note"></textarea>
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

import Datepicker from 'vuejs-datepicker';
import moment from 'moment';
import EventBus from '../event-bus';


//import axios from 'axios';
window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

export default {
	data: function(){
		 return {
		 	nome:'',
		 	colore:{titolo: 'Bianco', id: 2},
		 	dataNascita:'',
		 	dataMorte:'',
		 	padre:false,
		 	madre:'',
		 	allevamento:'',
		 	tipo:{titolo: 'Alpaca Gigante', id: 1},
		 	sesso:{label: 'Maschio', value: 0},
		 	premi:'',
		 	dna:'',
		 	microchip:'',
		 	existingMicro:false,
		 	note:'',
			padrePresente:false,
	    	madrePresente:false,
	    	allevamentoPresente:false,
	    	alpacaMorto:false,
	    	modifica:false,
	    	
	    	padri:[{
	    		id:0,
	    		nome: 'Il Padre non é presente nel DataBase',
	    		immagine:'/img/NoAlpaca.svg'
	    	}],
	    	madri:[{
	    		id:0,
	    		nome: 'La madre non é presente nel DataBase',
	    		immagine:'/img/NoAlpaca.svg'
	    	}],
	    	allevamenti:[]
	    }
	},
	mounted() {

		if (this.alpaca != null) {
			this.nome = this.alpaca.nome;
			this.dataNascita = this.alpaca.nascita;
			this.dataMorte = this.alpaca.morte;
			this.padre = this.alpaca.padre;
			this.madre = this.alpaca.madre;
			this.allevamento = this.alpaca.allevatore;
			this.sesso = this.alpaca.sesso;
			this.premi = this.alpaca.premi;
			this.note = this.alpaca.note;
			this.microchip = this.alpaca.microchip;
			this.dna = this.alpaca.dna;
			this.modifica = this.tastomodifica;
		}
		this.tipo = this.tipologie[0];
		this.colore = this.colori[0];

	},
	components:{
		Datepicker
	},
	props: {
		tipologie:{
               type: Array,
               default: () => ([]),
        },
        colori:{
               type: Array,
               default: () => ([]),
        },
        lerrors:{
        	type:Array,
        	default: ()=>([]),
        },
        alpaca:{
        	type:Object,
        	default: ()=>(null),
        },
        tastomodifica:{
        	type:Boolean,
        	default:false
        }
	},
	methods:{

		sendForm(event){

			this.$validator.validateAll().then((result) => {
      			if (result) { 
					var url = '';
					if (this.modifica) {
						var id = window.location.href;
						id = id.split('/');
						id = id[id.length-1];
						url = '/grimmadmin/alpaca/update/'+id;
					}else{
						url = '/grimmadmin/alpaca/nuovo';
					}
					axios.post(url, {
					    nome: this.nome,
					    colore: this.colore.id,
					    nascita:this.dataNascita,
					    morte: this.dataMorte,
					    padre: this.padre.id,
					    madre: this.madre.id,
					    allevamento: this.allevamento.id,
					    tipo: this.tipo.id,
					    sesso: this.sesso.value,
					    premi: this.premi,
					    note: this.note,
					    dna:this.dna,
					    microchip: this.microchip
					  })
					  .then(function (response) {
					    var resp = [];
					    if (response.data == 'hey.') {
					    	resp["success"] = 1;
					    	resp["message"] = 'L\'alpaca é stato aggiunto al Database';
					    	window.location.href = '/grimmadmin/alpaca';
					    } else if(response.data == 1062){
					    	resp["success"] = 0;
					    	resp["message"] = 'Il Numero inserito come microchip é gia presente nel nostro database.';
					    	this.existingMicro = true;
					    	this.$scrollTo('body');
					    } else{
					    	resp["success"] = 2;
					    	resp["message"] = 'Warning: qualcosa nell\'operazine non é andato a buon fine, contattare un amministratore.';
					    }
					    this.emiCom(resp);
					  }.bind(this))
					  .catch(function (error) {
					  	var resp = [];
					    resp["success"] = 0;
					    resp["message"] = 'L\'operazione non ha avuto successo, ripetere ricontrollando i parametri, se questo messaggio si ripete contattare l\'amministratore' ;
					    console.log(error);
					    //this.emiCom(resp);
					  }.bind(this));
      			};
			})
			//alert('ciao');
		},
		customFormatter(date) {
	      return moment(date).format('MMMM Do YYYY');
	    },
	    emiCom (Com) {
	       EventBus.$emit('Comunication', Com);
	    },
	    onSearchPadre(search, loading){
	    	if (search.length < 3) {
	    		return;
	    	}
	    	loading(true);
	    	axios.get('/grimmadmin/alpaca/nuovo/findAlpaca/'+search+'?sex=0')
	    	.then(function (response) {
	    		response.data.unshift(this.padri[0]);
	    		this.padri = response.data ;
	    		loading(false);
	    	}.bind(this))
	    	.catch(function (error) {
	    		console.log(error);
	    		loading(false);
	    	})
	    },
	    onSearchMadre(search, loading){
	    	loading(true);
	    	axios.get('/grimmadmin/alpaca/nuovo/findAlpaca/'+search+'?sex=1')
	    	.then(function (response) {
	    		response.data.unshift(this.madri[0]);
	    		this.madri = response.data;
	    		loading(false);
	    	}.bind(this))
	    	.catch(function (error) {
	    		console.log(error);
	    		loading(false);
	    	})
	    },
	    onSearchAllevamento(search, loading){
	    	loading(true);
	    	axios.get('/grimmadmin/alpaca/nuovo/findAllevamento/'+search)
	    	.then(function (response) {
	    		console.log(response.data);
	    		response.data.unshift(this.allevamenti[0]);
	    		this.allevamenti = response.data;
	    		loading(false);
	    	}.bind(this))
	    	.catch(function (error) {
	    		console.log(error);
	    		loading(false);
	    	})
	    },
	    checkDate(){
	    	console.log('focusout');
	    },
	    controlloPadre(){
	    	console.log("controllaPadre");
	    }

	}
}
</script>