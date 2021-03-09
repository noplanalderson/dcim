<?php defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Search Result : <?= ucwords($search);?></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="s" class="table responsive table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Block Network</th>
                          <th class="no-sort">Network Type</th>
                          <th class="no-sort">Network Label</th>
                          <th class="no-sort">Used</th>
                          <th class="no-sort">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($networks as $network) :?>
                        <tr>
                          <td><?= $network['network_block'];?></td>
                          <td><?= $network['network_type'];?></td>
                          <td><?= $network['network_label'];?></td>
                          <td>
                            <?=
                              $this->service_m->used_ip($network['network_type'], $network['network_id']).'/'.
                              $this->service_m->allocated_ip($network['network_type'], $network['network_id']);
                            ?>
                          </td>
                          <td>
                            <a href="<?= base_url('services/subnet/'.$network['network_type'].'/'.encrypt($network['network_id']));?>" class="btn btn-xs btn-success pull-right"><i class="fa fa-list"></i></a>
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