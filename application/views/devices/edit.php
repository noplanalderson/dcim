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
                    <h2>Add Device</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Hardware Information</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Device Identity</a>
                        </li>
                      </ul>
                    </div>
                      <br/><br/>
                      <?= form_open_multipart('', 'method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"');?>
                        <input type="hidden" name="id" value="<?= encrypt($device['device_id']);?>">
                        <div id="myTabContent" class="tab-content">
                          <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="device_number" class="control-label col-md-3 col-sm-3 col-xs-12">Device Code <span class="required">*</span></label>
                              <div class="col-md-3 col-sm-3 col-xs-12">
                                <select id="device-group" class="form-control" name="device_group" required />
                                  <option value="">Device Group..</option>
                                  <?php foreach ($dev_groups as $group) :?>
                                  <option value="<?= $group['group_code'];?>" <?php if($group['group_code'] == $device['group_code']):?>selected<?php endif;?>>
                                  <?= $group['group_label'];?></option>
                                  <?php endforeach;?>
                                </select>
                              </div>
                              <div class="col-md-5 col-sm-5 col-xs-12">
                                <input id="device_number" name="device_number" class="form-control" placeholder="Device Number" type="text" value="<?= explode('.', $device['device_code'])[0];?>" data-parsley-type="digits" required />
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="manufacture">Manufacture <span class="required">*</span></label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <select id="manufacture" class="form-control manufacture col-md-6 col-xs-12" name="manufacture" required />
                                  <option value="">Choose Manufacture..</option>
                                  <?php foreach ($dev_groups as $group) :?>
                                  <optgroup label='<?= ucwords($group['group_label']);?>'>
                                    <?php 
                                      $manufacture = $this->add_device_m->get_manufactures($group['group_id']);
                                      foreach ($manufacture as $manu) :
                                    ?>
                                    <option value="<?= $manu['dev_manufacture_id'];?>" <?php if($manu['dev_manufacture_id'] == $device['dev_manufacture_id']):?>selected<?php endif;?>>
                                      <?= ucwords($manu['dev_manufacture']);?>
                                    </option>
                                    <?php endforeach;?>
                                  <?php endforeach;?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="processor" class="control-label col-md-3 col-sm-3 col-xs-12">Processor</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="processor" type="text" name="processor_type" class="form-control" value="<?= $device['processor_type'];?>" placeholder="Processor" data-parsley-length="[5, 50]">
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="processor" class="control-label col-md-3 col-sm-3 col-xs-12">Model <span class="required">*</span></label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <select id="model" class="form-control model col-md-6 col-xs-12" name="model" required/>
                                  <option value="">Choose Model..</option>
                                  <?php foreach ($manufactures as $manu) :?>
                                  <optgroup label='<?= ucwords($manu['dev_manufacture']);?>'>
                                    <?php 
                                      $models = $this->add_device_m->get_dev_models($manu['dev_manufacture_id']);
                                      foreach ($models as $model) :
                                    ?>
                                    <option value="<?= $model['dev_model_id'];?>" <?php if($model['dev_model_id'] == $device['dev_model_id']):?>selected<?php endif;?>>
                                      <?= ucwords($model['dev_model']);?>
                                    </option>
                                    <?php endforeach;?>
                                  <?php endforeach;?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="cores" class="control-label col-md-3 col-sm-3 col-xs-12">Cores</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="cores" name="cores" class="form-control" type="text" value="<?= $device['cores'];?>" placeholder="0" min="0" max="128" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-type="digits">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memory_model">Mem. Models</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="memory_model" type="text" class="tags model-hw form-control" name="memory_model" value="<?= $device['memory_model'];?>">
				                        <small>Separate by comma if more than one model</small>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="mem_cap" class="control-label col-md-3 col-sm-3 col-xs-12">Mem. Capacity (GB)</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="mem_cap" name="mem_cap" class="size-hw form-control col-md-6 col-xs-6" type="text" value="<?= $device['memory_cap'];?>" placeholder="0" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-pattern="^[0-9,]+$">
                                <small>Size input are in accordance with the RAM Model sequence.</small>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="hdd_cap" class="control-label col-md-3 col-sm-3 col-xs-12">HDD Capacity (GB)</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="hdd_cap" name="hdd_cap" class="form-control size-hw" type="text" value="<?= $device['hdd_cap'];?>" placeholder="0" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-pattern="^[0-9,]+$">
                                <small>Size input are in accordance with the HDD Model sequence.</small>
                              </div>
                            </div>                            
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hdd_model">HDD Model </label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="hdd_model" type="text" class="tags model-hw form-control" name="hdd_model" value="<?= $device['hdd_model'];?>">
                                <small>Separate by comma if more than one model</small>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="port" class="control-label col-md-3 col-sm-3 col-xs-12">LAN + Console </label>
                              <div class="col-md-4 col-sm-4 col-xs-12">
                                <input id="eth_port" name="eth_port" class=" form-control col-md-6 col-xs-6" type="text" value="<?= $device['eth_port'];?>" placeholder="0" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-type="digits" data-parsley-length="[1,2]">
                              </div>
                              <div class="col-md-4 col-sm-4 col-xs-12">
                                <input id="console_port" name="console_port" class=" form-control col-md-6 col-xs-6" type="text" value="<?= $device['console_port'];?>" placeholder="0" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-type="digits" data-parsley-length="[1,2]">
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="usb_port" class="control-label col-md-3 col-sm-3 col-xs-12">USB</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="usb_port" name="usb_port" class="form-control" type="text" value="<?= $device['usb_port'];?>" placeholder="0" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-type="digits" data-parsley-length="[1,2]">
                              </div>
                            </div>
                          </div>
                          <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="hostname" class="control-label col-md-3 col-sm-3 col-xs-12">Hostname </label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="hostname" class="form-control" type="text" name="hostname" value="<?= $device['hostname'];?>" placeholder="default:localhost" data-parsley-pattern="^[A-Za-z0-9.@\-\_]+$" data-parsley-length="[3,50]">
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="serial_number" class="control-label col-md-33 col-sm-3 col-xs-12">Serial Number <span class="required"> *</span></label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="serial_number" name="serial_number" class=" form-control col-md-6 col-xs-6"  value="<?= $device['serial_number'];?>" placeholder="Serial Number" type="text" data-parsley-pattern="^[A-Za-z0-9:/-]+$" data-parsley-length="[5, 50]" required>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="operating_system" class="control-label col-md-3 col-sm-3 col-xs-12">Operating System</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="operating_system" class=" form-control col-md-6 col-xs-6" type="text" name="operating_system" value="<?= $device['operating_system'];?>" placeholder="Operating System" data-parsley-pattern="^[a-zA-Z0-9\s-.]+$" data-parsley-length="[3, 255]">
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label form="os_arch" class="control-label col-md-3 col-sm-3 col-xs-12">OS Arch</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="os_arch" class="form-control col-md-6 col-xs-6" name="os_arch" type="text" value="<?= $device['os_architecture'];?>" placeholder="OS Architecture" data-parsley-length="[3, 255]">
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="location" class="control-label col-md-3 col-sm-3 col-xs-12">Location <span class="required">*</span></label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="location" name="location" class="form-control" type="text" value="<?= $device['device_location'];?>" placeholder="Lokasi Perangkat" data-parsley-pattern="^[a-zA-Z0-9\s]+$" data-parsley-length="[3, 50]" required>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="rack" class="control-label col-md-3 col-sm-3 col-xs-12">Rack Number</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="rack" name="rack" class="form-control col-md-6 col-xs-6" type="text" value="<?= $device['rack_number'];?>" placeholder="0" max="100" data-parsley-trigger="keyup" data-parsley-type="digits" required>
                                <small>Give zero (0) number if outside rack.</small>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Procurement <span class="required">*</span></label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <select id="procurement" class="form-control col-md-6 col-xs-6" name="procurement" required>
                                  <option value="">Choose Year..</option>
                                    <?php for($i=2002; $i<=2002+48; $i+=1):?>>
                                      <option value="<?= $i; ?>" <?php if($i == $device['procurement']):?>selected<?php endif;?>><?= $i; ?></option>
                                    <?php endfor;?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="status" class="control-label col-md-3 col-sm-3 col-xs-12">Status <span class="required">*</span></label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <select id="status" class="form-control col-md-6 col-xs-6" name="status" required>
                                  <option value="">Choose Status..</option>
                                  <option value="active" <?php if($device['device_status'] == 'active'):?>selected<?php endif;?>>Active</option>
                                  <option value="vacant" <?php if($device['device_status'] == 'vacant'):?>selected<?php endif;?>>Vacant</option>
                                  <option value="broken" <?php if($device['device_status'] == 'broken'):?>selected<?php endif;?>>Broken</option>
                                </select>
                              </div>
                            </div>
			                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="owner" class="control-label col-md-3 col-sm-3 col-xs-12">Owner</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="owner" class=" form-control col-md-6 col-xs-6" type="text" name="owner" value="<?= $device['device_owner'];?>" placeholder="Device Owner" data-parsley-pattern="^[a-zA-Z0-9\s-.]+$" data-parsley-length="[3, 50]" required>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="device_image" class="control-label col-md-3 col-sm-3 col-xs-12">Device Image</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="hidden" name="old_device_image" value="<?= $device['device_picture'];?>">
                                <input id="device_image" type="file" name="device_image" class="form-control col-md-4 col-xs-12">
                                <small>Maximum image size 3 MB with format JPG, JPEG, or PNG.</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <div class="ln_solid"></div>
                              <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-10">
                                <button class="btn btn-primary" type="reset">Reset</button>
                                <button id="submit" type="submit" name="submit" class="btn btn-success">Submit</button>
                              </div>
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
