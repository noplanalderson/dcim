<?php defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="detail" class="x_panel">

                  <div class="x_title">
                    <h2>
                    	HARDWARE DETAILS
                    </h2>
                    <button type="button" class="btn btn-success pull-right" title="Print" onclick="printContent()"><i class="fa fa-print"></i> Print</button>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content responsive">
                    <table id="tab_detail" class="table responsive table-striped table-bordered">
                      <tr align="center">
                      	<td colspan="2"><h4>SPECIFICATION OF <?= strtoupper($hardware['hw_category'].' '.$hardware['hw_manufacture'].' '.$hardware['hw_model']);?></h4></td>
                      </tr>
                      <tr>
                        <td width="30%">Hardware Code</td>
                        <td><?= $hardware['category_code'].$hardware['hw_code'];?></td>
                      </tr>
                      <tr>
                      	<td width="30%">Manufacture</td>
                      	<td><?= $hardware['hw_manufacture'];?></td>
                      </tr>
                      <tr>
                      	<td>Model</td>
                      	<td><?= $hardware['hw_model'];?></td>
                      </tr>
                      <tr>
                      	<td>Capacity</td>
                      	<td><?= $hardware['capacity'].' '.$hardware['capacity_unit'];?></td>
                      </tr>
                      <tr>
                      	<td>Quantity</td>
                      	<td><?= $hardware['hw_quantity'];?> Unit</td>
                      </tr>
                      <tr>
                        <td>Procurement</td>
                        <td><?= $hardware['procurement'];?></td>
                      </tr>
                      <tr>
                      	<td>Note</td>
                      	<td><?= $hardware['notes'];?></td>
                      </tr>
                      <tr>
                      	<td>Status</td>
                      	<td><?= $hardware['hw_status'];?></td>
                      </tr>
                      <tr>
                      	<td>Hardware Picture</td>
                      	<td><img src="<?= encodeImage('./assets/wp-content/image/'.$hardware['hw_picture']);?>" alt="<?= $hardware['hw_code'];?>" width="250px" height="250px"></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->