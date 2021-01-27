      <footer class="main-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <p>Your company &copy; 2017-2019</p>
            </div>
            <div class="col-sm-6 text-right">
              <p>Design by <a href="https://bootstrapious.com" class="external">Bootstrapious</a></p>
              <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
            </div>
          </div>
        </div>
      </footer>
    </div>
    <!-- Javascript files-->
    
    <script src="{{url('/')}}/admin/vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="{{url('/')}}/admin/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="{{url('/')}}/admin/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    
    
    {{-- <script src="{{url('/')}}/admin/js/front.js"></script> --}}
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

   
    <script src="{{url('/')}}/js/appAdmin.js"></script>

    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID.-->
    <!---->
    <script>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='//www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
      ga('create','UA-XXXXX-X');ga('send','pageview');
    </script>
    <script type="text/javascript">
        $('#checkboxCustom1').on('click', function () {
          $(this).val(this.checked ? 'yes' : 'not');
        });
    </script>
