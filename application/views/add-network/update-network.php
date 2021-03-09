<?php defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <?php Alert::submitData();?>

                  <div class="x_title">
                    <h2>Sunting IP Network</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form action="<?= BASEURL;?>public/service/doSunting/ip-network" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                      <?php Form_filter::anticsrf();?>

                      <input type="hidden" name="id" value="<?= Hashing::encrypt($data['service']['id_network']);?>">
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tipe_dan_grup">Tipe, Mask, Submask, dan Grup <span class="required">*</span></label>
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="tipe">
                          <select id="tipe" name="tipe" class="form-control col-sm-7 col-xs-7" required="required" type="text">
                            <option value="">Pilih Tipe..</option>
                            <option value="PUBLIC" <?php if($data['service']['tipe_network'] == 'PUBLIC') :?>selected <?php endif;?>>IP Publik</option>
                            <option value="PRIVATE" <?php if($data['service']['tipe_network'] == 'PRIVATE') :?>selected <?php endif;?>>IP Privat</option>
                          </select>
                        </label>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <select id="mask" onChange="ip()" class="form-control col-sm-2 col-xs-2" name="mask" style="margin-top:8px;" required>
                            <option value="">Mask..</option>
                            <?php 
                              $mask = explode("/", $data['service']['ip_network']);
                              for($i=24; $i<=30; $i++) { ?>
                            
                            <option value="<?= $i;?>" <?php if($mask[1] == $i) :?>selected<?php endif;?>> <?= $i;?> </option>
                            <?php } ?>

                          </select>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <select id="submask" class="form-control col-sm-2 col-xs-2" name="submask" style="margin-top:8px;" required>
                            <option value="">Submask..</option>
                            <?php for($i=24; $i<=30; $i++) { ?>

                            <option value="<?= $i;?>" <?php if($data['service']['submask'] == $i) :?>selected <?php endif; if($i < $data['service']['submask']) :?>disabled<?php endif;?>> <?= $i;?> </option>
                            <?php } ?>

                          </select>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <select class="form-control col-sm-7 col-xs-7" name="grup" style="margin-top:8px;" required>
                            <option value="">Pilih Grup..</option>
                            <?php foreach ($data['group'] as $grup) :?>

                            <option value="<?= $grup['id_grup'];?>" <?php if($data['service']['id_grup'] == $grup['id_grup']) :?>selected <?php endif;?>><?= $grup['grup_network'];?></option>
                            <?php endforeach;?>

                          </select>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="network">IP Network <span class="required">*</span></label>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <select id="1" class="form-control col-sm-1 col-xs-1" name="a" style="margin-top:8px;" required>
                            <option value="">--</option>
                            <?php 
                            $ip = explode(".", $mask[0]);
                            for($i=1; $i<=254; $i++) { ?>

                            <option value="<?= $i;?>" <?php if($ip[0] == $i) :?>selected<?php endif;?>> <?= $i;?> </option>
                            <?php } ?>

                          </select>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <select id="2" class="form-control col-sm-1 col-xs-1" name="b" style="margin-top:8px;" required>
                            <option value="">--</option>
                            <?php for($i=1; $i<=255; $i++) { ?>

                            <option value="<?= $i;?>" <?php if($ip[1] == $i) :?>selected<?php endif;?>> <?= $i;?> </option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <select id="3" class="form-control col-sm-1 col-xs-1" name="c" style="margin-top:8px;" required>
                            <option value="">--</option>
                            <?php for($i=1; $i<=255; $i++) { ?>

                            <option value="<?= $i;?>" <?php if($ip[2] == $i) :?>selected<?php endif;?>> <?= $i;?> </option>
                            <?php } ?>

                          </select>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                          <select id="4" class="form-control col-sm-1 col-xs-1" name="d" style="margin-top:8px;" required>
                            <option value="">--</option>
                            <?php 
                              $host = Utils::netPossible($mask[1]);
                              foreach ($host as $ip) :?>

                              <option value="<?= $ip;?>" <?php if($ip[3] == $ip) :?>selected<?php endif;?>><?= $ip;?></option>
                            <?php endforeach;?>

                          </select>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Label <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea required="required" name="label" class="form-control col-md-7 col-xs-12" data-parsley-length="[5, 100]"><?= $data['service']['label_network'];?></textarea>
                          <small style="color:#f00">PERHATIAN : Mengubah IP dan Netmask akan menghapus Sub-Network dan IP Address</small>
                        </div>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <div class="ln_solid"></div>
                        <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-10">
                          <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" name="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                    </form>
                    <br/>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->