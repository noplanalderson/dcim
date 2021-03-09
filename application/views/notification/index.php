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
                    <h2>Notifications</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="n" class="table responsive table-striped table-bordered">
                      <thead>
                        <tr>
                          <th class="no-sort">Date</th>
                          <th class="no-sort">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php foreach ($all as $notif) :?>

                        <tr>
                          <td><?= $notif['date_act'].' '.$notif['hour'];?></td>
                          <td><?= $notif['action'];?></td>
                        </tr>
                      <?php endforeach; ?>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>