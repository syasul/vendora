    <style type="text/css">
        .modal { overflow: auto !important; }
    </style>

    <div class="modal-header bg-35 border-radius0">
        <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;"><?=$all_data['kode_topup'];?></h5>
        <button class="close color-putih" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body bg-f9">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="border-radius5 bg-putih">
                    <div class="">
                      <?php if ($all_data['is_status']!='y') { ?>
                        <div class="padding-0-15 pt-3">
                            <div class="mb-3">
                                <div class="row">
                                    <?php if ($all_data['is_status']=='p') { ?>
                                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <a href="javascript:prosesActionTransaksiTopup('<?=$all_data['topup_id'];?>','b');" class="btn btn-danger btn-sm btn-block"><i class="fa fa-times"></i>&nbsp;&nbsp;Batalkan</a>
                                      </div>
                                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <a href="javascript:prosesActionTransaksiTopup('<?=$all_data['topup_id'];?>','y')" class="btn btn-success btn-sm btn-block"><i class="fa fa-check"></i>&nbsp;&nbsp;Konfirmasi</a>
                                      </div>
                                    <?php } ?>
                                </div>
                                <?php if ($all_data['is_status']=='b') { ?>
                                  <div class="color-danger mt-2">
                                    <?=$all_data['if_cancel'];?>
                                  </div>
                                <?php } ?>
                                <?php if ($all_data['is_status']=='p') { ?>
                                  <div class="color-success mt-2">
                                    Klik button <b>"Konfirmasi"</b> jika topup akan diproses, pastikan pembayaran sudah diterima.
                                  </div>
                                <?php } ?>
                            </div>
                        </div>
                      <?php } ?>

                        <div class="">
                          <div class="padding-15">
                            <div class="ft-14 font-weight-bold mb-1">Topup</div>
                            <h4 class="font-weight-bold mb-1"><?=formatRupiah($all_data['nominal_topup']);?></h4>
                          </div>
                          <hr>
                          <div class="padding-0-15">
                            <div class="ft-14 pb-3">
                              <div class="ft-14 font-weight-bold mb-1">
                                Bukti Pembayaran
                              </div>
                              <?php if ($all_data['bukti_pembayaran']=='n') { ?>
                                  Belum ada bukti pembayaran.
                              <?php }else if ($all_data['bukti_pembayaran']=='y') { ?>
                                  Tidak ada bukti pembayaran. - Otomoatis VA
                              <?php }else{ ?>
                                  Midtrans Redirect - Dan Customer Unggah Bukti Transfer.<br>
                                  <a class="fancybox btn btn-light btn-sm mt-2" rel="ligthbox" href="<?=$this->config->item("nhub_url");?>assets/uploaded/komponen/<?=$all_data['bukti_pembayaran'];?>">Lihat Bukti Pembayaran</a>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
    </div>

    <script>
      $(document).ready(function(){
        $(".fancybox").fancybox({
          openEffect: "none",
          closeEffect: "none"
        });
      });
    </script>