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
    <!-- High Chart-->
    <script src="<?= site_url();?>assets/vendors/highcharts/code/highcharts.js"></script>
    <script src="<?= site_url();?>assets/vendors/export/jspdf.js"></script>
    <script src="<?= site_url();?>assets/vendors/export/exporting.js"></script>
    <script src="<?= site_url();?>assets/vendors/export/offline-exporting.js"></script>
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
    <script src="<?= site_url();?>assets/vendors/datatables/js/dataTables.responsive.min.js"></script>     
    <!-- Parsley -->
    <script src="<?= site_url();?>assets/vendors/parsleyjs/dist/parsley.min.js"></script>
    <script src="<?= site_url();?>assets/vendors/jquery/dist/jquery-ui.js"></script>
    <script src="<?= site_url();?>assets/vendors/datetimepicker/dist/jquery-ui-timepicker-addon.js"></script>
    <script src="<?= site_url();?>assets/vendors/easyautocomplete/jquery.easy-autocomplete.min.js"></script> 
    <!-- Custom Theme Scripts -->
    <script src="<?= site_url();?>assets/js/custom.js"></script>
    <script src="<?= site_url();?>assets/js/autocomplete.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){

        $('.update').on('click', function() {
            $('#judulModal').html('Sunting ISP');
            $('.modal-footer button[type=submit]').html('Sunting');
            $('.modal-body form').attr('action', '<?= base_url("sla-summary/edit");?>');

            const id_sla = $(this).data('id');
            $.ajax({
                url: '<?= site_url("sla-summary/get_sla");?>',
                data: {
                  id: id_sla,
                  <?= $this->security->get_csrf_token_name();?>: $('input[name="<?= $this->security->get_csrf_token_name();?>"]').attr('value')
                },
                method: 'post',
                dataType: 'json',
                success: function(data){
                    $('input[name="<?= $this->security->get_csrf_token_name();?>"]').val(data.token);
                    $('#sla_id').val(id_sla);
                    $('#isp_id').val(data.isp_id);
                    $('#downtime').val(data.downtime);
                    $('#uptime').val(data.uptime);
                    $('#cause').val(data.cause);
                    $('#solution').val(data.solution);
                }
            });
        });
    });

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

    var nav = Highcharts.win.navigator,
        isMSBrowser = /Edge\/|Trident\/|MSIE /.test(nav.userAgent),
        isEdgeBrowser = /Edge\/\d+/.test(nav.userAgent),
        containerEl = document.getElementById("<?= $isp['slug'];?>"),
        parentEl = containerEl.parentNode,
        oldDownloadURL = Highcharts.downloadURL;

    function addText(text) {
        var heading = document.createElement('h2');
        heading.innerHTML = text;
        parentEl.appendChild(heading);
    }

    function addURLView(title, url) {
        var iframe = document.createElement('iframe');
        if (isMSBrowser && Highcharts.isObject(url)) {
            addText(title +
            ': Microsoft browsers do not support Blob iframe.src, test manually'
            );
            return;
        }
        iframe.src = url;
        iframe.width = 400;
        iframe.height = 300;
        iframe.title = title;
        iframe.style.display = 'none';
        //parentEl.appendChild(iframe);
    }

    function fallbackHandler(options) {
        if (options.type !== 'image/svg+xml' && isEdgeBrowser ||
            options.type === 'application/pdf' && isMSBrowser) {
            addText(options.type + ' fell back on purpose');
        } else {
            throw 'Should not have to fall back for this combination. ' +
                options.type;
        }
    }

    Highcharts.downloadURL = function (dataURL, filename) {
        // Emulate toBlob behavior for long URLs
        if (dataURL.length > 2000000) {
            dataURL = Highcharts.dataURLtoBlob(dataURL);
            if (!dataURL) {
                throw 'Data URL length limit reached';
            }
        }
        // Show result in an iframe instead of downloading
        addURLView(filename, dataURL);
    };

    Highcharts.Chart.prototype.exportTest = function (type) {
        this.exportChartLocal({
            type: type
        }, {
            title: {
                text: type
            },
            subtitle: {
                text: false
            }
        });
    };

    Highcharts.Chart.prototype.callbacks.push(function (chart) {
        if (!chart.options.chart.forExport) {
            var menu = chart.exportSVGElements && chart.exportSVGElements[0],
                oldHandler;
            chart.exportTest('image/png');
            chart.exportTest('image/jpeg');
            chart.exportTest('image/svg+xml');
            chart.exportTest('application/pdf');

            // Allow manual testing by resetting downloadURL handler when trying
            // to export manually
            if (menu) {
                oldHandler = menu.element.onclick;
                menu.element.onclick = function () {
                    Highcharts.downloadURL = oldDownloadURL;
                    oldHandler.call(this);
                };
            }
        }
    });

    /* End of automation code */

        var chart; 
        $(document).ready(function() {
              chart = new Highcharts.Chart(
              {
                  
                 chart: {
                    renderTo: "<?= $isp['slug'];?>",
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                 },   
                 title: {
                    text: "SLA <?= $isp['isp_name'].' '.$month;?>",
                 },
                 tooltip: {
                    formatter: function() {
                        return '<b>'+
                        this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 2) +' % ';
                    }
                 },
                 
                
                 plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            color: '#777',
                            connectorColor: '#777',
                            formatter: function() 
                            {
                                return '<b>' + this.point.name + '</b>: ' + Highcharts.numberFormat(this.percentage, 2) +' % ';
                            }
                        }
                    }
                 },
                    series: [{
                    type: 'pie',
                    name: 'SLA',
                    data: [
                      ['Uptime', <?= $chart['uptime'];?>],
                      ['Downtime', <?= $chart['downtime'];?>],
                      ['Kewajaran', <?= $chart['wajar'];?>]
                    ]
                }]
              });
        });

    $(document).ready(function() {
      var table = $('#sla_summary').DataTable({
        responsive: true,
        columnDefs: [
        { 
          "targets": 'no-sort',
          "orderable": false
        }],
      dom: 'Bfrtip',
      buttons: [
          {
              extend: 'excelHtml5',
              pageSize: 'potrait',
              title: "SLA <?= $isp['isp_name'].' '.$month;?>",
              exportOptions: {
                  columns: [ 0,1,2,3 ],
              },
          },
          {
              extend: 'pdfHtml5',
              pageSize: 'Legal',
              orientation: 'landscape',
              title: "SLA <?= $isp['isp_name'].' '.$month;?>",
              exportOptions: {
                  columns: [ 0,1,2,3 ],
              },
                customize : function(doc) { 
                  margin: [12, 0, 0, 12];
                  alignment: 'center';
                  doc.styles.tableHeader.alignment = 'center';
                  doc.content[1].table.widths = [150,150,150,150];
              }
          },
          'colvis'
        ]
      });
    });
    </script>
  </body>
</html>