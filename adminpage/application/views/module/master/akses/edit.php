<div class="container-fluid" id="container-wrapper">
	<div class="row mb-3">
		<div class="col-lg-8">
      <!-- Form Basic -->
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-white">Edit <?=$title;?></h6>
        </div>
        <div class="card-body">
          
          <?= $this->session->flashdata('message'); ?>
          <form id="editform" action="javascript:prosesDefault('master/editAkses/<?=$role['role_id'].'/proses'?>','editform')" method="POST">
            <div class="row">
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label>Nama Role<span style="color: red">*</span></label>
                  <?php if ($role['role_id']==9) { ?>
                  <input type="text" class="form-control" name="nama_akses" value="<?=$role['nama_role'];?>" autocomplete="off" required="" readonly="">
                  <div class="small mt-2">Khusus Point Of Sale tidak bisa edit nama.</div>
                  <?php }else{ ?>
                  <input type="text" class="form-control" name="nama_akses" value="<?=$role['nama_role'];?>" autocomplete="off" required="">
                  <?= form_error('nama_akses','<small class="text-danger">','</small>');?>
                  <?php } ?>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Status<span style="color: red">*</span></label>
                  <select class="form-control" name="is_active" required="">
                    <option value="1" <?php if ($role['is_active']==1) echo 'selected'; ?>>Active</option>
                    <option value="0" <?php if ($role['is_active']==0) echo 'selected'; ?>>Inactive</option>
                  </select>
                  <?= form_error('is_active','<small class="text-danger">','</small>');?>
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <label for="exampleInputEmail1">Akses Menu</label><br>
                  <div class="row">
                    <?php $menu = $this->menu->getMenu(); ?>
                    <?php foreach ($menu as $m) : ?>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <b><?=$m['nama_menu'];?></b><br>
                    <?php $subMenu = $this->menu->getSubMenu($role['role_id'],$m['menu_id']); ?>
                    <?php foreach ($subMenu as $sm) : ?>
                    <label style="margin-bottom: 0px;"><input type="checkbox" name="hak[]" id="hak[]" class="flat" <?php if($sm['id_menu']<>''){ echo "checked";} ?> value="<?=$m['menu_id']."~".$sm['menu_id']?>"> <?=$sm['nama_menu']?></label><br>
                    <?php endforeach; ?>
                    </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <a href="<?= base_url('master/akses'); ?>" class="btn btn-light">Kembali</a> &nbsp; atau &nbsp;
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>