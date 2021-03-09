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
                    <h2>Input Hardware</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?= form_open_multipart('', 'method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" accept-charset="utf-8"');?>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenis-perangkat">Hardware Code <span class="required">*</span></label>
                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="category" class="form-control" name="category" required />
                              <option value="">Hardware Category..</option>
                              <?php foreach ($categories as $category) :?>

                              <option value="<?= $category['hw_code'];?>" <?php if($category['hw_code'] == $hardware['category_code']) :?>selected<?php endif;?>>
                                <?= $category['hw_category'];?>
                              </option>
                              <?php endforeach;?>

                            </select>
                          </div>

                          <div class="col-md-2 col-sm-2 col-xs-12">
                            <input id="hw_number" name="hw_number" class="form-control" type="text" placeholder="0" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-pattern="^\d+(\.\d+)?$" value="<?= explode('.', $hardware['hw_code'])[0];?>" required>
                          </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="manufaktur">Manufacture <span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <select id="manufacture" class="form-control manufacture col-md-6 col-xs-12" name="manufacture" required/>
                            <option value="">Choose Manufacture..</option>
                            <?php foreach ($categories as $category) :?>

                            <optgroup label='<?= $category['hw_category'];?>'>
                              <?php 
                                $manufacture = $this->add_hardware_m->get_hw_manufactures($category['hw_category_id']);
                                foreach ($manufacture as $manu) :
                              ?>

                              <option value="<?= $manu['hw_manufacture_id'];?>" <?php if($manu['hw_manufacture_id'] == $hardware['hw_manufacture_id']) :?>selected<?php endif;?>>
                                <?= $manu['hw_manufacture'];?>
                              </option>
                              <?php endforeach;?>

                            <?php endforeach;?>

                          </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label for="model" class="control-label col-md-3 col-sm-3 col-xs-12">Model</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input id="model" list="modelList" name="model" class="form-control" placeholder="Model" type="text" data-parsley-length="[5, 50]" value="<?= $hardware['hw_model'];?>">
                          <datalist id="modelList">
                            <?php foreach ($models as $model) :?>

                            <option value="<?= $model['hw_model'];?>"><?= $model['hw_model'];?></option>
                            <?php endforeach;?>

                          </datalist>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label for="capacity" class="control-label col-md-3 col-sm-3 col-xs-12">Capacity</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input id="capacity" name="capacity" class="form-control" type="text" placeholder="0" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-pattern="^\d+(\.\d+)?$" value="<?= $hardware['capacity'];?>" required>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Satuan <span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <select id="capacity_unit" class="form-control col-md-6 col-xs-6" name="capacity_unit" required />
                            <option value="">Choose Unit..</option>
                            <option value="MB" <?php if($hardware['capacity_unit'] == 'MB') :?>selected<?php endif;?>>Mega Byte</option>
                            <option value="GB" <?php if($hardware['capacity_unit'] == 'GB') :?>selected<?php endif;?>>Giga Byte</option>
                            <option value="TB" <?php if($hardware['capacity_unit'] == 'TB') :?>selected<?php endif;?>>Tera Byte</option>
                            <option value="Mhz" <?php if($hardware['capacity_unit'] == 'Mhz') :?>selected<?php endif;?>>Mega Hertz</option>
                            <option value="Ghz" <?php if($hardware['capacity_unit'] == 'Ghz') :?>selected<?php endif;?>>Giga Hertz</option>
                            <option value="Watt" <?php if($hardware['capacity_unit'] == 'Watt') :?>selected<?php endif;?>>Watt</option>
                            <option value="Volt" <?php if($hardware['capacity_unit'] == 'Volt') :?>selected<?php endif;?>>Volt</option>
                            <option value="Ampere" <?php if($hardware['capacity_unit'] == 'Ampere') :?>selected<?php endif;?>>Ampere</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label for="quantity" class="control-label col-md-3 col-sm-3 col-xs-12">Quantity</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input id="quantity" name="quantity" class=" form-control col-md-6 col-xs-6" type="text" placeholder="0" min="1" max="10000" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-type="digits" value="<?= $hardware['hw_quantity'];?>">
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Procurement <span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <select id="procurement" class="form-control col-md-6 col-xs-6" name="procurement" required/>
                            <option value="">Choose Year..</option>
                              <?php for($i=2002; $i<=2002+48; $i+=1) :?>

                                <option value='<?= $i; ?>' <?php if($hardware['procurement'] == $i) :?>selected<?php endif;?>><?= $i; ?></option>
                              <?php endfor; ?>

                          </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label for="notes" class="control-label col-md-3 col-sm-3 col-xs-12">Notes </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input id="notes" class="form-control" type="text" name="notes" placeholder="Keterangan" data-parsley-length="[5,255]" value="<?= $hardware['notes'];?>" />
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label for="status" class="control-label col-md-3 col-sm-3 col-xs-12">Status <span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <select id="status" class="form-control col-md-6 col-xs-6" name="status" required/>
                            <option value="">Choose Status..</option>
                            <option value="active" <?php if($hardware['hw_status'] == 'active') :?>selected<?php endif;?>>Active</option>
                            <option value="vacant" <?php if($hardware['hw_status'] == 'vacant') :?>selected<?php endif;?>>Vacant</option>
                            <option value="broken" <?php if($hardware['hw_status'] == 'broken') :?>selected<?php endif;?>>Broken</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label for="hw_picture" class="control-label col-md-3 col-sm-3 col-xs-12">Hardware Picture</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="hidden" name="old_hw_picture" value="<?= $hardware['hw_picture'];?>">
                          <input type="file" name="hw_picture" class="form-control col-md-4 col-xs-12">
                          <small>Maximum Image Size 3 MB with JPG, JPEG, or PNG format.</small>
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
