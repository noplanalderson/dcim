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
                    <h2>User Management</h2>
                    <?= button($btn_add, 'button', '#', 'class="btn btn-md btn-primary add pull-right"', ' data-toggle="modal" data-target="#userModal"', true);?>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table responsive table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Username</th>
                          <th>Email</th>
                          <th>Level</th>
                          <th>Last Login</th>
                          <th>Status</th>
                          <th class="no-sort">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($users as $userlist) :?>
                        <tr>
                          <td><?= $userlist['user_name'];?></td>
                          <td><?= $userlist['user_email'];?></td>
                          <td><?= $userlist['user_group'];?></td>
                          <td><?= date('d F Y - H:i:s', $userlist['last_login']);?></td>
                          <td><?php if($userlist['user_status'] == 1) { echo "Active"; } else { echo "Not Active"; }?></td>
                          <td>
                            <?= button($btn_edit, 'a', '#', 'class="btn btn-md btn-warning update"', 'data-toggle="modal" data-target="#userModal" data-id="'.encrypt($userlist['user_id']).'"');?>

                            <?= button($btn_delete, 'a', base_url('user-management/delete/'.encrypt($userlist['user_id'])), 'class="btn btn-md btn-danger"', 'onclick="return confirm(\'Are You sure to delete user '.$userlist['user_name'].'?\');"');?>
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
        <div class="modal fade bs-example-modal-lg" id="userModal" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <?= form_open_multipart('', 'method="post" id="demo-form2" data-parsley-validate');?>
                      <input type="hidden" id="user_id" name="user_id" value="">
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label for="username" class="control-label col-md-3 col-sm-3 col-xs-12">Username</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input id="username" name="username" class="form-control" placeholder="Username" type="text" data-parsley-length="[5, 50]" required="">
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="email" id="email" name="email" class="form-control" placeholder="you@somewhere.com">
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="question">Security Question <span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <select id="question" class="form-control col-md-6 col-xs-12" name="question" required/>
                            <option value="">Choose Question..</option>
                            <?php foreach ($questions as $question) :?>

                            <option value="<?= $question['sec_question_id'];?>"><?= ucwords($question['sec_question']);?></option>
                            <?php endforeach;?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label for="answer" class="control-label col-md-3 col-sm-3 col-xs-12">Security Answer <span class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input id="answer" name="answer" class="form-control" placeholder="Security Answer" type="text" data-parsley-length="[5, 50]">
                        </div>
                      </div>
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">User Status <span class="required">*</span></label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <select id="status" name="status" class="form-control">
                        <option value="">Status..</option>
                        <option value="1">Active</option>
                        <option value="0">Not Active</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_group">User Group <span class="required">*</span></label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <select id="user_group" name="user_group" class="form-control">
                        <option value="">Choose Group..</option>
                        <?php foreach ($user_groups as $ug) :?>

                        <option value="<?= $ug['user_group_id'];?>"><?= $ug['user_group'];?></option>
                        <?php endforeach;?>

                      </select>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                    <label for="picture" class="control-label col-md-3 col-sm-3 col-xs-12">Profil Picture </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <input type="hidden" id="old_picture" name="old_picture" value="">
                      <input type="file" name="picture" class="form-control col-md-4 col-xs-12">
                      <small class="text-danger">Picture size max. 3 MB in JPG, JPEG, or PNG  format.</small>
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