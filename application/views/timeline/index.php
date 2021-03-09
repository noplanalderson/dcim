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
                    <h2>Timeline <?= $device['group_label'].' '.$device['hostname'];?> </h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content responsive">
                    <div class="timeline">
                      <div class="timeline__wrap">
                        <div class="timeline__items">
                        <?php foreach($timelines as $row): ?>

                          <div class="timeline__item">
                            <div class="timeline__content">
                              <h1><?= date('d F Y', strtotime($row['installation_date']));?></h1>
                              <h4>Device Identity : <?= $row["hostname"]; ?></h4>
                              <h4>Device Code : <?= $row['group_code'].$row["device_code"];?></h4>
                              <h4>Installation Location : <?= $row["installation_location"];?></h4>
                              <h4>Status <?= $row["status"];?></h4>
                            </div>
                          </div>
                        <?php endforeach; ?>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->