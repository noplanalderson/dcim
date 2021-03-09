<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

    <!-- Parsley -->
    <script src="<?= site_url();?>assets/vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Select2 -->
    <script src="<?= site_url();?>assets/vendors/select2/js/select2.min.js"></script>

    <script type="text/javascript">

    $(function(){

            $('.add').on('click', function() {
            $('.modal-title').html('Use IP Address');
            $('.modal-footer button[type=submit]').html('Submit');
            $('.modal-body form').attr('action', '<?= base_url("services/action/add");?>');

            const id_ip = $(this).data('id');
            $.ajax({
                url: '<?= base_url("add-service/use");?>',
                data: { id: id_ip },
                method: 'post',
                dataType: 'json',
                success: function(data){
                    $('#id_ip').val(id_ip).trigger('change');;
                    $('#device').val(data.device_code).trigger('change');;
                    $('#app').val(data.app_id).trigger('change');;
                    $('#wifi').val(data.wifi_id).trigger('change');;
                    $('#vm').val(data.vm_id).trigger('change');;
                }
            });
        });
    });

      $(document).ready(function() { 
        $("#device").select2({
          placeholder: "Choose Device..",
          allowClear: true
        });
        $("#app").select2({
          placeholder: "Choose App..",
          allowClear: true
        });
        $("#wifi").select2({
          placeholder: "Choose Wifi..",
          allowClear: true
        });
        $("#vm").select2({
          placeholder: "Choose VM..",
          allowClear: true
        });
      });
    </script>
    <script type="text/javascript">

    $(document).ready(function() {
      var groupColumn = 1;
      var table = $('#ip').DataTable({
        responsive:true,
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
              $(rows).eq( i ).before('<tr class="group"><td colspan="7">'+group+'</td></tr>');
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
              pageSize: 'A4',
              title: "Daftar IP Address Pemerintah Kota Tangerang",
              exportOptions: {
                  columns: ':visible'
              }
          },
          {
              extend: 'pdfHtml5',
              pageSize: 'A4',
              orientation: 'landscape',
              title: "Daftar IP Address Pemerintah Kota Tangerang",
              exportOptions: {
                  columns: [ 1, 2, 3, 4, 5, 6 ],
              },
                customize : function(doc) { 
                  margin: [12, 0, 0, 12];
                  alignment: 'center';
                  doc.styles.tableHeader.alignment = 'center';
                  doc.content[1].table.widths = [180,150,80,120,80,120];
              }
          },
          'colvis'
        ]
      });
    });
    </script>
  </body>
</html>