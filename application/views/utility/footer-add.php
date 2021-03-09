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
    <script src="<?= site_url();?>assets/vendors/select2/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.5/js/bootstrap-select.min.js"></script>
    <script src="<?= site_url();?>assets/vendors/easyautocomplete/jquery.easy-autocomplete.min.js"></script> 
    <!-- Custom Theme Scripts -->
    <script src="<?= site_url();?>assets/js/custom.js"></script>
    <script src="<?= site_url();?>assets/js/autocomplete.js"></script>
    <script type="text/javascript">
    /* PARSLEY */
      
    function init_parsley() {
      
      if( typeof (parsley) === 'undefined'){ return; }
      console.log('init_parsley');
      
      $/*.listen*/('parsley:field:validate', function() {
        validateFront();
      });
      $('#demo-form .btn').on('click', function() {
        $('#demo-form').parsley().validate();
        validateFront();
      });
      var validateFront = function() {
        if (true === $('#demo-form').parsley().isValid()) {
        $('.bs-callout-info').removeClass('hidden');
        $('.bs-callout-warning').addClass('hidden');
        } else {
        $('.bs-callout-info').addClass('hidden');
        $('.bs-callout-warning').removeClass('hidden');
        }
      };
      
      $/*.listen*/('parsley:field:validate', function() {
        validateFront();
      });
      $('#device .btn').on('click', function() {
        $('#device').parsley().validate();
        validateFront();
      });
      var validateFront = function() {
        if (true === $('#demo-form2').parsley().isValid()) {
        $('.bs-callout-info').removeClass('hidden');
        $('.bs-callout-warning').addClass('hidden');
        } else {
        $('.bs-callout-info').addClass('hidden');
        $('.bs-callout-warning').removeClass('hidden');
        }
      };

      $/*.listen*/('parsley:field:validate', function() {
        validateFront();
      });
      $('#hardware .btn').on('click', function() {
        $('#hardware').parsley().validate();
        validateFront();
      });
      var validateFront = function() {
        if (true === $('#demo-form2').parsley().isValid()) {
        $('.bs-callout-info').removeClass('hidden');
        $('.bs-callout-warning').addClass('hidden');
        } else {
        $('.bs-callout-info').addClass('hidden');
        $('.bs-callout-warning').removeClass('hidden');
        }
      };

      $/*.listen*/('parsley:field:validate', function() {
        validateFront();
      });
      $('#device .btn').on('click', function() {
        $('#device').parsley().validate();
        validateFront();
      });
      var validateFront = function() {
        if (true === $('#device').parsley().isValid()) {
        $('.bs-callout-info').removeClass('hidden');
        $('.bs-callout-warning').addClass('hidden');
        } else {
        $('.bs-callout-info').addClass('hidden');
        $('.bs-callout-warning').removeClass('hidden');
        }
      };

      $/*.listen*/('parsley:field:validate', function() {
        validateFront();
      });
      $('#manufacture .btn').on('click', function() {
        $('#manufacture').parsley().validate();
        validateFront();
      });
      var validateFront = function() {
        if (true === $('#manufaktur').parsley().isValid()) {
        $('.bs-callout-info').removeClass('hidden');
        $('.bs-callout-warning').addClass('hidden');
        } else {
        $('.bs-callout-info').addClass('hidden');
        $('.bs-callout-warning').removeClass('hidden');
        }
      };

      $/*.listen*/('parsley:field:validate', function() {
        validateFront();
      });
      $('#manu-hw .btn').on('click', function() {
        $('#manu-hw').parsley().validate();
        validateFront();
      });
      var validateFront = function() {
        if (true === $('#manu-hw').parsley().isValid()) {
        $('.bs-callout-info').removeClass('hidden');
        $('.bs-callout-warning').addClass('hidden');
        } else {
        $('.bs-callout-info').addClass('hidden');
        $('.bs-callout-warning').removeClass('hidden');
        }
      };

      $/*.listen*/('parsley:field:validate', function() {
        validateFront();
      });
      $('#model .btn').on('click', function() {
        $('#model').parsley().validate();
        validateFront();
      });
      var validateFront = function() {
        if (true === $('#model').parsley().isValid()) {
        $('.bs-callout-info').removeClass('hidden');
        $('.bs-callout-warning').addClass('hidden');
        } else {
        $('.bs-callout-info').addClass('hidden');
        $('.bs-callout-warning').removeClass('hidden');
        }
      };   

        try {
        hljs.initHighlightingOnLoad();
        } catch (err) {}
      
    };
    $('#dev_icon').selectpicker();
    $('#hw_icon').selectpicker();
    </script>
  </body>
</html>