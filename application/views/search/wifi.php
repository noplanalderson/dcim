<?php defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Search Result : <?= $search;?></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="s" class="table table-striped table-bordered responsive">
                      <thead>
                        <tr>
                          <th>Hostname</th>
                          <th>IP Device</th>
                          <th>SSID</th>
                          <th class="no-sort">User Wifi</th>
                          <th class="no-sort">Password</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($wifis as $wifi) :?>
                        <tr>
                          <td><?= $wifi['hostname'];?></td>
                          <td><?= $wifi['private_ip'];?>, <?= $wifi['public_ip'];?></th>
                          <td><?= $wifi['wifi_ssid'];?></td>
                          <td><?= $wifi['wifi_user'];?></td>
                          <td><?= $wifi['wifi_password'];?></td>
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