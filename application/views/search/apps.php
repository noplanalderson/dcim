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
                    <table id="s" class="table responsive table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Hostname</th>
                          <th class="no-sort">Private IP</th>
                          <th class="no-sort">Public IP</th>
                          <th class="no-sort">Web/Application Address</th>
                          <th class="no-sort">Note</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($apps as $app) :?>
                        <tr>
                          <td><?= $app['hostname'];?></td>
                          <td><?= $app['private_ip'];?></td>
                          <td><?= $app['public_ip'];?></td>
                          <td><?= $app['app_address'];?></td>
                          <td><?= $app['notes'];?></td>
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