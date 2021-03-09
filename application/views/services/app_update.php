<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <?= show_alert();?>

                  <div class="x_title">
                    <h2>Edit Application</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?= form_open('', 'method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" accept-charset="utf-8"');?>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label for="url" class="control-label col-md-3 col-sm-3 col-xs-12">App Address <span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input id="url" name="url" class="form-control" type="url" placeholder="http(s)://" value="<?= $app['app_address'];?>" required />
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Notes <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea required="required" name="notes" class="form-control" data-parsley-length="[5, 100]"><?= $app['notes'];?></textarea>
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