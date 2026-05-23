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
          <form id="editform" action="javascript:prosesDefault('master/editSlider/<?=$edit['slider_id'].'/proses'?>','editform')" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Status<span style="color: red">*</span></label>
                  <select class="form-control" name="is_active" required="">
                    <option value="1" <?php if ($edit['is_active']==1) echo 'selected'; ?>>Aktif</option>
                    <option value="0" <?php if ($edit['is_active']==0) echo 'selected'; ?>>Tidak Aktif</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Tipe<span style="color: red">*</span></label>
                  <select class="form-control" name="tipe_slider" required="" onchange="tipeSlider(this.value)">
                    <option value="default" <?php if ($edit['tipe_slider']=='default') echo 'selected'; ?>>Default</option>
                    <option value="link" <?php if ($edit['tipe_slider']=='link') echo 'selected'; ?>>Link</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 d-none" id="keterangan_slider_xid">
                <div class="form-group editoronly">
                  <label>Keterangan</label>
                  <textarea name="ket_slider" class="form-control"><?=$edit['ket_slider'];?></textarea>
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <label>Gambar</label>
                  <input type="file" class="form-control" name="gambar" autocomplete="off" onChange="showImgfile(this);">
                  <input type="hidden" class="form-control" name="old_gambar" value="<?=$edit['logo_image'];?>">
                </div>
                <div class="font-size-12 mt-2 mb-2">Ukuran gambar maksimal 2mb, rekomendasi 1980*820 pixel.</div>
                <center><div id="targetfileimg"><img src="<?=$this->config->item("nhub_url");?>assets/uploaded/komponen/<?=$edit["logo_image"];?>" class="img-fluid rounded" style="height: 80px;"></div></center> 
              </div>
            </div>
            <hr>
            <a href="<?= base_url('master/slider'); ?>" class="btn btn-light">Kembali</a> &nbsp; atau &nbsp;
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function () {
    setTimeout(function(){
      if ('<?=$edit['tipe_slider'];?>'=='link') { $('#keterangan_slider_xid').removeClass('d-none'); }
    }, 500);
  });

  function tipeSlider(a){
    if (a=='default') {
      $('#keterangan_slider_xid').addClass('d-none');
    }else{
      $('#keterangan_slider_xid').removeClass('d-none');
    }
  }
</script>