<?php
defined('BASEPATH') OR die('No Direct Script Access Allowed');?>

        <div class="form-group">
          <?= form_open('services/action/add', 'method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"');?>
          
          <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jenis-perangkat">Device Name <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="device" class="form-control device" name="kode_device" style="width:300px;" required>
                  <option value="">Pilih Device</option>
                  <?php foreach($data['device'] as $device) :?>

                  <option value="<?= $device['kode_device'];?>"><?= $device['hostname'];?></option>
                  <?php endforeach;?>

                </select>
              </div>
              <div class="col-md-2 col-sm-2 col-xs-12">
                <button type="submit" class="btn btn-primary" name="submit">Tambah</button>
              </div>
          </div>
          </form>
        </div>
        <div class="ln_solid"></div>
        <div class="form-group pull-right">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

        <!-- Parsley -->
        <script src="<?= site_url();?>assets/vendors/parsleyjs/dist/parsley.min.js"></script>
        <!-- Select2 -->
        <script src="<?= site_url();?>assets/vendors/select2/dist/js/select2.min.js"></script>
    
        <script type="text/javascript">
          $(document).ready(function() { 
            $("#device").select2({
              placeholder: "Pilih Device..",
              allowClear: true
            });
          });
        </script>