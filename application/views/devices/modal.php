<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>
        <!-- Modal -->
        <div class="modal fade bs-example-modal-lg" id="deviceModal" style="overflow:hidden;" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title" id="modalTitle"></h3>
                <button type="button" class="close" style="margin-top:-3rem;" data-dismiss="modal" aria-label="Close">
                  <i class="fa fa-close"></i>
                </button>
              </div>
              <div class="modal-body">
                  <?= form_open_multipart('devices/edit', 'method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"');?>

                        <input id="device_code" type="hidden" name="device_code" value="">
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="device_group">Device Group <span class="required">*</span></label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                  <select id="device_group" class="form-control" name="device_group" required />
                                    <option value="">Choose Device Group..</option>
                                    <?php foreach ($group_lists as $group) :?>
                                    <option value="<?= $group['group_code'];?>"><?= $group['group_label'];?></option>
                                    <?php endforeach;?>
                                  </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="manufacture">Manufacture <span class="required">*</span></label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <select id="manufacture" class="form-control manufacture col-md-12 col-xs-12" name="manufacture" required/>
                                  <option value="">Choose Manufacture..</option>
                                  <?php foreach ($group_lists as $group) :?>
                                  <optgroup label='<?= ucwords($group['kategori_device']);?>'>
                                    <?php 
                                      $manufacture = $this->add_device_m->get_manufactures($group['group_id']);
                                      foreach ($manufacture as $manu) :
                                    ?>
                                    <option value="<?= $manu['dev_manufacture_id'];?>"><?= ucwords($manu['dev_manufacture']);?></option>
                                    <?php endforeach;?>
                                  <?php endforeach;?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="model" class="control-label col-md-3 col-sm-3 col-xs-12">Model <span class="required">*</span></label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <select id="model" class="form-control model col-md-6 col-xs-12" name="model" required/>
                                  <option value="">Choose Model..</option>
                                  <?php foreach ($manufactures as $manu) :?>
                                  <optgroup label='<?= ucwords($manu['manufaktur']);?>'>
                                    <?php 
                                      $models = $this->add_device_m->get_dev_models($manu['dev_manufacture_id']);
                                      foreach ($models as $model) :
                                    ?>
                                    <option value="<?= $model['dev_model_id'];?>"><?= ucwords($model['dev_model']);?></option>
                                    <?php endforeach;?>
                                  <?php endforeach;?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="processor" class="control-label col-md-3 col-sm-3 col-xs-12">Processor</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="processor" name="prosesor" class="form-control" placeholder="Processor" type="text" data-parsley-length="[5, 50]">
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="cores" class="control-label col-md-3 col-sm-3 col-xs-12">Cores</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="cores" name="core" class="form-control" type="text" placeholder="0" min="1" max="128" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-type="digits" title="Harus Angka">
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="memory_model">Memory Model </label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="memory_model" type="text" class="tags model-hw form-control" name="memory_model" data-role="tagsinput">
                                <small>Separate by comma if more than one model</small>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="memory_cap" class="control-label col-md-3 col-sm-3 col-xs-12">Memmory Cap. (GB)</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="memory_cap" name="memory_cap" class="size-hw form-control col-md-6 col-xs-6" type="text" placeholder="0" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-pattern="^[0-9,]+$" title="Harus Angka" data-role="tagsinput">
                                <small>Size input are in accordance with the RAM Model sequence.</small>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hdd_model">HDD Model </label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="hdd_model" type="text" class="tags model-hw form-control" name="hdd_model" data-role="tagsinput">
                                <small>Separate by comma if more than one model</small>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="hdd_cap" class="control-label col-md-3 col-sm-3 col-xs-12">HDD Cap. (GB)</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="hdd_cap" name="hdd_cap" class="form-control size-hw" type="text" placeholder="0" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-pattern="^[0-9,]+$" title="Harus Angka" data-role="tagsinput">
                                <small>Size input are in accordance with the HDD Model sequence.</small>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="port" class="control-label col-md-3 col-sm-3 col-xs-12">LAN + Console </label>
                              <div class="col-md-4 col-sm-4 col-xs-12">
                                <input id="eth_port" name="eth_port" class=" form-control col-md-6 col-xs-6" type="text" value="<?= show_value('eth_port');?>" placeholder="0" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-type="digits" data-parsley-length="[1,2]">
                              </div>
                              <div class="col-md-4 col-sm-4 col-xs-12">
                                <input id="console_port" name="console_port" class=" form-control col-md-6 col-xs-6" type="text" value="<?= show_value('console_port');?>" placeholder="0" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-type="digits" data-parsley-length="[1,2]">
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="usb_port" class="control-label col-md-3 col-sm-3 col-xs-12">USB</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="usb_port" name="usb_port" class="form-control" type="text" value="<?= show_value('usb_port');?>" placeholder="0" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-type="digits" data-parsley-length="[1,2]">
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="hostname" class="control-label col-md-3 col-sm-3 col-xs-12">Hostname </label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="hostname" class="form-control" type="text" name="hostname" value="<?= show_value('hostname');?>" placeholder="default:localhost" data-parsley-pattern="^[A-Za-z0-9.@\-\_]+$" data-parsley-length="[3,50]">
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="serial_number" class="control-label col-md-33 col-sm-3 col-xs-12">Serial Number <span class="required"> *</span></label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="serial_number" name="serial_number" class=" form-control col-md-6 col-xs-6"  value="<?= show_value('serial_number');?>" placeholder="Serial Number" type="text" data-parsley-pattern="^[A-Za-z0-9:/-]+$" data-parsley-length="[5, 50]" required>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="os" class="control-label col-md-3 col-sm-3 col-xs-12">Operating System</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="operating_system" class=" form-control col-md-6 col-xs-6" type="text" name="operating_system" value="<?= show_value('operating_system');?>" placeholder="Operating System" data-parsley-pattern="^[a-zA-Z0-9\s-.]+$" data-parsley-length="[3, 255]">
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Arsitektur OS</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="os_arch" class="form-control col-md-6 col-xs-6" name="os_arch" type="text" value="<?= show_value('os_arch');?>" placeholder="OS Architecture" data-parsley-length="[3, 255]">
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="device_location" class="control-label col-md-3 col-sm-3 col-xs-12">Location <span class="required">*</span></label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="device_location" name="device_location" class="form-control" type="text" placeholder="Device Location" data-parsley-pattern="^[a-zA-Z0-9\s]+$" data-parsley-length="[3, 50]" required />
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="rack_number" class="control-label col-md-3 col-sm-3 col-xs-12">Rack Number</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="rack_number" name="rack_number" class="form-control col-md-6 col-xs-6" type="text" value="<?= show_value('rack');?>" placeholder="0" max="100" data-parsley-trigger="keyup" data-parsley-type="digits" required>
                                <small>Give zero (0) number if outside rack.</small>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Procurement <span class="required">*</span></label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <select id="procurement" class="form-control col-md-6 col-xs-6" name="procurement" required/>
                                  <option value="">Choose Year..</option>
                                    <?php
                                      for($i=2002; $i<=2002+48; $i+=1){
                                          echo "<option value='$i'> $i </option>";
                                      }
                                    ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="device_status" class="control-label col-md-3 col-sm-3 col-xs-12">Status <span class="required">*</span></label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <select id="device_status" class="form-control col-md-6 col-xs-6" name="device_status" required/>
                                  <option value="">Choose Status..</option>
                                  <option value="ACTIVE">Active</option>
                                  <option value="VACANT">Vacant</option>
                                  <option value="BROKEN">Broken</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="device_owner" class="control-label col-md-3 col-sm-3 col-xs-12">Owner</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="device_owner" class=" form-control col-md-6 col-xs-6" type="text" name="device_owner" placeholder="Pemilik" data-parsley-pattern="^[a-zA-Z0-9\s-.]+$" data-parsley-length="[3, 50]" title="Harus Huruf, Angka, dan Spasi"required />
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="device_image" class="control-label col-md-3 col-sm-3 col-xs-12">Device Image</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="hidden" id="old_device_image" name="oldfoto" value="">
                                <input type="file" name="device_image" class="form-control col-md-4 col-xs-12">
                                <small>Maximum image size 3 MB with format JPG, JPEG, or PNG.</small>
                              </div>
                            </div>
                          </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="submit"></button>
                </form>
              </div>
            </div>
          </div>
        </div>