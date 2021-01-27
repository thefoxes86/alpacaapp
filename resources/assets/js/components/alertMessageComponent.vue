<template>
	<div class="flash-message" v-if="com" id="grimm-message">
  		<p class="alert" v-bind:class="[alertClass]">{{message}}<a href="/" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
	</div> <!-- end .flash-message -->
</template>
<script>
	import EventBus from '../event-bus';
	export default{
		data:function(){
			return{
				com:false,
				message:'',
				alertClass:''
			}
		},
		mounted(){
			console.log(this);
			EventBus.$on('Comunication', function (data) {
				console.log(data);
				console.log(this); 
		      if (data['success'] == 1) {	
		      	this.com = true;
		      	this.message = data['message'];
		      	this.alertClass = 'alert-success';
		      } else {
		      	if (data['success'] == 2) {
		      		this.com = true;
		      		this.message = data['message'];
		      		this.alertClass = 'alert-warning';
		      	} else {
		      		this.com = true;
		      		this.message = data['message'];
		      		this.alertClass = 'alert-danger';
		      	}
		      }
		    }.bind(this));
		}
	}
</script>