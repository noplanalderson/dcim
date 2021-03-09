<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="detail" class="x_panel">
                  
                  <div class="x_title">
                    <h2>
                    	SPECIFICATION <?= strtoupper($device['group_label'].' '.$device['hostname']);?>
                    </h2>
                    <button type="button" class="btn btn-success pull-right" title="Print" onclick="printContent()"><i class="fa fa-print"></i> Print</button>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content responsive">
                    <table id="tab_detail" class="table responsive table-striped table-bordered">
                      <tr align="center">
                      	<td colspan="2"><h3>SPECIFICATION <?= strtoupper($device['group_label'].' '.$device['hostname']);?></h3></td>
                      </tr>
                      <tr>
                        <td width="30%">Device Code</td>
                        <td><?= $device['group_code'].$device['device_code'];?></td>
                      </tr>
                      <tr>
                      	<td width="30%">Hostname</td>
                      	<td><?= $device['hostname'];?></td>
                      </tr>
                      <tr>
                      	<td>Serial Number</td>
                      	<td><?= $device['serial_number'];?></td>
                      </tr>
                      <tr>
                      	<td>Manufacture & Model</td>
                      	<td><?= $device['dev_manufacture'].'<br/>'.$device['dev_model'];?></td>
                      </tr>
                      <tr>
                      	<td>Processor</td>
                      	<td><?= $device['processor_type'];?><br/>Core : <?= $device['cores'];?></td>
                      </tr>
                      <tr>
                      	<td>Memory</td>
                      	<td>
                          <?php
                          $model= explode(',',$device['memory_model']);
                          $cap  = explode(',',$device['memory_cap']);
                          
                          $count_model= count($model);

                          for ($i=0; $i < $count_model; $i++) { 
                            echo $model[$i].' '.$cap[$i].' GB<br/>';
                          }
                          ?>
                        </td>
                      </tr>
                      <tr>
                      	<td>Harddisk</td>
                      	<td>
                          <?php
                          $model= explode(',',$device['hdd_model']);
                          $cap  = explode(',',$device['hdd_cap']);
                          
                          $count_model= count($model);

                          for ($i=0; $i < $count_model; $i++) { 
                            echo $model[$i].' '.$cap[$i].' GB<br/>';
                          }
                          ?>
                        </td>
                      </tr>
                      <tr>
                      	<td>Ports</td>
                      	<td>
                          Ethernet : <?= $device['eth_port'];?><br/>
                          USB : <?= $device['usb_port'];?><br/>
                          Console : <?= $device['console_port'];?>
                        </td>
                      </tr>
                      <tr>
                      	<td>Operating System</td>
                      	<td><?= $device['operating_system'];?><br/><?= $device['os_architecture'];?></td>
                      </tr>
                      <tr>
                      	<td>Device Location</td>
                      	<td><?= $device['device_location'];?><br/>Rak : <?= $device['rack_number'];?></td>
                      </tr>
                      <tr>
                      	<td>Procurement</td>
                      	<td><?= $device['procurement'];?></td>
                      </tr>
                      <tr>
                        <td>Device Owner</td>
                        <td><?= $device['device_owner'];?></td>
                      </tr>
                      <tr>
                      	<td>Device Status</td>
                      	<td><?= $device['device_status'];?></td>
                      </tr>
                      <tr>
                      	<td>Device Picture</td>
                      	<td><img src="<?= encodeImage('./assets/wp-content/image/'.$device['device_picture']);?>" alt="<?= $device['hostname'];?>" width="250px" height="250px"></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->