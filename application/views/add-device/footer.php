<?php defined('BASEPATH') OR die('No Direct Script Access Allowed');?>
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
    <!-- Parsley -->
    <script src="<?= site_url();?>assets/vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Select2 -->
    <script src="<?= site_url();?>assets/vendors/select2/js/select2.min.js"></script>
    <!-- iCheck -->
    <script src="<?= site_url();?>assets/vendors/iCheck/icheck.min.js"></script>
    <!-- tags -->
    <script src="<?= site_url();?>assets/vendors/tags/jquery.tagsinput.min.js"></script>
    <script src="<?= site_url();?>assets/vendors/easyautocomplete/jquery.easy-autocomplete.min.js"></script> 
    <!-- Custom Theme Scripts -->
    <script src="<?= site_url();?>assets/js/custom.js"></script>
    <script src="<?= site_url();?>assets/js/autocomplete.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
      $(".manufacture").select2({
          placeholder: "Choose Device Manufacture..",
            allowClear: true
      });
      $(".model").select2({
          placeholder: "Choose Device Model..",
            allowClear: true
      });
      $(".server").select2({
          placeholder: "Choose Server..",
            allowClear: true
      }); 
      $('.model-hw').tagsInput({
        width: 'auto',
        defaultText:'Add Model',
      });
      $('.size-hw').tagsInput({
        width: 'auto',
        defaultText:'Add Size',
      });
    });

    $('#device-group').on('click', function() {
        var data = $('option:selected', this).attr('count');
        console.log(data);
        $('#device_number').val(data);
    });
    // $("#submit").click(function() {
    //     var formAction = $("#device-form").attr('action');
    //     var datalogin = {
    //         <?= $this->security->get_csrf_token_name();?>: $('input[name="<?= $this->security->get_csrf_token_name();?>"]').attr('value')
    //         device_group: $("#device-group").val(),
    //         device_number: $("#device_number").val(),
    //         manufacture: $("#manufacture").val(),
    //         processor: $("#processor").val(),
    //         model: $("#model").val(),
    //         cores: $("#cores").val(),
    //         memory_model: $("#memory_model").val(),
    //         mem_cap: $("#mem_cap").val(),
    //         hdd_cap: $("#hdd_cap").val(),
    //         hdd_model: $("#hdd_model").val(),
    //         eth_port: $("#eth_port").val(),
    //         console_port: $("#console_port").val(),
    //         usb_port: $("#usb_port").val(),
    //         hostname: $("#hostname").val(),
    //         serial_number: $("#serial_number").val(),
    //         operating_system: $("#operating_system").val(),
    //         os_arch: $("#os_arch").val(),
    //         location: $("#location").val(),
    //         rack: $("#rack").val(),
    //         procurement: $("#procurement").val(),
    //         status: $("#status").val(),
    //         owner: $("#owner").val(),
    //         device_image: $("#device_image").val()
    //     };

    //     $.ajax({
    //         type: "POST",
    //         url: formAction,
    //         data: datalogin,
    //         dataType: 'json',
    //         success: function(data) {
    //             if (data.result == 1) {
    //                 $('input[name="<?= $this->security->get_csrf_token_name();?>"]').val(data.token);
    //                 $("#msg").removeAttr('style');
    //                 $('#msg').attr('class', 'alert alert-success');
    //                 $('.msg').html(data.msg);
    //                 $("#msg").slideDown('slow');
    //                 $("#msg").alert().delay(6000).slideUp('slow');
    //             } else {
    //                 $('input[name="<?= $this->security->get_csrf_token_name();?>"]').val(data.token);
    //                 $("#msg").removeAttr('style');
    //                 $('#msg').attr('class', 'alert alert-danger');
    //                 $('.msg').html(data.msg);
    //                 $("#msg").slideDown('slow');
    //                 $("#msg").alert().delay(3000).slideUp('slow');
    //             }
    //         }
    //     });
    //     return false;
    // });
    </script>
  </body>
</html>