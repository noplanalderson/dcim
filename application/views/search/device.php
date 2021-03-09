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
                          <th>Device Code</th>
                          <th>System Identity</th>
                          <th class="no-sort">Serial Number</th>
                          <th class="no-sort">Manufacture</th>
                          <th class="no-sort">Processor</th>
                          <th class="no-sort">Memory</th>
                          <th class="no-sort">Harddisk</th>
                          <th class="no-sort">Location</th>
                          <th>Rack Num.</th>
                          <th class="no-sort">Owner</th>
                          <th class="no-sort">Status</th>
                          <th class="no-sort">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($devices as $device) :?>
                        <tr>
                          <td>
                            <a href="<?= base_url('devices/detail/'.encrypt($device['device_code']));?>" target="_blank"><?= $device['device_code'];?></a>
                          </td>
                          <td><?= $device['hostname'];?></td>
                          <td><?= $device['serial_number'];?></td>
                          <td><?= $device['dev_manufacture'];?> <?= $device['dev_model'];?></td>
                          <td><?= $device['processor_type'];?> <?= $device['cores'];?> Core</td>
                          <td><?= $device['memory_model'];?> <?= $device['memory_cap'];?> GB</td>
                          <td><?= $device['hdd_model'];?> <?= $device['hdd_cap'];?> GB</td>
                          <td><?= $device['device_location'];?></td>
                          <td><?php if($device['rack_number'] == 0) : echo "OUTSIDE RACK"; else : echo $device['rack_number']; endif;?></td>
                          <td><?= $device['device_owner'];?></td>
                          <td><?= $device['device_status'];?></td>
                  			  <td>
                    				<a href="<?= base_url('devices/timeline/'.encrypt($device['device_code']));?>" 
                  					class="btn btn-xs btn-primary">
                            		<i class="fa fa-info"></i> Timeline
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
