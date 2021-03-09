<?php
defined('BASEPATH') OR die('No Direct Script Access Alowed');?>
<body class="login">
    <div>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <?= form_open('reset', 'method="post" accept-charset="utf-8" id="demo-form2" data-parsley-validate');?>
              <h1>Signin Application</h1>
              <div>
                <input type="hidden" name="user_name" value="<?= $user_name;?>">
                <?php
                  $upass = array(
                    'type'        => 'password',
                    'id'          => 'password',
                    'name'        => 'password',
                    'value'       => show_value('password'),
                    'class'       => 'form-control',
                    'placeholder' => '********',
                    'pattern'     => '(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}',
                    'title'       => 'Password must contain Uppercase, lowercase, numeric, and symbols min. 8 Chars.',
                    'required'    => 'required',
                    'autocomplete'=> 'off'
                  );
                  echo form_input($upass);
                ?>
              </div>

              <div>
                <?php
                  $upass = array(
                    'type'        => 'password',
                    'id'          => 'password2',
                    'name'        => 'password2',
                    'value'       => show_value('password'),
                    'class'       => 'form-control',
                    'placeholder' => '********',
                    'data-parsley-equalto' => '#password',
                    'title'       => 'Password must match.',
                    'required'    => 'required',
                    'autocomplete'=> 'off'
                  );
                  echo form_input($upass);
                ?>
              </div>

              <br/>
              <div>
                <button type="submit" name="reset" class="btn btn-default submit">Reset</button>
                <a href="<?= base_url('signin');?>" class="to_register reset_pass">Try Login</a>
              </div>
              
              <div class="clearfix"></div>
              
              <div class="separator">
                <?php show_alert();?>
                <div class="clearfix"></div>
                <br />
                <div>
                  <h4><i class="fa fa-hdd-o"></i> Data Center Inventory Management v3</h4>
                  <p>Copyright &copy; <?= date('Y');?><br/><?= $this->app['app_copyright'];?></p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>