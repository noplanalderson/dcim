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
    <!-- Datatables -->
    <script src="<?= site_url();?>assets/vendors/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?= site_url();?>assets/vendors/datatables/js/dataTables.buttons.min.js"></script>
    <script src="<?= site_url();?>assets/vendors/datatables/js/buttons.bootstrap.min.js"></script>
    <script src="<?= site_url();?>assets/vendors/datatables/js/buttons.html5.min.js"></script>
    <script src="<?= site_url();?>assets/vendors/datatables/js/buttons.print.min.js"></script>
    <script src="<?= site_url();?>assets/vendors/datatables/js/jszip.min.js"></script>
    <script src="<?= site_url();?>assets/vendors/datatables/js/pdfmake.min.js"></script>
    <script src="<?= site_url();?>assets/vendors/datatables/js/vfs_fonts.js"></script>    
    <script src="<?= site_url();?>assets/vendors/datatables/js/buttons.colVis.min.js"></script>
    <script src="<?= site_url();?>assets/vendors/easyautocomplete/jquery.easy-autocomplete.min.js"></script> 
    <!-- Custom Theme Scripts -->
    <script src="<?= site_url();?>assets/js/custom.js"></script>
    <script src="<?= site_url();?>assets/js/autocomplete.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#devices').DataTable({
            "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
            }],
            columns: [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                {
                    "render": function(data, type, row){
                        return data.split(",").join("<br/>\n");
                    }
                },
                {
                    "render": function(data, type, row){
                        return data.split(",").join("<br/>\n");
                    }
                },
                {
                    "render": function(data, type, row){
                        return data.split(",").join("<br/>\n");
                    }
                },
                {
                    "render": function(data, type, row){
                        return data.split(",").join("<br/>\n");
                    }
                },
                null,
                null,
                null,
                null,
                null
            ],
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
                    title: "Daftar Perangkat <?= ucwords($dev_group);?> Pemerintah Kota Tangerang",
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    pageSize: 'Legal',
                    orientation: 'landscape',
                    title: "Daftar Perangkat <?= ucwords($dev_group);?> Pemerintah Kota Tangerang",
                    exportOptions: {
                        columns: ':visible',
                        stripNewlines: false
                    },
                    customize : function(doc) 
                    {
                        doc.content.splice(0, 1, {
                          text: [
                            {
                                text: "Daftar Perangkat <?= ucwords($dev_group);?> Pemerintah Kota Tangerang \n\n",
                                fontSize: 14,
                                alignment: 'center'
                            }, 
                            {
                                text: "Total <?= ucwords($dev_group).' : '.$countdev;?> Unit\n\n\n",
                                fontSize: 9,
                                alignment: 'left'
                            }
                          ]
                        });
                        margin: [5, 0, 0, 5];
                        alignment: 'center';
                        doc.styles.tableHeader.alignment = 'center'
                        doc.defaultStyle.fontSize = 6;
                        doc.styles.tableHeader.fontSize = 6;

                        var colCount = new Array();
                        var tr = $('#devices tbody tr:first-child');
                        var trWidth = $(tr).width();

                        var length = $('#devices tbody tr:first-child td').length;

                        $('#devices').find('tbody tr:first-child td').each(function()
                        {
                            var tdWidth = $(this).width();
                            var widthFinal = parseFloat(tdWidth * 120);
                            widthFinal = widthFinal.toFixed(2) / trWidth.toFixed(2);
                            if ($(this).attr('colspan')) 
                            {
                                for (var i = 1; i <= $(this).attr('colspan'); $i++) {
                                    colCount.push('*');
                                }
                            } 
                            else 
                            {
                                colCount.push(parseFloat(widthFinal.toFixed(2)) + '%');
                            }
                        });
                        doc.content[1].table.widths = colCount;
                    }
                },
                'colvis'
            ]
        });
    });
    </script>
  </body>
</html>