<div class="container-fluid" id="container-wrapper">
  <div class="row mb-3">
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-white"><?= $title; ?></h6>
        </div>
        <form id="tambahform" action="javascript:prosesDefault('pengaturan/sistem/proses','tambahform')" method="POST">
          <div class="card-body">
          <?= $this->session->flashdata('message'); ?>
            <div id="alertpassproses"></div>
            <div class="row">
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Diskon Semua Produk<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="global_diskon" value="<?=$sistem['global_diskon'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Metode Pembayaran<span style="color: red">*</span></label>
                  <select class="form-control" name="metode_pembayaran" required="">
                    <option value="midtrans" <?php if ($sistem['metode_pembayaran']=='midtrans') echo 'selected'; ?>>Midtrans</option>
                    <option value="tripay" <?php if ($sistem['metode_pembayaran']=='tripay') echo 'selected'; ?>>Tripay</option>
                    <option value="xendit" <?php if ($sistem['metode_pembayaran']=='xendit') echo 'selected'; ?>>Xendit</option>
                    <option value="manual" <?php if ($sistem['metode_pembayaran']=='manual') echo 'selected'; ?>>Transfer Manual</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Metode Ulasan Produk<span style="color: red">*</span></label>
                  <select class="form-control" name="metode_ulasan" required="">
                    <option value="konfirmasi" <?php if ($sistem['metode_ulasan']=='konfirmasi') echo 'selected'; ?>>Konfirmasi Ulasan</option>
                    <option value="auto" <?php if ($sistem['metode_ulasan']=='auto') echo 'selected'; ?>>Auto Publikasi</option>
                    <option value="off" <?php if ($sistem['metode_ulasan']=='off') echo 'selected'; ?>>Tidak Aktif</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Metode Rating Produk<span style="color: red">*</span></label>
                  <select class="form-control" name="metode_rating" required="">
                    <option value="konfirmasi" <?php if ($sistem['metode_rating']=='konfirmasi') echo 'selected'; ?>>Konfirmasi Rating</option>
                    <option value="auto" <?php if ($sistem['metode_rating']=='auto') echo 'selected'; ?>>Auto Publikasi</option>
                    <option value="off" <?php if ($sistem['metode_rating']=='off') echo 'selected'; ?>>Tidak Aktif</option>
                  </select>
                </div>
              </div>
              <!-- <div class="col-xl-12 col-lg-12">
                <div class="alert alert-primary">
                  Fitur Topup saat ini hanya tersedia untuk menggunakan jenis pembayaran "Manual Transfer", "Midtrans" dan "Tripay".
                </div>
              </div> -->
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Fitur Live Chat<span style="color: red">*</span></label>
                  <select class="form-control" name="fitur_chat" required="">
                    <option value="y" <?php if ($sistem['fitur_chat']=='y') echo 'selected'; ?>>Aktif</option>
                    <option value="n" <?php if ($sistem['fitur_chat']=='n') echo 'selected'; ?>>Tidak Aktif</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6 d-none">
                <div class="form-group">
                  <label>Login WhatsApp<span style="color: red">*</span></label>
                  <select class="form-control" name="login_whatsapp" required="">
                    <option value="y" <?php if ($sistem['login_whatsapp']=='y') echo 'selected'; ?>>Aktif</option>
                    <option value="n" <?php if ($sistem['login_whatsapp']=='n') echo 'selected'; ?>>Tidak Aktif</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Tipe Login<span style="color: red">*</span></label>
                  <select class="form-control" name="tipe_login" required="">
                    <option value="0" <?php if ($sistem['tipe_login']=='0') echo 'selected'; ?>>Modal/Popup</option>
                    <option value="1" <?php if ($sistem['tipe_login']=='1') echo 'selected'; ?>>Redirect</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Hilangkan Menu Produk Digital<span style="color: red">*</span></label>
                  <select class="form-control" name="is_hide_menu_digital" required="">
                    <option value="n" <?php if ($sistem['is_hide_menu_digital']=='n') echo 'selected'; ?>>Tidak</option>
                    <option value="y" <?php if ($sistem['is_hide_menu_digital']=='y') echo 'selected'; ?>>Ya, Hilangkan</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Label Home <?=$sistem['label_produk_lainnya_home'];?><span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="label_produk_lainnya_home" value="<?=$sistem['label_produk_lainnya_home'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label>Informasi Global (Semua Halaman)</label>
                  <input type="text" class="form-control" name="lbl_info_global" value="<?=$sistem['lbl_info_global'];?>" autocomplete="off">
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label>Informasi Global (Halaman Detail Transaksi)</label>
                  <input type="text" class="form-control" name="lbl_info_transaksi" value="<?=$sistem['lbl_info_transaksi'];?>" autocomplete="off">
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Kota Kecamatan Toko / Store<span style="color: red">*</span></label>
                  <select class="form-control selectpicker" name="origin_store" data-live-search="true" title="-- Pilih --" required="">
                    <?php foreach($city['result'] as $obj) {
                      $expl = explode("*", $sistem['origin_store']);
                      if($expl[0]==$obj['kec_id']){
                        $oksip ='selected';
                      }else{
                        $oksip ='';
                      }
                      echo "<option value='".$obj['kec_id']."*".$obj['kec_name']." - ".$obj['city_name']."' $oksip>".$obj['kec_name']." - ".$obj['city_name']."</option>";
                    } ?>
                  </select>
                </div>
              </div>
              <!-- // tambahan tambahan affiliate -->
              
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <h6 class="mt-3 mb-3 font-weight-bold">Affiliate Produk</h6>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group">
                    <label>Status Affiliate<span style="color: red">*</span></label>
                    <select class="form-control" name="fitur_saldo" required="">
                      <option value="y" <?php if ($sistem['fitur_saldo']=='y') echo 'selected'; ?>>Aktif</option>
                      <option value="n" <?php if ($sistem['fitur_saldo']=='n') echo 'selected'; ?>>Tidak Aktif</option>
                    </select>
                  </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group">
                    <label>Komisi Default (persentase %)<span style="color: red">*</span></label>
                    <input type="text" class="form-control" name="komisi_affiliate_produk" value="<?=$sistem['komisi_affiliate_produk'];?>" autocomplete="off" required="">
                  </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group">
                    <label>Minimal Penarikan<span style="color: red">*</span></label>
                    <input type="text" class="form-control" name="min_tarik_saldo" value="<?=$sistem['min_tarik_saldo'];?>" autocomplete="off" required="">
                  </div>
                </div>
                <!-- // end tambahan affiliate -->
              <div class="d-none">
                <!-- // tambahan kurir lokal -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <h6 class="mt-3 mb-3 font-weight-bold">Kurir Lokal</h6>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group">
                    <label>Label Kurir<span style="color: red">*</span></label>
                    <input type="text" class="form-control" name="kurir_nama" value="<?=$xkurir['kurir_nama'];?>" autocomplete="off" required="">
                  </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group">
                    <label>Harga Kurir<span style="color: red">*</span></label>
                    <input type="text" class="form-control" name="kurir_harga" value="<?=$xkurir['kurir_harga'];?>" autocomplete="off" required="">
                  </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4">
                  <div class="form-group">
                    <label>Status Kurir<span style="color: red">*</span></label>
                    <select class="form-control" name="is_status_k" required="">
                      <option value="y" <?php if ($xkurir['is_status']=='y') echo 'selected'; ?>>Aktif</option>
                      <option value="n" <?php if ($xkurir['is_status']=='n') echo 'selected'; ?>>Tidak Aktif</option>
                    </select>
                  </div>
                </div>
                <!-- // end tambahan kurir lokal -->
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <h6 class="mt-3 mb-3 font-weight-bold">API KEY Google Login</h6>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Client ID<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="google_client" value="<?=$sistem['google_client'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Secret ID<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="google_secret" value="<?=$sistem['google_secret'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <label>Redirect Url<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="google_redirect" value="<?=$sistem['google_redirect'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="alert alert-primary">Google key diatas adalah contoh sehingga tidak bisa digunakan di domain atau localhost lain.<br/>Cara mendapatkan google key bisa liat tutorial disini : <a href="https://www.mynotescode.com/form-login-google-php-mysql/" target="_blank" style="color: #fff; font-weight:bold;">https://www.mynotescode.com/form-login-google-php-mysql/</a></div>
              </div>
              <div class="d-none">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <h6 class="mt-3 mb-3 font-weight-bold">API KEY WABLAS</h6>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-12">
                  <div class="form-group">
                    <label>Status<span style="color: red">*</span></label>
                    <select class="form-control" name="status_wablas" required="">
                      <option value="y" <?php if ($sistem['status_wablas']=='y') echo 'selected'; ?>>Aktif</option>
                      <option value="n" <?php if ($sistem['status_wablas']=='n') echo 'selected'; ?>>Tidak Aktif</option>
                    </select>
                  </div>
                </div>
                <div class="col-xl-10 col-lg-10 col-md-8 col-sm-12">
                  <div class="form-group">
                    <label>API Key / Token</label>
                    <input type="text" class="form-control" name="api_token_wablas" value="<?=$sistem['api_token_wablas'];?>" autocomplete="off">
                  </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <div class="form-group">
                    <label>Server Wablas</label>
                    <input type="text" class="form-control" name="server_wablas" value="<?=$sistem['server_wablas'];?>" autocomplete="off">
                    <div class="mt-2">Server wablas yang diganti hanya bagian "eu.wablas.com" sesuaikan dengan server wablas yg kalian daftar.</div>
                  </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <div class="alert alert-primary">Wablas Api key diatas adalah contoh.<br/>Cara mendapatkan wablas key bisa daftar disini : <a href="https://wablas.com/" target="_blank" style="color: #fff; font-weight:bold;">https://wablas.com/</a></div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <h6 class="mt-3 mb-3 font-weight-bold">API KEY WATSAP</h6>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-12">
                  <div class="form-group">
                    <label>Status<span style="color: red">*</span></label>
                    <select class="form-control" name="status_watsap" required="">
                      <option value="y" <?php if ($sistem['status_watsap']=='y') echo 'selected'; ?>>Aktif</option>
                      <option value="n" <?php if ($sistem['status_watsap']=='n') echo 'selected'; ?>>Tidak Aktif</option>
                    </select>
                  </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-md-8 col-sm-12">
                  <div class="form-group">
                    <label>APP/API Key</label>
                    <input type="text" class="form-control" name="apikey_watsap" value="<?=$sistem['apikey_watsap'];?>" autocomplete="off">
                  </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-md-6 col-sm-12">
                  <div class="form-group">
                    <label>Auth Key</label>
                    <input type="text" class="form-control" name="iddevice_watsap" value="<?=$sistem['iddevice_watsap'];?>" autocomplete="off">
                  </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12">
                  <div class="form-group">
                    <label>Server Watsap</label>
                    <input type="text" class="form-control" name="server_watsap" value="<?=$sistem['server_watsap'];?>" autocomplete="off">
                  </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <div class="alert alert-primary">Cara mendapatkan watsap key bisa daftar disini : <a href="http://watsap.id/" target="_blank" style="color: #fff; font-weight:bold;">http://watsap.id/</a></div>
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <h6 class="mt-3 mb-3 font-weight-bold">API KEY MIDTRANS</h6>
              </div>
              <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4">
                <div class="form-group">
                  <label>Tipe&nbsp;Key<span style="color: red">*</span></label>
                  <select class="form-control" name="midtrans_tipekey" required="">
                    <option value="sanbox" <?php if ($sistem['midtrans_tipekey']=='sanbox') echo 'selected'; ?>>Sanbox</option>
                    <option value="production" <?php if ($sistem['midtrans_tipekey']=='production') echo 'selected'; ?>>Production</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-5 col-lg-5 col-md-4 col-sm-4">
                <div class="form-group">
                  <label>Client Key<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="midtrans_clientkey" value="<?=$sistem['midtrans_clientkey'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-5 col-lg-5 col-md-4 col-sm-4">
                <div class="form-group">
                  <label>Server Key<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="midtrans_serverkey" value="<?=$sistem['midtrans_serverkey'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                Gunakan API KEY Midtrans sesuai tipe yang digunakan.<br/>
                Jika Sanbox gunakan Key Sanbox dan Jika Production gunakan Key Production.<br/>
                Gunakan Client Key : "<span class="color-primary font-weight-bold">SB-Mid-client-dCsnwVpQWvonhARF</span>" sebagai contoh Sanbox.<br/>
                Gunakan Server Key : "<span class="color-primary font-weight-bold">SB-Mid-server-WpBrWxGX6O1vasr6jzFeLW1B</span>" sebagai contoh Sanbox.
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <h6 class="mt-3 mb-3 font-weight-bold">API KEY TRIPAY</h6>
              </div>
              <div class="col-xl-2 col-lg-2 col-md-4 col-sm-5">
                <div class="form-group">
                  <label>Tipe&nbsp;Key<span style="color: red">*</span></label>
                  <select class="form-control" name="tripay_tipekey" required="">
                    <option value="sanbox" <?php if ($sistem['tripay_tipekey']=='sanbox') echo 'selected'; ?>>Sanbox</option>
                    <option value="production" <?php if ($sistem['tripay_tipekey']=='production') echo 'selected'; ?>>Production</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-2 col-lg-3 col-md-8 col-sm-7">
                <div class="form-group">
                  <label>Kode Merchant<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="tripay_merchant" value="<?=$sistem['tripay_merchant'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-4 col-lg-3 col-md-6 col-sm-6">
                <div class="form-group">
                  <label>Api Key<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="tripay_apikey" value="<?=$sistem['tripay_apikey'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                <div class="form-group">
                  <label>Private Key<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="tripay_privatekey" value="<?=$sistem['tripay_privatekey'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                Gunakan API KEY Tripay sesuai tipe yang digunakan.<br/>
                Jika Sanbox gunakan Key Sanbox dan Jika Production gunakan Key Production.<br/>
                Daftar Tripay di situs resminya klik di sini <a href="https://tripay.co.id/?ref=TP22893">https://tripay.co.id</a><br/>
                Minimal Transaksi : Rp 10.000<br/>
                Maksimal Transaksi : Rp 5.000.000<br/>
                Khusus Untuk ALFAMART, ALFAMIDI, INDOMART : Rp 2.500.000<br/>

                <?php if ($sistem['tripay_apikey']!='-') { ?>
                <div class="mt-3">
                  <?php if ($tripay['result']['success']==true) { ?>
                  <div class="row">
                    <?php foreach($tripay['result']['data'] as $obj) { ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-6">
                      <label class="d-block c-pointer">
                        <div class="padding-15 mb-3 border-radius-5 border-d" style="background: #f3f4f5;">
                          <div class="ft-14 font-weight-bold">
                            <img src="<?=$obj['icon_url'];?>" class="img-fluid mr-2" width="40">
                            <?=$obj['name']?>
                          </div>
                        </div>
                      </label>
                    </div>
                    <?php } ?>
                  </div>
                  <?php }else{ echo "ERR: ".$tripay['result']['message']; } ?>
                </div>
                <?php } ?>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <h6 class="mt-3 mb-3 font-weight-bold">API KEY XENDIT</h6>
              </div>
              <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                <div class="form-group">
                  <label>Tipe&nbsp;Key<span style="color: red">*</span></label>
                  <select class="form-control" name="xendit_tipekey" required="">
                    <option value="sanbox" <?php if ($sistem['xendit_tipekey']=='sanbox') echo 'selected'; ?>>Sanbox/Test</option>
                    <option value="production" <?php if ($sistem['xendit_tipekey']=='production') echo 'selected'; ?>>Production/Live</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-9 col-lg-9 col-md-8 col-sm-7">
                <div class="form-group">
                  <label>Token Callback<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="xendit_callbank_token" value="<?=$sistem['xendit_callbank_token'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label>Public Key<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="xendit_publickey" value="<?=$sistem['xendit_publickey'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                  <label>Secret Key<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="xendit_secretkey" value="<?=$sistem['xendit_secretkey'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                Gunakan API KEY Xendit sesuai tipe yang digunakan.<br/>
                Jika Test gunakan Key Test dan Jika Live gunakan Key Live.<br/>
                Daftar Xendit di situs resminya klik di sini <a href="https://www.xendit.co/id/">https://www.xendit.co/id/</a>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <h6 class="mt-3 mb-3 font-weight-bold">API KEY RAJAONGKIR</h6>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                  <label>Key 1<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="api_ro1" value="<?=$sistem['api_ro1'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                  <label>Key 2 (opsional)</label>
                  <input type="text" class="form-control" name="api_ro2" value="<?=$sistem['api_ro2'];?>" autocomplete="off">
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                  <label>Key 3 (opsional)</label>
                  <input type="text" class="form-control" name="api_ro3" value="<?=$sistem['api_ro3'];?>" autocomplete="off">
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                  <label>Key 4 (opsional)</label>
                  <input type="text" class="form-control" name="api_ro4" value="<?=$sistem['api_ro4'];?>" autocomplete="off">
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                  <label>Key 5 (opsional)</label>
                  <input type="text" class="form-control" name="api_ro5" value="<?=$sistem['api_ro5'];?>" autocomplete="off">
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                <div class="form-group">
                  <label>Key 6 (opsional)</label>
                  <input type="text" class="form-control" name="api_ro6" value="<?=$sistem['api_ro6'];?>" autocomplete="off">
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                Api Key (Shipping Cost) Tipe = Starter (Gratis) Limit Harian 100/day.<br/>
                Untuk mendapatkan Api Key (Shipping Cost) daftar di situs resminya klik di sini <a href="https://rajaongkir.com/">https://rajaongkir.com/</a>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <h6 class="mt-3 mb-3 font-weight-bold">KIRIM NOTIFIKASI TRANSAKSI EMAIL</h6>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                  <label>Status<span style="color: red">*</span></label>
                  <select class="form-control" name="kirim_transaksi_email" required="">
                    <option value="y" <?php if ($sistem['kirim_transaksi_email']=='y') echo 'selected'; ?>>Aktif</option>
                    <option value="n" <?php if ($sistem['kirim_transaksi_email']=='n') echo 'selected'; ?>>Tidak Aktif</option>
                  </select>
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                Pastikan jika mengaktifkan fitur notif ini <b>SMTP EMAIL</b> udah diisi sesuai dengan semestinya.<br>
                Bisa menggunakan SMTP Server Domain atau SMTP Gmail yang Gratis.
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <h6 class="mt-3 mb-3 font-weight-bold">SMTP EMAIL</h6>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>SMTP Host<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="smtp_host" value="<?=$sistem['smtp_host'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>SMTP Username (email domain)<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="smtp_username" value="<?=$sistem['smtp_username'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>SMTP Password<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="smtp_password" value="<?=$sistem['smtp_password'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>SMTP Secure<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="smtp_secure" value="<?=$sistem['smtp_secure'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>SMTP Port<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="smtp_port" value="<?=$sistem['smtp_port'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>SMTP Set From Nama<span style="color: red">*</span></label>
                  <input type="text" class="form-control" name="smtp_setnama" value="<?=$sistem['smtp_setnama'];?>" autocomplete="off" required="">
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>SMTP CC Email</label>
                  <input type="text" class="form-control" name="smtp_cc_email" value="<?=$sistem['smtp_cc_email'];?>" autocomplete="off">
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>SMTP BCC Email</label>
                  <input type="text" class="form-control" name="smtp_bcc_email" value="<?=$sistem['smtp_bcc_email'];?>" autocomplete="off">
                </div>
              </div>
              <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                  <label>Status Maintance<span style="color: red">*</span></label>
                  <select class="form-control" name="maintance" required="">
                    <option value="y" <?php if ($sistem['maintance']=='y') echo 'selected'; ?>>Yes</option>
                    <option value="n" <?php if ($sistem['maintance']=='n') echo 'selected'; ?>>No</option>
                  </select>
                </div>
              </div> -->
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