<div class="modal-header">
  <h5 class="modal-title" id="exampleModalLabel">Edit <?=$title;?></h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?= $this->session->flashdata('message'); ?>
<form id="editform" action="javascript:prosesDefault('data/editAdmin/<?=$pengelola['pengelola_id'].'/proses'?>','editform')" method="POST">
  <div class="modal-body">
    <div class="row">
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label>Akses<span style="color: red">*</span></label>
          <select class="form-control" name="role_id" required="">
            <option value=""> -- Pilih --</option>
            <?php foreach ($all_role as $datarl) : ?>
            <option value="<?=$datarl['role_id'];?>" <?php if ($datarl['role_id']==$pengelola['role_id']) echo 'selected'; ?>><?=$datarl['nama_role'];?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="form-group">
          <label>Status<span style="color: red">*</span></label>
          <select class="form-control" name="is_active" required="">
            <option value="1" <?php if ($pengelola['is_active']==1) echo 'selected'; ?>>Aktif</option>
            <option value="0" <?php if ($pengelola['is_active']==0) echo 'selected'; ?>>Tidak Aktif</option>
          </select>
        </div>
      </div>
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="form-group">
          <label>Nama Lengkap<span style="color: red">*</span></label>
          <input type="text" class="form-control" name="nama" value="<?=$pengelola['nama_lengkap'];?>" autocomplete="off" required="">
        </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <div class="form-group">
          <label>Username<span style="color: red">*</span></label>
          <input type="text" class="form-control" name="name" value="<?=$pengelola['username'];?>" autocomplete="off" required="">
        </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" class="form-control" name="password" placeholder="***************">
          <small class="form-text text-muted">Kosongkan jika tidak dirubah.</small>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
    <button type="submit" class="btn btn-primary">&nbsp;Submit&nbsp;</button>
  </div>
</form>

