<template>
	<div class="card mt-3 col-12 galleryComponent" >
		<h3 class="card-header">Galleria</h3>
		<div class="card-body">
			<div class="row galleyPreviewBox">
				<div v-for="file in allfoto" class="col-4 singleFoto">
					<img  :src="file" alt="" class="img-fluid">
					<span @click="cancellaFoto(file)">
						<i class="fas fa-times-circle"></i>
					</span>
				</div>
			</div>
			<form class="mt-3 w-100 d-block" enctype="multipart/form-data">
				<input type="file" name="gallery" multiple @change="uploadFoto($event.target.name, $event.target.files)" accept="image/*" class="input-file w-100">
				<input type="hidden" :value="folder" name="cartella">
				<label for="file" class="btn col-12 btn-primary">Aggiungi File</label>
			</form>
		</div>
	</div>
</template>
<script>
	import { upload } from './lib/upload';
    import * as axios from 'axios';
    import EventBus from '../event-bus';
	const STATUS_INITIAL = 0, STATUS_SAVING = 1, STATUS_SUCCESS = 2, STATUS_FAILED = 3;
	export default{
		data:function () {
			return {
				fotoList:new Array(),
				fotoOldList:new Array(),
				allfoto:new Array()
			}
		},
		mounted(){
			console.log('componento galleria Check');
			if (this.preload.length>0) {
				this.fotoOldList = this.preload;
				this.allfoto = this.fotoList.concat(this.fotoOldList);
			}
			
		},
		props:{
			uploadto:{
				type:String,
				default:''
			},
			cancelfrom:{
				type:String,
				default:''
			},
			folder:{
				type:String,
				default:''
			},
			preload:{
				type:Array,
				default: function () { return [] }
			},
			id:{
				type:Number,
				default:0
			}
		},
		methods:{
			uploadFoto(fieldName, fileList){
				const formData = new FormData();
				console.log('lenght'+fileList.length);
		        if (!fileList.length) return;
		        
		        for (var i = 0; i < fileList.length; i++) {
		        	formData.append('gallery[]',fileList[i]);
		        }
		        formData.append('cartella', this.folder);
		        formData.append('id', this.id);
		        
				axios.post(this.uploadto, formData)
				.then(function (response) {
					console.log(response);
					this.fotoList = response.data['nuove'];
					this.fotoOldList = response.data['vecchie'];
					this.allfoto = this.fotoList.concat(this.fotoOldList);
					//this.fotoList.concat(response.data);
				}.bind(this))
				.catch(function (response) {
					console.log(response);
				}.bind(this))
			},
			cancellaFoto(url){
				var positionToErase = -1;

					this.fotoList.forEach( function(element, index) {
						if (element == url) {
							positionToErase = index;
						}
					});
					axios.post(this.cancelfrom, {
						name:url,
						id:this.id
					})
						.then(function (response) {
							console.log(response);
							this.allfoto = response.data;
							// this.fotoList = response.data['nuove'];
							// this.fotoOldList = response.data['vecchie'];
							// this.allfoto = this.fotoList.concat(this.fotoOldList);
							//this.fotoList.concat(response.data);
						}.bind(this))
						.catch(function (response) {
							console.log(response);
						}.bind(this));

					if(positionToErase > -1)this.fotoList.splice(positionToErase,1);
			

			}

		},
		computed: {
	      isInitial() {
	        return this.currentStatus === STATUS_INITIAL;
	      },
	      isSaving() {
	        return this.currentStatus === STATUS_SAVING;
	      },
	      isSuccess() {
	        return this.currentStatus === STATUS_SUCCESS;
	      },
	      isFailed() {
	        return this.currentStatus === STATUS_FAILED;
	      }
	    },

	}
</script>