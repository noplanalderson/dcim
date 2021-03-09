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
                    <h2>Wifi Lists</h2>
		                <?= button($btn_add, 'a', base_url($btn_add['menu_link']), 'class="btn btn-md btn-primary pull-right"', NULL, true);?>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="wifi" class="table table-striped table-bordered responsive">
                      <thead>
                        <tr>
                          <th>Hostname</th>
                          <th>IP Private</th>
                          <th>IP Public</th>
                          <th>SSID</th>
                          <th class="no-sort">User Wifi</th>
                          <th class="no-sort">Password</th>
                          <th class="no-sort">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($wifis as $wifi) :?>
                        <tr>
                          <td><?= $this->services_m->get_hostname('wifi', $wifi['wifi_id']);?></td>
                          <td><?= $wifi['private_ip'];?></th>
                          <td><?= $wifi['public_ip'];?></th>
                          <td><?= $wifi['wifi_ssid'];?></td>
                          <td><?= $wifi['wifi_user'];?></td>
                          <td><?= $wifi['wifi_password'];?></td>
                          <!-- <td width="200px">
                            <div class="password-group">
                              <input type="password" value="<?= $wifi['wifi_password'];?>" class="form-control password-box" aria-label="password" readonly="readonly" style="width:80%;"><a href="#!" title="Show/Hide Password" class="pull-right btn btn-warning btn-xs password-visibility" style="position:inherti;margin-top:-3rem;"><i class="fa fa-eye"></i></a>
                            </div>
                          </td> -->
                          <td>
                            <?= button($btn_edit, 'a', base_url('services/edit/wifi/'.encrypt($wifi['wifi_id'])), 'class="btn btn-xs btn-warning"');?>
                            <?= button($btn_delete, 'a', base_url('services/delete/wifi/'.encrypt($wifi['wifi_id'])), 'class="btn btn-xs btn-danger"', 'onclick="return confirm(\'Are You sure to deleting '.$wifi['wifi_ssid'].'?\');"');?>
                          </td>
                        </tr>
                        <?php endforeach;?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->