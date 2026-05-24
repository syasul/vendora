<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <meta name="keywords" content="<?=$rest_sistem['result']['meta_keywords'];?>">
    
    <?php include "module/include/style.php"; ?>

    <title>Detail Topup</title>
  </head>
  <body>

    <?php include "module/include/header.php"; ?>

    <section class="bg-container-2 mt-4 pt-3-mob">
      <div class="row">
        <div class="col-xl-12 col-lg-12">
          <div class="row justify-content-center">

            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 mb-4">
              <div class="default-shadow rounded-2">
                <div class="padding-0-15 pt-3">
                  <a href="<?=$main_url;?>balance" class="btn btn-light btn-sm"><i class="fa fa-close"></i>&nbsp; Kembali </a>
                </div>
                <div class="padding-15 text-center">


                  <?php if ($i_trx['result']) { ?>

                    <?php if ($rest_trx['is_status']=='p') { ?>
                      <h3 class="mb-3 ft-18 font-weight-bold mt-3">
                        TOPUP PENDING <i class="fa fa-hourglass-half"></i>
                      </h3>
                    <?php } else if ($rest_trx['is_status']=='y') { ?>
                      <h3 class="mb-3 ft-18 font-weight-bold mt-3">
                        TOPUP SELESAI <i class="fa fa-check"></i>
                      </h3>
                    <?php }else{ ?>
                      <h3 class="mb-3 ft-18 font-weight-bold mt-3">
                        TOPUP DIBATALKAN <i class="fa fa-times"></i>
                      </h3>
                    <?php } ?>
                      
                    <p class="color-semidark">
                      No Transaksi : <b class="font-weight-bold"><?=$rest_trx['kode'];?></b>
                      <br/>
                      Tanggal : <b><?=$rest_trx['tanggal'];?></b>
                    </p>
                    <p class="color-semidark">
                      Total Pembayaran : <b class="font-weight-bold"><?=$rest_trx['nominal'];?></b>
                    </p>

                    <?php if ($rest_trx['bukti_pembayaran']=='n' && $rest_trx['is_status']=='p') { ?>
                      <p class="color-semidark ft-14">
                        Silahkan lakukan pembayaran agar topup kamu bisa langsung kami proses.
                      </p>
                    <?php } ?>

                    <?php if ($rest_trx['bukti_pembayaran']!='n') { ?>
                      <p class="color-semidark ft-14">
                        Bukti Pembayaran telah kami terima dan sedang kami di proses.<br/>
                        <a href="<?=$main_imgurl.'komponen/'.$rest_trx['bukti_pembayaran'];?>" target="_blank">Lihat Bukti Pembayaran</a>
                      </p>
                    <?php } ?>

                    <?php if ($rest_trx['is_status']=='b') { ?>
                      <p class="color-semidark"><?=$rest_trx['if_cancel'];?></p>
                    <?php } ?>

                    <?php if ($rest_trx['is_status']=='p') { ?>
                      <p class="color-semidark">
                        <span class="font-weight-bold">Cara Pembayaran</span>
                        <br>
                        <span class="ft-14">Lakukan pembayaran melalui salah satu cara / bank dibawah ini :</span>
                      </p>
                      
                      <?php if ($rest_trx['payment_type']=='tripay') { ?>
                        <div class="row">
                          <?php foreach(json_decode($rest_trx['cara_pembayaran'], true) as $valc){ ?>
                            <div class="col-xl-12 col-lg-12 text-left pb-3">
                              <div class="padding-0-15 ft-14">
                                <div class="mb-3 ft-16 text-uppercase">
                                  <b><?=$valc['title'];?></b>
                                </div>
                                <div class="">
                                  <?php $no = 0; foreach($valc['steps'] as $valcx){ ?>
                                  <div class="">
                                    <?=$valcx;?>
                                  </div>
                                  <?php $no++; } ?>
                                </div>
                              </div>
                            </div>
                          <?php } ?>
                          <?php if ($rest_trx['biller_code']!='OVO' && $rest_trx['if_cancel']!='') { ?>
                          <div class="padding-15 text-center w-100">
                            <img src="<?=$rest_trx['if_cancel'];?>" class="img-fluid" width="220px">
                          </div>
                          <?php } ?>
                          <?php if ($rest_trx['biller_code']=='OVO' && $rest_trx['if_cancel']!='') { ?>
                          <div class="padding-15 text-center w-100">
                            <a href="<?=$rest_trx['if_cancel'];?>" class="btn btn-primary btn-sm" target="_blank"> 
                            Klik untuk melihat cara pembayaran. 
                          </a>
                          </div>
                          <?php } ?>
                        </div>
                      <?php }else if ($rest_trx['payment_type']=='xendit') { ?>
                        <!-- Jika menggunakan manual transfer -->
                        <div class="manual_bank_pay ft-14">
                          Batas Pembayaran 24 Jam.<br/><br/>
                          <a href="<?=$rest_trx['cara_pembayaran'];?>" class="btn btn-primary btn-sm" target="_blank"> 
                            Klik untuk melihat cara pembayaran. 
                          </a>
                        </div>
                      <?php }else if ($rest_trx['payment_type']=='manual') { ?>
                        <!-- Jika menggunakan manual transfer -->
                        <div class="manual_bank_pay ft-14">
                          <?php foreach($i_trx['m_bank'] as $valb){ ?>
                            <img src="<?=$main_imgurl.'komponen/'.$valb['logo_image'];?>" width="80"> &nbsp;
                            Bank <?=$valb['nama_bank'];?> a/n <?=$valb['nama_rekening'];?><br>
                            Nomor Rekening : <?=$valb['nomor_rekening'];?><br><br>
                          <?php } ?>
                        </div>
                      <?php }else if ($rest_trx['payment_type']=='cstore') { ?>
                        <div class="manual_bank_pay ft-14">
                          Batas Pembayaran 24 Jam.<br/><br/>
                          <a href="<?=$rest_trx['cara_pembayaran'];?>" class="btn btn-primary btn-sm" target="_blank"> 
                            Klik untuk melihat cara pembayaran. 
                          </a>
                        </div>
                      <?php }else if ($rest_trx['payment_type']=='qris' || $rest_trx['payment_type']=='gopay') { ?>
                        <div class="manual_bank_pay ft-14">
                          <b>Dimohon untuk cek email Anda untuk melihat cara pembayaran.</b><br/>
                        </div>
                      <?php }else{ ?>
                        <div class="row">
                          <div class="col-xl-12 col-lg-12">
                            <ul class="nav nav-tabs b-0_ mb-4 justify-content-center" id="myTab" role="tablist">
                              <?php $no='1'; foreach($rest_trx['cara_bayar'] as $valc){ ?>
                              <li class="nav-item">
                                <a class="nav-link ft-16 <?php if($no=='1') echo 'active';?>" id="cbyr-tab<?=$valc['cara_bayar_id'];?>" data-toggle="tab" href="#tabcbyr<?=$valc['cara_bayar_id'];?>" role="tab" aria-controls="tabcbyr<?=$valc['cara_bayar_id'];?>" aria-selected="true"><?=$valc['jenis_bayar'];?></a>
                              </li>
                              <?php $no++; } ?>
                            </ul>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xl-12 col-lg-12 text-left">
                            <div class="tab-content" id="myTabContent">
                              <?php $no = 0; foreach($rest_trx['cara_bayar'] as $valc){ ?>
                              <div class="tab-pane fade <?php if($no==0) echo 'show active';?>" id="tabcbyr<?=$valc['cara_bayar_id'];?>" role="tabpanel" aria-labelledby="cbyr-tab<?=$valc['cara_bayar_id'];?>">
                                <div class="padding-0-15 ft-14">
                                  <div class="mb-3 ft-16"><b>Kode Pembayaran / VA : <?=$rest_trx['bill_key'];?></b></div>
                                  <?php $nox = 1; foreach($rest_trx['cara_bayar'][$no]['cara_bayar'] as $valcc){ ?>
                                  <?=$nox.'. '.$valcc['cara_bayar'];?><br/>
                                  <?php $nox++; } ?>
                                </div>
                              </div>
                              <?php $no++; } ?>
                            </div>
                          </div>
                        </div>
                      <?php } ?>

                      <div class="pt-3"><hr></div>

                      <form id="form_kirim_bukti_bayar" class="mt-3" action="javascript:sendPayment()" enctype="multipart/form-data" method="POST">
                        <div class="row">

                          <?php if ($rest_trx['payment_type']!='manual') { ?>
                            <input type="hidden" name="bank_id" value="0" class="form-control">
                            <?php }else{ ?>
                            <!-- Jika menggunakan manual transfer -->
                            <div class="col-sm-12 col-md-12">
                              <div class="form-label-group text-left">
                                <label class="text-left">Transfer Ke</label>
                                <select class="form-control" required="" name="bank_id">
                                  <option value=""> -- Pilih Bank -- </option>
                                  <?php foreach($i_trx['m_bank'] as $valb){ ?>
                                  <option value="<?=$valb['bank_id'];?>"><?=$valb['nama_bank'];?> - <?=$valb['nama_rekening'];?> - <?=$valb['nomor_rekening'];?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div>
                          <?php } ?>

                          <div class="col-sm-12 col-md-12">
                            <div class="form-label-group text-left mt-2">
                              <label style="text-align: left;">Bukti Pembayaran</label>
                              <input type="file" name="gambar" class="form-control" required="">
                              <input type="hidden" name="no_transaksi" id="no_transaksiid" value="<?=$rest_trx['kode'];?>" class="form-control">
                            </div>
                          </div>

                          <div class="col-sm-12 col-md-12">
                            <?php 
                              if (isset($_SESSION['pesanbukti']) && $_SESSION['pesanbukti'] <> '') {
                                  echo '<br><div class="pesan alert alert-success">'.$_SESSION['pesanbukti'].'</div>';
                              }
                              $_SESSION['pesanbukti'] = '';
                            ?>
                          </div>

                          <div class="col-sm-12 col-md-12">
                            <div id="checkSave" class="mt-4">
                              <button class="btn btn-primary btn-block" type="submit">Kirim Bukti Pembayaran</button>
                            </div>
                          </div>

                        </div>
                      </form>

                    <?php } ?>

                  <?php }else{ ?>
                    <div class="pb-3">
                      <h3 class="ft-18 font-weight-bold mt-3 mb-4">TRANSAKSI TIDAK DITEMUKAN</h3>
                      <a href="<?=$main_url;?>account" class="btn btn-primary">Kembali Ke Riwayat Transaksi</a>
                    </div>
                  <?php } ?>

                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>

    <?php include "module/include/footer.php"; ?>
    
    <?php include "module/include/javascript.php"; ?>

    <script type="text/javascript">
      function sendPayment(){
        $.confirm({
            title: 'Confirm!',
            content: 'Pastikan bukti pembayaran yang di masukan benar!',
            theme: 'modern',
            closeIcon: true,
            draggable: false,
            animation: 'scale',
            type: 'dark',
            buttons: {
              Batal: function () {

              },
              Simpan: function () {
                $('button').addClass('disabled');
                var formData = new FormData($("#form_kirim_bukti_bayar")[0]);
                $.ajax({
                  type: "POST",
                  url: '<?=$main_url;?>module/action.php?jen=kirim_bukti_bayar_topup',
                  data:  formData,
                  contentType: false,
                  cache: false,
                  processData:false,
                  success: function(result){
                    $('button').removeClass('disabled');
                    var res = result.split('~');
                    if (res[0]=='y') {
                      confirmBerhasil(res[1],'reload');
                    }else{
                      confirmGagal(res[1]);
                    }
                  } 
                });
              }
            }
        });
      }
      function batalPesanan(){
        $.confirm({
            title: 'Confirm!',
            content: 'Transaksi akan dibatalkan, kamu yakin?',
            theme: 'modern',
            closeIcon: true,
            draggable: false,
            animation: 'scale',
            type: 'red',
            buttons: {
              Batal: function () {

              },
              Simpan: function () {
                $('button').addClass('disabled');
                var notrx = $('#no_transaksiid').val();
                $.ajax({
                  type : "POST",
                  url : "<?=$main_url;?>module/action.php?jen=batalkan_transaksi",
                  data :  { 'notrx' : notrx },
                  success: function(result){
                    $('button').removeClass('disabled');
                    var res = result.split('~');
                    if (res[0]=='y') {
                      confirmBerhasil(res[1],'reload');
                    }else{
                      confirmGagal(res[1]);
                    }
                  } 
                });
              }
            }
        });
      }

    </script>

  </body>
</html>