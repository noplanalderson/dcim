<?php defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="row top_tiles">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <?php 
		if(!empty($device_bg))
		{
		foreach ($total_dev as $total):?>
		
		<a href="<?= base_url('devices/group/'.strtolower(str_replace(" ", "-", $total['group_label'])));?>">
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="z-index:1;">
                  <div class="tile-stats">
                    <div class="icon"><i class="<?= $total['group_icon'];?>"></i></div>
                    <div class="count"><?= $total['total_device'];?></div>
                    <h3><?= ucwords(strtolower($total['group_label']));?></h3>
                  </div>
                </div>
		</a>
                <?php endforeach; } ?>

		<?php 
		if(!empty($hardware_bg))
		{
		foreach ($hardware as $hw):?>
		
		<a href="<?= base_url('hardwares/group/'.strtolower(str_replace(" ", "-", $hw['hw_category'])));?>">
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="z-index:1;">
                  <div class="tile-stats">
                    <div class="icon"><i class="<?= $hw['hw_icon'];?>"></i></div>
                    <div class="count"><?= $hw['total_hw'];?></div>
                    <h3><?= ucwords(strtolower($hw['hw_category']));?></h3>
                  </div>
                </div>
		</a>
                <?php endforeach; } ?>
		
		<?php if(!empty($app_bg)) :?>
		<a href="<?= base_url('services/apps');?>">
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="z-index:1;">
                  <div class="tile-stats">
                    <div class="icon"><i class="fa fa-android"></i></div>
                    <div class="count"><?= $app;?></div>
                    <h3>Application</h3>
                  </div>
                </div>
		</a>
		<?php endif; ?>

		<?php if(!empty($wifi_bg)) :?>
		<a href="<?= base_url('services/wifi');?>">
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="z-index:1;">
                  <div class="tile-stats">
                    <div class="icon"><i class="fa fa-wifi"></i></div>
                    <div class="count"><?= $wifi;?></div>
                    <h3>Wifi</h3>
                  </div>
                </div>
		</a>
		<?php endif; ?>
		
		<?php if(!empty($vm_bg)) :?>
		<a href="<?= base_url('services/vms');?>">
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="z-index:1;">
                  <div class="tile-stats">
                    <div class="icon"><i class="fa fa-sitemap"></i></div>
                    <div class="count"><?= $vm;?></div>
                    <h3>VM</h3>
                  </div>
                </div>
    		</a>
		<?php endif;?>

		<?php if(!empty($network_bg)) :?>
    		<a href="<?= base_url('services/networks');?>">
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="z-index:1;">
                  <div class="tile-stats">
                    <div class="icon"><i class="fa fa-code-fork"></i></div>
                    <div class="count"><?= $net;?></div>
                    <h3>Network Blocks</h3>
                  </div>
                </div>
		</a>
		<?php endif;?>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_content">
                      <div class="col-md-4 col-sm-12 col-xs-12">
                        <div id="device_graph"></div>
                      </div>
                      <div class="col-md-4 col-sm-12 col-xs-12">
                        <div id="service_graph"></div>
                      </div>
                      <div class="col-md-4 col-sm-12 col-xs-12">
                        <div id="hardware_graph"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

            <div id="reportPage">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Total ISP Downtime </h2>
                    <button class="btn btn-md btn-success pull-right" id="download-pdf">
                      <i class="fa fa-download"></i> Export
                    </button>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" style="height: 300px">
                    <canvas id="slaSummary"></canvas>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title"><h4>Device & Hardware Logs</h4></div>
                    <div class="x_content">
                      <table class="table responsive table-striped table-bordered">
                        <thead>
                          <tr>
                            <th>Action Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($log_device)):
                        foreach ($log_device as $device) :?>

                          <tr>
                            <td><?= $device['date_act'];?> at <?= $device['hour'];?></td>
                            <td><?= $device['action'];?></td>
                          </tr>
                        <?php endforeach; else: ?>
                          <tr>
                            <td class="text-center" colspan="2">No Action Log</td>
                          </tr>
                        <?php endif;?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="x_panel">
                    <div class="x_title"><h4>SLA Log</h4></div>
                    <div class="x_content">
                      <table class="table responsive table-striped table-bordered">
                        <thead>
                          <tr>
                            <th>Action Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($log_sla)):
                        foreach ($log_sla as $sla) :?>

                          <tr>
                            <td><?= $device['date_act'];?> at <?= $device['hour'];?></td>
                            <td><?= $sla['action'];?></td>
                          </tr>
                        <?php endforeach; else: ?>
                          <tr>
                            <td class="text-center" colspan="2">No SLA Log</td>
                          </tr>
                        <?php endif;?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->