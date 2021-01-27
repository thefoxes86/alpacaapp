//require('./bootstrap');

window.Vue = require('vue');
import VeeValidate from 'vee-validate';
import message_alert from './components/alertMessageComponent.vue';
import EventBus from './event-bus';
import vSelect from 'vue-select';
import * as VueGoogleMaps from 'vue2-google-maps';
import GmapCluster from 'vue2-google-maps/dist/components/cluster' ;

var VueScrollTo = require('vue-scrollto');
Vue.use(VueScrollTo);




Vue.use(VeeValidate);
Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyCxKkDRzsRMtJL2JseEqM0qnTacxFmQ4CE',
    libraries: 'places'
  },
 
})

Vue.component('form-nuovo-alpaca', require('./components/FormNuovoAlpacaComponent.vue'));
Vue.component('message-alert', require('./components/alertMessageComponent.vue'));
Vue.component('file-upload', require('./components/fileUpload.vue'));
Vue.component('single-alpaca', require('./components/singlealpaca.vue'));
Vue.component('single-user', require('./components/singleuser.vue'));
Vue.component('single-allevamento', require('./components/singleallevamento.vue'));
Vue.component('form-nuovo-allevamento', require('./components/FormNuovoAllevamento.vue'));
Vue.component('form-nuova-opzione', require('./components/FormNuovaOpzione.vue'));
Vue.component('categorie-admin', require('./components/categorieComponent.vue'));
Vue.component('nuovo-post', require('./components/newPostComponent.vue'));
Vue.component('single-post', require('./components/singlepost.vue'));
Vue.component('form-nuovo-evento', require('./components/FormEvento.vue'));
Vue.component('single-eventi', require('./components/SingleEvento.vue'));
Vue.component('grimm-gallery', require('./components/galleryComponent.vue'));
Vue.component('pannello-eventi', require('./components/pannelloEventi.vue'));
Vue.component('pannello-utenti', require('./components/pannelloUtenti.vue'));
Vue.component('dashboard-count', require('./components/dashboardCount.vue'));
Vue.component('pannello-notifiche', require('./components/notificationBoard.vue'));



Vue.component('v-select', vSelect);
Vue.component('gmapcluster', GmapCluster)

const app = new Vue({
    el: '#app',
    data:{
    	
    }   
});

window.sideBarApp = new Vue({
    el: '#sideBarApp',
    data:{
    	sideBarOpen:'',
        sideBarActive:false,
        menuActive:[false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,]
    },
    mounted:function () {
    	console.log('App Admin Check');
    },
    methods:{
    	isSideBarOpened:function(id){
    		return this.sideBarOpen == id ? '' : 'collapse';
    	},
    	openMenu:function(id){
    		this.sideBarOpen = id;
    	},
    	rotateArrow:function(id){
    		return this.sideBarOpen != id ? '' : 'rotate';
    	},
        openMenuder(){
            console.log('active');
            sideBarActive = !sideBarActive;
        }
    }
    
});
const headerApp = new Vue({
    el: '#headerApp',
    data:{
        open:false,
    },
    methods:{
        log(){
            window.sideBarApp.sideBarActive = !window.sideBarApp.sideBarActive;
            this.open = !this.open;

        },
        logout(){
            console.log('redirecto');
            window.location.href = '/grimmadmin/logout';
        }
    }   
});


