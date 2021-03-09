<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

    <script type="text/javascript">
    $(document).ready(function(){
        $('#apps').DataTable({
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
                title: "Daftar Website dan Aplikasi Pemerintah Kota Tangerang",
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                pageSize: 'Legal',
                orientation: 'landscape',
                title: "Daftar Website dan Aplikasi Pemerintah Kota Tangerang",
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4 ],
                },
                  customize : function(doc) { 
                    margin: [12, 0, 0, 12];
                    alignment: 'center';
                    doc.styles.tableHeader.alignment = 'center';
                    doc.content[1].table.widths = [150,150,100,100,200,200];
                }
            },
            'colvis'
            ]
        });
    });
    </script>
  </body>
</html>