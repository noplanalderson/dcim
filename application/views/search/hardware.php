<?php defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Search Result : <?= ucwords($search);?></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="s" class="table responsive table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Hardware Code</th>
                          <th>Manufacture</th>
                          <th class="no-sort">Model</th>
                          <th class="no-sort">Capacity</th>
                          <th class="no-sort">Quantity</th>
                          <th class="no-sort">Procurement</th>
                          <th class="no-sort">Note</th>
                          <th class="no-sort">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($hardwares as $hw) :?>
                        <tr>
                          <td>
                            <a href="<?= base_url('hardwares/detail/'.encrypt($hw['hw_code']));?>"><?= $hw['hw_code'];?></a>
                          </td>
                          <td><?= $hw['hw_manufacture'];?></td>
                          <td><?= $hw['hw_model'];?></td>
                          <td><?= $hw['capacity'];?> <?= $hw['capacity_unit'];?></td>
                          <td><?= $hw['hw_quantity'];?> Unit</td>
                          <td><?= $hw['procurement'];?></td>
                          <td><?= $hw['notes'];?></td>
                          <td><?= $hw['hw_status'];?></td>
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