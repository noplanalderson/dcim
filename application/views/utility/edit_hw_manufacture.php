<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Edit Hardware Manufacture</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <?= form_open('', 'method="post" id="manu-hw" data-parsley-validate class="form-horizontal form-label-left"');?>
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="hardware-manufacture">Hardware Manufacture<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="hw_manufacture" data-parsley-pattern="^[a-zA-Z0-9 \-]+$" data-parsley-length="[3, 50]" class="form-control col-md-7 col-xs-12" value="<?= $utils['hw_manufacture'];?>" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="hardware-group">Hardware Group <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="hw_group" class="form-control" required>
                            <option value="">Choose Hardware Group...</option>
                            <?php foreach ($hw_groups as $hardware) :?>

                            <option value="<?= $hardware['hw_category_id'];?>" <?php if($hardware['hw_category_id'] == $utils['hw_category_id']) :?>selected<?php endif;?>><?= $hardware['hw_category'];?></option>
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