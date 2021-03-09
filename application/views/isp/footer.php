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
    <!-- Parsley -->
    <script src="<?= site_url();?>assets/vendors/parsleyjs/dist/parsley.min.js"></script>
    <script src="<?= site_url();?>assets/vendors/easyautocomplete/jquery.easy-autocomplete.min.js"></script> 
    <!-- Custom Theme Scripts -->
    <script src="<?= site_url();?>assets/js/custom.js"></script>
    <script src="<?= site_url();?>assets/js/autocomplete.js"></script>
    <script type="text/javascript">
    $(function(){

        $('.add').on('click', function() {
            $('#modal-title').html('Add ISP')
            $('.modal-body form').attr('action', '<?= site_url("isp-setting/add");?>');
            $('#nama_isp').val('');
            $('#sla').val('');
        });
        $('.update').on('click', function() {
            $('#modal-title').html('Edit ISP');
            $('.modal-body form').attr('action', '<?= site_url("isp-setting/edit");?>');

            const id_isp = $(this).data('id');
            $.ajax({
                url: '<?= site_url("isp-setting/get-isp");?>',
                data: {
                    id: id_isp,
                    <?= $this->security->get_csrf_token_name();?>: $('input[name="<?= $this->security->get_csrf_token_name();?>"]').attr('value')
                },
                method: 'post',
                dataType: 'json',
                success: function(data){
                    $('input[name="<?= $this->security->get_csrf_token_name();?>"]').val(data.token);
                    $('#isp_id').val(id_isp);
                    $('#isp_name').val(data.isp_name);
                    $('#sla_standard').val(data.sla_standard);
                }
            });
        });
    });
    </script>
  </body>
</html>