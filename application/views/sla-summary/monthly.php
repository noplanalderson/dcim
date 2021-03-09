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
	                    <h2>Choose ISP</h2>
	                    <div class="clearfix"></div>
	                </div>
	                  	<div class="x_content">
	                  		<div class="row">
	                  			<div class="col-md-6 col-sm-12 col-xs-12">
				                    <?= form_open('', 'method="post" accept-charset="utf-8"');?>
				                    <select name="isp" class="form-control" required>
				                    	<option value="">Choose ISP</option>
				                    	<?php foreach ($isp_list as $isp) :?>
				                    
				                    	<option value="<?= $isp['slug'];?>" <?php if($isp['slug'] == $slug) :?> selected<?php endif;?>><?= $isp['isp_name'];?></option>
				                    	<?php endforeach;?>
				                    
				                    </select>
				                </div>
				                <div class="col-md-2 col-sm-6 col-xs-12">
				                    <select name="month" class="form-control" required="required">
				                    	<option value="">Choose Month</option>
				                    	<?php for ($i=1; $i <= 12; $i++) :?>
				                    	<option value="<?= sprintf("%02d", $i);?>" <?php if($i == date('m', $period)) :?> selected<?php endif;?>><?= $i;?></option>
				                    	<?php endfor;?>
				                    </select>
				                </div>
				                <div class="col-md-2 col-sm-6 col-xs-12">
				                    <select name="year" class="form-control" required="required">
				                    	<option value="">Choose Year</option>
				                    	<?php for ($i=2019; $i <= date('Y'); $i++) :?>
				                    	<option value="<?= $i;?>" <?php if($i == date('Y', $period)) :?> selected<?php endif;?>><?= $i;?></option>
				                    	<?php endfor;?>
				                    </select>
				                </div>
				                <div class="col-md-2 col-sm-6 col-xs-12">
				                    <button type="submit" class="btn btn-small btn-primary" name="submit">Submit</button>
				                </div>
		                	</form>
		                	</div>
						</div>
					</div>
				</div>
			</div>
            <div class="row">
            	<div class="col-md-12 col-sm-12 col-xs-12">
	                <div class="x_panel">
		                  <div class="x_content">
		                  <div id="<?= $slug;?>"></div>
	                  </div>
	                </div>
              	</div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                	<?php show_alert();?>
                	
                  <div class="x_title">
                    <h2>SLA <?= $title.' '.$month;?></h2>
                    <div class="clearfix"></div>
                  </div>
                  	<div class="x_content">
	                    <table id="sla_summary" class="table responsive table-striped table-bordered">
							<thead>
							<tr>
							  <th class="no-sort">Downtime</th>
							  <th class="no-sort">Uptime</th>
							  <th class="no-sort">Duration</th>
							  <th class="no-sort">Percentage</th>
							  <th class="no-sort">Cause</th>
							  <th class="no-sort">Solution</th>
							  <th class="no-sort">Aksi</th>
							</tr>
							</thead>
							<tbody>
								<?php foreach ($monthly as $mth) :?>
								<tr>
									<td><?= $mth['downtime'];?></td>
									<td><?= $mth['uptime'];?></td>
									<td><?= $mth['duration'];?> Minutes</td>
									<td><?= $mth['percentage'];?></td>
									<td><?= $mth['cause'];?></td>
									<td><?= $mth['solution'];?></td>
									<td>
										<a href="#" class="btn btn-xs update btn-warning" data-toggle="modal" data-target="#slaModal" data-id="<?= encrypt($mth['sla_id']);?>">
			                            	<i class="fa fa-pencil"></i>
			                            </a>
										<a href="<?= base_url('sla-summary/delete/'.encrypt($mth['sla_id']));?>" class="btn btn-xs btn-danger" onclick="return confirm('Yakin ingin Menghapus Data SLA?');">
			                            	<i class="fa fa-trash"></i>
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
	<!-- Modal -->
    <div class="modal fade bs-example-modal-lg" id="slaModal" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="judulModal"></h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          	<?= form_open('', 'method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"');?>

			<input type="hidden" id="sla_id" name="sla_id" value="">
			<div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="isp_id">ISP <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <select id="isp_id" class="form-control col-sm-7 col-xs-7" name="isp_id" required>
				    <option value="">Choose ISP..</option>
				    <?php foreach ($isp_list as $isp) :?>
				    <option value="<?= $isp['isp_id'];?>"><?= $isp['isp_name'];?></option>
				    <?php endforeach; ?>                        
				  </select>
				</div>
			</div>
			<div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="downtime">Downtime <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input id="downtime" type="text" name="downtime" class="form-control col-md-7 col-xs-12" required><i class="fa fa-calendar" style="position:absolute;margin-left:-20px;margin-top:10px;"></i>
				</div>
			</div>
			<div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="uptime">Uptime <span class="required">*</span> 
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input id="uptime" type="text" name="uptime" class="form-control col-md-7 col-xs-12" required><i class="fa fa-calendar" style="position:absolute;margin-left:-20px;margin-top:10px;"></i>
				</div>
			</div>
			<div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="cause">Cause <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <textarea id="cause" required="required" name="cause" class="form-control col-md-7 col-xs-12" data-parsley-length="[5, 100]"></textarea>
				</div>
			</div>
			<div class="item form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="solution">Solution 
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <textarea id="solution" name="solution" class="form-control col-md-7 col-xs-12" data-parsley-length="[0,100]"></textarea>
				</div>
			</div>
			<div class="item form-group">
				<div class="col-md-6 col-md-offset-3">
				  <small class="text-danger">* Jika Downtime di akhir bulan dan uptime di awal bulan, maka downtime akhir bulan diinput hingga pukul 23:59. Sisa downtime diinput pada bulan berikutnya.</small>
				</div>
			</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="submit"></button>
          </form>
          </div>
        </div>
      </div>
    </div>