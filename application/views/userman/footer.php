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
            $('#modal-title').html('Add User');
            $('.modal-footer button[type=submit]').html('Add User');
            $('#username').val('');
            $('#email').val('');
            $('#question').val('');
            $('#answer').val('');
            $('#old_picture').val('noimage.png');
            $('#status').val('');
            $('#user_group').val('');
        });
        $('.update').on('click', function() {
            $('#modal-title').html('Edit User');
            $('.modal-footer button[type=submit]').html('Submit');
            $('.modal-body form').attr('action', '<?= base_url("user-management/edit");?>');

            const user_id = $(this).data('id');
            $.ajax({
                url: '<?= base_url("user-management/get-user");?>',
                data: {
                    id: user_id,
                    <?= $this->security->get_csrf_token_name();?>: $('input[name="<?= $this->security->get_csrf_token_name();?>"]').attr('value')
                },
                method: 'post',
                dataType: 'json',
                success: function(data){
                    $('input[name="<?= $this->security->get_csrf_token_name();?>"]').val(data.token);
                    $('#user_id').val(user_id);
                    $('#username').val(data.user_name);
                    $('#email').val(data.user_email);
                    $('#question').val(data.sec_question_id);
                    $('#answer').val(data.sec_answer);
                    $('#old_picture').val(data.user_picture);
                    $('#status').val(data.user_status);
                    $('#user_group').val(data.user_group_id);
                }
            });
        });
    });
    </script>
  </body>
</html>