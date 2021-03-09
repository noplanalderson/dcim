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
                    <h2>Device Lists Procurement <?= $year;?></h2>
                      <div class="col-md-3 col-sm-3 col-xs-12 pull-right">
                        <?= form_open('', 'method="post"');?>

                          <select name="year" class="form-control" onchange="this.form.submit();" style="border-radius:5%">
                            <?php foreach ($years as $year_list) :?>

                            <option value="<?= $year_list['procurement'];?>" <?php if($year_list['procurement'] == $year): ?> selected <?php endif;?>><?= $year_list['procurement'];?></option>
                            <?php endforeach;?>
                            <option value="" <?php if($year == 'All Year'): ?> selected <?php endif;?>>All Year</option>

                          </select>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" style="overflow-x:scroll;font-size:10px;">
                    <table id="procurement" class="table responsive table-striped table-bordered">
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
                            <?= button($btn_timeline, 'a', base_url('devices/timeline/'.encrypt($device['device_id'])), 'class="btn btn-xs btn-primary"', NULL, true);?>
                          </td>
                        </tr>
                        <?php endforeach;?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="14">Total Device in <?= $year; ?> Procurement</td>
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