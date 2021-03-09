<?php defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <?php show_alert();?>
                  
                  <div class="x_title">
                    <h2>Hardware Lists Procurement <?= $year;?></h2>
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
                    <table id="hardwares" class="table responsive table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Hardware Code</th>
                          <th>Group & Manufacture</th>
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
                            <a href="<?= base_url('hardwares/detail/'.encrypt($hw['hw_code']));?>"><?= $hw['category_code'].$hw['hw_code'];?></a>
                          </td>
                          <td><?= $hw['hw_category'];?> / <?= $hw['hw_manufacture'];?></td>
                          <td><?= $hw['hw_model'];?></td>
                          <td><?= $hw['capacity'];?> <?= $hw['capacity_unit'];?></td>
                          <td><?= $hw['hw_quantity'];?> Unit</td>
                          <td><?= $hw['procurement'];?></td>
                          <td><?= $hw['notes'];?></td>
                          <td><?= $hw['hw_status'];?></td>
                        </tr>
                        <?php endforeach;?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="7">Total Hardware in <?= $year; ?> Procurement</td>
                          <td><?= $count; ?></td>
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