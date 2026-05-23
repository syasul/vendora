<div class="container-fluid" id="container-wrapper">
  <div class="row mb-3">
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-white"><?= $title; ?></h6>
        </div>
        <form id="tambahform" action="javascript:prosesDefault('pengaturan/kontak/proses','tambahform')" method="POST">
          <div class="card-body">
          <?= $this->session->flashdata('message'); ?>
            <div id="alertpassproses"></div>
            <div class="row">
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-6">
                <div class="form-group">
                  <label>Email Address<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="email_address" value="<?=$sistem['email_address'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-6">
                <div class="form-group">
                  <label>Call Center<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="call_center" value="<?=$sistem['call_center'];?>" autocomplete="off" required="" onkeydown="return angkatOnly2(event.key)">
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-6">
                <div class="form-group">
                  <label>Call Center 2</label>
                  <input type="text" class="form-control" name="call_center2" value="<?=$sistem['call_center2'];?>" autocomplete="off" onkeydown="return angkatOnly2(event.key)">
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-6">
                <div class="form-group">
                  <label>No WhatsApp</label>
                  <input type="text" class="form-control" name="whatsapp" value="<?=$sistem['whatsapp'];?>" autocomplete="off" onkeydown="return angkatOnly(event.key)">
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-6">
                <div class="form-group">
                  <label>No WhatsApp 2</label>
                  <input type="text" class="form-control" name="whatsapp2" value="<?=$sistem['whatsapp2'];?>" autocomplete="off" onkeydown="return angkatOnly(event.key)">
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-6">
                <div class="form-group">
                  <label>Instagram</label>
                  <input type="text" class="form-control" name="instagram" value="<?=$sistem['instagram'];?>" autocomplete="off">
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-6">
                <div class="form-group">
                  <label>Facebook</label>
                  <input type="text" class="form-control" name="facebook" value="<?=$sistem['facebook'];?>" autocomplete="off">
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label>Deskripsi<span style="color: red">*</span></label>
                  <textarea type="text" class="form-control" name="kontak_kami"><?=$sistem['kontak_kami'];?></textarea>
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label>Iframe Maps</label>
                  <textarea type="text" name="google_maps" class="form-control" rows="4"><?=$sistem['google_maps'];?></textarea>
                </div>
              </div>
              <style type="text/css">
                #maps_g iframe { width: 100%; height: 280px; border-radius: 5px; }
              </style>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
                <div id="maps_g"><?=$sistem['google_maps'];?></div>
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