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
				                    <select name="isp" class="form-control" required="required">
				                    	<option value="">Choose ISP</option>
				                    	<?php foreach ($isps as $isp) :?>
				                    
				                    	<option value="<?= $isp['slug'];?>"><?= $isp['isp_name'];?></option>
				                    	<?php endforeach;?>
				                    
				                    </select>
				                </div>
				                <div class="col-md-2 col-sm-6 col-xs-12">
				                    <select name="month" class="form-control" required="required">
				                    	<option value="">Choose Month</option>
				                    	<?php for ($i=1; $i <= 12; $i++) :?>
				                    	<option value="<?= sprintf("%02d", $i);?>"><?= $i;?></option>
				                    	<?php endfor;?>
				                    </select>
				                </div>
				                <div class="col-md-2 col-sm-6 col-xs-12">
				                    <select name="year" class="form-control" required="required">
				                    	<option value="">Choose Year</option>
				                    	<?php for ($i=2019; $i <= date('Y'); $i++) :?>
				                    	<option value="<?= $i;?>"><?= $i;?></option>
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
		</div>
	</div>
	<!-- /page content -->