<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Add Utilities</h3><br/>
              </div>
            </div>
            <div class="clearfix"></div>
            <?php show_alert();?>

            <div class="row">
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">

                  <div class="x_title">
                    <h2>Add Device Manufacture</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <?= form_open('utilities/submit/manufacture', 'method="post" id="manufacture" data-parsley-validate class="form-horizontal form-label-left"');?>
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="manufacture">Manufacture <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="manufacture_name" data-parsley-pattern="^[a-zA-Z0-9 \-]+$" data-parsley-length="[3, 50]" class="form-control col-md-7 col-xs-12" value="<?= show_value('manufacture_name');?>" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="device-group">Device Group <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="device_group" class="form-control" required>
                            <option value="">Choose Device Group...</option>
                            <?php foreach ($dev_groups as $device) :?>

                            <option value="<?= $device['group_id'];?>" <?php if($device['group_id'] == show_value('device_group')) :?>selected<?php endif;?>><?= $device['group_label'];?></option>
                            <?php endforeach;?>

                          </select>
                        </div>
                        <br/>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-md btn-success pull-right" name="add">Add</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add Device Model</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <?= form_open('utilities/submit/dev-model', 'method="post" id="model" data-parsley-validate class="form-horizontal form-label-left"');?>
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Device Model <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="model" data-parsley-pattern="^[a-zA-Z0-9 \/\-\-]+$" data-parsley-length="[3, 50]"  class="form-control col-md-7 col-xs-12" value="<?= show_value('model');?>" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Manufacture <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="manufacture" class="form-control" required>
                            <option value="">Choose Manufacture...</option>
                            <?php foreach ($manufactures as $manu) :?>

                            <option value="<?= $manu['dev_manufacture_id'];?>" <?php if($manu['dev_manufacture_id'] == show_value('manufacture')) :?>selected<?php endif;?>><?= $manu['dev_manufacture'];?></option>
                            <?php endforeach;?>
                          
                          </select>
                        </div>
                        <br/>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-md btn-success pull-right" name="add">Add</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add Hardware Manufacture</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <?= form_open('utilities/submit/hw-manufacture', 'method="post" id="manu-hw" data-parsley-validate class="form-horizontal form-label-left"');?>

                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="hardware-manufacture">Hardware Manufacture<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="hw_manufacture" data-parsley-pattern="^[a-zA-Z0-9 \-]+$" data-parsley-length="[3, 50]" class="form-control col-md-7 col-xs-12" value="<?= show_value('hw_manufacture');?>" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="hardware-group">Hardware Group <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="hw_group" class="form-control" required>
                            <option value="">Choose Hardware Group...</option>
                            <?php foreach ($hw_groups as $hardware) :?>

                            <option value="<?= $hardware['hw_category_id'];?>" <?php if($hardware['hw_category_id'] == show_value('hw_group')) :?>selected<?php endif;?>><?= $hardware['hw_category'];?></option>
                            <?php endforeach;?>

                          </select>
                        </div>
                        <br/>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-md btn-success pull-right" name="add">Add</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add Hardware Group</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <?= form_open('utilities/submit/hw-group', 'method="post" id="hardware" data-parsley-validate class="form-horizontal form-label-left"');?>

                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="device-group">Group Code<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="hw_code" data-parsley-pattern="^[A-Z]+$" data-parsley-length="[2,3]" class="form-control col-md-7 col-xs-12" value="<?= show_value('hw_code');?>" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="hardware-group">Hardware Group <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="hw_group_name" data-parsley-pattern="^[a-zA-Z0-9 \-]+$" data-parsley-length="[3, 20]"  class="form-control col-md-7 col-xs-12" value="<?= show_value('hw_group_name');?>" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="hw_icon" class="control-label col-md-4 col-sm-4 col-xs-12">Group Icons <span class="required"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="hw_icon" class="form-control" name="hw_icon" data-show-icon="true" required>
                            <option value="">Choose Icon...</option>
                            <option <?php if('fa fa-database' == show_value('hw_icon')) :?>selected<?php endif;?> value="fa fa-database" data-content="<i class='fa fa-database'></i> fa fa-database"></option>
                            <option <?php if('fa fa-shield' == show_value('hw_icon')) :?>selected<?php endif;?> value="fa fa-shield" data-content="<i class='fa fa-shield'></i> fa fa-shield"></option>
                            <option <?php if('fa fa-tasks' == show_value('hw_icon')) :?>selected<?php endif;?> value="fa fa-tasks" data-content="<i class='fa fa-tasks'></i> fa fa-tasks"></option>
                            <option <?php if('fa fa-server' == show_value('hw_icon')) :?>selected<?php endif;?> value="fa fa-server" data-content="<i class='fa fa-server'></i> fa fa-server"></option>
                            <option <?php if('fa fa-life-ring' == show_value('hw_icon')) :?>selected<?php endif;?> value="fa fa-life-ring" data-content="<i class='fa fa-life-ring'></i> fa fa-life-ring"></option>
                            <option <?php if('fa fa-signal' == show_value('hw_icon')) :?>selected<?php endif;?> value="fa fa-signal" data-content="<i class='fa fa-signal'></i> fa fa-signal"></option>
                            <option <?php if('fa fa-cloud' == show_value('hw_icon')) :?>selected<?php endif;?> value="fa fa-cloud" data-content="<i class='fa fa-cloud'></i> fa fa-cloud"></option>
                            <option <?php if('fa fa-ticket' == show_value('hw_icon')) :?>selected<?php endif;?> value="fa fa-ticket" data-content="<i class='fa fa-ticket'></i> fa fa-ticket"></option>
                            <option <?php if('fa fa-hdd-o' == show_value('hw_icon')) :?>selected<?php endif;?> value="fa fa-hdd-o" data-content="<i class='fa fa-hdd-o'></i> fa fa-hdd-o"></option>
                            <option <?php if('fa fa-square' == show_value('hw_icon')) :?>selected<?php endif;?> value="fa fa-square" data-content="<i class='fa fa-square'></i> fa fa-square"></option>
                          </select>
                        </div>
                        <br/>
                      </div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-md btn-success pull-right" name="add">Add</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add Device Group</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <?= form_open('utilities/submit/dev-group', 'method="post" id="device" data-parsley-validate class="form-horizontal form-label-left"');?>

                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="device-group">Group Code<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="group_code" data-parsley-pattern="^[A-Z]+$" data-parsley-length="[2,3]" class="form-control col-md-7 col-xs-12" value="<?= show_value('group_code');?>" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="device-group">Device Group <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="dev_group" data-parsley-pattern="^[a-zA-Z0-9 \-]+$" data-parsley-length="[3, 20]"   class="form-control col-md-7 col-xs-12" value="<?= show_value('dev_group');?>" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="dev_icon" class="control-label col-md-4 col-sm-4 col-xs-12">Icon <span class="required"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="dev_icon" class="form-control" name="dev_icon" data-show-icon="true" required>
                            <option value="">Choose Icon...</option>
                            <option <?php if('fa fa-database' == show_value('dev_icon')) :?>selected<?php endif;?> value="fa fa-database" data-content="<i class='fa fa-database'></i> fa fa-database"></option>
                            <option <?php if('fa fa-shield' == show_value('dev_icon')) :?>selected<?php endif;?> value="fa fa-shield" data-content="<i class='fa fa-shield'></i> fa fa-shield"></option>
                            <option <?php if('fa fa-tasks' == show_value('dev_icon')) :?>selected<?php endif;?> value="fa fa-tasks" data-content="<i class='fa fa-tasks'></i> fa fa-tasks"></option>
                            <option <?php if('fa fa-server' == show_value('dev_icon')) :?>selected<?php endif;?> value="fa fa-server" data-content="<i class='fa fa-server'></i> fa fa-server"></option>
                            <option <?php if('fa fa-life-ring' == show_value('dev_icon')) :?>selected<?php endif;?> value="fa fa-life-ring" data-content="<i class='fa fa-life-ring'></i> fa fa-life-ring"></option>
                            <option <?php if('fa fa-signal' == show_value('dev_icon')) :?>selected<?php endif;?> value="fa fa-signal" data-content="<i class='fa fa-signal'></i> fa fa-signal"></option>
                            <option <?php if('fa fa-cloud' == show_value('dev_icon')) :?>selected<?php endif;?> value="fa fa-cloud" data-content="<i class='fa fa-cloud'></i> fa fa-cloud"></option>
                            <option <?php if('fa fa-ticket' == show_value('dev_icon')) :?>selected<?php endif;?> value="fa fa-ticket" data-content="<i class='fa fa-ticket'></i> fa fa-ticket"></option>
                            <option <?php if('fa fa-hdd-o' == show_value('dev_icon')) :?>selected<?php endif;?> value="fa fa-hdd-o" data-content="<i class='fa fa-hdd-o'></i> fa fa-hdd-o"></option>
                            <option <?php if('fa fa-square' == show_value('dev_icon')) :?>selected<?php endif;?> value="fa fa-square" data-content="<i class='fa fa-square'></i> fa fa-square"></option>
                          </select>
                        </div>
                        <br/>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-md btn-success pull-right" name="add">Add</button>
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