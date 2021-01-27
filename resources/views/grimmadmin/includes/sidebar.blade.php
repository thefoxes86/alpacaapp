
        
        <div class="admin-menu">
          <ul id="side-admin-menu" class="side-menu list-unstyled"> 

          	<li v-bind:class="{'active':menuActive[0]}"><a href="{{url('grimmadmin')}}"> <i class="fa fa-home"></i>  <span>Home</span></a></li>
            <li v-bind:class="{'active':menuActive[1]}"> 
              <a @click="openMenu('pages-nav-list-1')">
                <i class="fa fa-plus-square"></i>  
                <span>Alpaca</span>
                <div class="arrow pull-right" :class="rotateArrow('pages-nav-list-1')">
                  <i class="fa fa-angle-right"></i>
                </div>
              </a>
              <ul id="pages-nav-list-1" class="list-unstyled" :class="isSideBarOpened('pages-nav-list-1')">
                <li v-bind:class="{'active':menuActive[2]}"> <a href="{{url('grimmadmin/alpaca/nuovo')}}">Nuovo Alpaca</a></li>
                <li v-bind:class="{'active':menuActive[3]}"> <a href="{{url('grimmadmin/alpaca')}}">Tutti gli Alpaca</a></li>
              </ul>
            </li>
            @if (Auth::user()->ruolo == 'Manager' || Auth::user()->ruolo == 'Admin')
            <li v-bind:class="{'active':menuActive[4]}"> <a @click="openMenu('pages-nav-list-2')"><i class="fa fa-warehouse"></i>  <span>Allevamenti</span>
                <div class="arrow pull-right" :class="rotateArrow('pages-nav-list-2')"><i class="fa fa-angle-right" ></i></div></a>
                <ul id="pages-nav-list-2" class="list-unstyled" :class="isSideBarOpened('pages-nav-list-2')">
                  <li v-bind:class="{'active':menuActive[5]}"> <a href="{{url('grimmadmin/allevamento/nuovo')}}">Nuovo Allevamento</a></li>
                  <li v-bind:class="{'active':menuActive[6]}"> <a href="{{url('grimmadmin/allevamenti')}}">Tutti gli Allevamenti</a></li>
                </ul>
            </li>
            @endif
            @if (Auth::user()->ruolo == 'Admin' || Auth::user()->ruolo == 'Manager')
            <li v-bind:class="{'active':menuActive[7]}"> <a @click="openMenu('pages-nav-list-3')"><i class="fa fa-user"></i>  <span>Utenti</span>
                <div class="arrow pull-right" :class="rotateArrow('pages-nav-list-3')"><i class="fa fa-angle-right"></i></div></a>
              <ul id="pages-nav-list-3" class="list-unstyled" :class="isSideBarOpened('pages-nav-list-3')">
                <li v-bind:class="{'active':menuActive[8]}"> <a href="{{url('grimmadmin/user/nuovo')}}">Nuovo Utente</a></li>
                <li v-bind:class="{'active':menuActive[9]}"> <a href="{{url('grimmadmin/user')}}">Tutti gli Utenti</a></li>
              </ul>
            </li>
            @endif
            <li v-bind:class="{'active':menuActive[10]}"> <a @click="openMenu('pages-nav-list-4')"><i class="fa fa-file-alt"></i>  <span>Blog</span>
                <div class="arrow pull-right" :class="rotateArrow('pages-nav-list-4')"><i class="fa fa-angle-right"></i></div></a>
              <ul id="pages-nav-list-4" class="list-unstyled" :class="isSideBarOpened('pages-nav-list-4')">
                <li v-bind:class="{'active':menuActive[11]}"> <a href="{{url('grimmadmin/articolo/nuovo')}}">Nuovo Articolo</a></li>
                <li v-bind:class="{'active':menuActive[12]}"> <a href="{{url('grimmadmin/articoli')}}">Tutti gli articoli</a></li>
              </ul>
            </li>
            <li v-bind:class="{'active':menuActive[13]}"> <a @click="openMenu('pages-nav-list-5')"><i class="fa fa-calendar-alt"></i>  <span>Eventi</span>
                <div class="arrow pull-right" :class="rotateArrow('pages-nav-list-5')"><i class="fa fa-angle-right"></i></div></a>
              <ul id="pages-nav-list-5" class="list-unstyled" :class="isSideBarOpened('pages-nav-list-5')">
                <li v-bind:class="{'active':menuActive[14]}"> <a href="{{url('grimmadmin/evento/nuovo')}}">Nuovo Evento</a></li>
                <li v-bind:class="{'active':menuActive[15]}"> <a href="{{url('grimmadmin/eventi')}}">Tutti gli Eventi</a></li>
              </ul>
            </li>
            @if (Auth::user()->ruolo == 'Admin')
            <li v-bind:class="{'active':menuActive[16]}"> <a @click="openMenu('pages-nav-list-6')"><i class="fa fa-cogs"></i>  <span>Opzioni Admin</span>
                <div class="arrow pull-right" :class="rotateArrow('pages-nav-list-6')"><i class="fa fa-angle-right"></i></div></a>
              <ul id="pages-nav-list-6" class="list-unstyled" :class="isSideBarOpened('pages-nav-list-6')">
                <li v-bind:class="{'active':menuActive[17]}"> <a href="{{url('grimmadmin/opzione/nuova')}}">Colori e Tipologie</a></li>
               
              </ul>
            </li>
            @endif
            
          </ul>

        </div>