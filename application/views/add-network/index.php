<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <?php show_alert();?>
                  
                  <div class="x_title">
                    <h2>Input IP Address</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?= form_open('add-service/network', 'method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" accept-charset="utf-8"');?>
                      
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tipe_dan_grup">Net. Type, Mask, Submask<span class="required">*</span></label>
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="network_type">
                          <select id="network_type" name="network_type" class="form-control col-sm-7 col-xs-7" required="required" type="text">
                            <option value="">Choose Type..</option>
                            <option value="PUBLIC" <?php if(show_value('network_type') == 'PUBLIC'):?>selected<?php endif;?>>Public IP</option>
                            <option value="PRIVATE" <?php if(show_value('network_type') == 'PRIVATE'):?>selected<?php endif;?>>Private IP</option>
                          </select>
                        </label>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <select id="mask" onChange="ip()" class="form-control col-sm-2 col-xs-2" name="mask" style="margin-top:8px;" required>
                            <option value="">Mask..</option>
                            <?php for($i=24; $i<=30; $i++):?>
                              <option value='<?= $i;?>' <?php if(show_value('mask') == $i):?>selected<?php endif;?>><?= $i;?></option>
                            <?php endfor;?>
                          </select>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <select id="submask" class="form-control col-sm-2 col-xs-2" name="submask" style="margin-top:8px;" required>
                            <option value="">Submask..</option>
                            <?php for($i=24; $i<=30; $i++):?>
                              <option value='<?= $i;?>' <?php if(show_value('submask') == $i):?>selected<?php endif;?>><?= $i;?></option>
                            <?php endfor;?>
                          </select>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="network">IP Network <span class="required">*</span></label>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <select id="1" class="form-control col-sm-1 col-xs-1" name="a" style="margin-top:8px;" required>
                            <option value="">--</option>
                            <?php for($i=1; $i<=254; $i++):?>
                              <option value='<?= $i;?>' <?php if(show_value('a') == $i):?>selected<?php endif;?>><?= $i;?></option>
                            <?php endfor;?>
                          </select>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <select id="2" class="form-control col-sm-1 col-xs-1" name="b" style="margin-top:8px;" required>
                            <option value="">--</option>
                            <?php for($i=0; $i<=254; $i++):?>
                              <option value='<?= $i;?>' <?php if(show_value('b') == $i):?>selected<?php endif;?>><?= $i;?></option>
                            <?php endfor;?>
                          </select>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <select id="3" class="form-control col-sm-1 col-xs-1" name="c" style="margin-top:8px;" required>
                            <option value="">--</option>
                            <?php for($i=0; $i<=254; $i++):?>
                              <option value='<?= $i;?>' <?php if(show_value('c') == $i):?>selected<?php endif;?>><?= $i;?></option>
                            <?php endfor;?>
                          </select>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <select id="4" class="form-control col-sm-1 col-xs-1" name="d" style="margin-top:8px;" required>
                            <option value="">--</option>
                          </select>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Label <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea required="required" name="network_label" class="form-control col-md-7 col-xs-12" data-parsley-length="[5, 100]"><?= show_value('network_label');?></textarea>
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
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->