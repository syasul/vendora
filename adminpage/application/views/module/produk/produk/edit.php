<div class="container-fluid" id="container-wrapper">
  <div class="row mb-3">
    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
      <!-- Form Basic -->
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-white">Edit <?=$title;?></h6>
        </div>
        <div class="card-body">
          <?= $this->session->flashdata('message'); ?>
          <form id="editform" action="javascript:prosesDefault('produk/editProduk/<?=$edit['produk_id'].'/proses'?>','editform')" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Produk Digital<span style="color: red">*</span></label>
                  <select class="form-control" name="is_digital" required="" onchange="selectDigital(this.value);">
                    <option value="n" <?php if ($edit['is_digital']=='n') echo 'selected'; ?>>Tidak</option>
                    <option value="y" <?php if ($edit['is_digital']=='y') echo 'selected'; ?>>Ya, Digital</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label for="exampleInputEmail1">Status<span style="color: red">*</span></label>
                  <select class="form-control" name="is_active" required="">
                    <option value="1" <?php if ($edit['is_active']==1) echo 'selected'; ?>>Aktif</option>
                    <option value="0" <?php if ($edit['is_active']==0) echo 'selected'; ?>>Tidak Aktif</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                  <label for="exampleInputEmail1">Kategori<span style="color: red">*</span></label>
                  <select class="form-control selectpicker" data-max-options="3" data-live-search="true" name="kategori_id[]" id="kategori_id" multiple="" title="-- Pilih --" required="" onchange="selectSub();">
                    <?php 
                      foreach ($all_kateg as $datarl) : 
                      $ik = $this->auth->rowData('m_produk_kategori','produk_id='.$edit['produk_id'].' AND kategori_id='.$datarl['kategori_id']); 
                      if (!isset($ik['kategori_id'])) { $ik['kategori_id'] = 0; }
                    ?>
                    <option value="<?=$datarl['kategori_id'];?>" <?php if($datarl['kategori_id']==$ik['kategori_id']) echo "selected"; ?>><?=$datarl['nama_kategori'];?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group" id="result_subkategori_produk">
                  <label for="exampleInputEmail1">Sub Kategori <span class="font-size-12">- opsional</span></label>
                  <select class="form-control selectpicker" name="kategori_sub_id[]" id="kategori_sub_id" data-max-options="5" data-live-search="true" multiple="" title="-- Pilih --" onchange="selectSub2();">
                    <?php foreach ($all_sub['result'] as $datasb) : $is = $this->auth->rowData('m_produk_kategori','produk_id='.$edit['produk_id'].' AND kategori_sub_id='.$datasb['kategori_sub_id']); ?>
                    <option value="<?=$datasb['kategori_id'].'__'.$datasb['kategori_sub_id'];?>" <?php if ($is) echo 'selected'; ?>><?=$datasb['nama_kategori'];?> &nbsp;-&nbsp; <?=$datasb['nama_sub'];?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group" id="result_subkategori_lv2_produk">
                  <label>Sub Lv2 <span class="font-size-12">- opsional</span></label>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Kode Produk<span style="color: red">*</span></label>
                  <input type="text" name="kode_produk" class="form-control" value="<?=$edit['kode_produk'];?>" required="">
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6" id="isdigital1">
                <div class="form-group">
                  <label>Berat Produk (gram)<span style="color: red">*</span></label>
                  <input type="text" name="berat_produk" class="form-control" value="<?=$edit['berat_produk'];?>" required="" autocomplete="off" onkeydown="return angkatOnly(event.key)">
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Nama Produk<span style="color: red">*</span></label>
                  <input type="text" id="nama_produk" name="nama_produk" class="form-control" value="<?=$edit['nama_produk'];?>" required="" autocomplete="off">
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Meta Title<span style="color: red">*</span></label>
                  <input type="text" id="meta_title" name="meta_title" class="form-control" value="<?=$edit['meta_title'];?>" required="" autocomplete="off">
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="form-group">
                  <label>Meta Deskripsi<span style="color: red">*</span></label>
                  <textarea type="text" name="meta_deskripsi" class="form-control" required=""><?=$edit['meta_deskripsi'];?></textarea>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Harga Produk<span style="color: red">*</span></label>
                  <input type="text" name="harga_produk" class="form-control" value="<?=$edit['harga_produk'];?>" required="" autocomplete="off" onkeydown="return angkatOnly(event.key)">
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6" id="isdigital2">
                <div class="form-group">
                  <label for="exampleInputEmail1">Warna <span class="font-size-12">- opsional</span></label>
                  <select class="form-control selectpicker" data-live-search="true" multiple name="warna_id[]" id="warna_id_id" title="-- Default --" onchange="checkWarna(this.value)">
                    <?php foreach ($all_warna as $datarwr) : $iw = $this->auth->rowData('m_produk_warna','is_status="y" AND produk_id='.$edit['produk_id'].' AND warna_id='.$datarwr['warna_id']); ?>
                    <option value="<?=$datarwr['warna_id'];?>" <?php if ($iw) echo 'selected'; ?>><?=$datarwr['nama_warna'];?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6" id="isdigital3">
                <div class="form-group">
                  <label for="exampleInputEmail1">Ukuran / Spesifikasi <span class="font-size-12">- opsional</span></label>
                  <select class="form-control selectpicker" data-live-search="true" multiple name="ukuranid_i" title="-- Default --" onchange="ukuranSize(this.value)">
                    <?php foreach ($all_ukuran as $dataruk) : 
                      $iu = $this->auth->rowData('m_produk_ukuran','is_status="y" AND produk_id='.$edit['produk_id'].' AND ukuran_id='.$dataruk['ukuran_id']);
                      if (!isset($iu['tambahan_harga'])) { $iu['tambahan_harga'] = ''; }
                    ?>
                    <option value="<?=$dataruk['ukuran_id']."~".$dataruk['ukuran_size']."~".$iu['tambahan_harga'];?>" <?php if ($iu['tambahan_harga']!='') echo 'selected'; ?>><?=$dataruk['ukuran_size'];?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="row" id="ukuran_size_label_id"></div>

            <div class="row">
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6" id="isdigital4">
                <div class="form-group">
                  <label>New Arrival<span style="color: red">*</span></label>
                  <select class="form-control" name="is_new" required="">
                    <option value="n" <?php if ($edit['is_new']=='n') echo 'selected'; ?>>Tidak</option>
                    <option value="y" <?php if ($edit['is_new']=='y') echo 'selected'; ?>>Ya, new arrival</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Status Potongan / Diskon<span style="color: red">*</span></label>
                  <select class="form-control" name="potongan_status" required="" onchange="statusPotongan(this.value)">
                    <option value="n" <?php if ($edit['potongan_status']=='n') echo 'selected'; ?>>Tidak Aktif</option>
                    <option value="y" <?php if ($edit['potongan_status']=='y') echo 'selected'; ?>>Aktif</option>
                  </select>
                </div>
              </div>
            </div>

            <div id="potongan_p_xid" class="d-none">
              <div class="">
                <div class="row" style="background: #ededed; border-radius: 5px; padding: 10px 5px; margin: 5px 0px 10px 0px;">
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <div class="form-group">
                      <label>Nominal Diskon<span style="color: red">*</span></label>
                      <input type="text" name="potongan_diskon" class="form-control" autocomplete="off" onkeydown="return angkatOnly(event.key)" value="<?=$edit['potongan_diskon'];?>">
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <div class="form-group">
                      <label>Mulai Berlaku<span style="color: red">*</span></label>
                      <input type="date" name="potongan_mulai" class="form-control" id="startcon" value="<?=$edit['potongan_mulai'];?>">
                    </div>
                  </div>
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <div class="form-group">
                      <label>Berakhir<span style="color: red">*</span></label>
                      <input type="date" name="potongan_akhir" class="form-control" id="endcon" value="<?=$edit['potongan_akhir'];?>">
                    </div>
                  </div>
                  <div class="col-xl-12 col-lg-12 font-size-12">
                    Contoh : harga produk 65.000 nominal diskon 15.000 maka harga produk akan menjadi 50.000.
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Status Affiliate<span style="color: red">*</span></label>
                  <select class="form-control" name="status_affiliate" required="" onchange="statusAffiliate(this.value)">
                    <option value="d" <?php if ($edit['status_affiliate']=='d') echo 'selected'; ?>>Mengikuti Pengaturan Default Sistem</option>
                    <option value="y" <?php if ($edit['status_affiliate']=='y') echo 'selected'; ?>>Mengikuti Pengaturan Per Produk</option>
                    <option value="n" <?php if ($edit['status_affiliate']=='n') echo 'selected'; ?>>Tidak Aktif</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6 d-none" id="komisi_affiliate_produk">
                <div class="form-group">
                  <label>Komisi (persentase %)<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="komisi_affiliate_produk" value="<?=$edit['komisi_affiliate_produk'];?>" autocomplete="off">
                </div>
              </div>
            </div>

            <div class="row">

              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 d-none" id="isdigital0">
                <div class="form-group" style="background: #cefadb; border-radius: 5px; padding: 10px 10px; margin: 5px 0px 10px 0px;">
                  <label>File Digital (PDF/DOC/XLS/PPT/CSV/ZIP/RAR)<br/>Maksimal 8mb.<br/><br/><b>Kosongkan jika tidak ada perubahan file digital.</b></label>
                  <input type="file" class="form-control" name="digital" autocomplete="off">
                  <input type="hidden" class="form-control" name="old_digital" value="<?=$edit['file_digital'];?>">
                </div>
              </div>

              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group editoronly">
                  <label>Deskripsi <span class="font-size-12">- opsional</span></label>
                  <textarea name="keterangan_produk" class="form-control"><?=$edit['keterangan_produk'];?></textarea>
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 mt-5 d-none" id="loadingsubmitx">
                <span class="font-size-12">Loading.... Proses sedang berlangsung.... <img src="<?=base_url('assets/temp/');?>img/komponen/loading.gif"></span>
              </div>
            </div>
            <hr>
            <a href="<?= base_url('produk/produk'); ?>" class="btn btn-light">Kembali</a> &nbsp; atau &nbsp;
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
      <?php $countimg = count($all_img); $no = 1; foreach ($all_img as $dataimg) : ?>
      <form id="editform_img<?=$no;?>" action="javascript:prosesDefault('produk/editProdukImg/<?=$dataimg['produk_img_id']?>','editform_img<?=$no;?>')" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label>Gambar <?=$no;?><span style="color: red">*</span></label>
          <center>
            <div class="mb-3" id="targetfileimg_p<?=$no;?>">
              <?php if ($countimg>1) { ?>
              <div style="position:absolute;right:20px;margin-top:10px;border:2px solid #fff;padding:5px;color:red;" class="rounded" onclick="prosesActionHapusImg('produk/hapusProdukImg/<?=$dataimg['produk_img_id']?>')">
                <i class="fa fa-times"></i>
              </div>
              <?php } ?>
              <img src='<?=$this->config->item("nhub_url");?>assets/uploaded/products/<?=$dataimg["logo_image"];?>' class="rounded img-fluid">
            </div>
          </center> 
          <div class="input-group">
            <input type="hidden" class="form-control" name="old_gambar" value="<?=$dataimg['logo_image'];?>">
            <input type="file" class="form-control" name="gambar" autocomplete="off" onChange="showImgfileGlobal(this,'targetfileimg_p<?=$no;?>');">
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i></button>
            </div>
          </div>
        </div>
      </form>
      <div class="mt-2 mb-4">
        <span class="font-size-12">Ukuran gambar maksimal 2mb, rekomendasi 640*640 pixel.</span>
      </div>
      <?php $no++; endforeach; ?>

      <hr>
      <div class="mb-3 font-weight-bold">Tambah Gambar</div>

      <?php for ($x = 1; $x <= 4-$countimg; $x++) {  ?>
      <form id="tmbhform_img<?=$x;?>" action="javascript:prosesDefault('produk/tambahProdukImg/<?=$edit['produk_id']?>','tmbhform_img<?=$x;?>')" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label>Gambar <?=$x;?><span style="color: red">*</span></label>
          <div class="input-group">
            <input type="file" class="form-control" name="gambar" required="" autocomplete="off" onChange="showImgfileGlobal(this,'targetfileimg_px<?=$x;?>');">
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i></button>
            </div>
          </div>
          <center>
            <div class="mt-3" id="targetfileimg_px<?=$x;?>"></div>
          </center> 
        </div>
      </form>
      <?php } ?>
      <div class="mt-3">
        <span class="font-size-12">Ukuran gambar maksimal 2mb, rekomendasi 640*640 pixel.</span>
      </div>
    </div>
  </div>
</div>

<script>
  const namaProduk = document.getElementById('nama_produk');
  const metaTitle = document.getElementById('meta_title');

  let metaEdited = false;

  // Deteksi user edit meta title
  metaTitle.addEventListener('input', function () {
    if (metaTitle.value.trim() === '') {
      // kalau dikosongkan → aktifkan auto sync lagi
      metaEdited = false;
    } else {
      metaEdited = true;
    }
  });

  // Sinkronisasi dari nama produk
  namaProduk.addEventListener('input', function () {
    if (!metaEdited) {
      metaTitle.value = namaProduk.value;
    }
  });
</script>

<script type="text/javascript">

  $(document).ready(function () {
    ukuranSize('');
    setTimeout(function(){
      if ('<?=$edit['potongan_status'];?>'=='y') { 
        $('#potongan_p_xid').removeClass('d-none'); 
        $("input[name=potongan_diskon]").prop('required',true);
        $("input[name=potongan_mulai]").prop('required',true);
        $("input[name=potongan_akhir]").prop('required',true);
      }
      selectSub2();
      selectDigital('<?=$edit['is_digital'];?>');
      statusAffiliate('<?=$edit['status_affiliate'];?>');
    }, 500);
  });

  function selectSub(){
    let res = $('select#kategori_id').val().toString().replace(/,/g, '-');
    $('#result_subkategori_produk').html('Loading....');
    $.get('<?=base_url()?>produk/selectSub/'+res+'/<?=$edit['produk_id'];?>', function(data) {
      // $('#result_subkategori_lv2_produk').html('<label>Sub Lv2 <span class="font-size-12">- opsional</span></label><select class="form-control" name="kategori_sub_lv2_id[]"><option value="">-- Menunggu Sub --</option></select>');
      $('#result_subkategori_produk').html(data);
      selectSub2();
    });
  }

  function selectSub2(){
    let res = $('select#kategori_sub_id').val().toString().replace(/,/g, '-');
    if (res=='') {
      res = 0;
    }
    $('#result_subkategori_lv2_produk').html('Loading....');
    $.get('<?=base_url()?>produk/selectSub2/'+res+'/<?=$edit['produk_id'];?>', function(data) {
      $('#result_subkategori_lv2_produk').html(data);
    });
  }

  function selectDigital(a){
    if (a=='y') {
      $('#isdigital0').removeClass('d-none');
      $('#isdigital1').addClass('d-none');
      $('#isdigital2').addClass('d-none');
      $('#isdigital3').addClass('d-none');
      $('#isdigital4').addClass('d-none');
      $('#ukuran_size_label_id').addClass('d-none');
      $("input[name=is_new]").prop('required',false);
      $("input[name=berat_produk]").prop('required',false);
    }else{
      $('#isdigital0').addClass('d-none');
      $('#isdigital1').removeClass('d-none');
      $('#isdigital2').removeClass('d-none');
      $('#isdigital3').removeClass('d-none');
      $('#isdigital4').removeClass('d-none');
      $("input[name=is_new]").prop('required',true);
      $("input[name=berat_produk]").prop('required',true);
    }
  }

  function checkWarna(a){
    if (a==1) {
      $('#warna_id_id').selectpicker('deselectAll');
      $('#warna_id_id').selectpicker('toggle');
    }
  }

  function ukuranSize(a){
    let val = a.split("~");
    if (val[0]==1) {
      $('select[name=ukuranid_i]').selectpicker('deselectAll');
      $('select[name=ukuranid_i]').selectpicker('toggle');
      // setTimeout(function(){ $('select[name=ukuranid_i]').val("1~Default"); }, 500);
    }else{
      var atext = '';
      for (let d of $('select[name=ukuranid_i]').val()) {
        var res = d.split("~");
        atext += '<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-6" style="color:green"><div class="form-group"><label>Tambahan Harga '+res[1]+' <span class="font-size-12">- opsional</span></label><input type="text" name="harga_tambahan_ukuran[]" placeholder="0" value="'+res[2]+'" class="form-control" autocomplete="off"><input type="hidden" name="ukuran_id[]" value="'+res[0]+'" class="form-control"></div></div>';
      }
      $('#ukuran_size_label_id').html(atext);
    }
  }

  function statusPotongan(a){
    if (a=='n') {
      $('#potongan_p_xid').addClass('d-none');
      $("input[name=potongan_diskon]").prop('required',false);
      $("input[name=potongan_mulai]").prop('required',false);
      $("input[name=potongan_akhir]").prop('required',false);
    }else{
      $('#potongan_p_xid').removeClass('d-none');
      $("input[name=potongan_diskon]").prop('required',true);
      $("input[name=potongan_mulai]").prop('required',true);
      $("input[name=potongan_akhir]").prop('required',true);
    }
  }

  function statusAffiliate(a){
    if (a=='y') {
      $('#komisi_affiliate_produk').removeClass('d-none');
      $("input[name=komisi_affiliate_produk]").prop('required',true);
    }else{
      $('#komisi_affiliate_produk').addClass('d-none');
      $("input[name=komisi_affiliate_produk]").prop('required',false);
    }
  }
</script>