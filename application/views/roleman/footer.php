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
    <!-- Select2 -->
    <script src="<?= site_url();?>assets/vendors/select2/js/select2.min.js"></script>
    <!-- Parsley -->
    <script src="<?= site_url();?>assets/vendors/parsleyjs/dist/parsley.min.js"></script>
    <script src="<?= site_url();?>assets/vendors/easyautocomplete/jquery.easy-autocomplete.min.js"></script> 
    <!-- Custom Theme Scripts -->
    <script src="<?= site_url();?>assets/js/custom.js"></script>
    <script src="<?= site_url();?>assets/js/autocomplete.js"></script>
    <script type="text/javascript">
    $(function(){
        $('.add').on('click', function() {
            $('.modal-title').html('Add User Group');
            $('.modal-footer button[type=submit]').html('Add');

            $('#id').val('');
            $('#user_group').val('');
            $('#roles').select2({
                dropdownParent: $('#roleModal'),
                minimumResultsForSearch: Infinity,
                placeholder: 'Choose Roles'
            }).val('').trigger('change');
        });
        $('.update').on('click', function() {
            $('.modal-title').html('Edit User Group');
            $('.modal-footer button[type=submit]').html('Submit');
            $('.modal-body form').attr('action', '<?= base_url("role-management/edit");?>');
            $('#user_picture').removeAttr('required');

            const id_group = $(this).data('id');
            $.ajax({
                url: '<?= base_url("role-management/get-role");?>',
                data: {
                        id: id_group, 
                        <?= $this->security->get_csrf_token_name();?>: $('input[name="<?= $this->security->get_csrf_token_name();?>"]').attr('value')
                    },
                method: 'post',
                dataType: 'json',
                success: function(data){
                    $('input[name="<?= $this->security->get_csrf_token_name();?>"]').val(data.token);
                    $('#id').val(id_group);
                    $('#user_group').val(data.user_group);

                    var roles = data.roles;

                    if (roles) {
                        var arrayRoles = roles.split(',');
                        $('#roles').select2({
                            dropdownParent: $('#roleModal'),
                            minimumResultsForSearch: Infinity,
                            placeholder: 'Choose Roles'
                        }).val(arrayRoles).trigger('change');
                    }
                    else
                    {
                        $('#roles').select2({
                            dropdownParent: $('#roleModal'),
                            minimumResultsForSearch: Infinity,
                            placeholder: 'Choose Roles'
                        }).val('').trigger('change');
                    }
                }
            });
        });
    });
    </script>
  </body>
</html>