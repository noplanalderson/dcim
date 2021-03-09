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
    <script src="<?= site_url();?>assets/vendors/jspdf/jspdf.debug.js"></script>
    <script src="<?= site_url();?>assets/vendors/jspdf/autotable.js"></script>
    <script src="<?= site_url();?>assets/vendors/easyautocomplete/jquery.easy-autocomplete.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?= site_url();?>assets/js/custom.js"></script>
    <script src="<?= site_url();?>assets/js/autocomplete.js"></script>
    <script type="text/javascript">
    function printContent() {
      var doc = new jsPDF();

      doc.autoTable({
        html: '#tab_detail',
        bodyStyles: {minCellHeight: 15},
        didDrawCell: function(data) {
          if (data.row.index === 14 && data.column.index === 1) {
             var td = data.cell.raw;
             var img = td.getElementsByTagName('img')[0];
             var textPos = data.cell.textPos;
             doc.addImage(img.src, textPos.x,  textPos.y, 50, 50);
          }
        }
      });

      doc.save("<?= $device['hostname'];?>.pdf");
    }
    </script>
  </body>
</html>
