<div class="container-fluid" id="container-wrapper">
	<div class="row mb-3">
		<div class="col-lg-8">
      <!-- Form Basic -->
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-white">Tambah <?=$title;?></h6>
        </div>
        <div class="card-body">
          <?= $this->session->flashdata('message'); ?>
          <form id="tambahform" action="javascript:prosesDefault('master/tambahSlider/proses?>','tambahform')" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Status<span style="color: red">*</span></label>
                  <select class="form-control" name="is_active" required="">
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Tipe<span style="color: red">*</span></label>
                  <select class="form-control" name="tipe_slider" required="" onchange="tipeSlider(this.value)">
                    <option value="default">Default</option>
                    <option value="link">Link</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 d-none" id="keterangan_slider_xid">
                <div class="form-group editoronly">
                  <label>Keterangan</label>
                  <textarea name="ket_slider" class="form-control"></textarea>
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <label>Gambar<span style="color: red">*</span></label>
                  <input type="file" class="form-control" name="gambar" autocomplete="off" onChange="showImgfile(this);">
                </div>
                <div class="font-size-12 mt-2 mb-2">Ukuran gambar maksimal 2mb, rekomendasi 1980*820 pixel.</div>
                <center><div id="targetfileimg"></div></center> 
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
  function tipeSlider(a){
    if (a=='default') {
      $('#keterangan_slider_xid').addClass('d-none');
    }else{
      $('#keterangan_slider_xid').removeClass('d-none');
    }
  }
</script>