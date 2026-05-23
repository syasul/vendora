<?php include "module/module.php"; ?>
<?php if (!isset($_SESSION['XID_ARRAY'])) { header("Location: ".$main_url); exit(); } ?>
<?php if (isset($_SESSION['XID_ARRAY']) && $_SESSION['XID_ARRAY']['cust_id']=='guest') { header("Location: ".$main_url); exit(); } ?>
<?php 
  $arr = array('tipe' => 'web', 'lang' => 'en');
  $bank_list = loadData('rest_load/load_bank_tarik/', $arr);
?>
<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <meta name="keywords" content="<?=$rest_sistem['result']['meta_keywords'];?>">
    
    <?php include "module/include/style.php"; ?>

    <title>Saldo - <?=$rest_cust['result']['cust_nama'];?></title>
  </head>
  <body>

    <?php include "module/include/header.php"; ?>

    <section class="bg-container mt-4">
      <div class="row justify-content-center">
        <div class="col-xl-12 col-lg-12 col-xl-10_ col-lg-10_ col-md-11_">
          <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12 mb-4">
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tabtrx" role="tabpanel" aria-labelledby="trx-tab">

                  <div class="default-shadow rounded-2 mb-3">
                    <div class="padding-15 border-bottom1 pt-4">
                      <div class="">
                        <div class="ft-14 font-weight-bold mb-1">
                          Saldo Kamu :
                        </div>
                        <div class="ft-18 color-app font-weight-bold b-0">
                          <?=$rest_cust['saldo'];?>
                        </div>
                      </div>
                      <?php 
                        if (isset($_SESSION['XMSG_TARIK_WD']) && $_SESSION['XMSG_TARIK_WD'] <> '') {
                            echo '<br><div class="pesan alert alert-success">'.$_SESSION['XMSG_TARIK_WD'].'</div>';
                        }
                        $_SESSION['XMSG_TARIK_WD'] = '';
                      ?>
                      <?php if ($rest_cust['wd_pending']>0) { ?>
                        <br>
                        <div class="pesan alert alert-info">
                          Penarikan Saldo <b><?=formatRupiah($rest_cust['wd_pending']);?></b> sedang diproses, membutuhkan waktu hingga 1x24 jam atau terkadang membutuhkan waktu lebih lama.
                        </div>
                      <?php } ?>
                      <div class="p-absolute right-30" style="top: 7px !important;">
                        <a href="<?=$main_url;?>account" class="ft-16 color-semidark-m">&nbsp;<i class="fa fa-close"></i>&nbsp;</a>
                      </div>
                      <?php if ($rest_sistem['result']['fitur_topup']=='y') { ?>
                      <div class="p-absolute" style="top: 40px !important; right: 150px">
                        <button type="button" onclick="topupSaldo()" class="btn btn-primary ft-14 border-radius-5 height-38">&nbsp;Topup&nbsp;</button>
                      </div>
                      <?php } ?>
                      <?php if ($rest_sistem['result']['fitur_saldo']=='y' && $rest_cust['wd_pending']==0) { ?>
                      <div class="p-absolute right-30" style="top: 40px !important;">
                        <button type="button" onclick="tarikSaldo()" class="btn btn-primary ft-14 border-radius-5 height-38">&nbsp;Tarik Saldo&nbsp;</button>
                      </div>
                      <?php } ?>
                    </div>

                    <ul class="nav nav-tabs b-0 mb-3 border-bottom1" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active ft-14" id="alamat-tab" data-toggle="tab" href="#tabalamat" role="tab" aria-controls="tabalamat" aria-selected="false">Riwayat Saldo</a>
                      </li>
                      <?php if ($rest_sistem['result']['fitur_topup']=='y') { ?>
                      <li class="nav-item">
                        <a class="nav-link ft-14" id="trxtopup-tab" data-toggle="tab" href="#tabtrxtopup" role="tab" aria-controls="tabtrxtopup" aria-selected="true">Riwayat Topup</a>
                      </li>
                      <?php } ?>
                    </ul>
                    
                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="tabalamat" role="tabpanel" aria-labelledby="alamat-tab">
                        <div class="">
                          <div class="padding-15 pt-0">
                            <div class="">
                              <div class="ft-14 font-weight-bold mb-3">
                                Riwayat Saldo
                              </div>

                              <?php 
                                $arr = array('tipe' => 'web', 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'lang' => 'en');
                                $rest_trx = loadData('rest_load/load_riwayat_saldo/', $arr);
                              ?>

                              <div class="table-responsive mt-10 b-0" style="height:310px; overflow-y: auto;">
                                <table class="table table-hover b-0">
                                  <thead class="b-0">
                                    <tr class="b-0">
                                      <th class="ft-14">No Transaksi</th>
                                      <th class="ft-14">Tipe</th>
                                      <th class="ft-14">Nominal</th>
                                      <th class="ft-14">Tanggal</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php foreach($rest_trx['result'] as $obj) { ?>
                                    <tr>
                                      <td class="ft-14">
                                        <?php if ($obj['tipe']=='trx') { ?>
                                        <a href="<?=$main_url;?>trx/<?=$obj['uid'];?>" class="font-weight-bold">
                                          <?=$obj['kode'];?>
                                        </a>
                                        <?php }else if($obj['tipe']=='topup'){ ?>
                                        <a href="<?=$main_url;?>topup/<?=$obj['uidtopup'];?>" class="font-weight-bold">
                                          <?=$obj['kode'];?>
                                        </a>
                                        <?php }else if($obj['tipe']=='afp'){ ?>
                                          <a href="<?=$main_url;?>trx/<?=$obj['uid'];?>" class="font-weight-bold">
                                            <?=$obj['kode'];?>
                                          </a>
                                        <?php }else if($obj['tipe']=='wds'){ ?>
                                          <a href="javascript:modalDetailtsaldo('<?=encodeData($obj['uid']);?>');" class="font-weight-bold">
                                            <?=$obj['kode'];?>
                                          </a>
                                        <?php }else { ?>
                                          <?=$obj['kode'];?>
                                        <?php } ?>
                                      </td>
                                      <td class="ft-14"><?=$obj['tipelbl'];?></td>
                                      <td class="ft-14">
                                        <span class="color-<?=$obj['clr_ft'];?>"><?=$obj['nominal'];?></span>
                                      </td>
                                      <td class="ft-14">
                                        <?=$obj['tanggal'];?>
                                      </td>
                                    </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="tabtrxtopup" role="tabpanel" aria-labelledby="trxtopup-tab">
                        <div class="">
                          <div class="padding-15 pt-0">
                            <div class="">
                              <div class="ft-14 font-weight-bold mb-3">
                                Riwayat Topup
                              </div>

                              <?php 
                                $arr = array('tipe' => 'web', 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'lang' => 'en');
                                $rest_trx = loadData('rest_load/load_riwayat_topup/', $arr);
                              ?>

                              <div class="table-responsive mt-10 b-0" style="height:310px; overflow-y: auto;">
                                <table class="table table-hover b-0">
                                  <thead class="b-0">
                                    <tr class="b-0">
                                      <th class="ft-14">No Transaksi</th>
                                      <th class="ft-14">Nominal</th>
                                      <th class="ft-14">Status</th>
                                      <th class="ft-14">Tanggal</th>
                                      <th class="ft-14">&nbsp;</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php foreach($rest_trx['result'] as $obj) { ?>
                                    <tr>
                                      <td class="ft-14">
                                        <a href="<?=$main_url;?>topup/<?=$obj['uid'];?>" class="font-weight-bold">
                                          <?=$obj['kode'];?>
                                        </a>
                                      </td>
                                      <td class="ft-14"><?=$obj['nominal'];?></td>
                                      <td class="ft-14">
                                        <span class="color-<?=$obj['status_clr'];?>"><?=$obj['status'];?></span>
                                      </td>
                                      <td class="ft-14">
                                        <?=$obj['tanggal'];?>
                                      </td>
                                      <td class="ft-14" align="right">
                                        <a href="<?=$main_url;?>topup/<?=$obj['uid'];?>">
                                          Lihat
                                        </a>
                                      </td>
                                    </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="modal fade" id="myModalTopupsaldo">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal body -->
          <img src="<?=$main_url;?>assets/images/komponen/bubble_x3_v1.png" class="p-absolute h-100 left-0">
          <img src="<?=$main_url;?>assets/images/komponen/bubble_x3_v2.png" class="p-absolute h-100 right-0">
          <div class="modal-body">
            <div class="close_pfda" data-dismiss="modal"><span class="icon-close2"></span></div>
            <div class="text-center p-mob-30">
              <div class="section-title ft-18 text-center mb-3">
                  &mdash; Topup Saldo &mdash;
              </div>
              <div class="row text-center pb-3 pr-3 pl-3">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <form id="form_topup_akun_saldo" action="javascript:goTopupSaldo()" method="POST">
                    <div class="form-group mb-1 text-left">
                      <label class="">Nominal<span class="color-danger">*</span></label>
                      <input type="text" class="form-control ft-16" name="nominal_topup" id="nominal_topup" placeholder="0" required="" autocomplete="off" onkeydown="return angkatOnly(event.key)">
                      <div class="ft-12 mt-2 color-semidark text-right">Minimal Rp 10.000</div>
                    </div>
                    <?php if ($rest_sistem['result']['metode_pembayaran']=='tripay') { ?>
                    <div class="form-group mb-1 text-left">
                      <label class="">Metode Pembayaran<span class="color-danger">*</span></label>
                      <div id="payment_tripay"></div>
                    </div>
                    <?php } ?>
                    <div class="mt-4 mb-4">
                      <div class="">
                        <div id="infosebelumsubmitx"></div>
                      </div>
                      <button type="submit" class="btn btn-primary btn-block">Topup</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="myModalTariksaldo">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal body -->
          <img src="<?=$main_url;?>assets/images/komponen/bubble_x3_v1.png" class="p-absolute h-100 left-0">
          <img src="<?=$main_url;?>assets/images/komponen/bubble_x3_v2.png" class="p-absolute h-100 right-0">
          <div class="modal-body">
            <div class="close_pfda" data-dismiss="modal"><span class="icon-close2"></span></div>
            <div class="text-center p-mob-30">
              <div class="section-title ft-18 text-center mb-3">
                  &mdash; Tarik Saldo &mdash;
              </div>
              <div class="row text-center pb-3 pr-3 pl-3">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <form id="form_tarik_akun_saldo" action="javascript:goTarikSaldo()" method="POST">
                    <div class="form-group mb-2 text-left">
                      <label class="">Nominal<span class="color-danger">*</span></label>
                      <input type="text" class="form-control ft-16" name="nominal_tarik" id="nominal_tarik" placeholder="0" required="" autocomplete="off" onkeydown="return angkatOnly(event.key)">
                      <div class="ft-12 mt-2 color-semidark">Saldo <?=$rest_cust['saldo'];?> <span class="float-right">Minimal <?=formatRupiah($rest_sistem['result']['min_tarik_saldo']);?></span></div>
                    </div>
                    <div class="form-group mb-2 text-left">
                      <select class="form-control border-radius-10 ft-14" id="bank_tarik_id" name="bank_tarik_id" required>
                        <option value="<?=$objbank['bank_tarik_id'];?>">-- Pilih Bank --</option>
                        <?php foreach($bank_list['result'] as $objbank) { ?>
                        <option value="<?=$objbank['bank_tarik_id'];?>"><?=$objbank['nama_bank'];?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group mb-1 text-left">
                      <label class="">Nama Rekening<span class="color-danger">*</span></label>
                      <input type="text" class="form-control ft-16" name="nama_rek" id="nama_rek" required="" autocomplete="off">
                    </div>
                    <div class="form-group mb-1 text-left">
                      <label class="">Nomor Rekening/E-wallet<span class="color-danger">*</span></label>
                      <input type="text" class="form-control ft-16" name="no_rek" id="no_rek" required="" autocomplete="off" onkeydown="return angkatOnly(event.key)">
                    </div>
                    <div class="mt-4 mb-4">
                      <div class="">
                        <div id="infosebelumsubmitxtarik"></div>
                      </div>
                      <button type="submit" class="btn btn-primary btn-block">Tarik Saldo</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="mymodalDetailtsaldo">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal body -->
          <img src="<?=$main_url;?>assets/images/komponen/bubble_x3_v1.png" class="p-absolute h-100 left-0">
          <img src="<?=$main_url;?>assets/images/komponen/bubble_x3_v2.png" class="p-absolute h-100 right-0">
          <div class="modal-body">
            <div id="mymodalDetailtsaldores">Loading...</div>
          </div>
        </div>
      </div>
    </div>

    <?php include "module/include/footer.php"; ?>
    
    <?php include "module/include/javascript.php"; ?>

    <?php if($rest_sistem['result']['midtrans_tipekey']=='production') { ?>
    <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="<?=$rest_sistem['result']['midtrans_clientkey'];?>"></script>
    <?php }else{ ?>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?=$rest_sistem['result']['midtrans_clientkey'];?>"></script>
    <?php } ?>

    <script type="text/javascript">

      var itipepay = "<?=$rest_sistem['result']['metode_pembayaran'];?>";

      $(document).ready(function(){
        if (itipepay=='tripay') {
          getmPaymentTripay();
        }
      });

      function getmPaymentTripay() {
        $('#payment_tripay').html('<div class="mb-2">Loading...</div>');
        $.get('<?=$main_url;?>module/action.php?jen=metode_tripay', function(data) {
          $('#payment_tripay').html(data);
          if (data.substr(0, 3)=='ERR') {
            setTimeout(function(){
              getmPaymentTripay();
            }, 2000);
          }
        });
      }

      function topupSaldo(){
        $('#myModalTopupsaldo').modal('toggle');
      }

      function tarikSaldo(){
        $('#myModalTariksaldo').modal('toggle');
      }

      function modalDetailtsaldo(a){
        $('#mymodalDetailtsaldo').modal('toggle');
        modalDetailtsaldoform(a);
      }

    function modalDetailtsaldoform(a) {
      $.get("<?=$main_url;?>module/action.php?jen=modal_detail_tarik_saldo&uid="+a, function(data) {
        $('#mymodalDetailtsaldores').html(data);
      });
    }

      function goTarikSaldo(){

        var nominalvtarik = $('#nominal_tarik').val();
        var saldouser = "<?=$rest_cust['saldo_num'];?>";
        var minsaldo = "<?=$rest_sistem['result']['min_tarik_saldo'];?>";

        if (!nominalvtarik){
          $('#infosebelumsubmitxtarik').html('<div class="alert alert-danger">Nominal tidak boleh kosong.</div>');
          return false;
        }else{

          if(parseInt(nominalvtarik)>parseInt(saldouser)){
            $('#infosebelumsubmitxtarik').html('<div class="alert alert-danger">Saldo tidak mencukupi</div>');
            return false;
          }

          if(parseInt(minsaldo)>parseInt(nominalvtarik)){
            $('#infosebelumsubmitxtarik').html('<div class="alert alert-danger">Minimal penarikan '+minsaldo+'</div>');
            return false;
          }

          $.confirm({
            title: 'Confirm!',
            content: 'Pastikan nominal yang di masukan benar!',
            theme: 'modern',
            closeIcon: true,
            draggable: false,
            animation: 'scale',
            type: 'dark',
            buttons: {
              Batal: function () {

              },
              Submit: function () {
                $('button').addClass('disabled');
                var formData = new FormData($("#form_tarik_akun_saldo")[0]);
                $.ajax({
                  type: "POST",
                  url: '<?=$main_url;?>module/action.php?jen=tarik_saldo_user',
                  data:  formData,
                  contentType: false,
                  cache: false,
                  processData:false,
                  success: function(result){
                    $('button').removeClass('disabled');
                    if(result=='y'){
                      document.body.scrollTop = 0;
                      document.documentElement.scrollTop = 0;
                      location.reload();
                    }else{
                      confirmGagal(result);
                    }
                  } 
                });
              }
            }
          });
        }
        }

      function goTopupSaldo(){

        var nominalv = $('#nominal_topup').val();

        if (!nominalv){
          $('#infosebelumsubmitx').html('<div class="alert alert-danger">Nominal tidak boleh kosong.</div>');
          return false;
        }else{
          $.confirm({
            title: 'Confirm!',
            content: 'Pastikan nominal yang di masukan benar!',
            theme: 'modern',
            closeIcon: true,
            draggable: false,
            animation: 'scale',
            type: 'dark',
            buttons: {
              Batal: function () {

              },
              Submit: function () {
                $('button').addClass('disabled');
                if (itipepay=='midtrans'){
                  $.ajax({
                    url: '<?=$main_url;?>module/action.php?jen=snap_token_midtrans_topup&nominalv='+nominalv,
                    cache: false,
                    success: function(result){
                      console.log(result);
                      var res = result.split('~');
                      $('button').removeClass('disabled');
                      if (res[0]=='y') { // success
                        var obj = JSON.parse(res[2]);
                        snap.pay(obj.snapMidtrans, {
                          autoCloseDelay: 2,
                          onSuccess: function(resultmid){
                            var objmid = JSON.stringify(resultmid);
                            prosestopupCheckout(obj.uniquecode,objmid,'y',nominalv);
                          },
                          onPending: function(resultmid){
                            var objmid = JSON.stringify(resultmid);
                            prosestopupCheckout(obj.uniquecode,objmid,'p',nominalv);
                          },
                          onError: function(resultmid){
                            document.location='<?=$main_url;?>topup/error';
                          },
                          onClose: function(){
                            document.body.scrollTop = 0;
                            document.documentElement.scrollTop = 0;
                            console.log('close snap!')
                          }
                        });
                      }else{
                        confirmGagal(res[1],'reload');
                      }
                    } 
                  });
                }else if (itipepay=='tripay'){
                  var tripay_code = $('#tripay_codex').val();
                  prosestopupCheckout('tripay',tripay_code,'p',nominalv);
                }else{
                  prosestopupCheckout('manual','manual','p',nominalv);
                }
              }
            }
          });
        }
      }

      function prosestopupCheckout(c,d,e,f){
        if (e=='y' || e=='p') {
          $.ajax({
            type : "POST",
            url : "<?=$main_url;?>module/action.php?jen=simpan_topup_saldo",
            data :  { 'idunique' : c, 'snapobj' : d, 'statuspay' : e, 'nominaltopup' : f },
            success: function (result) {
              var res = result.split('~');
              if (res[0]=='y') {
                if(e=='y' || e=='p'){
                  document.location='<?=$main_url;?>topup/'+res[2];
                }else{
                  document.location='<?=$main_url;?>topup/error';
                }
              }else{
                confirmGagal(res[1],'reload');
              }
            }
          });
        }else{
          document.location='<?=$main_url;?>topup/error';
        }
      }
    </script>

  </body>
</html>