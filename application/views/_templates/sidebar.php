<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?= base_url('dashboard');?>" class="site_title">
                <i class="fa fa-hdd-o"></i>
                <span style="margin-left:45px;margin-top:-8px;position:absolute;letter-spacing:0.3em;"><?= $this->app['app_title_short'];?></span>
                <span style="margin-left:10px;margin-top:8px;position:absolute;"><small style="font-size:9px;"><?= $this->app['app_title'];?></small></span>
              </a>
            </div>

            <div class="clearfix"></div>
            <br/>
            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?= site_url('assets/wp-content/image/user/'.$this->user['user_picture']);?>" alt="<?= $this->user['user_name'];?>" class="img-circle profile_img" style="width:65px;height:65px;">
              </div>
              <div class="profile_info">
                <span><?= $this->user['user_name'];?></span>
                <h2><?= $this->user['user_group'];?></h2>
              </div>
              <div class="clearfix"></div>
            </div>
            <!-- /menu profile quick info -->

            <br />
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <?php foreach ($this->menu_group as $gm) :?>
              <div class="menu_section">
                  <h3><?= $gm['menu_group'];?></h3>

                  <?php
                  $menus = $this->sidebar_m->menus($gm['menu_group_id']);

                  foreach ($menus as $menu) :
                  ?>

                  <ul class="nav side-menu">
                    <?php if(empty($this->sidebar_m->submenus($menu['menu_id']))) :?>

                    <li>
                      <a href="<?= base_url($menu['menu_link']);?>">
                        <i class="<?= $menu['menu_icon'];?>"></i> <?= $menu['menu_label'];?>
                      </a>
                    </li>
                    <?php else: ?>

                    <li>
                      <a>
                        <i class="<?= $menu['menu_icon'];?>"></i> <?= $menu['menu_label'];?> <span class='fa fa-chevron-down'></span>
                      </a>
                        <ul class="nav child_menu">
                          <?php foreach($this->sidebar_m->submenus($menu['menu_id']) as $submenu) :?>

                          <li>
                            <a href="<?= base_url($submenu['menu_link']);?>">
                              <i class="<?= $submenu['menu_icon'];?>"></i> <?= $submenu['menu_label'];?>
                            </a>
                          </li>
                          <?php endforeach;?>
                        
                        </ul>
                    </li>
                    <?php endif; ?>
                  </ul>
                  <?php endforeach;?>
              
              </div>
              <?php endforeach;?>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings" href="<?= base_url('account-setting');?>">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Sign Out" href="<?= base_url('signout');?>">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>