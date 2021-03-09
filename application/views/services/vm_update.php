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
                    <h2>Add VM</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?= form_open('', 'method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" accept-charset="utf-8"');?>
                      <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="device">Device <span class="required">*</span></label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                            <select id="device" class="form-control col-md-6 col-xs-12" name="device" required/>
                              <option value="">Choose Device..</option>
                              <?php foreach ($devices as $device) :?>

                                <option value="<?= $device['device_code'];?>" <?php if($device['device_code'] == $vm['device_code']):?>selected<?php endif;?>>
                                  <?= $device['hostname'];?>
                                </option>

                              <?php endforeach;?>

                            </select>
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                          <label for="hostname" class="control-label col-md-3 col-sm-3 col-xs-12">Hostname </label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                            <input id="hostname" class="form-control" type="text" name="hostname" value="<?= $vm['hostname'];?>" placeholder="default:localhost" data-parsley-pattern="^[A-Za-z0-9.@\-\_]+$" data-parsley-length="[3,50]">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                          <label for="operating_system" class="control-label col-md-3 col-sm-3 col-xs-12">Operating System</label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                            <input id="operating_system" class=" form-control col-md-6 col-xs-6" type="text" name="operating_system" value="<?= $vm['operating_system'];?>" placeholder="Operating System" data-parsley-pattern="^[a-zA-Z0-9\s-.]+$" data-parsley-length="[3, 255]">
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                          <label form="os_arch" class="control-label col-md-3 col-sm-3 col-xs-12">OS Arch</label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                            <input id="os_arch" class="form-control col-md-6 col-xs-6" name="os_arch" type="text" value="<?= $vm['os_architecture'];?>" placeholder="OS Architecture" data-parsley-length="[3, 255]">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                          <label for="hdd_cap" class="control-label col-md-3 col-sm-3 col-xs-12">Storage Capacity (GB)</label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                            <input id="hdd_cap" name="hdd_cap" class="form-control col-md-6 col-xs-6" type="text" value="<?= $vm['hdd_cap'];?>" placeholder="0" data-parsley-trigger="keyup" data-parsley-type="digits">
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                          <label for="mem_cap" class="control-label col-md-3 col-sm-3 col-xs-12">Memory Capacity (GB)</label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                            <input id="mem_cap" name="mem_cap" class="form-control col-md-6 col-xs-6" type="text" value="<?= $vm['mem_cap'];?>" placeholder="0" data-parsley-trigger="keyup" data-parsley-type="digits">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                          <label for="cores" class="control-label col-md-3 col-sm-3 col-xs-12">Cores</label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                            <input id="cores" name="cores" class="form-control col-md-6 col-xs-6" type="text" value="<?= $vm['cores'];?>" placeholder="0" data-parsley-trigger="keyup" data-parsley-type="digits">
                          </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Notes</label>
                          <div class="col-md-8 col-sm-8 col-xs-12">
                            <textarea name="notes" class="form-control" data-parsley-length="[5, 100]"><?= $vm['notes'];?></textarea>
                          </div>
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