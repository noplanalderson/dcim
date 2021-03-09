<?php defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Data Center Inventory Management -Dinas Kominfo kota Tangerang by <a href="https://instagram.com/__debu_semesta">debu semesta</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?= BASEURL;?>public/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?= BASEURL;?>public/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?= BASEURL;?>public/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?= BASEURL;?>public/vendors/nprogress/nprogress.js"></script>
    <!-- Datatables -->
    <script src="<?= BASEURL;?>public/vendors/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?= BASEURL;?>public/vendors/datatables/js/dataTables.buttons.min.js"></script>
    <script src="<?= BASEURL;?>public/vendors/datatables/js/buttons.bootstrap.min.js"></script>
    <script src="<?= BASEURL;?>public/vendors/datatables/js/buttons.html5.min.js"></script>
    <script src="<?= BASEURL;?>public/vendors/datatables/js/buttons.print.min.js"></script>
    <script src="<?= BASEURL;?>public/vendors/datatables/js/jszip.min.js"></script>
    <script src="<?= BASEURL;?>public/vendors/datatables/js/pdfmake.min.js"></script>
    <script src="<?= BASEURL;?>public/vendors/datatables/js/vfs_fonts.js"></script>    
    <script src="<?= BASEURL;?>public/vendors/datatables/js/buttons.colVis.min.js"></script>
    <script src="<?= BASEURL;?>public/vendors/datatables/js/dataTables.responsive.min.js"></script> 
    <script src="<?= BASEURL;?>public/vendors/datatables/js/responsive.bootstrap.js"></script>
    <script src="<?= BASEURL;?>public/vendors/easyautocomplete/jquery.easy-autocomplete.min.js"></script> 
    <!-- Custom Theme Scripts -->
    <script src="<?= BASEURL;?>public/assets/js/custom.js"></script>
    <script src="<?= BASEURL;?>public/assets/js/autocomplete.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
      var groupColumn = 1;
      var table = $('#sla').DataTable({
        responsive: true,
        columnDefs: [{ 
        "visible": false,
        "targets": groupColumn
        },
        { 
          "targets": 'no-sort',
          "orderable": false
        },
        { 
          "targets": [0],
          "visible": false,
          "searchable": false,
          "orderData": [0]
        }],
      "drawCallback": function (settings)
      {
        var api = this.api();
        var rows = api.rows( {page:'current'} ).nodes();
        var last=null;

        api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
          if ( last !== group )
          {
              $(rows).eq( i ).before('<tr class="group"><td colspan="5">'+group+'</td></tr>');
              last = group;
          }
        });
      },
      dom: 'Bfrtip',
      buttons: [
          {
              extend: 'copyHtml5',
              exportOptions: {
                  columns: [ 0, ':visible' ]
              }
          },
          {
              extend: 'excelHtml5',
              pageSize: 'Legal',
              title: "SLA Summary <?= $data['isp'];?>",
              exportOptions: {
                  columns: [ 1,2,3,4,5 ],
              }
          },
          {
              extend: 'pdfHtml5',
              pageSize: 'Legal',
              orientation: 'landscape',
              title: "SLA Summary <?= $data['isp'];?>",
              exportOptions: {
                  columns: [ 1, 2, 3, 4, 5 ],
              },
                customize : function(doc) { 
                  margin: [12, 0, 0, 12];
                  alignment: 'center';
                  doc.styles.tableHeader.alignment = 'center';
                  doc.content[1].table.widths = [150,150,150,100,80,200,200];
              }
          },
          'colvis'
        ]
      });
    });
    </script>
  </body>
</html>