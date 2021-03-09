<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#network').DataTable( {
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
                    title: "Daftar Blok Network Pemkot Tangerang",
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    pageSize: 'Legal',
                    orientation: 'potrait',
                    title: "Daftar Blok Network Pemkot Tangerang",
                    exportOptions: {
                        columns: [ 0, 1, 2, 3 ],
                    },
                      customize : function(doc) { 
                        margin: [12, 0, 0, 12];
                        alignment: 'center';
                        doc.styles.tableHeader.alignment = 'center';
                        doc.content[1].table.widths = [150,60,200,80];
                    }
                },
                'colvis'
            ]
        } );
    } );
    </script>
  </body>
</html>