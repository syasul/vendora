<div class="container-fluid" id="container-wrapper">
	<div class="row mb-3">
		<div class="col-xl-9 col-lg-10 col-md-12 col-sm-12">
      <!-- Form Basic -->
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-white">Tambah <?=$title;?></h6>
        </div>
        <div class="card-body">
          <?= $this->session->flashdata('message'); ?>
          <form id="tambahform" action="javascript:prosesDefault('produk/tambahVoucher/proses','tambahform')" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Nama Voucher<span style="color: red">*</span></label>
                  <input type="text" name="nama_voucher" class="form-control" required="" autocomplete="off">
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Kode Voucher<span style="color: red">*</span></label>
                  <input type="text" name="kode_voucher" class="form-control" required="" autocomplete="off" maxlength="8">
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Tipe Voucher<span style="color: red">*</span></label>
                  <select class="form-control" name="tipe_voucher" required="" onchange="tipeVoucher(this.value)">
                    <option value="1">Nominal</option>
                    <option value="2">Persentasi</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Tampilkan Publik<span style="color: red">*</span></label>
                  <select class="form-control" name="tampilkan" required="">
                    <option value="y">Tampilkan</option>
                    <option value="n">Tidak</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Limit Voucher<span style="color: red">*</span></label>
                  <input type="text" name="jumlah_voucher" class="form-control" required="" autocomplete="off" onkeydown="return angkatOnly(event.key)">
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Nominal / % Voucher<span style="color: red">*</span></label>
                  <input type="text" name="nominal_voucher" class="form-control" required="" autocomplete="off" onkeydown="return angkatOnly(event.key)">
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Minimal Belanja</label>
                  <input type="text" name="minimal_belanja" placeholder="0" class="form-control" autocomplete="off" onkeydown="return angkatOnly(event.key)">
		              <div class="mt-1 font-size-12">Jika nominal minimal belanja di kosongkan, maka tidak ada batasan minimal belanja.</div>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group d-none" id="maksimal_diskon_idiv">
                  <label>Maksimal Diskon</label>
                  <input type="text" name="maksimal_diskon" placeholder="0" class="form-control" autocomplete="off" onkeydown="return angkatOnly(event.key)">
		              <div class="mt-1 font-size-12">Jika nominal maksimal diskon di kosongkan, maka tidak ada batasan maksimal diskon.</div>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Mulai Berlaku<span style="color: red">*</span></label>
                  <input type="date" name="tgl_mulai" class="form-control" id="startcon" required="">
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Berakhir<span style="color: red">*</span></label>
                  <input type="date" name="tgl_akhir" class="form-control" id="endcon" required="">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group editoronly">
                  <label>Deskripsi</label>
                  <textarea name="deskripsi_voucher" class="form-control"></textarea>
                </div>
              </div>
            </div>
            <hr>
            <a href="<?= base_url('produk/voucher'); ?>" class="btn btn-light">Kembali</a> &nbsp; atau &nbsp;
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function tipeVoucher(a){
    if (a==1) {
      $('#maksimal_diskon_idiv').addClass('d-none');
    }else{
      $('#maksimal_diskon_idiv').removeClass('d-none');
    }
  }
</script>