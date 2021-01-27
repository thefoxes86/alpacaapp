<template>
		<div class="col-12">
              <div id="daily-feeds" class="wrapper daily-feeds">
                <div id="feeds-header" class="card-header d-flex justify-content-between align-items-center">
                  <h2 class="h5 display"><a data-toggle="collapse" data-parent="#daily-feeds" href="#feeds-box" aria-expanded="true" aria-controls="feeds-box">Aggiornamenti e Notifiche </a></h2>
                  <div class="right-column">
                    
                  </div>
                </div>
                <div id="feeds-box" role="tabpanel" class="collapse show">
                  <div class="feed-box">
                    <ul class="feed-elements list-unstyled">
                      
                      <li class="clearfix" v-for="notifica in notifiche">
                        <div class="feed d-flex justify-content-between">
                          <div class="feed-body d-flex justify-content-between"><a href="#" class="feed-profile"><img :src="notifica.user.img" alt="person" class="img-fluid rounded-circle"></a>
                            <div class="content"><strong>{{notifica.user.name}} </strong><small>{{notifica.testo}} </small>
                              <div class="full-date"><small>{{formatDate(notifica.created_at)}}</small></div>
                            </div>
                          </div>
                          <div class="date"><small>{{ago(notifica.created_at)}}</small></div>
                        </div>
                      </li>
                    </ul>
                    <button class="btn btn-primary btn-lg mx-auto mb-1" @click="getMoreData()">Carica altre notifiche</button>
                  </div>
                </div>
              </div>
            </div>	
</template>	
<script>
	import moment from 'moment';
	export default{
		data: function () {
			return {
				notifiche:Array(),
				pag:0
			}
		},
		mounted(){
			console.log('Notification-Board mounted');
			moment.locale('it');
			axios.get('/grimmadmin/notifiche/getAdminNotifications',{
				params: {
					pag:this.pag
				}
			})
				.then(function (response) {
					this.pag++;					
					this.notifiche = response.data;
				}.bind(this))
				.catch(function (response) {
					console.log(response.data);
			});
		},
		methods:{
			ago(date){
				return moment(date).from(moment());
			},
			formatDate(date){
				return moment(date).format('DD MMMM YYYY', 'it');
			},
			getMoreData(){
				axios.get('/grimmadmin/notifiche/getAdminNotifications',{
					params: {
						pag:this.pag
					}
				})
					.then(function (response) {
						this.pag++;
						this.notifiche = this.notifiche.concat(response.data);	
										
					}.bind(this))
					.catch(function (response) {
						console.log(response.data);
				});
			}
		}
	}
</script>