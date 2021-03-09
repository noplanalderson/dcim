<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Edit Hardware Group</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <?= form_open('', 'method="post" id="hardware" data-parsley-validate class="form-horizontal form-label-left"');?>

                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="device-group">Group Code<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="hw_code" data-parsley-pattern="^[A-Z]+$" data-parsley-length="[2,3]" class="form-control col-md-7 col-xs-12" value="<?= $utils['hw_code'];?>" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="hardware-group">Hardware Group <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="hw_group_name" data-parsley-pattern="^[a-zA-Z0-9 \-]+$" data-parsley-length="[3, 20]"  class="form-control col-md-7 col-xs-12" value="<?= $utils['hw_category'];?>" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="hw_icon" class="control-label col-md-4 col-sm-4 col-xs-12">Group Icons <span class="required"> *</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="hw_icon" class="form-control" name="hw_icon" data-show-icon="true" required>
                            <option value="">Choose Icon...</option>
                            <option <?php if('fa fa-database' == $utils['hw_icon']) :?>selected<?php endif;?> value="fa fa-database" data-content="<i class='fa fa-database'></i> fa fa-database"></option>
                            <option <?php if('fa fa-shield' == $utils['hw_icon']) :?>selected<?php endif;?> value="fa fa-shield" data-content="<i class='fa fa-shield'></i> fa fa-shield"></option>
                            <option <?php if('fa fa-tasks' == $utils['hw_icon']) :?>selected<?php endif;?> value="fa fa-tasks" data-content="<i class='fa fa-tasks'></i> fa fa-tasks"></option>
                            <option <?php if('fa fa-server' == $utils['hw_icon']) :?>selected<?php endif;?> value="fa fa-server" data-content="<i class='fa fa-server'></i> fa fa-server"></option>
                            <option <?php if('fa fa-life-ring' == $utils['hw_icon']) :?>selected<?php endif;?> value="fa fa-life-ring" data-content="<i class='fa fa-life-ring'></i> fa fa-life-ring"></option>
                            <option <?php if('fa fa-signal' == $utils['hw_icon']) :?>selected<?php endif;?> value="fa fa-signal" data-content="<i class='fa fa-signal'></i> fa fa-signal"></option>
                            <option <?php if('fa fa-cloud' == $utils['hw_icon']) :?>selected<?php endif;?> value="fa fa-cloud" data-content="<i class='fa fa-cloud'></i> fa fa-cloud"></option>
                            <option <?php if('fa fa-ticket' == $utils['hw_icon']) :?>selected<?php endif;?> value="fa fa-ticket" data-content="<i class='fa fa-ticket'></i> fa fa-ticket"></option>
                            <option <?php if('fa fa-hdd-o' == $utils['hw_icon']) :?>selected<?php endif;?> value="fa fa-hdd-o" data-content="<i class='fa fa-hdd-o'></i> fa fa-hdd-o"></option>
                            <option <?php if('fa fa-square' == $utils['hw_icon']) :?>selected<?php endif;?> value="fa fa-square" data-content="<i class='fa fa-square'></i> fa fa-square"></option>
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