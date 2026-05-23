<div class="container-fluid" id="container-wrapper">
  <div class="row mb-3">
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-white"><?= $title; ?></h6>
        </div>
        <form id="tambahform" action="javascript:prosesDefault('pengaturan/faq/proses','tambahform')" method="POST">
          <div class="card-body">
          <?= $this->session->flashdata('message'); ?>
            <div id="alertpassproses"></div>
            <div class="row">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 editoronly">
                <div class="form-group">
                  <label>Deskripsi<span style="color: red">*</span></label>
                  <textarea name="faq_asked"><?=$sistem['faq_asked'];?></textarea>
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