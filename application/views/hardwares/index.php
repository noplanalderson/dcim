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
                    <div class="row">
                      <div class="col-md-8 col-sm-6">
                        <h2>Data <?= ucwords($hw_group);?></h2>
                      </div>
                      <div class="col-md-2 col-sm-12 pull-right">
                        <?= form_open('', 'method="post"');?>
                          <select name="group" class="form-control" onchange="this.form.submit()" required>
                            <option value="">Hardware Group</option>
                            <?php foreach ($groups as $group) :?>
                            
                            <option value="<?= strtolower(str_replace(' ', '-', $group['hw_category']));?>"><?= $group['hw_category'];?></option>
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
                          <th class="no-sort">Action</th>
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
                          <td>
                            <?= button($btn_edit, 'a', base_url('hardwares/edit/'.encrypt($hw['hw_code'])), 'class="btn btn-xs btn-warning"');?>
                            <?= button($btn_delete, 'a', base_url('hardwares/delete/'.encrypt($hw['hw_code'])), 'class="btn btn-xs btn-danger"', 'onclick="return confirm(\'Are You sure to deleting '.$hw['hw_code'].'?\');"');?>
                            </a>
                          </td>
                        </tr>
                        <?php endforeach;?>
                      </tbody>
                       <tfoot>
                        <tr>
                          <td colspan="8">Total <?= $hw_group; ?></td>
                          <td><?= $counthw; ?></td>
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