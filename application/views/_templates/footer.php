<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

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
    <script src="<?= site_url();?>assets/vendors/select2/dist/js/select2.min.js"></script>
    <!-- iCheck -->
    <script src="<?= site_url();?>assets/vendors/iCheck/icheck.min.js"></script>
    <script src="<?= site_url();?>assets/vendors/easyautocomplete/jquery.easy-autocomplete.min.js"></script> 
    <!-- Custom Theme Scripts -->
    <script src="<?= site_url();?>assets/js/custom.js"></script>
    <script src="<?= site_url();?>assets/js/autocomplete.js"></script>
    <script type="text/javascript">
    $(document).ready(function() { 
      $(".manufaktur").select2({
          placeholder: "Pilih Manufaktur..",
            allowClear: true
        });
      $(".model").select2({
          placeholder: "Pilih Model..",
            allowClear: true
        });
      $(".server").select2({
          placeholder: "Pilih Server..",
            allowClear: true
        });
      $(".hypervsor").select2({
          placeholder: "Pilih Hypervsor..",
            allowClear: true
        });   
      });
      $(document).on('click', '.browse', function(){
        var file = $(this).parent().parent().parent().find('.file');
        file.trigger('click');
      });
      $(document).on('change', '.file', function(){
        $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
      });
    </script>
  </body>
</html>