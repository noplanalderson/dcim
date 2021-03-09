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
                    <h2>VMs</h2>
		                <?= button($btn_add, 'a', base_url($btn_add['menu_link']), 'class="btn btn-md btn-primary pull-right"', NULL, true);?>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="vms" class="table responsive table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Host</th>
                          <th class="no-sort">VM Hostname</th>
                          <th class="no-sort">IP Address</th>
                          <th class="no-sort">Operating System</th>
                          <th class="no-sort">Cores</th>
                          <th class="no-sort">Memory Cap.</th>
                          <th class="no-sort">HDD Cap.</th>
                          <th class="no-sort">Notes</th>
                          <th class="no-sort">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($vms as $vm) :?>
                        <tr>
                          <td><?= $vm['host'];?></td>
                          <td><?= $vm['hostname'];?></td>
                          <td>
                            Private IP : <?= $vm['private_ip'];?><br/>
                            Public IP : <?= $vm['public_ip'];?>
                          </td>
                          <td>
                            <?= $vm['operating_system'];?><br/>
                            <?= $vm['os_architecture'];?>
                          </td>
                          <td><?= $vm['cores'];?></td>
                          <td><?= $vm['mem_cap'];?> GB</td>
                          <td><?= $vm['hdd_cap'];?> GB</td>
                          <td><?= $vm['notes'];?></td>
                          <td>
                            <?= button($btn_edit, 'a', base_url('services/edit/vm/'.encrypt($vm['vm_id'])), 'class="btn btn-xs btn-warning"');?>
                            
                            <?= button($btn_delete, 'a', base_url('services/delete/vm/'.encrypt($vm['vm_id'])), 'class="btn btn-xs btn-danger"', 'onclick="return confirm(\'Are You sure to deleting VM '.$vm['hostname'].'?\');"');?>
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
