<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Edit Utilities</h3><br/>
              </div>
            </div>
            <div class="clearfix"></div>
            <?php show_alert();?>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <?= $form; ?>
              </div>
            </div>
          </div>
        </div>