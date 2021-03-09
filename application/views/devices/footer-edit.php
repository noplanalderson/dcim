<?php defined('BASEPATH') OR die('No Direct Script Access Allowed');?>
        <!-- footer content -->
        <footer>
          <div class="pull-right">
            <?= $this->app['app_title'];?> - <?= $this->app['app_copyright'];?> by <a href="https://instagram.com/__debu_semesta">debu semesta</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?= site_url();?>assets/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?= site_url();?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?= site_url();?>assets/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?= site_url();?>assets/vendors/nprogress/nprogress.js"></script>
    <!-- Parsley -->
    <script src="<?= site_url();?>assets/vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Select2 -->
    <script src="<?= site_url();?>assets/vendors/select2/js/select2.min.js"></script>
    <!-- iCheck -->
    <script src="<?= site_url();?>assets/vendors/iCheck/icheck.min.js"></script>
    <!-- tags -->
    <script src="<?= site_url();?>assets/vendors/tags/jquery.tagsinput.min.js"></script>
    <script src="<?= site_url();?>assets/vendors/easyautocomplete/jquery.easy-autocomplete.min.js"></script> 
    <!-- Custom Theme Scripts -->
    <script src="<?= site_url();?>assets/js/custom.js"></script>
    <script src="<?= site_url();?>assets/js/autocomplete.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
      $(".manufacture").select2({
          placeholder: "Choose Device Manufacture..",
            allowClear: true
      });
      $(".model").select2({
          placeholder: "Choose Device Model..",
            allowClear: true
      });
      $(".server").select2({
          placeholder: "Choose Server..",
            allowClear: true
      }); 
      $('.model-hw').tagsInput({
        width: 'auto',
        defaultText:'Add Model',
      });
      $('.size-hw').tagsInput({
        width: 'auto',
        defaultText:'Add Size',
      });
    });
    </script>
  </body>
</html>