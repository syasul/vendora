<div class="modal-header">
  <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?= $this->session->flashdata('message'); ?>
<form id="editform" action="javascript:prosesDefault('kategori/editWarna/<?=$edit['warna_id'].'/proses'?>','editform')" method="POST" enctype="multipart/form-data">
  <div class="modal-body">
    <div class="row">
      <div class="col-xl-12 col-lg-12">
        <div class="form-group">
            <label>Nama Warna<span style="color: red">*</span></label>
            <input type="text" class="form-control" value="<?=$edit['nama_warna'];?>" name="nama_warna" required="" autocomplete="off">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
    <button type="submit" class="btn btn-primary">&nbsp;Submit&nbsp;</button>
  </div>
</form>