<?php defined('BASEPATH') OR die('No Direct Script Access Allowed');?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <?php Alert::submitData();?>

                  <div class="x_title">
                    <h2>SLA Summary</h2>
                    <div class="clearfix"></div>
                  </div>
                  	<div class="x_content">
	                    <table id="sla" class="table responsive table-striped table-bordered">
							<thead>
							<tr>
							  <th>ID SLA</th>
							  <th>Bulan</th>
							  <th class="no-sort">Total Downtime</th>
							  <th class="no-sort">Persentase Downtime</th>
							  <th class="no-sort">Persentase Uptime</th>
							  <th class="no-sort">SLA Standar</th>
							  <th class="no-sort">Selisih</th>
							</tr>
							</thead>
							<tbody>
								<?php foreach ($data['sla'] as $sla) :?>
								<tr>
									<td><?= $sla['id_sla'];?></td>
									<td>
										<b><?= $sla['month'];?></b>
										<a class="btn btn-xs btn-success pull-right" href="<?= BASEURL;?>public/sla-summary/<?= strtolower(str_replace(" ", "-", $sla['nama_isp']));?>/<?= date('Y-m', strtotime($sla['month']));?>"><i class="fa fa-eye"></i></a>
									</td>
									<td><?= $sla['totalDown'];?> Menit</td>
									<td><?= $sla['percentage'];?></td>
									<td><?= round(100 + $sla['percentage'], 2);?></td>
									<td><?= $sla['sla_standar'];?></td>
									<td><?= round((100 - $sla['sla_standar']) + $sla['percentage'], 2);?></td>
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