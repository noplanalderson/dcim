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
                  <?= show_alert();?>

                  <div class="x_title">
                    <h2>Add IP Subnet</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?= form_open('', 'method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"');?>
                      
                      <input type="hidden" name="id" value="<?= $network['network_id'];?>">
                      <input type="hidden" name="subnet_id" value="<?= $subnet['subnet_id'];?>">
                      <input type="hidden" name="type" value="<?= $network['network_type'];?>">
                      <div class="item form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="network">IP Subnet <span class="required">*</span></label>
                        <div class="col-md-1 col-sm-2 col-xs-12">
                          <input type="text" id="a" class="form-control col-sm-3 col-xs-6" name="a" readonly value="<?= $exp_network[0];?>">
                        </div>
                        <div class="col-md-1 col-sm-2 col-xs-12">
                          <input type="text" id="b" class="form-control col-sm-3 col-xs-6" name="b" readonly value="<?= $exp_network[1];?>">
                        </div>
                        <div class="col-md-1 col-sm-2 col-xs-12">
                          <input type="text" id="c" class="form-control col-sm-3 col-xs-6" name="c" value="<?= $exp_network[2];?>" readonly>
                        </div>
                        <div class="col-md-1 col-sm-2 col-xs-12">
                          <select id="d" class="form-control col-sm-3 col-xs-6" name="d" required>
                            <option value="">--</option>
                            <?php
                              $x = net_possible($network['submask']);
                              $y = array_search($exp_network[3], $x);
                              for ($i = $y; $i < count($x); $i++) :
                            ?>
                              <option value="<?= $x[$i];?>" <?php  if($host[0] == $x[$i]):?>selected<?php endif;?>><?= $x[$i];?></option>
                              
                            <?php endfor; ?>
                          </select>
                        </div>
                        <div class="col-md-2 col-sm-1 col-xs-12">
                          <input type="number" id="vlan" class="form-control col-sm-3 col-xs-6" name="vlan" placeholder="VLAN ID" value="<?= $subnet['vlan'];?>" required>
                        </div>
                        <div class="col-md-2 col-sm-1 col-xs-12">
                          <input type="text" class="form-control col-sm-3 col-xs-6" name="netmask" value="<?= $network['submask'];?>" readonly >
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="textarea">Label <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea required="required" name="label" class="form-control col-md-7 col-xs-12" data-parsley-length="[5, 100]"><?= $subnet['subnet_label'];?></textarea>
                        </div>
                      </div>   
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-2 pull-right">
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