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
                    <h2>Websites and Applications</h2>
		                <?= button($btn_add, 'a', base_url($btn_add['menu_link']), 'class="btn btn-md btn-primary pull-right"', NULL, true);?>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="apps" class="table responsive table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Host</th>
                          <th>VM</th>
                          <th class="no-sort">Private IP</th>
                          <th class="no-sort">Public IP</th>
                          <th class="no-sort">Site/Apps URL</th>
                          <th class="no-sort">Notes</th>
                          <th class="no-sort">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($apps as $app) :?>
                        <tr>
                          <td><?= $app['hostname'];?></td>
                          <td><?= $app['vm_hostname'];?></td>
                          <td><?= $app['ip_private'];?></td>
                          <td><?= $app['ip_public'];?></td>
                          <td><?= $app['app_address'];?></td>
                          <td><?= $app['notes'];?></td>
                          <td>
                            <?= button($btn_edit, 'a', base_url('services/edit/app/'.encrypt($app['app_id'])), 'class="btn btn-xs btn-warning"');?>
                            <?= button($btn_delete, 'a', base_url('services/delete/app/'.encrypt($app['app_id'])), 'class="btn btn-xs btn-danger"', 'onclick="return confirm(\'Are You sure to deleting '.$app['app_address'].'?\');"');?>

                            </a>
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
