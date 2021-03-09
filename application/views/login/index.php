<?php
defined('BASEPATH') OR die('No Direct Script Access Alowed');?>
<body class="login">
    <div>
      <a class="hiddenanchor" id="reset"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <?= form_open('signin/auth', 'method="post" accept-charset="utf-8" id="demo-form2" data-parsley-validate');?>
              <h1>Signin Application</h1>
              <div>
                <?php
                  $uname = array(
                    'name'        => 'u_name',
                    'value'       => show_value('username'),
                    'class'       => 'form-control',
                    'placeholder' => 'Username',
                    'pattern'     => '^[a-zA-Z0-9.-_@]{4,25}$',
                    'title'       => 'Only alphanumeric and (@_.) 4-80 Chars.'
                  );
                  echo form_input($uname);
                ?>
              </div>

              <div>
                <?php
                  $upass = array(
                    'type'        => 'password',
                    'name'        => 'u_pass',
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
                <button type="submit" name="submit" class="btn btn-default submit">Signin</button>
                <a href="#reset" class="to_register reset_pass">Forgot Password?</a>
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

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <?= form_open('reset-password', 'method="post" accept-charset="utf-8" data-parsley-validate');?>
              <h1>Reset Password</h1>
              <div>
                <?php
                  $user_name = array(
                    'name'        => 'user_name',
                    'value'       => show_value('user_name'),
                    'class'       => 'form-control',
                    'placeholder' => 'Username',
                    'pattern'     => '^[a-zA-Z0-9.-_@]{4,25}$',
                    'title'       => 'Only alphanumeric and (@_.) 4-80 Chars.',
                    'required'    => 'required'
                  );
                  echo form_input($user_name);
                ?>
              </div>
              <div>
                <?php
                  $user_email = array(
                    'type'        => 'email',
                    'name'        => 'user_email',
                    'value'       => show_value('user_email'),
                    'class'       => 'form-control',
                    'placeholder' => 'Email',
                    'required'    => 'required'
                  );
                  echo form_input($user_email);
                ?>
              </div>
              <div>
                <select name="sec_question" class="form-control" required>
                  <option value="">Security Question</option>
                  <?php foreach ($questions as $question) :?>

                  <option value="<?= $question['sec_question_id'];?>"><?= $question['sec_question'];?></option>
                  <?php endforeach;?>
                
                </select>
              </div>
              <br/>
              <div>
                <?php
                  $sec_answer = array(
                    'name'        => 'sec_answer',
                    'value'       => show_value('sec_answer'),
                    'class'       => 'form-control',
                    'placeholder' => 'Security Answer',
                    'required'    => 'required'
                  );
                  echo form_input($sec_answer);
                ?>
              </div>
              <div>
                <button type="submit" name="submit" class="btn btn-default submit">Submit</button>
                <a href="#signin" class="to_register reset_pass"> Back to Signin </a>
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