<template>
  <div>
    <div>
      <!--UPLOAD-->
      <form enctype="multipart/form-data" novalidate v-if="isInitial || isSaving">
        <h1>Upload images</h1>
        <div class="dropbox">
          <input type="file" :name="uploadFieldName" :disabled="isSaving" @change="filesChange($event.target.name, $event.target.files); fileCount = $event.target.files.length" accept="image/*" class="input-file">
          <p v-if="isInitial">
            Drag your file(s) here to begin<br> or click to browse
          </p>
          <p v-if="isSaving">
            Uploading {{ fileCount }} files...
          </p>
        </div>
      </form>
      <div v-if="isSuccess" class="row">
        <div v-if="!modifica" class="alert alert-success col-12" role="alert">
          Caricamento Completato!
        </div>
        
        
          <div class="col-12" v-for="image in uploadedFiles">
            <img :src="image.outsidePath" class="img-fluid">
          </div>
       
        <div class="col-12">
          <div class="btn btn-warning w-100 text-center" @click="modificaFoto()">Modifica</div>
        </div>    
      </div>
      <div v-if="isFailed" class="row">
        <div class="alert alert-danger col-12" role="alert">
          Qualcosa é andato storto (forse il file é corrotto oppure é troppo grande)
        </div>
      </div>
    </div>
  </div>
</template>
<script>
    import { upload } from './lib/upload';
    import * as axios from 'axios';
    const STATUS_INITIAL = 0, STATUS_SAVING = 1, STATUS_SUCCESS = 2, STATUS_FAILED = 3;
    const BASE_URL = 'http://www.registroitalianoalpaca.it';
    export default {
      data:function(){
        return{
          uploadedFiles: [],
          uploadError: null,
          currentStatus: null,
          modifica:false,
          uploadFieldName: 'photos'
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
    props:{
      immagine:{
        type:String,
        default: '', 
      },
      url:''
    },
    methods: {
      modificaFoto(){
        var r = confirm("La foto verrá concellata dal DataBase. Sei sicuro di voler proseguire?");
        if (r == true) {
          var url = `${BASE_URL}`+this.url+'/cancella';
          var id = window.location.href;
          id = id.split('/');
          id = id[id.length-1];
          id = {'id':id};
          axios.post(url, id)
            .then(function (response) {
              if (response.data == 'hey.') {
                this.reset();
              }
            }.bind(this));
        }
      },
      reset() {
        // reset form to initial state
        this.currentStatus = STATUS_INITIAL;
        this.uploadedFiles = [];
        this.uploadError = null;
      },
      setModifica(){
        console.log(this.immagine);
        this.currentStatus = STATUS_SUCCESS;
        this.uploadedFiles.push({outsidePath:this.immagine}) ;
        this.modifica = true;
        this.uploadError = null;
      },
      save(formData) {
        // upload data to the server
        this.currentStatus = STATUS_SAVING;
        var url = `${BASE_URL}`+this.url;
        axios.post(url, formData)
        .then(function (response) {
          console.log(response);
          this.uploadedFiles = [].concat(response.data);
          this.currentStatus = STATUS_SUCCESS;
        }.bind(this))
        .catch(function (err) {
          console.log(err);
          this.uploadError = err.response;
          this.currentStatus = STATUS_FAILED;
        }.bind(this));


      },
      filesChange(fieldName, fileList) {
        // handle file changes
        const formData = new FormData();
        console.log(fieldName);
        console.log(fileList);
        if (!fileList.length) return;
        var count= 0 ;
        formData.append('photos',fileList[0]);
          this.save(formData);
        }
      },
      mounted() {
        
        
        if (this.immagine == '') {
          this.reset();
        }else{
          if (this.immagine == '/img/AlpacaDefaultProfile.svg' || this.immagine == '/img/AllevamentoDefault.svg') {
            this.reset();
            return;
          }
          this.setModifica();
        }
        
        console.log('upload montato');
      }
    }
</script>
