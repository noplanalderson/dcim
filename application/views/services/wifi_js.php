<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

    <script type="text/javascript">
    $(function() {
        $('.password-group').find('.password-box').each(function(index, input) {
            var $input = $(input);
            $input.parent().find('.password-visibility').click(function() {
                var change = "";
                if ($(this).find('i').hasClass('fa-eye')) {
                    $(this).find('i').removeClass('fa-eye')
                    $(this).find('i').addClass('fa-eye-slash')
                    change = "text";
                } else {
                    $(this).find('i').removeClass('fa-eye-slash')
                    $(this).find('i').addClass('fa-eye')
                    change = "password";
                }
                var rep = $("<input type='" + change + "' readonly/>")
                    .attr('id', $input.attr('id'))
                    .attr('name', $input.attr('name'))
                    .attr('class', $input.attr('class'))
                    .attr('style', $input.attr('style'))
                    .val($input.val())
                    .insertBefore($input);
                $input.remove();
                $input = rep;
            }).insertAfter($input);
        });
    });

    $(document).ready(function() {
        $('#wifi').DataTable( {
            responsive:true,
            "columnDefs": [ {
                "targets": 'no-sort',
                "orderable": false,
            }],
            columns: [
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
                    pageSize: 'portrait',
                    title: "Daftar SSID Wifi Pemerintah Kota Tangerang",
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    pageSize: 'Legal',
                    orientation: 'landscape',
                    title: "Daftar SSID Wifi Pemerintah Kota Tangerang",
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5 ],
                    },
                      customize : function(doc) { 
                        margin: [12, 0, 0, 12];
                        alignment: 'center';
                        doc.styles.tableHeader.alignment = 'center';
                        doc.content[1].table.widths = [200,80,80,200,80,80];
                    }
                },
                'colvis'
            ]
        } );
    } );
    </script>
  </body>
</html>