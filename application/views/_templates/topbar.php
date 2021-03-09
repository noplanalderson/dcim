<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <div class="row nav">
                <div class="col-md-9 col-sm-9 col-xs-6" style="margin-top:1.2rem;margin-left:-3rem;">
		    <?php if(!empty($searchable)) {?>
                    <?= form_open('search', 'method="post" accept-charset="utf-8"');?>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback responsive">
                      <input id="search" name="q" type="text" class="form-control" style="border-radius:5px;z-index:100;" placeholder="Global Search..." required>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
                      <select class="form-control" name="type" required style="border-radius:5px;z-index:100;" onchange="this.form.submit()">
                        <option value="">Choose Type</option>
                        <option value="hardware">Hardware</option>
                        <option value="device">Device</option>
                        <option value="apps">Application</option>
                        <option value="wifi">Wifi</option>
                        <option value="network">Network</option>
                      </select>
                    </div>
                  </form>
		  <?php } ?>
                </div>
              </div>
              <ul class="nav navbar-nav navbar-right" style="margin-top:-5rem;">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?= site_url('assets/wp-content/image/user/'.$this->user['user_picture']);?>" alt="<?= $this->user['user_name'];?>">
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li>
                      <a href="<?= base_url('account-setting');?>">
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="<?= base_url('signout');?>"><i class="fa fa-sign-out pull-right"></i> Sign Out</a></li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown" style="margin-top:0.5rem;">
                  <a href="javascript:;" class="dropdown-toggle notif info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    <div class="count-notif">
                      <span id="count-notif" class="badge bg-green"><?= $this->count_notif;?></span>
                    </div>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <?php foreach ($this->notif as $notif) :?>
                    <li>
                      <span class="message">
                        <?= $notif['action'];?>
                        <br/>
                        <b class="pull-right"><?= $notif['date_act'].' - '.$notif['hour'];?></b>
                      </span>
                    </li>
                    <?php endforeach;?>
                    <li>
                      <div class="text-center">
                        <a href="<?= base_url('notification');?>">
                          <strong>All Notifications</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->