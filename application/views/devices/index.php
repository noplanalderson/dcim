<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <?php show_alert();?>
                  
                  <div class="x_title">
                    <div class="row">
                      <div class="col-md-8 col-sm-6">
                        <h2>Data <?= ucwords($dev_group);?></h2>
                      </div>
                      <div class="col-md-2 col-sm-12 pull-right">
                        <?= form_open('', 'method="post"');?>
                          <select name="group" class="form-control" onchange="this.form.submit()" required>
                            <option value="">Device Group</option>
                            <?php foreach ($groups as $group) :?>
                            
                            <option value="<?= strtolower(str_replace(' ', '-', $group['group_label']));?>"><?= $group['group_label'];?></option>
                            <?php endforeach;?>
                          
                          </select>
                        </form>
                      </div>
                      <div class="col-md-2 col-sm-12 pull-right">
                        <?= button($btn_add, 'a', base_url($btn_add['menu_link']), 'class="btn btn-md btn-primary pull-right"', NULL, true);?>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" style="overflow-x:scroll;font-size:10px;">
                    <table id="devices" class="table display table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>No. </th>
                          <th>Device Code</th>
                          <th><?= ucwords($dev_group);?> Name</th>
                          <th class="no-sort">Serial Number</th>
                          <th class="no-sort">Manufacture & Model</th>
                          <th class="no-sort">Processor</th>
                          <th class="no-sort">Cores</th>
                          <th class="no-sort">Mem. Model</th>
                          <th class="no-sort">Mem Cap. (GB)</th>
                          <th class="no-sort">HDD Model</th>
                          <th class="no-sort">HDD Cap. (GB)</th>
                          <th class="no-sort">Location</th>
                          <th>Rack Num.</th>
                          <th class="no-sort">Owner</th>
                          <th class="no-sort">Status</th>
                          <th class="no-sort">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($devices as $index => $device) :?>
                        <tr>
                          <td><?= $index+1;?></td>
                          <td>
                            <a href="<?= base_url('devices/detail/'.encrypt($device['device_id']));?>" target="_blank"><?= $device['group_code'].$device['device_code'];?></a>
                          </td>
                          <td><?= $device['hostname'];?></td>
                          <td><?= $device['serial_number'];?></td>
                          <td><?= $device['dev_manufacture'];?> <?= $device['dev_model'];?></td>
                          <td><?= $device['processor_type'];?></td>
                          <td><?= $device['cores'];?></td>
                          <td><?= $device['memory_model'];?></td>
                          <td><?= $device['memory_cap'];?></td>
                          <td><?= $device['hdd_model'];?></td>
                          <td><?= $device['hdd_cap'];?></td>
                          <td><?= $device['device_location'];?></td>
                          <td><?php if($device['rack_number'] == 0) : echo 'Outside Rack'; else: echo $device['rack_number']; endif;?></td>
                          <td><?= $device['device_owner'];?></td>
                          <td><?= $device['device_status'];?></td>
                          <td>
                            <?= button($btn_edit, 'a', base_url('devices/edit/'.encrypt($device['device_id'])), 'class="btn btn-xs btn-warning"');?>
                            <?= button($btn_delete, 'a', base_url('devices/delete/'.encrypt($device['device_code'])), 'class="btn btn-xs btn-danger"', 'onclick="return confirm(\'Are You sure to deleting '.$device['hostname'].'?\');"');?>
                            <?= button($btn_timeline, 'a', base_url('devices/timeline/'.encrypt($device['device_id'])), 'class="btn btn-xs btn-primary"', NULL, true);?>
                            </a>
                          </td>
                        </tr>
                        <?php endforeach;?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="15">Total <?= $dev_group; ?></td>
                          <td><?= $countdev; ?></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
