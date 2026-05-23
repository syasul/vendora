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
          <form id="editform" action="javascript:prosesDefault('master/editPartner/<?=$edit['partner_id'].'/proses'?>','editform')" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-xs-5">
                <div class="form-group">
                  <label for="exampleInputEmail1">Status<span style="color: red">*</span></label>
                  <select class="form-control" name="is_active" required="">
                    <option value="1" <?php if ($edit['is_active']==1) echo 'selected'; ?>>Aktif</option>
                    <option value="0" <?php if ($edit['is_active']==0) echo 'selected'; ?>>Tidak Aktif</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-8 col-lg-8 col-md-8 col-sm-7 col-xs-7">
                <div class="form-group">
                  <label>Gambar</label>
                  <input type="file" class="form-control" name="gambar" autocomplete="off" onChange="showImgfile(this);">
                  <input type="hidden" class="form-control" name="old_gambar" value="<?=$edit['logo_image'];?>">
                </div>
                <div class="font-size-12 mt-2 mb-2">Ukuran gambar maksimal 2mb, rekomendasi 650*460 pixel.</div>
                <center><div id="targetfileimg"><img src="<?=$this->config->item("nhub_url");?>assets/uploaded/komponen/<?=$edit["logo_image"];?>" class="img-fluid rounded" style="height: 80px;"></div></center> 
              </div>
            </div>
            <hr>
            <a href="<?= base_url('master/partner'); ?>" class="btn btn-light">Kembali</a> &nbsp; atau &nbsp;
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>