<?php
defined('BASEPATH') or exit('No direct script access allowed');?>

              <div class="x_panel">
                  <div class="x_title">
                    <h2>Edit Device Model</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <?= form_open('', 'method="post" id="model" data-parsley-validate class="form-horizontal form-label-left"');?>
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Device Model <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="model" data-parsley-pattern="^[a-zA-Z0-9 \/\-\-]+$" data-parsley-length="[3, 50]"  class="form-control col-md-7 col-xs-12" value="<?= $utils['dev_model'];?>" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Manufacture <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="manufacture" class="form-control" required>
                            <option value="">Choose Manufacture...</option>
                            <?php foreach ($manufactures as $manu) :?>

                            <option value="<?= $manu['dev_manufacture_id'];?>" <?php if($manu['dev_manufacture_id'] == $utils['dev_manufacture_id']) :?>selected<?php endif;?>><?= $manu['dev_manufacture'];?></option>
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