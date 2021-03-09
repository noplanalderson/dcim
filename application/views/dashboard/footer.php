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
    <script src="<?= site_url();?>assets/vendors/Chart.js/dist/Chart.bundle.js"></script>
    <script src="<?= site_url();?>assets/vendors/export/jspdf.js"></script>
    <script src="<?= site_url();?>assets/vendors/export/exporting.js"></script>
    <script src="<?= site_url();?>assets/vendors/export/offline-exporting.js"></script>
    <!-- JS file -->
    <script src="<?= site_url();?>assets/vendors/easyautocomplete/jquery.easy-autocomplete.min.js"></script> 
    <script src="<?= site_url();?>assets/js/dashboard.js"></script>
    <script src="<?= site_url();?>assets/js/autocomplete.js"></script>
    <script type="text/javascript">
    var chart; 
    $(document).ready(function() {
          chart = new Highcharts.Chart(
          {
              
             chart: {
                renderTo: 'device_graph',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
             },   
             title: {
                text: 'Device Percentage ',
             },
             tooltip: {
                formatter: function() {
                    return '<b>'+
                    this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 1) +' % ';
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
                            return '<b>' + this.point.name + '</b>: ' + Highcharts.numberFormat(this.percentage, 1) +' % ';
                        }
                    }
                }
             },
   
              series: [{
              type: 'pie',
              name: 'Device Type',
              data: [<?php foreach($total_dev as $count): ?>["<?= $count['group_label'];?>", <?= $count['total_device'];?>],<?php endforeach;?>]
            }]
          });
    });
    var chart; 
    $(document).ready(function() {
          chart = new Highcharts.Chart(
          {
              
             chart: {
                renderTo: 'service_graph',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
             },   
             title: {
                text: 'Service Percentage ',
             },
             tooltip: {
                formatter: function() {
                    return '<b>'+
                    this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 1) +' % ';
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
                            return '<b>' + this.point.name + '</b>: ' + Highcharts.numberFormat(this.percentage, 1) +' % ';
                        }
                    }
                }
             },
   
                series: [{
                type: 'pie',
                name: 'Service Type',
                data: [
                        [ 'Web & Apps', <?= $app;?>],
                        [ 'Wifi', <?= $wifi;?>],
                        [ 'Network Blocks', <?= $net;?>],
                ]
            }]
          });
    });  
    var chart; 
    $(document).ready(function() {
      chart = new Highcharts.Chart(
      {
        chart: {
            renderTo: 'hardware_graph',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },   
        title: {
            text: 'Hardware Percentage ',
        },
        tooltip: {
            formatter: function() {
                return '<b>'+
                this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 1) +' % ';
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
                  return '<b>' + this.point.name + '</b>: ' + Highcharts.numberFormat(this.percentage, 1) +' % ';
              }
            }
          }
        },
        series: [{
          type: 'pie',
          name: 'Hardware Type',
          data: [<?php foreach($hardware as $count): ?>["<?= $count['hw_category'];?>", <?= $count['total_hw'];?>],<?php endforeach;?>]
        }]
      });
    });

    var ctx = document.getElementById("slaSummary").getContext('2d');
    ctx.height = 200;
      function getRandomColor() {
        var letters = '0123456789ABCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++ ) {
          color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
      }
      var slaSummary = new Chart(ctx, {
        type: 'line',
        data: {
          labels: [<?php foreach ($periods as $period):echo "'".$period['period']."',";endforeach;?>],
          datasets: [
          <?php foreach ($isp_list as $isp) :?>
          {
            label: "<?= $isp['isp_name'];?>",
            data: [
            <?php $sla_list = $this->dashboard_m->get_sla($isp['isp_id']);
              foreach ($sla_list as $sla) :
              echo "'".round($sla['totalDown']/60, 2)."',";
              endforeach;?>
            ],
            borderColor: getRandomColor(),
            borderWidth: 2
          },
          <?php endforeach;?>
          
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero:true
              }
            }]
          }
        }
      });
    </script>
  </body>
</html>