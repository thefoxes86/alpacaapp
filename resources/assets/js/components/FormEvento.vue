<template>
<div>
  <div class="form-group">
    <label>Titolo</label>
    <input type="text" name="name" v-model="titolo" placeholder="Nome" class="form-control" value="">
  </div>
  
  <div class="form-group">
    <label>Contenuto</label>
    <textarea type="text" v-model="contenuto" rows="20" name="note" placeholder="" class="form-control" value=""></textarea>
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
    <div class="help-block alert alert-danger" v-if="errors.has('indirizzo')">
      <span>Devi inserire un indirizzo valido</span>
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
  <div class="form-group">
    <label>Data</label>
    <datepicker v-model="dataEvento" :language="'it'" name="dataNascita" bootstrap-styling :format="customFormatter"></datepicker>
  </div>
  <div class="form-group">                        
    <input type="submit" value="Registra" class="btn btn-primary" @click="sendForm()">
  </div>
</div>
</template>
<script>
  import {gmapApi} from 'vue2-google-maps';
  import Datepicker from 'vuejs-datepicker';
  import moment from 'moment';
  import {en, it} from 'vuejs-datepicker/dist/locale'
  export default{
    data:function(){
      return{
        coord:{lat:44,lng:10},
        mapLoaded: true,
        modifica:false,
        marker:null,
        places: [],
        currentPlace: null,
        dataEvento:'',
        citta:'',
        provincia:'',
        cap:'',
        indirizzo:'',
        titolo:'',
        contenuto:'',
        indirizzo_sint:''
      }
    },
    mounted(){
      console.log('Componente evento montato');
      if (this.evento != null) {
        this.titolo = this.evento.titolo;
        this.contenuto = this.evento.contenuto;
        this.coord = {lat:Number(this.evento.lat),lng:Number(this.evento.lon)};
        this.indirizzo_sint = this.evento.indirizzo;
        this.indirizzo = this.indirizzo_sint;
        this.dataEvento = this.evento.data;
        // this.testo = this.post.testo;
        // this.categoria = this.post.categoria;
        this.modifica = true;
      }
      moment.locale('it');
      this.geolocate();
    },
    computed:{
      google:gmapApi,

    },
    props:{
      evento:{
            type:Object,
            default: ()=>(null),
          }
    },
    methods:{
      getMarkerPosition(marker){
        this.coord.lat = marker.lat();
        this.coord.lng = marker.lng();
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
        },
        customFormatter(date) {
          return moment(date).format('d MMMM YYYY');
        },
        sendForm(){
          var url = '';
          if (this.modifica) {
            var id = window.location.href;
            id = id.split('/');
            id = id[id.length-1];
            url = '/grimmadmin/evento/update/'+id;
          }else{
            url = '/grimmadmin/evento/nuovo';
          }
          axios.post(url, {
              titolo: this.titolo,
              contenuto:this.contenuto,
              indirizzo:this.indirizzo,
              lat: this.coord.lat,
              lon: this.coord.lng,
              data: this.dataEvento
          }).then(function(response){
            if (response.data == 'hey.') {
              window.location.href = '/grimmadmin/eventi';
            }
          }.bind(this))
          .catch(function(response){
            console.log(response);
          }.bind(this))
        }
      },
    components:{
      Datepicker
    }
  }
</script>