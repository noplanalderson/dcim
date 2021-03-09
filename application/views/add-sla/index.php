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
                    <h2>Add SLA</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?= form_open('', 'method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"');?>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="isp">ISP <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="form-control col-sm-7 col-xs-7" name="isp" required>
                            <option value="">Choose ISP..</option>
                            <?php foreach ($isps as $isp) :?>
                            <option value="<?= $isp['isp_id'];?>" <?php if($isp['isp_id'] == show_value('isp')):?>selected<?php endif;?>>
                              <?= ucwords($isp['isp_name']);?></option>
                            <?php endforeach; ?>                        
                          </select>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="downtime">Downtime <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="downtime" type="text" name="downtime" class="form-control col-md-7 col-xs-12" value="<?= show_value('downtime');?>" required><i class="fa fa-calendar" style="position:absolute;margin-left:-20px;margin-top:10px;"></i>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uptime">Uptime <span class="required">*</span> 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="uptime" type="text" name="uptime" class="form-control col-md-7 col-xs-12" value="<?= show_value('uptime');?>" required><i class="fa fa-calendar" style="position:absolute;margin-left:-20px;margin-top:10px;"></i>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="reason">Reason <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea required="required" name="reason" class="form-control col-md-7 col-xs-12" data-parsley-length="[5, 100]"><?= show_value('reason');?></textarea>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="solution">Solution 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea name="solution" class="form-control col-md-7 col-xs-12" data-parsley-length="[0,100]"><?= show_value('solution');?></textarea>
                        </div>
                      </div>
                      <div class="item form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <small style="color:#FF0000;">* Jika Downtime di akhir bulan dan uptime di awal bulan, maka downtime akhir bulan diinput hingga pukul 23:59. Sisa downtime diinput pada bulan berikutnya.</small>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button type="reset" class="btn btn-primary">Reset</button>
                          <input type="submit" name="submit" class="btn btn-success" value="Submit">
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