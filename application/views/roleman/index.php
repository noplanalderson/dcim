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
                    <h2>Role Management</h2>
                    <?= button($btn_add, 'button', '#', 'class="btn btn-md btn-primary add pull-right"', ' data-toggle="modal" data-target="#roleModal"', true);?>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table responsive table-striped table-bordered">
                      <thead>
                        <tr>
                          <th width="150px">Group Name</th>
                          <th>Roles</th>
                          <th class="no-sort" width="80px">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($user_groups as $ug) :?>
                        <tr>
                          <td><?= $ug['user_group'];?></td>
                          <td><?= $this->role_m->get_roles_by_ug($ug['user_group_id']);?></td>
                          <td>
                            <?= button($btn_edit, 'a', '#', 'class="btn btn-xs btn-warning update"', ' data-toggle="modal" data-target="#roleModal" data-id="'.encrypt($ug['user_group_id']).'"');?>

                            <?= button($btn_delete, 'a', base_url('role-management/delete/'.encrypt($ug['user_group_id'])), 'class="btn btn-xs btn-danger"', 'onclick="return confirm(\'Are You sure to delete User Group '.$ug['user_group'].'?\');"');?>

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
        <div class="modal fade bs-example-modal-lg" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <?= form_open('', 'method="post" id="demo-form2" data-parsley-validate');?>
                  <input type="hidden" id="id" name="id" value="">
                  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                    <label for="user_group" class="control-label col-md-2 col-sm-2 col-xs-12">Group Name *</label>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                      <input id="user_group" name="user_group" class="form-control" placeholder="Group Name" type="text" pattern="^[a-zA-Z ]{5,50}$" required="">
                    </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                    <label for="user_group" class="control-label col-md-2 col-sm-2 col-xs-12">Group Name *</label>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                      <select id="roles" name="roles[]" class="form-control select2-no-search" style="width:100%;" multiple="multiple" required />
                        <?php foreach ($menus as $menu) :?>
                        <option value="<?= $menu['menu_id'];?>"><?= $menu['menu_label'];?></option>
                        <?php endforeach;?>
                      </select>
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