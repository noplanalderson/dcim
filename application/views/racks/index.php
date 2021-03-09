<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Device Lists in <?= $rack_title;?></h2>
                      <div class="col-md-3 col-sm-3 col-xs-12 pull-right">
                        <?= form_open('', 'method="post"');?>

                          <select name="rack" class="form-control" onchange="this.form.submit();" style="border-radius:5%">
                            <?php foreach ($racks as $rack_list) :?>

                            <option value="<?= $rack_list['rack_number'];?>" <?php if($rack_list['rack_number'] == $rack): ?> selected <?php endif;?>>Rack <?= $rack_list['rack_number'];?></option>
                            <?php endforeach;?>
                            <option value="OUTSIDE-RACK">Outside Rack</option>

                          </select>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" style="overflow-x:scroll;font-size:10px;">
                    <table id="racks" class="table responsive table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Device Code</th>
                          <th>Device Identity/Hostname</th>
                          <th class="no-sort">Serial Number</th>
                          <th class="no-sort">Manufacture & Model</th>
                          <th class="no-sort">Processor</th>
                          <th class="no-sort">Cores</th>
                          <th class="no-sort">Mem. Model</th>
                          <th class="no-sort">Mem Cap. (GB)</th>
                          <th class="no-sort">HDD Model</th>
                          <th class="no-sort">HDD Cap. (GB)</th>
                          <th class="no-sort">Location</th>
                          <th class="no-sort">Owner</th>
                          <th class="no-sort">Status</th>
                          <th class="no-sort">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($devices as $device) :?>
                        <tr>
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
                          <td><?= $device['device_owner'];?></td>
                          <td><?= $device['device_status'];?></td>
                          <td>
                          <?= button($btn_timeline, 'a', base_url('devices/timeline/'.encrypt($device['device_id'])), 'class="btn btn-xs btn-primary"', NULL, true);?>
                          </td>
                        </tr>
                        <?php endforeach;?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="13">Total Device in <?= $rack_title; ?></td>
                          <td><?= $count; ?></td>
                        </tr>
                      </tfoot>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->