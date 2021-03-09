<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <?php show_alert();?>

                  <div class="x_title">
                    <h2>ISP Setting</h2>
                    <?= button($btn_add, 'button', '#', 'class="btn btn-md btn-primary add pull-right"', 'data-toggle="modal" data-target="#ispModal"', true);?>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table responsive table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>ISP name</th>
                          <th>SLA Standard</th>
                          <th class="no-sort">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($isps as $isp) :?>
                        <tr>
                          <td><?= $isp['isp_name'];?></td>
                          <td><?= $isp['sla_standard'];?></td>
                          <td>
                            <?= button($btn_edit, 'a', '#', 'class="btn btn-xs btn-warning update"', 'data-toggle="modal" data-target="#ispModal" data-id="'.encrypt($isp['isp_id']).'"');?>

                            <?= button($btn_delete, 'a', base_url('isp-setting/delete/'.encrypt($isp['isp_id'])), 'class="btn btn-xs btn-danger"', 'onclick="return confirm(\'Are you sure to deleting ISP '.$isp['isp_name'].'?\');"');?>
                              
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
        <div class="modal fade bs-example-modal-lg" id="ispModal" tabindex="-1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title" id="modal-title"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <?= form_open('', 'method="post" id="demo-form2" data-parsley-validate');?>
                <div class="form-group">
                  <label for="isp_name">ISP Name</label>
                  <input type="hidden" name="isp_id" id="isp_id">
                  <input type="text" name="isp_name" class="form-control" id="isp_name" aria-describedby="isp_help" placeholder="ISP Name">
                </div>
                <div class="form-group">
                  <label for="sla_standard">SLA Standard</label>
                  <input id="sla_standard" name="sla_standard" class="form-control" type="text" placeholder="0" min="1" max="100" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-pattern="^[0-9]*\.[0-9]{2}$" title="Must Numeric">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
              </form>
              </div>
            </div>
          </div>
        </div>