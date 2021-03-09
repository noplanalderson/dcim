<?php defined('BASEPATH') OR die('No Direct Script Access Allowed');?>
        <!-- Modal -->
        <div class="modal fade bs-example-modal-lg" id="deviceModal" style="overflow:hidden;" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title" id="judulModal"></h3>
                <button type="button" class="close" style="margin-top:-3rem;" data-dismiss="modal" aria-label="Close">
                  <i class="fa fa-close"></i>
                </button>
              </div>
              <div class="modal-body">
                  <form action="<?= BASEURL;?>public/device/sunting" method="post" id="demo-form2" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
                        <?php Form_filter::anticsrf();?>
                        
                        <input id="kode" type="hidden" name="id" value="">
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenis-perangkat">Kategori <span class="required">*</span></label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                  <select id="jenis-perangkat" class="form-control" name="kategori" required />
                                    <option value="">Pilih Kategori Perangkat..</option>
                                    <?php foreach ($data['kategori-list'] as $kategori) :?>
                                    <option value="<?= $kategori['id_kategori_device'];?>"><?= $kategori['kategori_device'];?></option>
                                    <?php endforeach;?>
                                  </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="manufaktur">Manufaktur <span class="required">*</span></label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <select id="manufaktur" class="form-control manufaktur col-md-12 col-xs-12" name="manufaktur" required/>
                                  <option value="">Pilih Manufaktur..</option>
                                  <?php foreach ($data['kategori-list'] as $kategori) :?>
                                  <optgroup label='<?= ucwords($kategori['kategori_device']);?>'>
                                    <?php 
                                      $manufaktur = $this->model('Input_dev_m')->getManufaktur($kategori['id_kategori_device']);
                                      foreach ($manufaktur as $manu) :
                                    ?>
                                    <option value="<?= $manu['id_manufaktur'];?>"><?= ucwords($manu['manufaktur']);?></option>
                                    <?php endforeach;?>
                                  <?php endforeach;?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="tipe-perangkat" class="control-label col-md-3 col-sm-3 col-xs-12">Tipe Perangkat <span class="required">*</span></label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="radio" class="flat" name="tipe" value="VIRTUAL" required /> Virtual
                                <input type="radio" class="flat" name="tipe" value="FISIK" /> Fisik
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="hypervsor" class="control-label col-md-3 col-sm-3 col-xs-12">Guest of</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <select id="hypervsor" class="form-control hypervsor col-md-6 col-xs-12" name="hypervsor" />
                                  <option value="">Pilih Hypervsor..</option>
                                  <?php foreach ($data['hypervsor'] as $hypervsor) :?>
                                  <option value="<?= $hypervsor['hostname'];?>"><?= $hypervsor['hostname'];?></option>
                                  <?php endforeach;?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="model" class="control-label col-md-3 col-sm-3 col-xs-12">Model <span class="required">*</span></label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <select id="model" class="form-control model col-md-6 col-xs-12" name="model" required/>
                                  <option value="">Pilih Model..</option>
                                  <?php foreach ($data['manufaktur'] as $manu) :?>
                                  <optgroup label='<?= ucwords($manu['manufaktur']);?>'>
                                    <?php 
                                      $models = $this->model('Input_dev_m')->getModel($manu['id_manufaktur']);
                                      foreach ($models as $model) :
                                    ?>
                                    <option value="<?= $model['id_model'];?>"><?= ucwords($model['model']);?></option>
                                    <?php endforeach;?>
                                  <?php endforeach;?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="processor" class="control-label col-md-3 col-sm-3 col-xs-12">Processor</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="processor" name="prosesor" class="form-control" placeholder="Processor" type="text" data-parsley-length="[5, 50]">
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="cores" class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Core</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="cores" name="core" class="form-control" type="text" placeholder="0" min="1" max="128" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-type="digits" title="Harus Angka">
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ram_model">Model RAM </label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="ram_model" type="text" class="tags model-hw form-control" name="ram-model" data-role="tagsinput">
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="ram" class="control-label col-md-3 col-sm-3 col-xs-12">Kapasitas (GB)</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="ram" name="ram" class="size-hw form-control col-md-6 col-xs-6" type="text" placeholder="0" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-pattern="^[0-9,]+$" title="Harus Angka" data-role="tagsinput">
                                <small>Input Size sesuai urutan Model RAM</small>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="hdd_model">Model Harddisk </label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="hdd_model" type="text" class="tags model-hw form-control" name="hdd-model" data-role="tagsinput">
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="hdd" class="control-label col-md-3 col-sm-3 col-xs-12">Kapasitas (GB)</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="hdd" name="hdd" class="form-control size-hw" type="text" placeholder="0" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-pattern="^[0-9,]+$" title="Harus Angka" data-role="tagsinput">
                                <small>Input Size sesuai urutan Model Harddisk</small>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="nic" class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Port </label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="nic" name="nic" class=" form-control col-md-6 col-xs-6" type="text" placeholder="0" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-type="digits" data-parsley-length="[1,2]" title="Harus Angka" />
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="usb" class="control-label col-md-3 col-sm-3 col-xs-12">USB</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="usb" name="usb" class="form-control" type="text" placeholder="0" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-type="digits" data-parsley-length="[1,2]" title="Harus Angka">
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="hostname" class="control-label col-md-3 col-sm-3 col-xs-12">Nama Host </label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="hostname" class="form-control" type="text" name="hostname" placeholder="default:localhost" data-parsley-pattern="^[A-Za-z0-9@\-\_]+$" data-parsley-length="[5,50]" title="Harus Huruf, Angka, @ dan Dash"/>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="serial-number" class="control-label col-md-33 col-sm-3 col-xs-12">Serial Number <span class="required"> *</span></label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="serial-number" name="serial-number" class=" form-control col-md-6 col-xs-6"  placeholder="Serial Number" type="text" data-parsley-pattern="^[A-Za-z0-9/-]+$" data-parsley-length="[5, 50]" title="Harus Huruf, Angka, Slash, dan Dash" required />
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="os" class="control-label col-md-3 col-sm-3 col-xs-12">Sistem Operasi</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="os" class=" form-control col-md-6 col-xs-6" type="text" name="os" placeholder="Sistem Operasi" data-parsley-pattern="^[a-zA-Z0-9\s-.]+$" data-parsley-length="[3, 50]" title="Harus Huruf, Angka, dan Spasi"/>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Arsitektur OS</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="os-arch" class="form-control col-md-6 col-xs-6" name="os_arch" type="text" placeholder="Arsitektur OS" data-parsley-length="[3, 50]">
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="lokasi" class="control-label col-md-3 col-sm-3 col-xs-12">Lokasi <span class="required">*</span></label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="lokasi" name="lokasi" class="form-control" type="text" placeholder="Lokasi Perangkat" data-parsley-pattern="^[a-zA-Z0-9\s]+$" data-parsley-length="[3, 50]" title="Harus Huruf, Angka, dan Spasi" required />
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="rak" class="control-label col-md-3 col-sm-3 col-xs-12">Nomor Rak</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="rak" name="rak" class="form-control col-md-6 col-xs-6" type="text" placeholder="0" min="0" max="100" data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-type="digits" title="Harus Angka">
                                <small>Isi 0 Jika di luar Rak</small>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun Pengadaan <span class="required">*</span></label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <select id="tahun" class="form-control col-md-6 col-xs-6" name="tahun" required/>
                                  <option value="">Pilih Tahun..</option>
                                    <?php
                                      for($i=2002; $i<=2002+48; $i+=1){
                                          echo "<option value='$i'> $i </option>";
                                      }
                                    ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="os" class="control-label col-md-3 col-sm-3 col-xs-12">Status <span class="required">*</span></label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <select id="status" class="form-control col-md-6 col-xs-6" name="status" required/>
                                  <option value="">Pilih Status..</option>
                                  <option value="ACTIVE">Aktif</option>
                                  <option value="VACANT">Vacant</option>
                                  <option value="BROKEN">Rusak</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                              <label for="foto" class="control-label col-md-3 col-sm-3 col-xs-12">Foto Perangkat</label>
                              <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="hidden" id="old-foto" name="oldfoto" value="">
                                <input type="file" name="foto" class="form-control col-md-4 col-xs-12">
                                <small>Ukuran Gambar Maksimal 3 MB dengan format JPG, JPEG, atau PNG.</small>
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