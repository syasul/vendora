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
          <form id="editform" action="javascript:prosesDefault('master/editBankp/<?=$edit['bank_tarik_id'].'/proses'?>','editform')" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Status<span style="color: red">*</span></label>
                  <select class="form-control" name="is_active" required="">
                    <option value="1" <?php if ($edit['is_active']==1) echo 'selected'; ?>>Aktif</option>
                    <option value="0" <?php if ($edit['is_active']==0) echo 'selected'; ?>>Tidak Aktif</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-8 col-lg-8 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Nama Bank<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="nama_bank" required="" autocomplete="off" value="<?=$edit['nama_bank'];?>">
                  <?= form_error('nama_bank','<small class="text-danger">','</small>');?>
                </div>
              </div>
            </div>
            <hr>
            <a href="<?= base_url('master/bank'); ?>" class="btn btn-light">Kembali</a> &nbsp; atau &nbsp;
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>