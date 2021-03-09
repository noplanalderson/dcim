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
                    <h2>Address Lists</h2>
		    		<?= button($btn_add, 'a', base_url($btn_add['menu_link']), 'class="btn btn-md btn-primary pull-right"', NULL, true);?>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="ip" class="table responsive table-striped table-bordered">
		                  <thead>
		                    <tr>
		                      <th>ID</th>
		                      <th>IP Subnet</th>
		                      <th class="no-sort">IP Address</th>
		                      <th class="no-sort">System Identity</th>
		                      <th class="no-sort">Device Type</th>
		                      <th class="no-sort">Service</th>
		                      <th class="no-sort">Action</th>
		                    </tr>
		                  </thead>
		                  <tbody>
		                  	<?php foreach ($subnets as $net) :?>

	                  		<tr <?php if($net['is_active'] == 'N'):?> style="color:#000000;background-color:#FF0000;"<?php endif;?>>
	                  			<td><?= $net['address_id'];?></td>
	                  			<td>
	                  				<b><?= $net['subnet_label'];?> (<?= $net['ip_subnet'];?> - VLANID : <?= $net['vlan'];?>)</b>

                           			<?= button($btn_delete, 'a', base_url('services/delete/subnet/'.encrypt($net['subnet_id'])), 'class="btn btn-xs btn-danger pull-right"', 'onclick="return confirm(\'Are You sure to deleting Subnet Block?\');"');?>

	                  				<?= button($btn_edit, 'a', base_url('services/edit/subnet/'.encrypt($net['subnet_id'])), 'class="btn btn-xs btn-warning pull-right"');?>
	                    		</td>
	                  			<td><?= $net['ip_address'];?></td>
	                  			<td><?= $net['hostname'];?></td>
	                  			<td><?= $net['group_label'];?></td>
	                  			<td>
	                  				Web & Apps : <?= $this->services_m->get_app_by_network($net['network_type'], $net['address_id']);?><br/>
	                  				Wifi : <?= $this->services_m->get_wifi_by_network($net['network_type'], $net['address_id']);?><br/>
	                  				VMs : <?= $this->services_m->get_vm_by_network($net['network_type'], $net['address_id']);?>
	              				</td>
	                  			<td>
	                  				<?php
	                  				if(!empty($btn_action)) :
	                  					if ($net['is_active'] == 'Y'): ?>
										<a href="<?= base_url('services/action/block/'.$net['network_type'].'/'.encrypt($net['address_id']));?>" class="btn btn-xs btn-danger" onclick="return confirm('Block IP?');">Block IP</a>
										<?php else : ?>

										<a href="<?= base_url('services/action/allow/'.$net['network_type'].'/'.encrypt($net['address_id']));?>" class="btn btn-xs btn-success" onclick="return confirm('Buka IP?');">Open IP</a>
										<?php endif;?>
										<?php if($net['is_active'] == 'Y') :?>

										<button data-id="<?= $net['network_type'].'/'.encrypt($net['address_id']);?>" type="button" class="btn btn-warning btn-xs add" data-toggle="modal" data-target="#devModal">
										 <i class="fa fa-plus"></i> Use IP
										</button>
										<?php 
										endif; 
									endif;?>
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
        	<div class="modal fade" id="devModal" style="overflow:hidden;" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog col-md-12 col-sm-12 col-xs-12" style="width:50%;left:25%;top:10%;">
					<div class="modal-content">
						<div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal">x</button>
						  <h4 class="modal-title" id="myModalLabel">Add IP to Device</h4>
						</div>
						<div class="modal-body">
					        <div class="form-group">
					          <?= form_open('', 'method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"');?>
					          <input type="hidden" name="network_type" value="<?= $net_type;?>">
					          <input id="id_ip" type="hidden" name="id_ip">
					          <input type="hidden" name="network_id" value="<?= $network_id;?>">
					          <div class="col-md-12 col-sm-12 col-xs-12 form-group">
					            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenis-perangkat">Device Name</label>
					              <div class="col-md-6 col-sm-6 col-xs-12">
					                <select id="device" class="form-control device" name="device_code" style="width:300px;">
					                  <option value="">Choose Device</option>
					                  <?php foreach($devices as $device) :?>

					                  <option value="<?= $device['device_code'];?>"><?= $device['hostname'];?></option>
					                  <?php endforeach;?>

					                </select>
					              </div>
					          </div>
					          <div class="col-md-12 col-sm-12 col-xs-12 form-group">
					            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenis-perangkat">Application</label>
					              <div class="col-md-6 col-sm-6 col-xs-12">
					                <select id="app" class="form-control" name="app_id" style="width:300px;">
					                  <option value="">Choose App</option>
					                  <?php foreach($apps as $app) :?>

					                  <option value="<?= $app['app_id'];?>"><?= $app['app_address'];?> (<?= $app['notes'];?>)</option>
					                  <?php endforeach;?>

					                </select>
					              </div>
					          </div>
					          <div class="col-md-12 col-sm-12 col-xs-12 form-group">
					            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenis-perangkat">Wifi</label>
					              <div class="col-md-6 col-sm-6 col-xs-12">
					                <select id="wifi" class="form-control" name="wifi_id" style="width:300px;">
					                  <option value="">Choose Wifi</option>
					                  <?php foreach($wifis as $wifi) :?>

					                  <option value="<?= $wifi['wifi_id'];?>"><?= $wifi['wifi_ssid'];?></option>
					                  <?php endforeach;?>

					                </select>
					              </div>
					          </div>
					          <div class="col-md-12 col-sm-12 col-xs-12 form-group">
					            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenis-perangkat">VM</label>
					              <div class="col-md-6 col-sm-6 col-xs-12">
					                <select id="vm" class="form-control" name="vm_id" style="width:300px;">
					                  <option value="">Choose VM</option>
					                  <?php foreach($vms as $vm) :?>

					                  <option value="<?= $vm['vm_id'];?>"><?= $vm['hostname'];?></option>
					                  <?php endforeach;?>

					                </select>
					              </div>
					          </div>
					        </div>
						</div>
				        <div class="modal-footer">
				            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				            <button type="submit" class="btn btn-primary" name="submit"></button>
				        </div>
				    	</form>
                	</div>
				</div>
            </div>