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
    <script src="<?= site_url();?>assets/vendors/jquery/dist/jquery-ui.js"></script>
    <script src="<?= site_url();?>assets/vendors/datetimepicker/dist/jquery-ui-timepicker-addon.js"></script>
    <script src="<?= site_url();?>assets/vendors/easyautocomplete/jquery.easy-autocomplete.min.js"></script> 
    <!-- Custom Theme Scripts -->
    <script src="<?= site_url();?>assets/js/autocomplete.js"></script>
    <script src="<?= site_url();?>assets/js/custom.js"></script>
    <script type="text/javascript">
    var startDateTextBox = $('#downtime');
    var endDateTextBox = $('#uptime');

    $.timepicker.datetimeRange(
      startDateTextBox,
      endDateTextBox,
      {
        minInterval: (1000*60), // 1mnt
        dateFormat: 'yy-mm-dd', 
        timeFormat: 'HH:mm:ss',
        start: {}, // start picker options
        end: {} // end picker options         
      }
    );
    </script>
  </body>
</html>