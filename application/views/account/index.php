<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <?php show_alert();?>

                  <div class="x_title">
                    <h2>Account Setting</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?= form_open_multipart('', 'method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"');?>

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label for="username" class="control-label col-md-3 col-sm-3 col-xs-12">Username</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input id="username" name="username" class="form-control" placeholder="Username" type="text" data-parsley-length="[5, 50]" value="<?= $account['user_name'];?>" required="">
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">Password <span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" class="form-control col-md-7 col-xs-12" placeholder="********" required="">
                          <small class="text-danger">Password must contain Uppercase, Lowercase, Numeric, and Symbols 8-16 Characters.</small>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12">Repeat Password <span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="password" id="password2" name="password2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" class="form-control col-md-7 col-xs-12" placeholder="********" data-parsley-equalto="#password" required="">
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="email" id="email" name="email" class="form-control" placeholder="you@somewhere.com" value="<?= $account['user_email'];?>">
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="question">Security Question <span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <select id="question" class="form-control col-md-6 col-xs-12" name="question" required/>
                            <option value="">Choose Question..</option>
                            <?php foreach ($questions as $question) :?>

                            <option value="<?= $question['sec_question_id'];?>" <?php if($question['sec_question_id'] == $account['sec_question_id']) : ?> selected<?php endif;?>>
                              <?= ucwords($question['sec_question']);?>
                              
                            </option>
                            <?php endforeach;?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label for="answer" class="control-label col-md-3 col-sm-3 col-xs-12">Security Answer <span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input id="answer" name="answer" class="form-control" placeholder="Security Answer" type="text" data-parsley-length="[5, 50]" value="<?= $account['sec_answer'];?>">
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label for="picture" class="control-label col-md-3 col-sm-3 col-xs-12">Profil Picture</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="hidden" name="old_picture" value="<?= $account['user_picture'];?>">
                          <input type="file" name="picture" class="form-control col-md-4 col-xs-12">
                          <small class="text-danger">Picture size max. 3 MB in JPG, JPEG, or PNG  format.</small>
                        </div>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <div class="ln_solid"></div>
                          <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-10">
                            <button class="btn btn-primary" type="reset">Reset</button>
                            <button type="submit" name="submit" class="btn btn-success">Submit</button>
                          </div>
                      </div>
                    </form>
                    <br/>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->