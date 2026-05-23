<div class="container-fluid" id="container-wrapper">
	<div class="row mb-3">
		<div class="col-lg-12">
			<div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-white">Search Engine Optimization (SEO)</h6>
        </div>
        <form id="tambahform" action="javascript:prosesDefault('pengaturan/seoui/proses','tambahform')" method="POST" enctype="multipart/form-data">
          <div class="card-body">
            <?= $this->session->flashdata('message'); ?>
            <div id="alertpassproses"></div>
            <div class="row">
              <div class="col-xl-12 col-lg-12">
                <div class="form-group">
                  <label>Meta Title<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="meta_title" value="<?=$sistem['meta_title'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-12 col-lg-12">
                <div class="form-group">
                  <label>Meta Description<span style="color: red">*</span></label>
                  <textarea type="text" class="form-control" name="meta_description" required="" rows="5"><?=$sistem['meta_description'];?></textarea>
                </div>
              </div>
              <div class="col-xl-12 col-lg-12">
                <div class="form-group">
                  <label>Meta Keywords<span style="color: red">*</span></label>
                  <textarea type="text" class="form-control" name="meta_keywords" required="" rows="4"><?=$sistem['meta_keywords'];?></textarea>
                </div>
              </div>
            </div>
          </div>

          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-white">User Interface (UI)</h6>
          </div>

          <div class="card-body">
            <div id="alertpassproses"></div>
            <div class="row">
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label>Primary Color<span style="color: red">*</span></label>
                  <input type="color" class="form-control form-control-color" name="primary_color" value="<?=$sistem['primary_color'];?>">
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label>Sub Color (Hover)<span style="color: red">*</span></label>
                  <input type="color" class="form-control form-control-color" name="primary_hovercolor" value="<?=$sistem['primary_hovercolor'];?>">
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label>Logo Admin<br/><span class="font-size-12">Ukuran gambar maksimal 2mb, rekomendasi 486*100 pixel.</span></label>
                  <input type="file" class="form-control" name="gambar" autocomplete="off" onChange="showImgfileGlobal(this,'targetfileimg_logo');">
                  <input type="hidden" class="form-control" name="gambar_old" value="<?=$sistem['logo_image'];?>">
                </div>
                <center><div id="targetfileimg_logo" class="mb-2 mt-3">
                  <?php if ($sistem['logo_image']!='') { ?>
                    <img src="<?=$this->config->item("nhub_url");?>assets/uploaded/logo/<?=$sistem["logo_image"];?>" class="rounded" height='65'>
                  <?php } ?>
                </div></center>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label>Logo Toko<br/><span class="font-size-12">Ukuran gambar maksimal 2mb, rekomendasi 486*100 pixel.</span></label>
                  <input type="file" class="form-control" name="gambar4" autocomplete="off" onChange="showImgfileGlobal(this,'targetfileimg_logotoko');">
                  <input type="hidden" class="form-control" name="gambar_old4" value="<?=$sistem['logo_toko_image'];?>">
                </div>
                <center><div id="targetfileimg_logotoko" class="mb-2 mt-3">
                  <?php if ($sistem['logo_toko_image']!='') { ?>
                    <img src="<?=$this->config->item("nhub_url");?>assets/uploaded/logo/<?=$sistem["logo_toko_image"];?>" class="rounded" height='65'>
                  <?php } ?>
                </div></center>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label>Favicon<br/><span class="font-size-12">Ukuran gambar maksimal 2mb, rekomendasi (1:1) 192*192 pixel.</span></label>
                  <input type="file" class="form-control" name="gambar2" autocomplete="off" onChange="showImgfileGlobal(this,'targetfileimg_favicon');">
                  <input type="hidden" class="form-control" name="gambar_old2" value="<?=$sistem['favicon_image'];?>">
                </div>
                <center><div id="targetfileimg_favicon" class="mb-2 mt-3">
                  <?php if ($sistem['favicon_image']!='') { ?>
                    <img src="<?=$this->config->item("nhub_url");?>assets/uploaded/logo/<?=$sistem["favicon_image"];?>" class="rounded" height='65'>
                  <?php } ?>
                </div></center>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label>Empty Cart<br/><span class="font-size-12">Ukuran gambar maksimal 2mb.</span></label>
                  <input type="file" class="form-control" name="gambar3" autocomplete="off" onChange="showImgfileGlobal(this,'targetfileimg_emptycart');">
                  <input type="hidden" class="form-control" name="gambar_old3" value="<?=$sistem['empty_cart_image'];?>">
                </div>
                <center><div id="targetfileimg_emptycart" class="mb-2 mt-3">
                  <?php if ($sistem['empty_cart_image']!='') { ?>
                    <img src="<?=$this->config->item("nhub_url");?>assets/uploaded/logo/<?=$sistem["empty_cart_image"];?>" class="rounded" height='65'>
                  <?php } ?>
                </div></center>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label>UI Menu Navbar<span style="color: red">*</span></label>
                  <select class="form-control" name="ui_navbar" required="" onchange="uiNavbar(this.value)">
                    <option value="1" <?php if ($sistem['ui_navbar']==1) echo 'selected'; ?>>Default</option>
                    <option value="2" <?php if ($sistem['ui_navbar']==2) echo 'selected'; ?>>Tampilan 2</option>
                  </select>
                </div>
                <div class="p-3">
                  <div class="mb-2 text-center">-- Simulasi UI / Tampilan --</div>
                  <div id="img_navbar_v1" class="<?php if($sistem['ui_navbar']==2) echo 'd-none'; ?>">
                    <img src="<?=$this->config->item("nhub_url");?>assets/images/komponen/navbar_v1.png" class="rounded img-fluid">
                  </div>
                  <div id="img_navbar_v2" class="<?php if($sistem['ui_navbar']==1) echo 'd-none'; ?>">
                    <img src="<?=$this->config->item("nhub_url");?>assets/images/komponen/navbar_v2.png" class="rounded img-fluid">
                  </div>
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label>UI Kategori<span style="color: red">*</span></label>
                  <select class="form-control" name="ui_kategori" required="" onchange="uiKategori(this.value)">
                    <option value="1" <?php if ($sistem['ui_kategori']==1) echo 'selected'; ?>>Kategori Lv1</option>
                    <option value="2" <?php if ($sistem['ui_kategori']==2) echo 'selected'; ?>>Kategori Lv2</option>
                    <option value="3" <?php if ($sistem['ui_kategori']==3) echo 'selected'; ?>>Kategori Lv3</option>
                  </select>
                </div>
                <div class="p-3">
                  <div class="mb-2 text-center">-- Simulasi UI / Tampilan --</div>
                  <div id="img_kateg_v1" class="d-none">
                    <img src="<?=$this->config->item("nhub_url");?>assets/images/komponen/kategori_v1.png" class="rounded img-fluid">
                  </div>
                  <div id="img_kateg_v2" class="d-none">
                    <img src="<?=$this->config->item("nhub_url");?>assets/images/komponen/kategori_v2.png" class="rounded img-fluid">
                  </div>
                  <div id="img_kateg_v3" class="d-none">
                    <img src="<?=$this->config->item("nhub_url");?>assets/images/komponen/kategori_v3.png" class="rounded img-fluid">
                  </div>
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label>UI Footer<span style="color: red">*</span></label>
                  <select class="form-control" name="ui_footer" required="" onchange="uiFooter(this.value)">
                    <option value="footer-dark" <?php if ($sistem['ui_footer']=='footer-dark') echo 'selected'; ?>>Dark</option>
                    <option value="footer-light" <?php if ($sistem['ui_footer']=='footer-light') echo 'selected'; ?>>Light</option>
                    <option value="footer-silver" <?php if ($sistem['ui_footer']=='footer-silver') echo 'selected'; ?>>Silver</option>
                  </select>
                </div>
                <div class="p-3">
                  <div class="mb-2 text-center">-- Simulasi UI / Tampilan --</div>
                  <div id="img_footer_v1" class="d-none">
                    <img src="<?=$this->config->item("nhub_url");?>assets/images/komponen/footer-dark.png" class="rounded img-fluid">
                  </div>
                  <div id="img_footer_v2" class="d-none">
                    <img src="<?=$this->config->item("nhub_url");?>assets/images/komponen/footer-light.png" class="rounded border img-fluid">
                  </div>
                  <div id="img_footer_v3" class="d-none">
                    <img src="<?=$this->config->item("nhub_url");?>assets/images/komponen/footer-silver.png" class="rounded img-fluid">
                  </div>
                </div>
              </div>
              <div class="col-xl-12 col-lg-12">
                <div class="form-group">
                  <label>Label Footer</label>
                  <textarea type="text" class="form-control" name="label_footer" rows="2"><?=$sistem['label_footer'];?></textarea>
                </div>
              </div>
              <div class="col-xl-12 col-lg-12">
                <div class="form-group">
                  <label>Footer<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="footer" value="<?=$sistem['footer'];?>" autocomplete="off" required="">
                </div>
              </div>
            </div>
          </div>
          <hr>
          <div class="padding-submit">
            <button type="submit" class="btn btn-primary">&nbsp;Submit&nbsp;</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  $(document).ready(function () {
    uiFooter('<?=$sistem['ui_footer'];?>');
    uiKategori('<?=$sistem['ui_kategori'];?>');
  });
  function uiNavbar(a){
    if (a==1) {
      $('#img_navbar_v1').removeClass('d-none');
      $('#img_navbar_v2').addClass('d-none');
    }else{
      $('#img_navbar_v1').addClass('d-none');
      $('#img_navbar_v2').removeClass('d-none');      
    }
  }

  function uiKategori(a){
    if (a=='1') {
      $('#img_kateg_v1').removeClass('d-none');
      $('#img_kateg_v2').addClass('d-none');
      $('#img_kateg_v3').addClass('d-none');
    }else if (a=='2') {
      $('#img_kateg_v1').addClass('d-none');
      $('#img_kateg_v2').removeClass('d-none');
      $('#img_kateg_v3').addClass('d-none');
    }else{
      $('#img_kateg_v1').addClass('d-none');
      $('#img_kateg_v2').addClass('d-none');
      $('#img_kateg_v3').removeClass('d-none');
    }
  }

  function uiFooter(a){
    if (a=='footer-dark') {
      $('#img_footer_v1').removeClass('d-none');
      $('#img_footer_v2').addClass('d-none');
      $('#img_footer_v3').addClass('d-none');
    }else if (a=='footer-light') {
      $('#img_footer_v1').addClass('d-none');
      $('#img_footer_v2').removeClass('d-none');
      $('#img_footer_v3').addClass('d-none');
    }else{
      $('#img_footer_v1').addClass('d-none');
      $('#img_footer_v2').addClass('d-none');
      $('#img_footer_v3').removeClass('d-none');
    }
  }
</script>