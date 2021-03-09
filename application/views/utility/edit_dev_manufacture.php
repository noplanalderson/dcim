<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Edit Device Manufacture</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <?= form_open('', 'method="post" id="manufacture" data-parsley-validate class="form-horizontal form-label-left"');?>

                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="manufacture">Manufacture <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="manufacture_name" data-parsley-pattern="^[a-zA-Z0-9 \-]+$" data-parsley-length="[3, 50]" class="form-control col-md-7 col-xs-12" value="<?= $utils['dev_manufacture'];?>" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="device-group">Device Group <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="device_group" class="form-control" required>
                            <option value="">Choose Device Group...</option>
                            <?php foreach ($dev_groups as $device) :?>

                            <option value="<?= $device['group_id'];?>" <?php if($device['group_id'] == $utils['group_id']) :?>selected<?php endif;?>><?= $device['group_label'];?></option>
                            <?php endforeach;?>

                          </select>
                        </div>
                        <br/>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-md btn-success pull-right" name="edit">Update</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>