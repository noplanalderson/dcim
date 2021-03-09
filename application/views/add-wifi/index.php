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
                    <h2>Add Wifi</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?= form_open('add-service/wifi', 'method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" accept-charset="utf-8"');?>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label for="wifi_ssid" class="control-label col-md-3 col-sm-3 col-xs-12">SSID <span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input id="wifi_ssid" name="wifi_ssid" class="form-control" type="text" placeholder="SSID Wifi" value="<?= show_value('wifi_ssid');?>" required>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label for="wifi_user" class="control-label col-md-3 col-sm-3 col-xs-12">Username</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input id="wifi_user" name="wifi_user" class="form-control" type="text" placeholder="Username" value="<?= show_value('wifi_user');?>">
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label for="wifi_password" class="control-label col-md-3 col-sm-3 col-xs-12">Password Wifi</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input id="wifi_password" name="wifi_password" class="form-control" type="password" placeholder="********" value="<?= show_value('wifi_password');?>">
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