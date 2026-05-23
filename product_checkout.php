<?php include "module/module.php"; ?>
<?php 
  if (!isset($_SESSION['XID_ARRAY'])) { header("Location: ".$main_url); exit(); } 
  if($_SESSION['XID_ARRAY']['cust_id']=='guest'){
    $idnya = $_SESSION['XID_ARRAY']['unique_guest'];
  }else{
    $idnya = $_SESSION['XID_ARRAY']['cust_id'];
  }
?>
<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <meta name="keywords" content="<?=$rest_sistem['result']['meta_keywords'];?>">

    <meta property="og:title" content="Checkout">
    <meta property="og:description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <?php if (file_exists($main_imgurl.'thumbnails/'.$rest_sistem['result']['logo_toko_image'])){ ?>
    <meta property="og:image" content="<?=$main_imgurl.'thumbnails/'.$rest_sistem['result']['logo_toko_image'];?>">
    <?php }else{ ?>
    <meta property="og:image" content="<?=$main_imgurl.'logo/'.$rest_sistem['result']['logo_toko_image'];?>">
    <?php } ?>
    <meta property="og:url" content="<?=$main_url;?>v/checkout">
    
    <?php include "module/include/style.php"; ?>

    <title>Checkout</title>
  </head>
  <body>

    <?php include "module/include/header.php"; ?>

    <section id="" class="bg-container-2 mt-4 mb-30">
      <div class="title-category pb-3 border-bot-d font-weight-bold ft-14">
        <a href="<?=$main_url;?>">Home</a>
        &nbsp;>&nbsp;
        <?php if($_SESSION['XID_ARRAY']['cust_id']=='guest'){ ?>
        Guest / Tamu
        <?php }else{ ?>
        <a href="<?=$main_url;?>account"><?=$rest_cust['result']['cust_nama'];?></a>
        <?php } ?>
        &nbsp;>&nbsp;
        Checkout
      </div>
    </section>

    <?php
      // tambahan kurir lokal
      $arr = array('tipe' => 'all', 'lang' => 'en');
      $rest_k_lokal = loadData('rest_load/load_kurir_lokal/',$arr);
      // end tambahan kurir lokal
    ?>

    <?php 
      $arr = array('tipe' => 'all', 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'lang' => 'en');
      $rest_alamat = loadData('rest_load/load_alamat_customer/',$arr);
    ?>

    <?php
      $arr = array('tipe' => 'web', 'idcust' => $idnya, 'lang' => 'en');
      $rest_val_c = loadData('rest_load/load_cart/', $arr);

      $digitalonly = $rest_val_c['digitalonly'];

    ?>

    <section class="bg-container-2 mb-5">

      <?php 
        if (isset($_SESSION['trxidunique_msg']) && $_SESSION['trxidunique_msg'] <> '') {
            echo '<div class="alert alert-danger mb-4">'.$_SESSION['trxidunique_msg'].'</div>';
        }
        $_SESSION['trxidunique_msg'] = '';
      ?>

      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
          <div class="produk_detail">
            <form id="form_p_cart_checkout" action="javascript:snapPayprocess()" method="POST">
              <div class="row <?php if ($digitalonly=='y') { echo 'justify-content-center'; } ?>">
              <?php if ($digitalonly=='y') { ?>
                <div class="col-xl-8 col-lg-7 mb-2">
                  <div class="alert alert-info">
                    Produk Digital akan langsung diterima ketika Anda sudah menyelesaikan pembayaran.
                  </div>
                  <div class="text-center pt-3">
                    <div class="row text-center">
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                        <div class="form-group mb-2 text-left">
                          <label class="ft-14">Nama Lengkap</label>
                          <input type="text" class="form-control ft-16" name="nama_penerima" id="nama_penerima" required="" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                        <div class="form-group mb-2 text-left">
                          <label class="ft-14">Nomor Penerima / WhatsApp</label>
                          <input type="text" class="form-control ft-16" name="ponsel_penerima" id="ponsel_penerima" required="" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                        <div class="form-group mb-2 text-left">
                          <label class="ft-14">Email</label>
                          <input type="email" class="form-control ft-16" name="emailpemenerima" id="emailpemenerima" required="" autocomplete="off" value="">
                          <div class="small mt-1">Email ini untuk notifikasi pemesanan.</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php }else{ ?>
                <div class="col-xl-8 col-lg-7 mb-2">

                  <?php if ($digitalonly=='n' && $rest_val_c['digital_count']>0) { ?>
                  <div class="alert alert-info">
                    Produk Digital akan langsung diterima ketika Anda sudah menyelesaikan pembayaran.
                  </div>
                  <?php } ?>

                  <div class="border-bottom-dashed1 pb-10">
                    <div class="detail_pd ft-16 font-weight-bold">
                      &mdash; Alamat Pengiriman &mdash;
                    </div>
                  </div>
                  <div class="pb-4 w-100">
                    <?php if ($digitalonly=='n') { ?>
                    <?php if ($_SESSION['XID_ARRAY']['cust_id']!='guest') { ?>
                    <div class="font-weight-bold color-app mt-3 mb-3">
                      <select class="selectpicker border-radius-5 mr-2" name="alamat_id" data-live-search="true" title="-- Pilih --" required="" onchange="changeAlamat(this.value)">
                        <?php 
                          foreach($rest_alamat['result'] as $obj) { 
                          if($rest_alamat['iselected']['cust_det_id']==$obj['cust_det_id']){
                            $oksip ='selected';
                          }else{
                            $oksip ='';
                          }
                        ?>
                        <option value="<?=$obj['cust_det_id'];?>" <?=$oksip;?>><?=$obj['label_alamat'];?></option>
                        <?php } ?>
                      </select>
                      <button type="button" onclick="actionAlamat('add')" class="btn btn-outline-primary ft-14 border-d border-radius-5 height-38"><i class="fa fa-plus"></i>&nbsp;&nbsp;Alamat</button>
                    </div>
                    <?php } ?>
                    <?php } ?>
                    <?php if ($rest_alamat['nums']>0) { ?>
                    <div class="alamat_nya_my_send padding-10-15 rounded-2 border-d" id="alamat_nya_my_send" style="background: #f3f4f5;">
                      <div class="ft-14 font-weight-bold mb-1">
                        <?=$rest_alamat['iselected']['label_alamat'];?>
                        <span class="float-right"><span class="icon-pencil-square-o c-pointer" onclick="actionAlamat('edit','<?=$rest_alamat['iselected']['cust_det_id']?>')"></span></span>
                      </div>
                      <div class="ft-14">Penerima : <?=$rest_alamat['iselected']['nama_penerima'];?></div>
                      <div class="ft-14"><?=$rest_alamat['iselected']['alamat_lengkap'];?>, 
                        <span class="text-lowercase"><?=$rest_alamat['iselected']['nama_provinsi'];?>, <?=$rest_alamat['iselected']['nama_kabkot'];?> - <?=$rest_alamat['iselected']['kodepos'];?></span>
                      </div>
                      <div class="ft-14">Nomor yang dapat di hubungi <?=$rest_alamat['iselected']['ponsel_penerima'];?></div>
                      <input type="hidden" id="idkbakot_id" value="<?=$rest_alamat['iselected']['id_kabkot']?>">
                      <input type="hidden" id="idkeckec_id" value="<?=$rest_alamat['iselected']['id_kec']?>">
                      <input type="hidden" id="cust_det_id" value="<?=$rest_alamat['iselected']['cust_det_id']?>">
                    </div>
                    <?php }else{ ?>
                      <?php if ($_SESSION['XID_ARRAY']['cust_id']=='guest') { ?>
                        <div class="text-center pt-3">
                          <div class="row text-center">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                              <div class="form-group mb-2 text-left">
                                <label class="ft-14">Nama Lengkap</label>
                                <input type="text" class="form-control ft-16" name="nama_penerima" id="nama_penerima" required="" autocomplete="off">
                              </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                              <div class="form-group mb-2 text-left">
                                <label class="ft-14">Nomor Penerima / WhatsApp</label>
                                <input type="text" class="form-control ft-16" name="ponsel_penerima" id="ponsel_penerima" required="" autocomplete="off">
                              </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                              <div class="form-group mb-2 text-left">
                                <label class="ft-14">Provinsi</label>
                                <?php 
                                  $arr = array('id' => 'n', 'lang' => 'en');
                                  $rest_prov = loadData('rest_load/load_provinsi/', $arr);
                                ?>
                                <select name='provinsi_id_ex_guest' id='provinsi_id_ex_guest' class='form-control selectpicker' data-live-search="true" title="-- Pilih --" required="">
                                  <?php foreach($rest_prov['result'] as $obj) { 
                                    if($rest_val['result']['id_provinsi']==$obj['province_id']){
                                        $oksip ='selected';
                                    }else{
                                        $oksip ='';
                                    }
                                    echo "<option value='".$obj['province_id']."*".$obj['province']."' $oksip>".$obj['province']."</option>";
                                  } ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                              <div class="form-group mb-2 text-left" id="kabupaten_kota_id_ex_guest">
                                <label class="ft-14">Kabupaten / Kota</label>
                                <select name='kabkot_id_ex' id='kabupaten_kota_id_eexx' class='form-control selectpicker' data-live-search="true" title="--" required="">
                                </select>
                              </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                              <div class="form-group mb-2 text-left" id="kecamatan_id_ex_guest">
                                <label class="ft-14">Kecamatan</label>
                                <select name='kec_id_ex' id='kecamatan_id_eexx' class='form-control selectpicker' data-live-search="true" title="--" required="">
                                </select>
                              </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                              <div class="form-group mb-2 text-left">
                                <label class="ft-14">Kodepos</label>
                                <input type="text" class="form-control ft-16" name="kode_pos_ex" id="kode_pos_ex" required="" autocomplete="off" value="">
                              </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                              <div class="form-group mb-2 text-left">
                                <label class="ft-14">Email</label>
                                <input type="email" class="form-control ft-16" name="emailpemenerima" id="emailpemenerima" required="" autocomplete="off" value="">
                                <div class="small mt-1">Email ini untuk notifikasi pemesanan.</div>
                              </div>
                            </div>
                            <div class="col-xl-12 col-lg-12">
                              <div class="form-group mb-2 text-left">
                                <label class="ft-14">Alamat Lengkap</label>
                                <textarea type="text" class="form-control ft-16" name="alamat_lengkap" id="alamat_lengkap" required="" rows="3"></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php }else{ ?>
                      <div class="alamat_nya_my_send padding-10-15 rounded-2 border-d" style="background: #f3f4f5;">
                        <div class="ft-14 font-weight-bold mb-1">
                          Tidak ada alamat tersimpan
                        </div>
                        <div class="ft-14">Tambah alamat untuk melanjutkan.</div>
                      </div>
                      <?php } ?>
                    <?php } ?>
                  </div>
                  <div class="border-bottom-dashed1 pb-10 pt-10">
                    <div class="detail_pd ft-16 font-weight-bold">
                      &mdash; Kurir Pengiriman &mdash;
                    </div>
                  </div>
                  <div class="font-weight-bold color-app mt-3 mb-3">
                    <div class="row">
                      <div class="col-xl-12 col-lg-12">
                        <select id="kurir_idmy" class="form-control border-d border-radius-5" name="kurir_id" required="" onchange="selectKurir(this.value)">
                          <option value="">-- Pilih Kurir --</option>
                          <?php foreach($rest_k_lokal['kurir'] as $obj) {  ?>
                          <option value="<?=$obj['kode'];?>"><?=$obj['nama'];?></option>
                          <?php } ?>
                          <!-- // tambahan kurir lokal -->
                          <?php foreach($rest_k_lokal['result'] as $obj) {  ?>
                          <option value="<?=$obj['kurir_kode'];?>"><?=$obj['kurir_nama'];?></option>
                          <?php } ?>
                          <!-- // end tambahan kurir lokal -->
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="" id="rajaongkir_pilihan_kurir"></div>
                </div>
                <?php } ?>
                <div class="col-xl-4 col-lg-5 mb-4">
                  <div class="">
                    <div class="bg-putih">
                      <div class="border-bottom-dashed1 mb-4 mt-15 d-none-991"></div>
                      <div class="border-d rounded-2 padding-10-15">
                        <div class="font-weight-bold ft-16 mb-3">Keranjang</div>
                        <div class="padding-0-15_">
                          <div class="row">
                            <?php if ($rest_val_c['items_count']>0) { ?>
                            <?php foreach($rest_val_c['result'] as $obj) { ?>
                              <div class="col-xl-12 col-lg-12 mb-3">
                                <div class="d-flex align-items-c_">
                                  <a href="<?=$main_url;?>p/<?=$obj['url_produk'];?>" class="mr-3">
                                    <div class="bg_cart-set-2 rounded-2" style="background: url('<?=$main_imgurl.'products/'.$obj['logo_image'];?>');"></div>
                                  </a>
                                  <div class="text-left">
                                    <div class="media-title ft-14 font-weight-600 color-dark"> 
                                      <a href="<?=$main_url;?>p/<?=$obj['url_produk'];?>" class="color-dark">
                                        <?=$obj['nama_produk'];?>
                                      </a>
                                      <span class="p-absolute ft-14 c-pointer del-cart-p" onclick="myModalCartItem('<?=$obj['cart_id'];?>','reload')" style="right: 35px;"><span class="icon-pencil"></span></span>
                                      <span class="p-absolute right-15 ft-14 c-pointer del-cart-p" onclick="gohapusCart('<?=$obj['cart_id'];?>','reload')"><span class="icon-trash-o"></span></span>
                                    </div>
                                    
                                    <div class="media-title ft-14 color-semidark-m"> 
                                      <?php if ($obj['is_digital']=='y') { ?>
                                        Produk Digital
                                      <?php }else{ ?>
                                      Varian : <?=$obj['varian'];?>
                                      <?php } ?>
                                    </div>
                                    <?php if ($obj['tstok']=='y') { ?>
                                    <div class="media-title ft-14 color-semidark-m"> 
                                      <?=$obj['harga_produk'];?>
                                      <span class="p-absolute right-15">x<?=$obj['jumlah_beli'];?></span>
                                    </div>
                                    <div class="media-title ft-14 color-semidark-m"> 
                                      Catatan : <?=$obj['catatan_beli'];?>
                                    </div>
                                    <div class="media-title ft-14 color-dark font-weight-600"> 
                                      Subtotal : <?=$obj['harga_produk_q'];?>
                                    </div>
                                    <?php } ?>
                                    <?php if ($obj['tstok']!='y') { ?>
                                      <span class="p-absolute right-15 ft-14 color-semidark-m">x<?=$obj['jumlah_beli'];?></span>
                                      <div class="media-title ft-14 color-danger mr-1"> 
                                        <?=$obj['tstok'];?>
                                      </div>
                                    <?php } ?>
                                  </div>
                                </div>
                              </div>
                            <?php } ?>
                            
                            <div class="col-xl-12 col-lg-12">
                              <div class="text-left">
                                <hr>
                                  <div class="ft-14">
                                    Subtotal 
                                    <span class="float-right"><?=substr($rest_val_c['total_bayar'],3);?></span>
                                  </div>
                                  <div class="ft-14">
                                    Ongkos Kirim 
                                    <span class="float-right" id="harga_ongkir_pay_id">0</span>
                                  </div>
                                  <div class="ft-14">
                                    Potongan Voucher 
                                    <span class="float-right color-danger" id="harga_voucher_pay_id">0</span>
                                  </div>
                                  <div class="font-weight-600 ft-16">
                                    Total Pembayaran
                                    <span class="float-right" id="total_h_pay_id"><?=$rest_val_c['total_bayar'];?></span>
                                  </div>
                                <hr>
                              </div>
                              <div class="">
                                <div id="infosebelumsubmit"></div>
                              </div>
                              <div class="">
                                <?php if ((isset($_SESSION['XID_ARRAY']) && $_SESSION['XID_ARRAY']['cust_id']!='guest') && ($rest_cust['result']['cust_nama']=='' || $rest_cust['result']['cust_ponsel']=='' || $rest_cust['result']['is_token']=='')){ ?>
                                <div class="alert alert-danger c-pointer" onclick="myModaleditProfil();">Lengkapi data informasi untuk melanjutkan belanja. Klik untuk melengkapi.</div>
                                <?php }else{ ?>
                                <?php if ($_SESSION['XID_ARRAY']['cust_id']!='guest' && $rest_sistem['result']['fitur_saldo']=='y') { ?>
                                  <div class="form-group mb-3">
                                    <div class="pb-2">
                                      <span class="ft-12">Saldo :</span> 
                                      <span class="color-dark font-weight-500 ft-14"><?=$rest_cust['saldo'];?></span>
                                    </div>
                                    <select class="selectpicker form-control border-radius-5" name="tipe_payment" title="-- Metode Pembayaran --" required="" id="tipe_payment" onchange="checkSaldo()">
                                      <option value="bank">Bank Transfer / VA</option>
                                      <option value="saldo">Saldo</option>
                                    </select>
                                  </div>
                                  <?php }else{ ?>
                                  <input type="hidden" name="tipe_payment" id="tipe_payment" value="bank">
                                <?php } ?>

                                <div id="payment_tripay"></div>

                                <div class="form-group text-left">
                                  <textarea type="text" class="form-control ft-14" name="catatan_trx" id="catatan_trx" placeholder="Catatan..." rows="2"></textarea>
                                </div>
                                <?php if(isset($_SESSION['XID_ARRAY']) && $_SESSION['XID_ARRAY']['cust_id']=='guest'){ ?>
                                <div class="form-group text-left">
                                  <div class="input-group">
                                    <input type="text" class="form-control ft-14" name="kode_voucher_icust" id="kode_voucher_icust" placeholder="Login Untuk Menggunakan Voucher" autocomplete="off" disabled>
                                  </div>
                                </div>
                                <?php }else{ ?>
                                <div class="form-group text-left">
                                  <div class="ft-12" id="voucher_nya_my_send"></div>
                                  <div class="input-group">
                                    <input type="text" class="form-control ft-14" name="kode_voucher_icust" id="kode_voucher_icust" placeholder="Masukan Kode Voucher" autocomplete="off" onkeyup="checkVoucher(this.value)">
                                    <div class="input-group-append">
                                      <button class="btn btn-app height-35" type="button" onclick="checkVoucher(kode_voucher_icust.value)"><span class="icon-check"></span></button>
                                    </div>
                                  </div>
                                </div>
                                <div id="alertnotiflblsaldopay"></div>
                                <?php } ?>
                                <button type="submit" id="submitpayproses" class="btn btn-primary ft-14 border-d border-radius-5 btn-block"><span id="submitpayprosesxid">Proses Pembayaran</span> </button>
                                <?php } ?>
                              </div>
                            </div>
                            
                            <?php }else{ ?>
                              <div class="col-xl-12 col-lg-12">
                                <div class="padding-15">
                                  <img src="<?=$main_imgurl;?>logo/<?=$rest_sistem['result']['empty_cart_image'];?>" class="img-fluid">
                                </div>
                              </div>
                            <?php } ?>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <?php include "module/include/footer.php"; ?>
    
    <?php include "module/include/javascript.php"; ?>
    <?php if($rest_sistem['result']['midtrans_tipekey']=='production') { ?>
    <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="<?=$rest_sistem['result']['midtrans_clientkey'];?>"></script>
    <?php }else{ ?>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?=$rest_sistem['result']['midtrans_clientkey'];?>"></script>
    <?php } ?>

    <script type="text/javascript">

      var total_bayar = "<?=$rest_val_c['total_bayar_num'];?>";
      var total_ongkir = 0;
      var total_voucher = 0;

      var grand_total_bayar = "<?=$rest_val_c['total_bayar_num'];?>";

      var fitur_saldo = "<?=$rest_sistem['result']['fitur_saldo'];?>";

      var itipepay = "<?=$rest_sistem['result']['metode_pembayaran'];?>";

      var digitalonly = '<?=$digitalonly;?>';


      $(document).ready(function(){
        $('#provinsi_id_ex_guest').change(function(){
          var prov = $('#provinsi_id_ex_guest').val();
          id_prov = prov.split("*");
          $("#kabupaten_kota_id_ex_guest").html('<label class="">Loading...</label>');
          $.get('<?=$main_url;?>module/action.php?jen=load_kabkot&prov_id='+id_prov[0]+'&tipe=0&idalamat=0', function(data) {
            $("#kabupaten_kota_id_ex_guest").html(data);
          });
        });
      });

      $(document).ready(function(){
        $("#kurir_idmy").val('');

        setTimeout(function(){
        if ('<?=$digitalonly;?>'=='y') { 
          $("#kurir_idmy").prop('required',false);
          $('#kurir_idmy').removeAttr('required');
        }
        }, 500);

        if (itipepay=='tripay' && fitur_saldo=='n') {
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

      function checkSaldo(x = 'n') {
        if (fitur_saldo=='y') {
          var a = $('#tipe_payment').val();
          var saldo = "<?=$rest_cust['saldo_num'];?>";
          if (a=='saldo') {
            if (parseInt(saldo)>=parseInt(grand_total_bayar)) {
              $('#submitpayproses').removeClass('disabled-x');
              $('#alertnotiflblsaldopay').html('');
            }else{
              $('#submitpayproses').addClass('disabled-x');
              $('#alertnotiflblsaldopay').html('<div class="color-danger mb-3">Saldo tidak mencukupi.</div>');
            }
            $('#payment_tripay').html('');
          }else{
            $('#submitpayproses').removeClass('disabled-x');
            $('#alertnotiflblsaldopay').html('');
            if (a!='' && itipepay=='tripay' && x=='n') {
              getmPaymentTripay();
            }
          }
        }
      }

      function changeAlamat(a) {
        $('#alamat_nya_my_send').html('Loading...');
        $.get('<?=$main_url;?>module/action.php?jen=change_my_alamat&idalamat='+a, function(data) {
            $("#kurir_idmy").val('');
            $("#rajaongkir_pilihan_kurir").html('');
            $('#alamat_nya_my_send').html(data);
        });
      }

      function checkVoucher(a) {
        $('#voucher_nya_my_send').html('<div class="mb-2">Loading...</div>');
        $.get('<?=$main_url;?>module/action.php?jen=check_voucher&kode='+a+'&total_bayar='+total_bayar, function(data) {
          var res_v = data.split('~');
          if (res_v[0]=='y') {
            total_voucher = res_v[1];
            $("#voucher_nya_my_send").html('');
            $('#harga_voucher_pay_id').html('-'+formatRupiah(res_v[1]));

            grand_total_bayar = parseInt(total_bayar)+parseInt(total_ongkir)-parseInt(res_v[1]);
            $('#total_h_pay_id').html(formatRupiah(grand_total_bayar));
          }else{
            total_voucher = 0;
            $('#voucher_nya_my_send').html('<div class="mb-2 color-danger">'+res_v[0]+'</div>');
            $('#harga_voucher_pay_id').html(0);

            grand_total_bayar = parseInt(total_bayar)+parseInt(total_ongkir);
            $('#total_h_pay_id').html(formatRupiah(grand_total_bayar));
          }

          checkSaldo('x');
        });
      }

      function selectKurir(a){
        $("#rajaongkir_pilihan_kurir").html('Loading...');
        <?php if($_SESSION['XID_ARRAY']['cust_id']=='guest'){ ?>
        var keckec   = $('#kecamatan_id_eexx').val();
        keckec = keckec.split("*");
        keckec = keckec[0];
        <?php }else{ ?>
        var keckec   = $('#idkeckec_id').val();
        <?php } ?>
        var kurir = $('#kurir_idmy').val();
        $.ajax({
          type : 'POST',
          url : '<?=$main_url;?>module/action.php?jen=raja_ongkir_cari_kurir',
          data :  { 'kabkot_id' : keckec, 'kurir_id' : kurir },
          success: function (data) {
            $("#rajaongkir_pilihan_kurir").html(data);
          }
        });
      }

      function selectKurirv2(a,b){
        total_ongkir = b;
        $("#ku"+a).prop("checked", true);
        $('#kurir_yg_dipilih_fix').val(a);
        $('#harga_ongkir_pay_id').html(formatRupiah(b));
        grand_total_bayar = parseInt(total_bayar)+parseInt(b)-parseInt(total_voucher);
        $('#total_h_pay_id').html(formatRupiah(grand_total_bayar));

        checkSaldo();
      }

      function snapPayprocess(){
        var kabkot = $('#idkbakot_id').val();
        var keckec = $('#idkeckec_id').val();
        var alamatid = $('#cust_det_id').val();
        var jeniskurir = $('#kurir_idmy').val();
        var kurirdipilih = $('#kurir_yg_dipilih_fix').val(); // kuririd

        var kodevoucher = $('#kode_voucher_icust').val();
        var catatan_trx = $('#catatan_trx').val();

        var metodepembayaran = $('#tipe_payment').val();

        var nama = '';
        var nomor = '';
        var nama_provinsi = '';
        var nama_kabkot = '';
        var kodepos = '';
        var alamat = '';
        var email = '';

        <?php if(isset($_SESSION['XID_ARRAY']) && $_SESSION['XID_ARRAY']['cust_id']=='guest'){ ?>
          alamatid = 'guest';
          kodevoucher = '';

          if(digitalonly=='y'){
            var splitkabkot   = '-*-';
            splitkabkot   = splitkabkot.split("*");
            kabkot        = splitkabkot[0];
            
            var splitkecc   = '-*-';
            splitkecc       = splitkecc.split("*");
            keckec          = splitkecc[0];
  
            var splitprov   = '-*-';
            splitprov   = splitprov.split("*");
            kodepos = '';
            alamat = '';
          }else{
            var splitkabkot = $('#kabupaten_kota_id_eexx').val();
            splitkabkot     = splitkabkot.split("*");
            kabkot          = splitkabkot[0];
            
            var splitkecc   = $('#kecamatan_id_eexx').val();
            splitkecc       = splitkecc.split("*");
            keckec          = splitkecc[0];
  
            var splitprov   = $('#provinsi_id_ex_guest').val();
            splitprov   = splitprov.split("*");
            kodepos = $('#kode_pos_ex').val();
            alamat = $('#alamat_lengkap').val();
          }
          
          nama = $('#nama_penerima').val();
          nomor = $('#ponsel_penerima').val();
          nama_provinsi = splitprov[1];
          nama_kabkot = splitkabkot[1];
          email = $('#emailpemenerima').val();
        <?php } ?>

        if (!kabkot && digitalonly=='n'){
          $('#infosebelumsubmit').html('<div class="alert alert-danger">Gagal memuat data, refresh browser dan coba lagi.</div>');
          return false;
        }else if (!keckec && digitalonly=='n'){
          $('#infosebelumsubmit').html('<div class="alert alert-danger">Gagal memuat data, refresh browser dan coba lagi.</div>');
          return false;
        }else if(!alamatid && digitalonly=='n'){
          $('#infosebelumsubmit').html('<div class="alert alert-danger">Alamat tidak terbaca, pilih atau tambah alamat baru dan silahkan coba lagi.</div>');
          return false;
        }else if(!jeniskurir && digitalonly=='n'){
          $('#infosebelumsubmit').html('<div class="alert alert-danger">Ekspedisi atau jenis pengiriman belum di pilih.</div>');
          return false;
        }else if(!kurirdipilih && digitalonly=='n'){
          $('#infosebelumsubmit').html('<div class="alert alert-danger">Kurir belum di pilih.</div>');
          return false;
        }else if(!metodepembayaran){
          $('#infosebelumsubmit').html('<div class="alert alert-danger">Metode pembayaran belum di pilih.</div>');
          return false;
        }else{

          if (metodepembayaran=='bank' || metodepembayaran=='saldo') {
            $.confirm({
              title: 'Confirm!',
              content: 'Pastikan orderan dan alamat pengiriman yang di masukan sudah benar!',
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
                  if ((itipepay=='midtrans' && metodepembayaran=='bank') && jeniskurir!='klokal1'){
                    $.ajax({
                      url: '<?=$main_url;?>module/action.php?jen=snap_token_midtrans&idalamat='+alamatid+'&idkurir='+kurirdipilih+'&kodevoucher='+kodevoucher+'&digitalonly='+digitalonly+'&nama='+nama+'&nomor='+nomor+'&nama_provinsi='+nama_provinsi+'&nama_kabkot='+nama_kabkot+'&kodepos='+kodepos+'&alamat='+alamat+'&email='+email,
                      cache: false,
                      success: function(result){
                        console.log(result);
                        var res = result.split('~');
                        $('button').removeClass('disabled');
                        if (res[0]=='y') { // success
                          var obj = JSON.parse(res[2]);
                          snap.pay(obj.snapMidtrans, {
                            autoCloseDelay: 3,
                            onSuccess: function(resultmid){
                              var objmid = JSON.stringify(resultmid);
                              prosescartCheckout(alamatid,kurirdipilih,obj.uniquecode,objmid,'y',kodevoucher,metodepembayaran);
                            },
                            onPending: function(resultmid){
                              var objmid = JSON.stringify(resultmid);
                              prosescartCheckout(alamatid,kurirdipilih,obj.uniquecode,objmid,'p',kodevoucher,metodepembayaran);
                            },
                            onError: function(resultmid){
                              document.location='<?=$main_url;?>payment/error/';
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
                  }else if (itipepay=='tripay' && metodepembayaran=='bank'){
                    var tripay_code = $('#tripay_codex').val();
                    prosescartCheckout(alamatid,kurirdipilih,'tripay',tripay_code,'p',kodevoucher,metodepembayaran);
                  }else if (itipepay=='xendit' && metodepembayaran=='bank'){
                    prosescartCheckout(alamatid,kurirdipilih,'xendit','xendit','p',kodevoucher,metodepembayaran);
                  }else{
                    prosescartCheckout(alamatid,kurirdipilih,'manual','manual','p',kodevoucher,metodepembayaran);
                  }
                }
              }
            });
          }else{
            confirmGagal('Metode pembayaran tidak sesuai.','reload');
          }
        }
      }

      function prosescartCheckout(a,b,c,d,e,f,g){
        $('#submitpayprosesxid').html('Loading... mohon tidak meninggalkan halaman.');
        var catatan_trx = $('#catatan_trx').val();

        var nama = $('#nama_penerima').val();
        var nomor = $('#ponsel_penerima').val();
        var splitprov   = $('#provinsi_id_ex_guest').val();          
        var splitkabkot   = $('#kabupaten_kota_id_eexx').val();
        var splitkec   = $('#kecamatan_id_eexx').val();
        var kodepos = $('#kode_pos_ex').val();
        var alamat = $('#alamat_lengkap').val();
        var email = $('#emailpemenerima').val();

        if (e=='y' || e=='p') {
          $.ajax({
            type : "POST",
            url : "<?=$main_url;?>module/action.php?jen=simpan_transaksi",
            data :  { 'idalamat' : a, 'idkurir' : b, 'idunique' : c, 'snapobj' : d, 'statuspay' : e, 'kodevoucher' : f, 'potonganvoucher' : total_voucher, 'metodepembayaran' : g, 'digitalonly' : digitalonly, 'catatan_trx' : catatan_trx, 'nama' : nama, 'nomor' : nomor, 'splitprov' : splitprov, 'splitkabkot' : splitkabkot, 'splitkec' : splitkec, 'kodepos' : kodepos, 'alamat' : alamat, 'email' : email },
            success: function (result) {
              console.log(result);
              var res = result.split('~');
              if (res[0]=='y') { // success
                if(e=='y'){
                  document.location='<?=$main_url;?>payment/success/';
                }else if(e=='p'){ // pending blm bayar
                  document.location='<?=$main_url;?>payment/pending/';
                }else{
                  document.location='<?=$main_url;?>payment/error/';
                }
              }else{
                confirmGagal(res[1],'reload');
              }
            }
          });
        }else{
          document.location='<?=$main_url;?>payment/error/';
        }
      }
        
    </script>

  </body>
</html>