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
                    <h2>Network Blocks</h2>
		                <?= button($btn_add, 'a', base_url($btn_add['menu_link']), 'class="btn btn-md btn-primary pull-right"', NULL, true);?>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="network" class="table responsive table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Network Block</th>
                          <th class="no-sort">Type</th>
                          <th class="no-sort">Label</th>
                          <th class="no-sort">Used</th>
                          <th class="no-sort">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($networks as $network) :?>
                        <tr>
                          <td><?= $network['network_block'];?></td>
                          <td><?= $network['network_type'];?></td>
                          <td><?= $network['network_label'];?></td>
                          <td>
                            <?=
                              $this->services_m->used_ip($network['network_type'], $network['network_id']).'/'.
                              $this->services_m->allocated_ip($network['network_type'], $network['network_id']);
                            ?>
                          </td>
                          <td>
                            <?= button($btn_read, 'a', base_url('services/subnet/'.$network['network_type'].'/'.encrypt($network['network_id'])), 'class="btn btn-xs btn-success"');?>
                            
                            <?= button($btn_subnet, 'a', base_url('add-service/subnet/'.encrypt($network['network_id'])), 'class="btn btn-xs btn-primary"', NULL, true);?>
                            
                            <?= button($btn_edit, 'a', base_url('services/edit/network/'.encrypt($network['network_id'])), 'class="btn btn-xs btn-warning"');?>
                            
                            <?= button($btn_delete, 'a', base_url('services/delete/network/'.encrypt($network['network_id'])), 'class="btn btn-xs btn-danger"', 'onclick="return confirm(\'Are You sure to deleting this network?\');"');?>
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