<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

    <script type="text/javascript">
    $(document).ready(function(){
        $('#vms').DataTable({
            responsive:true,
            "columnDefs": [ {
                "targets": 'no-sort',
                "orderable": false,
            }],

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
                title: "Daftar VM Pemerintah Kota Tangerang",
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                pageSize: 'Legal',
                orientation: 'landscape',
                title: "Daftar VM Pemerintah Kota Tangerang",
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ],
                },
                  customize : function(doc) { 
                    margin: [12, 0, 0, 12];
                    alignment: 'center';
                    doc.styles.tableHeader.alignment = 'center';
                    doc.content[1].table.widths = [100,100,150,150,80,80,80,150];
                }
            },
            'colvis'
            ]
        });
    });
    </script>
  </body>
</html>