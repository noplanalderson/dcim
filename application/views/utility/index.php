<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            
            <?= button($btn_add, 'a', base_url($btn_add['menu_link']), 'class="btn btn-md btn-primary pull-right"', NULL, true);?>

            <br/>
            <div class="page-title">
              <div class="title_left">
                <h3>Data Utility</h3><br/>
              </div>
            </div>

            <div class="clearfix"></div>
            <?php show_alert();?>

            <div class="row">
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Device Group</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" style="max-height:500px;overflow-y:scroll;font-size:10px;">
                    <table class="table responsive table-striped table-bordered">
                      <thead>
                        <tr>
                          <th width="120px">Group Code</td>
                          <th>Group Name</th>
                          <th>Group Icon</th>
                          <th class="no-sort" width="80px">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        if(!empty($dev_groups)) :
                        foreach ($dev_groups as $device) :?>
                        <tr>
                          <td><?= $device['group_code'];?></td>
                          <td><?= $device['group_label'];?></td>
                          <td><i class="<?= $device['group_icon'];?>"></i></td>
                          <td>
                            <?php if($device['group_code'] !== 'UC') :?>
                            <?= button($btn_edit, 'a', base_url('utilities/edit/dev-group/'.encrypt($device['group_id'])), 'class="btn btn-xs btn-warning"');?>
                            <?= button($btn_delete, 'a', base_url('utilities/delete/dev-group/'.encrypt($device['group_id'])), 'class="btn btn-xs btn-danger"', 'onclick="return confirm(\'Are You sure to deleting '.$device['group_label'].'?\');"');?>
                            <?php else :?>
                            <a class="btn btn-xs btn-danger" disabled>
                              <i class="fa fa-trash"></i> 
                            </a>
                            <?php endif;?>
                          </td>
                        </tr>
                        <?php endforeach; else :?>
                        <tr>
                          <td colspan="4" class="text-center">No Device Group</td>
                        </tr>
                        <?php endif;?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Hardware Group</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" style="max-height:500px;overflow-y:scroll;font-size:10px;">
                    <table class="table responsive table-striped table-bordered">
                      <thead>
                        <tr>
                          <th width="120px">Group Code</td>
                          <th>Group Name</th>
                          <th>Group Icon</th>
                          <th class="no-sort" width="80px">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if(!empty($hw_groups)) :
                        foreach ($hw_groups as $hardware) :?>
                        <tr>
                          <td><?= $hardware['hw_code'];?></td>
                          <td><?= $hardware['hw_category'];?></td>
                          <td><i class="<?= $hardware['hw_icon'];?>"></i></td>
                          <td>
                            <?php if($hardware['hw_code'] !== 'UC') :?>
                              <?= button($btn_edit, 'a', base_url('utilities/edit/hw-group/'.encrypt($hardware['hw_category_id'])), 'class="btn btn-xs btn-warning"');?>
                            <?= button($btn_delete, 'a', base_url('utilities/delete/hw-group/'.encrypt($hardware['hw_category_id'])), 'class="btn btn-xs btn-danger"', 'onclick="return confirm(\'Are You sure to deleting '.$hardware['hw_category'].'?\');"');?>
                            <?php else :?>
                            <a class="btn btn-xs btn-danger" disabled>
                              <i class="fa fa-trash"></i> 
                            </a>
                            <?php endif;?>
                          </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                          <td colspan="4" class="text-center">No Hardware Group</td>
                        </tr>
                        <?php endif;?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Device Manufacture</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" style="max-height:500px;overflow-y:scroll;font-size:10px;">
                    <table class="table responsive table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Manufacture Code</th>
                          <th>Device Group</th>
                          <th>Manufacture</th>
                          <th class="no-sort" width="80px">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if(!empty($manufactures)) :
                        foreach ($manufactures as $manufacture) :?>
                        <tr>
                          <td width="120px"><?= sprintf("%02d", $manufacture['dev_manufacture_id']);?></td>
                          <td><?= $manufacture['group_label'];?></td>
                          <td><?= $manufacture['dev_manufacture'];?></td>
                          <td>
                            <?php if($manufacture['dev_manufacture_id'] !== '1') :?>
                            <?= button($btn_edit, 'a', base_url('utilities/edit/manufacture/'.encrypt($manufacture['dev_manufacture_id'])), 'class="btn btn-xs btn-warning"');?>
                            <?= button($btn_delete, 'a', base_url('utilities/delete/manufacture/'.encrypt($manufacture['dev_manufacture_id'])), 'class="btn btn-xs btn-danger"', 'onclick="return confirm(\'Are You sure to deleting '.$manufacture['dev_manufacture'].'?\');"');?>
                            <?php else :?>
                            <a class="btn btn-xs btn-danger" disabled>
                              <i class="fa fa-trash"></i> 
                            </a>
                            <?php endif;?>
                          </td>
                        </tr>
                        <?php endforeach; else :?>
                        <tr>
                          <td colspan="4" class="text-center">No Device Manufacture</td>
                        </tr>
                        <?php endif;?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Hardware Manufacture</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" style="max-height:500px;overflow-y:scroll;font-size:10px;">
                    <table class="table responsive table-striped table-bordered">
                      <thead>
                        <tr>
                          <th width="120px">Manufacture Code</th>
                          <th>Hardware Group</th>
                          <th>Hardware Manufacture</th>
                          <th class="no-sort" width="80px">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if(!empty($hw_manufactures)) :
                        foreach ($hw_manufactures as $manuhw) :?>
                        <tr>
                          <td><?= sprintf("%02d", $manuhw['hw_manufacture_id']);?></td>
                          <td><?= $manuhw['hw_category'];?></td>
                          <td><?= $manuhw['hw_manufacture'];?></td>
                          <td>
                            <?php if($manuhw['hw_manufacture_id'] !== '1') :?>
                            <?= button($btn_edit, 'a', base_url('utilities/edit/hw-manufacture/'.encrypt($manuhw['hw_manufacture_id'])), 'class="btn btn-xs btn-warning"');?>
                            <?= button($btn_delete, 'a', base_url('utilities/delete/hw-manufacture/'.encrypt($manuhw['hw_manufacture_id'])), 'class="btn btn-xs btn-danger"', 'onclick="return confirm(\'Are You sure to deleting '.$manuhw['hw_manufacture'].'?\');"');?>
                            <?php else :?>
                            <a class="btn btn-xs btn-danger" disabled>
                              <i class="fa fa-trash"></i> 
                            </a>
                            <?php endif;?>
                          </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                          <td colspan="4" class="text-center">No Hardware Manufacture</td>
                        </tr>
                        <?php endif;?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Device Model</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" style="max-height:500px;overflow-y:scroll;font-size:10px;">
                    <table class="table responsive table-striped table-bordered">
                      <thead>
                        <tr>
                          <th width="120px">Model Code</th>
                          <th>Model Name</th>
                          <th>Manufacture</th>
                          <th class="no-sort" width="80px">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if(!empty($dev_models)):
                        foreach ($dev_models as $model) :?>
                        <tr>
                          <td><?= sprintf("%03d", $model['dev_model_id']);?></td>
                          <td><?= $model['dev_model'];?></td>
                          <td><?= $model['dev_manufacture'];?></td>
                          <td>
                            <?php if($model['dev_model_id'] !== '1') :?>
                            <?= button($btn_edit, 'a', base_url('utilities/edit/dev-model/'.encrypt($model['dev_model_id'])), 'class="btn btn-xs btn-warning"');?>
                            <?= button($btn_delete, 'a', base_url('utilities/delete/dev-model/'.encrypt($model['dev_model_id'])), 'class="btn btn-xs btn-danger"', 'onclick="return confirm(\'Are You sure to deleting '.$model['dev_model'].'?\');"');?>
                            <?php else :?>
                            <a class="btn btn-xs btn-danger" disabled>
                              <i class="fa fa-trash"></i> 
                            </a>
                            <?php endif;?>
                          </td>
                        </tr>
                        <?php endforeach; else : ?>
                        <tr>
                          <td colspan="4" class="text-center">No Device Model</td>
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
        <!-- /page content -->