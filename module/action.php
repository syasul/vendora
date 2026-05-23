<?php 

	include "module.php";

	if ($_SERVER['SERVER_NAME']!='localhost' && !isset($_SESSION['KEY_CSRF'])) { exit(); }
	if ($_GET['jen']=='lupa_password') {

	    if ($_POST['email_address']!='') {

	    	$arr = array('emailaddress' => $_POST['email_address'], 'lang' => 'en');
	    	$rest_val = loadData('rest_proses/lupa_password/', $arr);

	    	if ($rest_val['success']==true) {
		    	$rest_val['success'] = 'y';
		    	$_SESSION['trxrpassl_msg'] = $rest_val['msg'];
		    }else{
		    	$rest_val['success'] = 'n';
		    }

		    echo $rest_val['success'].'~'.$rest_val['msg'];

	    }else{
		    echo 'n~Email tidak boleh kosong.';
		}

	}
	if ($_GET['jen']=='reset_password') {

	    if ($_POST['password_baru']==$_POST['password_confirm']) {

	    	$arr = array('uniqueid' => $_POST['unique_id'], 'password_baru' => $_POST['password_baru'], 'password_confirm' => $_POST['password_confirm'], 'lang' => 'en');
	    	$rest_val = loadData('rest_proses/reset_password/', $arr);

	    	if ($rest_val['success']==true) {
		    	$rest_val['success'] = 'y';
		    	$_SESSION['trxrpass_msg'] = $rest_val['msg'];
		    }else{
		    	$rest_val['success'] = 'n';
		    }

		    echo $rest_val['success'].'~'.$rest_val['msg'];

	    }else{
		    echo 'n~Ulangi password tidak sesuai.';
		}

	}
	if ($_GET['jen']=='check_voucher') {

	    $arr = array('kode' => $_GET['kode'], 'total_bayar' => $_GET['total_bayar'], 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'lang' => 'en');
	    $rest_val = loadData('rest_load/check_voucher/', $arr);

	    echo $rest_val['st'].'~'.$rest_val['nominal'];

	}
	if ($_GET['jen']=='product_action') {

	    $arr = array('tipe' => $_GET['tipe'], 'idproduk' => $_GET['idproduk'], 'idwarna' => $_GET['idwarna'], 'idukuran' => $_GET['idukuran'], 'lang' => 'en');
	    $rest_produk_stok = loadData('rest_load/load_produk_stok/', $arr);

	    echo $rest_produk_stok['stok']."~".$rest_produk_stok['varian'];

	}
	if ($_GET['jen']=='signin_login') {
		$arr = array('tipe' => 'web', 'email' => $_POST['alamat_email'], 'password' => $_POST['password'], 'option' => $_GET['option_lg'], 'lang' => 'en', 'sessid' => $_SESSION['XID_ARRAY']['unique_guest']);
	    $rest_val = loadData('rest_proses/proses_signin/', $arr);

	    if ($rest_val['success']==true) {
	    	$rest_val['success'] = 'y';
	    	$_SESSION['XID_ARRAY'] = $rest_val['result'];
	    }else{
	    	$rest_val['success'] = 'n';
	    }

	    echo $rest_val['success'].'~'.$rest_val['msg'].'~'.$_POST['alamat_email'];
	}
	if ($_GET['jen']=='registration') {
		$arr = array('tipe' => 'web', 'from' => 'manual', 'email' => $_POST['alamat_email'], 'option' => $_GET['option_lg'], 'lang' => 'en');
	    $rest_val = loadData('rest_proses/proses_signup/', $arr);

	    if ($rest_val['success']==true) {
	    	$rest_val['success'] = 'y';
	    }else{
	    	$rest_val['success'] = 'n';
	    }

	    echo $rest_val['success'].'~'.$rest_val['email'].'~'.$rest_val['msg'];
	}
	if ($_GET['jen']=='activation_otp') {
		$arr = array('tipe' => 'web', 'email' => $_POST['alamat_email'], 'kode_aktivasi' => $_POST['kode_otp'], 'option' => $_GET['option_lg'], 'onesignalid' => '', 'lang' => 'en', 'sessid' => $_SESSION['XID_ARRAY']['unique_guest']);
	    $rest_val = loadData('rest_proses/proses_aktivasi/', $arr);

	    if ($rest_val['success']==true) {
	    	$rest_val['success'] = 'y';
		    $_SESSION['XID_ARRAY'] = $rest_val['result'];
	    }else{
	    	$rest_val['success'] = 'n';
	    }


	    echo $rest_val['success'].'~'.$rest_val['msg'];
	}
	if ($_GET['jen']=='edit_akun_profil') {
		$arr = array('tipe' => 'web', 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'cust_nama' => $_POST['cust_nama'], 'cust_ponsel' => $_POST['cust_ponsel'], 'is_token' => $_POST['is_token'], 'gambar' => $_FILES['gambar']['name'], 'gambar_tmp' => $_FILES['gambar']['tmp_name'], 'gambar_size' => $_FILES['gambar']['size'], 'lang' => 'en');
	    $rest_val = loadData('rest_proses/proses_edit_akun/', $arr);

	    if ($rest_val['success']==true) {
	    	$rest_val['success'] = 'y';
	    }else{
	    	$rest_val['success'] = 'n';
	    }

	    echo $rest_val['success'].'~'.$rest_val['msg'];
	}
	if ($_GET['jen']=='edit_akun_password') {

		if ($rest_cust['result']['is_password']!='') {
			$pass_lama = $_POST['password_lama'];
		}else{
			$pass_lama = '';
		}

		if ($_POST['password_baru']==$_POST['password_confirm']) {
			$arr = array('tipe' => 'web', 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'password_lama' => $pass_lama, 'password_baru' => $_POST['password_baru'], 'lang' => 'en');
		    $rest_val = loadData('rest_proses/proses_edit_password/', $arr);

		    if ($rest_val['success']==true) {
		    	$rest_val['success'] = 'y';
		    }else{
		    	$rest_val['success'] = 'n';
		    }

		    echo $rest_val['success'].'~'.$rest_val['msg'];

		}else{
		    echo 'n~Ulangi password tidak sesuai.';
		}

	}
	if ($_GET['jen']=='add_to_cart') {

		if($_SESSION['XID_ARRAY']['cust_id']=='guest'){
			$idnya = $_SESSION['XID_ARRAY']['unique_guest'];
		}else{
			$idnya = $_SESSION['XID_ARRAY']['cust_id'];
		}

		$arr = array('tipe' => 'web', 'idcust' => $idnya, 'idproduk' => $_POST['produk_id'], 'idwarna' => $_POST['warna_id'], 'idukuran' => $_POST['ukuran_id'], 'idcart' => $_POST['cart_id'], 'jumlah_qty' => $_GET['jumlah_beli'], 'catatan_trx' => $_POST['catatan_trx'], 'p_url' => $_POST['purl'], 'u_affiliate' => decodeData($_POST['uid']), 'lang' => 'en');
	    $rest_val = loadData('rest_proses/proses_add_cart/', $arr);

	    if ($rest_val['success']==true) {
	    	$rest_val['success'] = 'y';
	    }else{
	    	$rest_val['success'] = 'n';
	    }

		echo $rest_val['success'].'~'.$rest_val['msg'];

	}
	if ($_GET['jen']=='tarik_saldo_user') {

		if($_POST['nominal_tarik']>=$rest_sistem['result']['min_tarik_saldo']){
			$arr = array('tipe' => 'web', 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'nominal_tarik' => $_POST['nominal_tarik'], 'bank_tarik_id' => $_POST['bank_tarik_id'], 'nama_rek' => $_POST['nama_rek'], 'no_rek' => $_POST['no_rek'], 'lang' => 'en');
			$rest_val = loadData('rest_proses/tarik_saldo_user/', $arr);
			if ($rest_val['success']==true) {
				$rest_val['success'] = 'y';
			}else{
				$rest_val['success'] = 'n';
			}
			$_SESSION['XMSG_TARIK_WD'] = $rest_val['msg'];
			echo $rest_val['success'];
		}else{
			echo 'Minimal penarikan '.formatRupiah($rest_sistem['result']['min_tarik_saldo']);
		}

	}
	if ($_GET['jen']=='add_wo_whislist') {

		$arr = array('tipe' => 'web', 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'idproduk' => $_GET['produk_id'], 'lang' => 'en');
	    $rest_val = loadData('rest_proses/proses_add_whislist/', $arr);

	    if ($rest_val['success']==true) {
	    	$rest_val['success'] = 'y';
	    }else{
	    	$rest_val['success'] = 'n';
	    }

		echo $rest_val['success'].'~'.$rest_val['ires'].'~'.$rest_val['msg'];

	}
	if ($_GET['jen']=='sign_out') { 
		unset($_SESSION['XID_ARRAY']); 
		unset($_SESSION['access_token']); 
		session_destroy(); 
		exit(); 
	} 
	if ($_GET['jen']=='cek_jumlah_cart') {
		if ($_SESSION['XID_ARRAY']['cust_id']) {

			if($_SESSION['XID_ARRAY']['cust_id']=='guest'){
				$idnya = $_SESSION['XID_ARRAY']['unique_guest'];
			}else{
				$idnya = $_SESSION['XID_ARRAY']['cust_id'];
			}

			$arr = array('idcust' => $idnya, 'lang' => 'en');
		    $rest_val = loadData('rest_load/load_jumlah_cart/', $arr);
		    echo "+".$rest_val['jumlah_cart'];
		}else{
		    echo '';
		}
	}
	if ($_GET['jen']=='hapus_p_cart') {

		if($_SESSION['XID_ARRAY']['cust_id']=='guest'){
			$idnya = $_SESSION['XID_ARRAY']['unique_guest'];
		}else{
			$idnya = $_SESSION['XID_ARRAY']['cust_id'];
		}

		$arr = array('idcust' => $idnya, 'idcart' => $_GET['idcart'], 'lang' => 'en');
	    $rest_val = loadData('rest_proses/proses_del_cart/', $arr);
	}
?>
<?php if ($_GET['jen']=='my_cart') { ?>
	<?php

		if($_SESSION['XID_ARRAY']['cust_id']=='guest'){
			$idnya = $_SESSION['XID_ARRAY']['unique_guest'];
		}else{
			$idnya = $_SESSION['XID_ARRAY']['cust_id'];
		}
		$arr = array('tipe' => 'web', 'idcust' => $idnya, 'lang' => 'en');
	    $rest_val = loadData('rest_load/load_cart/', $arr);
	?>
	<div class="padding-0-15">
		<div class="row">
			<?php if ($rest_val['items_count']>0) { ?>
			<?php foreach($rest_val['result'] as $obj) { ?>
				<div class="col-xl-12 col-lg-12 mb-3">
					<div class="d-flex align-items-c_">
						<a href="<?=$main_url;?>p/<?=$obj['url_produk'];?>" class="mr-3">
							<div class="bg_cart-set rounded-2" style="background: url('<?=$main_imgurl.'products/'.$obj['logo_image'];?>');"></div>
						</a>
						<div class="text-left">
							<div class="media-title ft-14 font-weight-600 color-dark"> 
								<a href="<?=$main_url;?>p/<?=$obj['url_produk'];?>" class="color-dark">
			             <?=$obj['nama_produk'];?>
			          </a>
			          <span class="p-absolute right-0 ft-14 c-pointer del-cart-p" onclick="gohapusCart('<?=$obj['cart_id'];?>')"><span class="icon-trash-o"></span></span>
			          <span class="p-absolute right-20 ft-14 c-pointer del-cart-p" onclick="myModalCartItem('<?=$obj['cart_id'];?>')"><span class="icon-pencil"></span></span>
		          </div>
		          <div class="media-title ft-14 color-semidark-m"> 
		            Varian : <?=$obj['varian'];?>
		          </div>
		          <?php if ($obj['tstok']=='y') { ?>
		          <div class="media-title ft-14 color-semidark-m"> 
		            <?=$obj['harga_produk'];?>
		            <span class="p-absolute right-0">x<?=$obj['jumlah_beli'];?></span>
		          </div>
		          <div class="media-title ft-14 color-semidark-m"> 
		            Catatan : <?=$obj['catatan_beli'];?>
		          </div>
		          <div class="media-title ft-14 color-dark font-weight-600"> 
		            Subtotal : <?=$obj['harga_produk_q'];?>
		          </div>
			      	<?php } ?>
			      	<?php if ($obj['tstok']!='y') { ?>
				      <span class="p-absolute right-0 ft-14 color-semidark-m">x<?=$obj['jumlah_beli'];?></span>
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
					<hr><div class="font-weight-600 ft-16">Total : <?=$rest_val['total_bayar'];?></div><hr>
				</div>
				<div class="">
					<a href="<?=$main_url;?>v/checkout" class="btn btn-primary ft-14 border-d border-radius-5 btn-block"> Checkout </a>
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
<?php } ?>
<?php if ($_GET['jen']=='my_live_chat') { ?>
	<?php
		$arr = array('idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'lang' => 'en');
	    $rest_val = loadData('rest_load/load_live_chat/', $arr);
	?>

	<style type="text/css">
		.box-c-admin {
			display: table; 
			margin-bottom: 10px;
		}
		.box-cc-admin {
			background: #ebebeb;padding: 10px;border-radius: 5px; font-size: 14px;
		}
		.box-c-anda {
			display: table; 
			width: 100%;
			margin-bottom: 10px;
		}
		.box-cc-anda {
			background: #efe0ff; padding: 10px;border-radius: 5px; font-size: 14px; float: right;
		}
	</style>

	<?php if ($_GET['t']=='n') { ?>
	<style>
		.scroll_lchat {
			overflow-y: scroll; height: calc(100vh - 170px);
		}
		@media (max-width: 767.5px) {
			.scroll_lchat {
				height: calc(100vh - 220px);
			}
		}
	</style>
	<?php }else{ ?>
	<style>
		.scroll_lchat {
			overflow-y: scroll; height: calc(100vh - 190px);
		}
		@media (max-width: 767.5px) {
			.scroll_lchat {
				height: calc(100vh - 240px);
			}
		}
	</style>
	<?php } ?>

	<div class="">
		<div class="padding-0-10 scroll_lchat" id="scroll_chat">
			<?php foreach($rest_val['result'] as $obj) { ?>
				<?php if ($obj['admin_id']>0) { ?>
				<div class="box-c-admin">
					<div class="box-cc-admin">
						<div class="ft-12 font-weight-bold">Administrator</div>
						<div class="ft-14" style="white-space: pre-line;"><?=$obj['deskripsi'];?></div>
						<div class="text-right ft-12 mt-1"><?=indo($obj['tgl_chat']);?></div>
					</div>
				</div>
				<?php }else{ ?>
				<div class="box-c-anda">
					<div class="box-cc-anda">
						<div class="ft-14 text-left" style="white-space: pre-line;"><?=$obj['deskripsi'];?></div>
						<div class="text-right ft-12 mt-1"><?=indo($obj['tgl_chat']);?></div>
					</div>
				</div>
				<?php } ?>
			<?php } ?>
		</div>
		<div id="ilinkproduklivechhat" class="ft-12 text-right w-100 p-1"></div>
		<div class="padding-0-10 pt-3" style="border-top: 1px solid #E1E1E1 !important;">
			<form id="form_live_chat" action="javascript:prosesaddChat()" method="POST">
				<div class="input-group">
					<input type="hidden" class="form-control ft-16" id="ilinkproduktxtchhat">
					<textarea type="text" class="form-control ft-16" name="txt" id="txtchatlive" placeholder="Isi pesan..." required=""></textarea>
					<div class="input-group-append">
					  <button class="btn btn-app" type="submit"><span class="icon-send ml-2 mr-2"></span></button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<script type="text/javascript">
		function prosesaddChat(){
      $('button').addClass('disabled');
      var formData = new FormData($("#form_live_chat")[0]);
      $.ajax({
        type: "POST",
        url: '<?=$main_url;?>module/action.php?jen=add_live_chat',
        data:  formData,
        contentType: false,
        cache: false,
        processData:false,
        success: function(result){
          $('button').removeClass('disabled');
          setTimeout(function() {
          	document.getElementById('scroll_chat').scrollTop =  document.getElementById('scroll_chat').scrollHeight;
		    	}, 250);
          formmyChat();
        } 
      });
    }

    function prosesaddChatx(){
    	var ax = $('#txtchatlive').val($('#ilinkproduktxtchhat').val());
    	if (ax!='') {
    		$('#txtchatlive').val('<a href="'+$('#ilinkproduktxtchhat').val()+'" target="_blank">Klik untuk melihat produk<a/>\nSaya ingin tanya mengenai produk ini');
			  $('button').addClass('disabled');
			  var formData = new FormData($("#form_live_chat")[0]);
			  $.ajax({
			    type: "POST",
			    url: '<?=$main_url;?>module/action.php?jen=add_live_chat',
			    data:  formData,
			    contentType: false,
			    cache: false,
			    processData:false,
			    success: function(result){
			      $('button').removeClass('disabled');
			      setTimeout(function() {
			      	document.getElementById('scroll_chat').scrollTop =  document.getElementById('scroll_chat').scrollHeight;
					  }, 250);
			      formmyChat();
		      } 
		    });
			}
	  }
	</script>
<?php } ?>
<?php if ($_GET['jen']=='add_live_chat') {
	    $arr = array('idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'txt' => $_POST['txt'], 'lang' => 'en');
	    $rest_val = loadData('rest_proses/proses_live_chat/', $arr);
} ?>
<?php if ($_GET['jen']=='auto_cek_chat') {
		$arr = array(
			'tipe' => 'web', 
			'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 
			'lang' => 'en'
		);
		$rest_val = loadData('rest_load/auto_cek_chat/', $arr);
		echo $rest_val['msg'];
	}
?>
<?php if ($_GET['jen']=='my_cart_item') { ?>
	<?php

	if($_SESSION['XID_ARRAY']['cust_id']=='guest'){
		$idnya = $_SESSION['XID_ARRAY']['unique_guest'];
	}else{
		$idnya = $_SESSION['XID_ARRAY']['cust_id'];
	}

	$arr = array('idcart' => $_GET['idcart'], 'idcust' => $idnya, 'lang' => 'en');
  	$rest_i_cart = loadData('rest_load/load_item_cart/', $arr);

  	$arr = array('wishlist' => 'n', 'idproduk' => $rest_i_cart['result']['url_produk'], 'new' => '', 'tipe' => '', 'lang' => 'en');
  	$rest_produk = loadData('rest_load/load_produk/', $arr); $res_p = $rest_produk['result'][0];

  	$arr = array('idproduk' => $rest_i_cart['result']['produk_id'], 'lang' => 'en');
  	$rest_v_varian = loadData('rest_load/load_produk_varian/', $arr);
  ?>
  <div class="section-title ft-18 text-center mb-3">
	    &mdash; Edit <?=$res_p['nama_produk'];?> &mdash;
	</div>
	<div class="row">
	  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
	  	<div class="bg-putih border-d_ rounded-2">
        <div class="padding-10-15">
          <form id="form_p_add_to_cartx" action="javascript:prosesaddtoCartx()" method="POST">
            <?php if ($rest_v_varian['result']['row_w']>0) { ?>
            <div class="ft-14 varian_warna">
              <div class="form-group mb-2">
                <label class="">Warna</label>
                <select class="form-control" name="warna_id" id="id_warna_pidx" onchange="checkStokProdukx()" required="">
                  <option value="">-- Pilih --</option>
                  <?php foreach($rest_v_varian['result']['p_warna'] as $objx) { ?>
                  <option value="<?=$objx['warna_id'];?>" <?php if ($rest_i_cart['result']['warna_id']==$objx['warna_id']) echo 'selected'; ?>><?=$objx['nama_warna'];?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <?php }else{ ?>
              <input type="hidden" name="warna_id" id="id_warna_pidx">
            <?php } ?>
            <?php if ($rest_v_varian['result']['row_u']>0) { ?>
            <div class="ft-14 varian_ukuran">
              <div class="form-group mb-2">
                <label class="">Ukuran</label>
                <select class="form-control" name="ukuran_id" id="id_ukuran_pidx" onchange="checkStokProdukx()" required="">
                  <option value="">-- Pilih --</option>
                  <?php $no=1; foreach($rest_v_varian['result']['p_ukuran'] as $objx) { $ukid = explode('~', $objx['ukuran_id']); ?>
                  <option value="<?=$objx['ukuran_id'];?>" <?php if ($rest_i_cart['result']['ukuran_id']==$ukid[0]) echo 'selected'; ?>><?=$objx['ukuran'];?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <?php }else{ ?>
              <input type="hidden" name="ukuran_id" id="id_ukuran_pidx">
            <?php } ?>
            <div class="ft-14 varian_qty">
              <div class="form-group mb-3">
                <label class="">Jumlah / Qty</label>
                <div class="input-group disabled-x" id="id_jumlah_qty_px">
                  <div class="input-group-prepend">
                      <button type="button" class="btn btn-light ft-14 border-d b-lt-lb-5" id="minus-bt-px"><i class="fa fa-minus"></i></button>
                  </div>
                  <input type="number" name="qty_input_pr" id="qty_input_prx" class="form-control text-center bg-putih" value="<?=$rest_i_cart['result']['jumlah_beli'];?>" min="1">
                  <div class="input-group-prepend">
                      <button type="button" class="btn btn-light ft-14 border-d b-rt-rb-5" id="plus-bt-px"><i class="fa fa-plus"></i></button>
                  </div>
                  <div class="ml-2" style="line-height: 35px">
                    <span id="id_produk_stok_rex">Stok <b>...</b></span>
                  </div>
                </div>
              </div>
              <div class="form-group mb-2">
              	<textarea type="text" class="form-control ft-12" name="catatan_trx" rows="2" placeholder="Catatan..."><?=$rest_i_cart['result']['catatan_beli'];?></textarea>
              </div>
              <div class="varian_subtotal mt-3 w-100">
                <?php if ($res_p['potongan_status']=='y') { ?>
                <div class="text-right text-line-through color-semidark-m ft-14" id="subtotal_harga_apx"><?=$res_p['harga_produk_awal'];?></div>
                <?php } ?>
                <div class="d-flex align-items-center j-c-sb">
                  <span class="color-semidark-m">Subtotal</span>
                  <span class="color-dark ft-18 font-weight-bold" id="subtotal_harga_px"><?=$res_p['harga_produk'];?></span>
                </div>
              </div>
            </div>
            <div class="ft-14 varian_submit mt-2">
              <div class="">
                <input type="hidden" name="produk_id" value="<?=$res_p['produk_id'];?>">
                <input type="hidden" name="cart_id" value="<?=$_GET['idcart'];?>">
                <button type="submit" class="btn btn-primary ft-14 border-d border-radius-5 btn-block" id="produk_keranjang_submit_pidx">
                  <i class="fa fa-check"></i>&nbsp;&nbsp;Simpan Perubahan
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
	  </div>
	</div>

	<script type="text/javascript">

		var h_produk_awalx = '<?=$res_p['harga_produk_awal_num'];?>';
    var h_produkx = '<?=$res_p['harga_produk_num'];?>';

    var id_px = '<?=$res_p['produk_id'];?>';
    var row_wx = '<?=$rest_v_varian['result']['row_w'];?>';
    var row_ux = '<?=$rest_v_varian['result']['row_u'];?>';
      
    var hrga_tmbhanx = 0;
    var p_stokx = 1;

    var qty_awalx = '<?=$rest_i_cart['result']['jumlah_beli'];?>';
    var tipereload = '<?=$_GET['t'];?>';

    $(document).ready(function(){

    		$('#subtotal_harga_px').html(formatRupiah((parseInt(h_produkx)+parseInt(hrga_tmbhanx))*parseInt(qty_awalx)));
        $('#subtotal_harga_apx').html(formatRupiah((parseInt(h_produk_awalx)+parseInt(hrga_tmbhanx))*parseInt(qty_awalx)));

        if (row_wx==0 && row_ux==0) {
          $.get('<?=$main_url;?>module/action.php?jen=product_action&tipe=zero&idproduk='+id_px+'&idwarna=0&idukuran=0', function(res) {
            var data = res.split('~');
            if (data[0]>0) {
              p_stokx = parseInt(data[0]);
              $('#id_produk_stok_rex').html('Stok <b>'+data[0]+'</b>');
            }else{
              p_stokx = 1;
              $('#id_produk_stok_rex').html('Stok Habis');
              $('#produk_keranjang_submit_pidx').addClass('disabled-x');
            }
            $('#id_jumlah_qty_px').removeClass('disabled-x');
          });
        }

        $('#qty_input_prx').prop('disabled', true);
        $('#plus-bt-px').click(function(){
          if ($('#qty_input_prx').val() < p_stokx) {
            var qty_px = parseInt($('#qty_input_prx').val()) + 1;
            $('#qty_input_prx').val(qty_px);
            $('#subtotal_harga_px').html(formatRupiah((parseInt(h_produkx)+parseInt(hrga_tmbhanx))*parseInt(qty_px)));
            $('#subtotal_harga_apx').html(formatRupiah((parseInt(h_produk_awalx)+parseInt(hrga_tmbhanx))*parseInt(qty_px)));
          }
        });
        $('#minus-bt-px').click(function(){
          var qty_px = parseInt($('#qty_input_prx').val()) - 1;
          $('#qty_input_prx').val(qty_px);
          if ($('#qty_input_prx').val() == 0) {
            $('#qty_input_prx').val(1);
            if(qty_px!=0){
              $('#subtotal_harga_px').html(formatRupiah(parseInt(h_produkx)+parseInt(hrga_tmbhanx)));
              $('#subtotal_harga_apx').html(formatRupiah(parseInt(h_produk_awalx)+parseInt(hrga_tmbhanx)));
            }
          }else{
            $('#subtotal_harga_px').html(formatRupiah((parseInt(h_produkx)+parseInt(hrga_tmbhanx))*parseInt(qty_px)));
            $('#subtotal_harga_apx').html(formatRupiah((parseInt(h_produk_awalx)+parseInt(hrga_tmbhanx))*parseInt(qty_px)));
          }
        });

        checkStokProdukx();

        setTimeout(function() {
	        $('#qty_input_prx').val(qty_awalx);
	    	}, 500);

    });

		function checkStokProdukx(){

      var id_wx = $('#id_warna_pidx').val();
      var id_ux = $('#id_ukuran_pidx').val();

      if (row_wx>0 && row_ux>0 && id_wx!='' && id_ux!='') {
        $('#id_produk_stok_rex').html('Loading...');
        s_udix = id_ux.split('~');
        hrga_tmbhanx = s_udix[1];

        $.get('<?=$main_url;?>module/action.php?jen=product_action&tipe=zero&idproduk='+id_px+'&idwarna='+id_wx+'&idukuran='+s_udix[0], function(res) {
          var data = res.split('~');
          if (data[0]>0) {
            p_stokx = parseInt(data[0]);
            $('#id_produk_stok_rex').html('Stok <b>'+data[0]+'</b>');
            $('#produk_keranjang_submit_pidx').removeClass('disabled-x');
          }else{
            p_stokx = 1;
            $('#id_produk_stok_rex').html('Stok Habis');
            $('#produk_keranjang_submit_pidx').addClass('disabled-x');
          }
          $('#qty_input_prx').val(1)
          $('#id_jumlah_qty_px').removeClass('disabled-x');

          $('#subtotal_harga_px').html(formatRupiah(parseInt(h_produkx)+parseInt(hrga_tmbhanx)));
          $('#subtotal_harga_apx').html(formatRupiah(parseInt(h_produk_awalx)+parseInt(hrga_tmbhanx)));
        });
      }else if (row_wx>0 && row_ux==0 && id_wx!='') {
        $('#id_produk_stok_rex').html('Loading...');
        $.get('<?=$main_url;?>module/action.php?jen=product_action&tipe=zero&idproduk='+id_px+'&idwarna='+id_wx+'&idukuran=0', function(res) {
          var data = res.split('~');
          if (data[0]>0) {
            p_stokx = parseInt(data[0]);
            $('#id_produk_stok_rex').html('Stok <b>'+data[0]+'</b>');
            $('#produk_keranjang_submit_pidx').removeClass('disabled-x');
          }else{
            p_stokx = 1;
            $('#id_produk_stok_rex').html('Stok Habis');
            $('#produk_keranjang_submit_pidx').addClass('disabled-x');
          }
          $('#qty_input_prx').val(1)
          $('#id_jumlah_qty_px').removeClass('disabled-x');

          $('#subtotal_harga_p').html(formatRupiah(parseInt(h_produkx)+parseInt(hrga_tmbhanx)));
          $('#subtotal_harga_ap').html(formatRupiah(parseInt(h_produk_awalx)+parseInt(hrga_tmbhanx)));

        });
      }else if (row_wx==0 && row_ux>0 && id_ux!='') {
        $('#id_produk_stok_rex').html('Loading...');
        s_udix = id_ux.split('~');
        hrga_tmbhanx = s_udix[1];

        $.get('<?=$main_url;?>module/action.php?jen=product_action&tipe=zero&idproduk='+id_px+'&idwarna=0&idukuran='+s_udix[0], function(res) {
            var data = res.split('~');
            if (data[0]>0) {
              p_stokx = parseInt(data[0]);
              $('#id_produk_stok_rex').html('Stok <b>'+data[0]+'</b>');
              $('#produk_keranjang_submit_pidx').removeClass('disabled-x');
            }else{
              p_stokx = 1;
              $('#id_produk_stok_rex').html('Stok Habis');
              $('#produk_keranjang_submit_pidx').addClass('disabled-x');
            }
            $('#qty_input_prx').val(1)
            $('#id_jumlah_qty_px').removeClass('disabled-x');

            $('#subtotal_harga_px').html(formatRupiah(parseInt(h_produkx)+parseInt(hrga_tmbhanx)));
            $('#subtotal_harga_apx').html(formatRupiah(parseInt(h_produk_awalx)+parseInt(hrga_tmbhanx)));
            
        });
      }else{
        $('#id_produk_stok_rex').html('Stok ...');
        $('#id_jumlah_qty_px').addClass('disabled-x');
      }

    }

    function prosesaddtoCartx(){
      $('button').addClass('disabled');
      var formData = new FormData($("#form_p_add_to_cartx")[0]);
      $.ajax({
        type: "POST",
        url: '<?=$main_url;?>module/action.php?jen=add_to_cart&jumlah_beli='+$('#qty_input_prx').val(),
        data:  formData,
        contentType: false,
        cache: false,
        processData:false,
        success: function(result){
          $('button').removeClass('disabled');
          var res = result.split('~');
          if (res[0]=='y') {
          	if (tipereload=='reload') {
	            confirmBerhasil(res[1],'reload');
          	}else{
	          	$('#myModalCartItem').modal('hide');
	          	formmyModalCart();
	            confirmBerhasil(res[1]);
          	}
          }else{
            confirmGagal(res[1]);
          }
        } 
      });
    }

	</script>
	
<?php } ?>
<?php if ($_GET['jen']=='my_alamat_cust') { ?>
	<?php
		$arr = array('tipe' => $_GET['tipe'], 'idalamat' => $_GET['idalamat'], 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'lang' => 'en');
	    $rest_val = loadData('rest_load/load_alamat_customer/', $arr);
	?>
	<div class="text-center p-mob-30">
		<div class="section-title ft-18 text-center mb-3">
			<?php if ($_GET['tipe']=='add') { ?>
			&mdash; Tambah Alamat &mdash;
			<?php }else{ ?>
			&mdash; Edit Alamat &mdash;
			<?php } ?>
		</div>
	    <div class="row text-center pb-3 pr-3 pl-3">
		    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
		    	<form id="form_option_alamat_akun" action="javascript:goOptionmyAlamat()" method="POST">
		    		<div class="form-group mb-1 text-left">
					    <label class="">Label Alamat</label>
						<input type="hidden" class="form-control ft-16" name="idalamat" value="<?=$_GET['idalamat'];?>">
						<input type="hidden" class="form-control ft-16" name="idtipe" value="<?=$_GET['tipe'];?>" required="">
						<input type="text" class="form-control ft-16" name="label_alamat" value="<?=$rest_val['result']['label_alamat'];?>" required="" autocomplete="off">
					</div>
					<div class="form-group mb-1 text-left">
					    <label class="">Nama Penerima</label>
						<input type="text" class="form-control ft-16" name="nama_penerima" value="<?=$rest_val['result']['nama_penerima'];?>" required="" autocomplete="off">
					</div>
					<div class="form-group mb-1 text-left">
				      	<label class="">Nomor Penerima / WhatsApp</label>
						<input type="text" class="form-control ft-16" name="ponsel_penerima" value="<?=$rest_val['result']['ponsel_penerima'];?>" required="" autocomplete="off">
					</div>
					<div class="form-group mb-1 text-left">
					    <label class="">Provinsi</label>
                        <?php 
							$arr = array('id' => 'n', 'lang' => 'en');
						    $rest_prov = loadData('rest_load/load_provinsi/', $arr);
						?>

                        <select name='provinsi_id_ex' id='provinsi_id_ex' class='form-control selectpicker' data-live-search="true" title="-- Pilih --" required="">
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
					<div class="form-group mb-1 text-left" id="kabupaten_kota_id_ex">
					    <label class="">Kabupaten / Kota</label>
                        <select name='kabkot_id_ex' id='kabupaten_kota_id_eexx' class='form-control selectpicker' data-live-search="true" title="--" required="">
                        </select>
					</div>
					<div class="form-group mb-1 text-left" id="kecamatan_id_ex">
					    <label class="">Kecamatan</label>
                        <select name='kec_id_ex' id='kec_id_eexx' class='form-control selectpicker' data-live-search="true" title="--" required="">
                        </select>
					</div>
					<div class="form-group mb-1 text-left">
				      	<label class="">Kodepos</label>
						<input type="text" class="form-control ft-16" name="kode_pos_ex" id="kode_pos_ex" required="" autocomplete="off" value="<?=$rest_val['result']['kodepos'];?>">
					</div>
					<div class="form-group mb-1 text-left">
				      	<label class="">Alamat Pengiriman</label>
						<textarea type="text" class="form-control ft-16" name="alamat_lengkap" required="" rows="3"><?=$rest_val['result']['alamat_lengkap'];?></textarea>
					</div>
					<div class="mt-4 mb-4">
		               <button type="submit" class="btn btn-primary btn-block">Simpan</button>
			        </div>
				</form>
		    </div>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){

			var tipe_action = '<?=$_GET['tipe']?>';
			var idalamat = '<?=$_GET['idalamat']?>';

			if (tipe_action=='edit'){
				var prov = $('#provinsi_id_ex').val();
                id_prov = prov.split("*");

                $("#kabupaten_kota_id_ex").html('<label class="">Loading...</label>');
                $.get('<?=$main_url;?>module/action.php?jen=load_kabkot&prov_id='+id_prov[0]+'&tipe='+tipe_action+'&idalamat='+idalamat, function(data) {
					$("#kabupaten_kota_id_ex").html(data);
					setTimeout(function() {
    					getKecamatan(tipe_action,idalamat);
		    	    }, 300);
	            });
			}

            $('.selectpicker').selectpicker();

			$('#provinsi_id_ex').change(function(){
                var prov = $('#provinsi_id_ex').val();
                id_prov = prov.split("*");

                $("#kabupaten_kota_id_ex").html('<label class="">Loading...</label>');
                $.get('<?=$main_url;?>module/action.php?jen=load_kabkot&prov_id='+id_prov[0]+'&tipe='+tipe_action+'&idalamat='+idalamat, function(data) {
					$("#kabupaten_kota_id_ex").html(data);
	            });
            });
            
        });
        
        function getKecamatan(tipe_action,idalamat){
            var kabkot = $('#kabupaten_kota_id_eexx').val();
            id_kabkot = kabkot.split("*");
            
            console.log(id_kabkot[0]);

            $("#kecamatan_id_ex").html('<label class="">Loading...</label>');
            $.get('<?=$main_url;?>module/action.php?jen=load_kecamatan&kabkot_id='+id_kabkot[0]+'&tipe='+tipe_action+'&idalamat='+idalamat, function(data) {
				$("#kecamatan_id_ex").html(data);
	           });
        }

        function goOptionmyAlamat(){
    		$.confirm({
		        title: 'Confirm!',
		        content: 'Pastikan alamat yang di masukan sudah benar!',
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
		            var formData = new FormData($("#form_option_alamat_akun")[0]);
		            $.ajax({
		              type: "POST",
		              url: '<?=$main_url;?>module/action.php?jen=my_option_alamat_ex',
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

	</script>
<?php } ?>
<?php if ($_GET['jen']=='load_kabkot') {

	$arr = array('tipe' => $_GET['tipe'], 'idalamat' => $_GET['idalamat'], 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'lang' => 'en');
	$alamat_val = loadData('rest_load/load_alamat_customer/', $arr);

	$arr = array('idkabkot' => $_GET['prov_id'], 'lang' => 'en');
	$rest_val = loadData('rest_load/load_kabkot/', $arr); ?>

	<label class="">Kabupaten / Kota</label>
	<select name='kabkot_id_ex' id='kabupaten_kota_id_eexx' class='form-control selectpicker' data-live-search="true" title="-- Pilih --" required="" onchange="cekValid(this.value);">
		<?php 
			foreach($rest_val['result'] as $obj) { 
			if($alamat_val['result']['id_kabkot']==$obj['city_id']){
	            $oksip ='selected';
	        }else{
	            $oksip ='';
	        }
		?>
		<option value="<?=$obj['city_id'].'*'.$obj['city_name'];?>" <?=$oksip;?>><?=$obj['type']." ".$obj['city_name'];?></option>
	<?php } ?>
	</select>

	<script type="text/javascript">
		$(document).ready(function(){
            $('.selectpicker').selectpicker();
            
            var tipe = "<?=$_GET['tipe'];?>";
            var idalamat = "<?=$_GET['idalamat'];?>";

            $('#kabupaten_kota_id_eexx').change(function(){
              var kabkot = $('#kabupaten_kota_id_eexx').val();
              id_kabkot = kabkot.split("*");
              $("#kecamatan_id_ex_guest").html('<label class="">Loading...</label>');
              $.get('<?=$main_url;?>module/action.php?jen=load_kecamatan&kabkot_id='+id_kabkot[0]+'&tipe=0&idalamat=0', function(data) {
                $("#kecamatan_id_ex_guest").html(data);
              });
              
              $("#kecamatan_id_ex").html('<label class="">Loading...</label>');
              $.get('<?=$main_url;?>module/action.php?jen=load_kecamatan&kabkot_id='+id_kabkot[0]+'&tipe='+tipe+'&idalamat='+idalamat, function(data) {
    			$("#kecamatan_id_ex").html(data);
    	      });
            });
        });
        
        function cekValid(a){
		  <?php if(isset($_SESSION['XID_ARRAY']) && $_SESSION['XID_ARRAY']['cust_id']=='guest'){ ?>
			$('#kurir_idmy').val('');
			$("#rajaongkir_pilihan_kurir").html('');
		  <?php } ?>
	    }
      
	</script>
<?php } ?>
<?php if ($_GET['jen']=='load_kecamatan') {

	$arr = array('tipe' => $_GET['tipe'], 'idalamat' => $_GET['idalamat'], 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'lang' => 'en');
	$alamat_val = loadData('rest_load/load_alamat_customer/', $arr);

	$arr = array('idkabkot' => $_GET['kabkot_id'], 'lang' => 'en');
	$rest_val = loadData('rest_load/load_kecamatan/', $arr); ?>

	<label class="">Kecamatan</label>
	<select name='kec_id_ex' id='kecamatan_id_eexx' class='form-control selectpicker' data-live-search="true" title="-- Pilih --" required="" onchange="cekKodepos(this.value);">
		<?php 
			foreach($rest_val['result'] as $obj) { 
			if($alamat_val['result']['id_kec']==$obj['kec_id']){
	            $oksip ='selected';
	        }else{
	            $oksip ='';
	        }
		?>
		<option value="<?=$obj['kec_id'].'*'.$obj['kec_name'];?>" <?=$oksip;?>><?=$obj['type']." ".$obj['kec_name'];?></option>
	<?php } ?>
	</select>

	<script type="text/javascript">
		$(document).ready(function(){
            $('.selectpicker').selectpicker();
        });

        function cekKodepos(a){
	      id_kot = a.split("*");
	      $('#kode_pos_ex').val('');

		  <?php if(isset($_SESSION['XID_ARRAY']) && $_SESSION['XID_ARRAY']['cust_id']=='guest'){ ?>
			$('#kurir_idmy').val('');
			$("#rajaongkir_pilihan_kurir").html('');
		  <?php } ?>
	    }
	</script>
<?php } ?>
<?php if ($_GET['jen']=='my_option_alamat_ex') {

		$arr = array('tipe' => 'web', 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'idalamat' => $_POST['idalamat'], 'tipe' => $_POST['idtipe'], 'label_alamat' => $_POST['label_alamat'], 'nama_penerima' => $_POST['nama_penerima'], 'ponsel_penerima' => $_POST['ponsel_penerima'], 'provinsi_id_ex' => $_POST['provinsi_id_ex'], 'kabkot_id_ex' => $_POST['kabkot_id_ex'], 'kec_id_ex' => $_POST['kec_id_ex'], 'kode_pos_ex' => $_POST['kode_pos_ex'], 'alamat_lengkap' => $_POST['alamat_lengkap'], 'lang' => 'en');

		$rest_val = loadData('rest_proses/proses_option_alamat/', $arr);

		if ($rest_val['success']==true) {
			$rest_val['success'] = 'y';
		}else{
			$rest_val['success'] = 'n';
		}

		echo $rest_val['success'].'~'.$rest_val['msg'];
	}
?>
<?php if ($_GET['jen']=='change_my_alamat') {
	$arr = array('tipe' => 'edit', 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'idalamat' => $_GET['idalamat'], 'lang' => 'en');
    $rest_alamat = loadData('rest_load/load_alamat_customer/',$arr); ?>

	<div class="ft-14 font-weight-bold mb-1">
      <?=$rest_alamat['result']['label_alamat'];?>
      <span class="float-right"><span class="icon-pencil-square-o c-pointer" onclick="actionAlamat('edit','<?=$rest_alamat['result']['cust_det_id']?>')"></span></span>
    </div>
    <div class="ft-14">Penerima : <?=$rest_alamat['result']['nama_penerima'];?></div>
    <div class="ft-14"><?=$rest_alamat['result']['alamat_lengkap'];?>, 
      <span class="text-lowercase"><?=$rest_alamat['result']['nama_provinsi'];?>, <?=$rest_alamat['result']['nama_kabkot'];?> - <?=$rest_alamat['result']['kodepos'];?></span>
    </div>
    <div class="ft-14">Nomor yang dapat di hubungi <?=$rest_alamat['result']['ponsel_penerima'];?></div>
    <input type="hidden" id="idkbakot_id" value="<?=$rest_alamat['result']['id_kabkot']?>">
    <input type="hidden" id="idkeckec_id" value="<?=$rest_alamat['result']['id_kec']?>">
    <input type="hidden" id="cust_det_id" value="<?=$rest_alamat['result']['cust_det_id']?>">
<?php } ?>
<?php if ($_GET['jen']=='raja_ongkir_cari_kurir') {

	if($_SESSION['XID_ARRAY']['cust_id']=='guest'){
		$idnya = $_SESSION['XID_ARRAY']['unique_guest'];
	}else{
		$idnya = $_SESSION['XID_ARRAY']['cust_id'];
	}
	
	// Buat key unik berdasarkan input user
    $session_key = md5(
        'web_' .
        $idnya . '_' .
        $_POST['kabkot_id'] . '_' .
        $_POST['kurir_id']
    );

    $now = time(); $cache_valid = false;
    
    // Cek apakah session sudah ada dan belum expired 15 menit
    if (isset($_SESSION[$session_key])) {
        $session_data = $_SESSION[$session_key];
        if (isset($session_data['timestamp']) && ($now - $session_data['timestamp'] <= 900)) {
            // Session masih valid
            $rest_kurir = $session_data['data'];
            $cache_valid = true;
            
            $arr_save = [
                'tipe' => 'web',
                'result' => $rest_kurir['result'],
                'lang' => 'en'
            ];
            $save_res = loadData('rest_load/load_kurir_cost_save_tmp/', $arr_save);
        }
    }
    
    // Kalau session belum ada atau expired, load data baru
    if (!$cache_valid) {
	    $arr = array('tipe' => 'web', 'idcust' => $idnya, 'kabkot_id' => $_POST['kabkot_id'], 'kurir_id' => $_POST['kurir_id'], 'lang' => 'en');
        $rest_kurir = loadData('rest_load/load_kurir_cost/',$arr); 
    
        // Simpan ke session dengan timestamp
        $_SESSION[$session_key] = [
            'data' => $rest_kurir,
            'timestamp' => $now
        ];
    }
    ?>
  	<div class="">
	    <?php if ($rest_kurir['success']==false){ ?>
	    	<div class="alert alert-primary">
				Pastikan kamu sudah mengisi semua data alamat pengiriman dengan benar.</div>
	    <?php }else{ ?>
	    	<div class="row">
			  <?php if(count($rest_kurir['result'])>0){ ?>
				<?php foreach($rest_kurir['result'] as $obj) { ?>
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
					<label class="d-block c-pointer" onclick="selectKurirv2('<?=$obj['kurir_id'];?>','<?=$obj['ongkos_kirim'];?>')">
						<div class="padding-15 mb-3 border-radius-5 border-d" style="background: #f3f4f5;">
						<div class="ft-16 font-weight-bold"><?=$obj['nama_kurir']?></div>
						<div class="ft-16">Service <?=$obj['level_kurir'];?> 
							<span class="ft-12 float-right">estimasi <?=$obj['lama_pengiriman'];?> hari</span>
						</div>
						<div class="ft-16 pull-right font-weight-bold">
							<?=formatRupiah($obj['ongkos_kirim'])?>
						</div>
						<div class="">
							<input type="radio" name="kurir_id" style="margin-top: 7px;" value="<?=$obj['kurir_id'];?>" id="ku<?=$hasil['kurir_id'];?>" required="required">
						</div>
						</div>
					</label>
				</div>
				<?php } ?>
			  <?php }else{ ?>
				<div class="col-xl-12 col-lg-612 col-md-12 col-sm-12">
					<div class="alert alert-info">
						Tidak ada kurir yang tersedia, silahkan gunakan expedisi lain.<br>
						Dan pastikan kamu sudah mengisi semua data alamat pengiriman dengan benar.
					</div>
				</div>
			  <?php } ?>
	      	  <input type="hidden" id="kurir_yg_dipilih_fix" class="form-control">
	    	</div>
		  <?php } ?>
  	</div>
<?php } ?>
<?php if ($_GET['jen']=='raja_ongkir_cari_kurir_bak') {

	if($_SESSION['XID_ARRAY']['cust_id']=='guest'){
		$idnya = $_SESSION['XID_ARRAY']['unique_guest'];
	}else{
		$idnya = $_SESSION['XID_ARRAY']['cust_id'];
	}

	$arr = array('tipe' => 'web', 'idcust' => $idnya, 'kabkot_id' => $_POST['kabkot_id'], 'kurir_id' => $_POST['kurir_id'], 'lang' => 'en');
    $rest_kurir = loadData('rest_load/load_kurir_cost/',$arr); ?>
  	<div class="">
	    <?php if ($rest_kurir['success']==false){ ?>
	    	<div class="alert alert-primary">
				Pastikan kamu sudah mengisi semua data alamat pengiriman dengan benar.</div>
	    <?php }else{ ?>
	    	<div class="row">
		      <?php foreach($rest_kurir['result'] as $obj) { ?>
		      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
		      	<label class="d-block c-pointer" onclick="selectKurirv2('<?=$obj['kurir_id'];?>','<?=$obj['ongkos_kirim'];?>')">
			        <div class="padding-15 mb-3 border-radius-5 border-d" style="background: #f3f4f5;">
			          <div class="ft-16 font-weight-bold"><?=$obj['nama_kurir']?></div>
			          <div class="ft-16">Service <?=$obj['level_kurir'];?> 
			          	<span class="ft-12 float-right">estimasi <?=$obj['lama_pengiriman'];?> hari</span>
			          </div>
			          <div class="ft-16 pull-right font-weight-bold">
			             <?=formatRupiah($obj['ongkos_kirim'])?>
			          </div>
			          <div class="">
			            <input type="radio" name="kurir_id" style="margin-top: 7px;" value="<?=$obj['kurir_id'];?>" id="ku<?=$hasil['kurir_id'];?>" required="required">
			          </div>
			        </div>
		  		</label>
		      </div>
		      <?php } ?>
	      	  <input type="hidden" id="kurir_yg_dipilih_fix" class="form-control">
	    	</div>
		  <?php } ?>
  	</div>
<?php } ?>
<?php if ($_GET['jen']=='simpan_topup_saldo') {

		$arr = array(
			'tipe' => 'web', 
			'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 
			'idunique' => $_POST['idunique'], 
			'snapobj' => $_POST['snapobj'], 
			'statuspay' => $_POST['statuspay'], 
			'nominaltopup' => $_POST['nominaltopup'],
			'lang' => 'en'
		);

	  $rest_val = loadData('rest_proses/proses_topup_saldo/', $arr);

	  if ($rest_val['success']==true) {
	  	$rest_val['success'] = 'y';
	  }else{
	  	$rest_val['success'] = 'n';
	  }

	  echo $rest_val['success'].'~'.$rest_val['msg'].'~'.$rest_val['uid'];
	}
?>
<?php if($_GET['jen']=="snap_token_midtrans"){

	if($_SESSION['XID_ARRAY']['cust_id']=='guest'){
		$idnya = $_SESSION['XID_ARRAY']['unique_guest'];
	}else{
		$idnya = $_SESSION['XID_ARRAY']['cust_id'];
	}

	$arr = array(
		'idcust' => $idnya, 
		'idalamat' => $_GET['idalamat'], 
		'digitalonly' => $_GET['digitalonly'], 
		'idkurir' => $_GET['idkurir'], 
		'kodevoucher' => $_GET['kodevoucher'], 
		'nama' => $_GET['nama'],
		'nomor' => $_GET['nomor'],
		'nama_provinsi' => $_GET['nama_provinsi'],
		'nama_kabkot' => $_GET['nama_kabkot'],
		'kodepos' => $_GET['kodepos'],
		'alamat' => $_GET['alamat'],
		'email' => $_GET['email'],
		'lang' => 'en',
		'tipe' => 'web'
	);

	$rest_val = loadData('rest_load/snap_token_midtrans/', $arr);

	if ($rest_val['success']==true) {
		$rest_val['success'] = 'y';
	}else{
		$rest_val['success'] = 'n';
	}

	echo $rest_val['success'].'~'.$rest_val['msg'].'~'.$rest_val['result'];
}
?>
<?php if($_GET['jen']=="snap_token_midtrans_topup"){

			$arr = array(
				'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 
				'nominalv' => $_GET['nominalv'],
				'lang' => 'en',
				'tipe' => 'web'
			);

		  $rest_val = loadData('rest_load/snap_token_midtrans_topup/', $arr);

		  if ($rest_val['success']==true) {
		  	$rest_val['success'] = 'y';
		  }else{
		  	$rest_val['success'] = 'n';
		  }
		  
		  echo $rest_val['success'].'~'.$rest_val['msg'].'~'.$rest_val['result'];
  	}
?>
<?php if ($_GET['jen']=='simpan_transaksi') {

		if($_SESSION['XID_ARRAY']['cust_id']=='guest'){
			$idnya = $_SESSION['XID_ARRAY']['unique_guest'];
		}else{
			$idnya = $_SESSION['XID_ARRAY']['cust_id'];
		}

		$arr = array(
			'tipe' => 'web', 
			'idcust' => $idnya, 
			'idalamat' => $_POST['idalamat'], 
			'idkurir' => $_POST['idkurir'], 
			'idunique' => $_POST['idunique'], 
			'snapobj' => $_POST['snapobj'], 
			'statuspay' => $_POST['statuspay'], 
			'kodevoucher' => $_POST['kodevoucher'], 
			'potonganvoucher' => $_POST['potonganvoucher'],
			'metodepembayaran' => $_POST['metodepembayaran'],
			'digitalonly' => $_POST['digitalonly'],
			'catatan_trx' => $_POST['catatan_trx'],
			'nama' => $_POST['nama'],
			'nomor' => $_POST['nomor'],
			'splitprov' => $_POST['splitprov'],
			'splitkabkot' => $_POST['splitkabkot'],
			'splitkec' => $_POST['splitkec'],
			'kodepos' => $_POST['kodepos'],
			'alamat' => $_POST['alamat'],
			'email' => $_POST['email'],
			'lang' => 'en'
		);

		if ($_POST['metodepembayaran']=='bank' || $_POST['metodepembayaran']=='saldo') {
			$rest_val = loadData('rest_proses/proses_simpan_transaksi/', $arr);

			if ($rest_val['success']==true) {
				$rest_val['success'] = 'y';
				$_SESSION['trxidunique_xix'] = $rest_val['uid'];
				$_SESSION['trxidunique_msg'] = $rest_val['msg'];
			}else{
				$rest_val['success'] = 'n';
				$_SESSION['trxidunique_msg'] = $rest_val['msg'];
			}

			echo $rest_val['success'].'~'.$rest_val['msg'];
		}else{
			echo 'n~Metode pembayaran tidak sesuai.';
		}
	}
?>
<?php if ($_GET['jen']=='batalkan_transaksi') {
		$arr = array(
			'tipe' => 'web', 
			'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 
			'notrx' => $_POST['notrx'], 
			'lang' => 'en'
		);

		$rest_val = loadData('rest_proses/proses_batalkan_transaksi/', $arr);

		if ($rest_val['success']==true) {
			$rest_val['success'] = 'y';
		}else{
			$rest_val['success'] = 'n';
		}

		echo $rest_val['success'].'~'.$rest_val['msg'];
	}
?>
<?php if ($_GET['jen']=='tiba_transaksi') {
		$arr = array(
			'tipe' => 'web', 
			'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 
			'notrx' => $_POST['notrx'], 
			'lang' => 'en'
		);

		$rest_val = loadData('rest_proses/proses_tiba_transaksi/', $arr);

		if ($rest_val['success']==true) {
			$rest_val['success'] = 'y';
		}else{
			$rest_val['success'] = 'n';
		}

		echo $rest_val['success'].'~'.$rest_val['msg'];
	}
?>
<?php if ($_GET['jen']=='kirim_bukti_bayar') {

		if($_SESSION['XID_ARRAY']['cust_id']=='guest'){
			$idnya = $_SESSION['XID_ARRAY']['unique_guest'];
		}else{
			$idnya = $_SESSION['XID_ARRAY']['cust_id'];
		}

		$arr = array(
			'tipe' => 'web', 
			'idcust' => $idnya, 
			'notrx' => $_POST['no_transaksi'], 
			'idbank' => $_POST['bank_id'], 
			'gambar' => $_FILES['gambar']['name'], 
			'gambar_tmp' => $_FILES['gambar']['tmp_name'], 
			'gambar_size' => $_FILES['gambar']['size'],
			'lang' => 'en'
		);

		$rest_val = loadData('rest_proses/proses_kirim_bukti_bayar/', $arr);

		if ($rest_val['success']==true) {
			$rest_val['success'] = 'y';
		}else{
			$rest_val['success'] = 'n';
		}
		
		$_SESSION['pesanbukti'] = $rest_val['msg'];

		echo $rest_val['success'].'~'.$rest_val['msg'];
	}
?>
<?php if ($_GET['jen']=='kirim_bukti_bayar_topup') {
		$arr = array(
			'tipe' => 'web', 
			'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 
			'notrx' => $_POST['no_transaksi'], 
			'idbank' => $_POST['bank_id'], 
			'gambar' => $_FILES['gambar']['name'], 
			'gambar_tmp' => $_FILES['gambar']['tmp_name'], 
			'gambar_size' => $_FILES['gambar']['size'],
			'lang' => 'en'
		);

		$rest_val = loadData('rest_proses/proses_kirim_bukti_bayar_topup/', $arr);

		if ($rest_val['success']==true) {
			$rest_val['success'] = 'y';
		}else{
			$rest_val['success'] = 'n';
		}
		
		$_SESSION['pesanbukti'] = $rest_val['msg'];

		echo $rest_val['success'].'~'.$rest_val['msg'];
	}
?>
<?php if ($_GET['jen']=='cek_resi') { 
	$arr = array('tipe' => 'web', 'noresi' => $_GET['resi'], 'kurir' => $_GET['kurir'], 'lang' => 'en');
    $rest_trx = loadData('rest_load/load_cek_resi/',$arr); ?>
  	<div class="">
        <div class="bg-putih">
        	<?php if($rest_trx['result']=='jne'){ ?>
        		<div class="alert alert-info"><?=$rest_trx['msg'];?></div>
        	<?php }else{ ?>
            <div class="border-bottom1 mb-2 pb-3">
                <div class="ft-12 color-semidark">Nomor Resi</div>
                <div class="ft-16 color-dark font-weight-bold"><?=$rest_trx['result']['query']['waybill'];?></div>
            </div>
            <div class="">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-5 mb-2">
                        <div class="">
                            <div class="ft-12 color-semidark">Tanggal Pengiriman</div>
                            <div class="ft-16 color-dark"><?=indo($rest_trx['result']['result']['summary']['waybill_date']);?></div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-7 mb-2">
                        <div class="">
                            <div class="ft-12 color-semidark">Service Code</div>
                            <div class="ft-16 color-dark">
                            	<?=$rest_trx['result']['result']['summary']['courier_name'];?> - <?=$rest_trx['result']['result']['summary']['service_code'];?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-2">
                        <div class="">
                            <div class="ft-12 color-semidark">Pembeli & Alamat Pengiriman</div>
                            <div class="ft-16 color-dark">
                                <?=$rest_trx['result']['result']['details']['receiver_name'];?><br>
                            	<?=$rest_trx['result']['result']['summary']['destination'];?> - 
                                <?=$rest_trx['result']['result']['details']['receiver_address1'];?> 
                                <?=$rest_trx['result']['result']['details']['receiver_address2'];?> 
                                <?=$rest_trx['result']['result']['details']['receiver_address3'];?>  
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-5 mb-2">
                        <div class="">
                            <div class="ft-12 color-semidark">Status</div>
                            <div class="ft-16 color-dark">
                                <div class="ft-16 color-app font-weight-bold"><?=$rest_trx['result']['result']['delivery_status']['status'];?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-7 mb-2">
                        <div class="">
                            <div class="ft-12 color-semidark">Diterima Oleh</div>
                            <div class="ft-16 color-dark">
                                <div class="ft-14">
                                	<?=$rest_trx['result']['result']['delivery_status']['pod_receiver'];?><br>
                                	<?=$rest_trx['result']['result']['delivery_status']['pod_date'];?>&nbsp;&nbsp;<?=$rest_trx['result']['result']['delivery_status']['pod_time'];?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-bottom1 mb-3"></div>

                <div class="mb-3">
                    <div class="">
                    	<?php 
                    		$arr_manifest = $rest_trx['result']['result']['manifest'];
                    		$nol = count($rest_trx['result']['result']['manifest']);
                    		$inol = $nol-1;
                    		for ($x = 1; $x <= $nol; $x++) { 
                    	?>
                        <div class="<?php if($nol-$x==$inol) echo 'tanda0'; else echo 'tandamore';?>">
                        	<div class="pb-2">
	                            <div class="ft-14 font-weight-bold mb-1">
	                                <span class="color-dark font-weight-bold"><?=indo($arr_manifest[$nol-$x]['manifest_date']);?></span>
	                                <span class="float-right color-semidark font-weight-400"><?=$arr_manifest[$nol-$x]['manifest_time'];?></span>
	                            </div>
	                            <div class="ft-14 color-semidark"><?=$arr_manifest[$nol-$x]['manifest_description'];?> - <?=$arr_manifest[$nol-$x]['city_name'];?></div>
	                        </div>
                        </div>
	                    <?php } ?>
                    </div>
                </div>
            </div>
          <?php } ?>
        </div>
    </div>
<?php } ?>
<?php if ($_GET['jen']=='ulasan_transaksi') {
	$arr = array('tipe' => 'web', 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'idtrx' => $_GET['idtrx'], 'lang' => 'en');
    $rest_trx = loadData('rest_load/load_ulasan_transaksi/',$arr); ?>
  	<div class="pb-5">
	    <div class="row">
	      <?php 
	      	foreach($rest_trx['result'] as $obj) {

	      		if($obj['rating_produk']!='' || $obj['ulasan_produk']!=''){
	                $iz = "readonly='true'";
	            }else{
	                $iz = "";
	            }
	      ?>
	      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-left mb-1">
	      	<div class="form-group">
	      		<label class="text-left mb-0"><?=$obj['nama_produk'];?> ( <?=$obj['varian'];?> )</label>
	      		<?php if($rest_sistem['result']['metode_rating']!='off'){ ?>
				<div class="rat_produk_trx mb-2 text-left c-pointer">
					<?php if ($iz=='') { ?>
						<?php for ($i=1; $i < 6; $i++) { ?>
						<span class="ft-20" id="rat_trx_star<?=$i.$obj['transaksi_det_id'];?>" onmouseover="iRating(<?=$i;?>,<?=$obj['transaksi_det_id'];?>)"><i class="fa fa-star"></i></span>
						<?php } ?>
					<?php }else{ ?>
						<?php for ($i=1; $i < 6; $i++) { ?>
						<?php if ($obj['rating_produk']>=$i) $colorrat = 'color-warning'; else $colorrat = ''; ?>
						<span class="ft-20 <?=$colorrat;?>"><i class="fa fa-star"></i></span>
						<?php } ?>
					<?php } ?>
				</div>
				<?php }else{ echo '<div class="mb-2"></div>'; } ?>
				<input type="hidden" id="ididrating<?=$obj['transaksi_det_id'];?>" value="5" class="form-control">
	      		<?php if($rest_sistem['result']['metode_ulasan']!='off'){ ?>
		      	<div class="input-group">
					<input type="text" <?=$iz;?> id="ididulasan<?=$obj['transaksi_det_id'];?>" value="<?=$obj['ulasan_produk'];?>" class="form-control" placeholder="Ulasan...">
				  	<div class="input-group-append classclassidbutton<?=$obj['transaksi_det_id'];?>">
				  		<?php if ($iz=='') { ?>
				    		<button class="btn btn-app" type="button" onclick="simpanUlasan('<?=$obj['transaksi_det_id'];?>',ididulasan<?=$obj['transaksi_det_id'];?>.value,ididrating<?=$obj['transaksi_det_id'];?>.value)"><span class="icon-check"></span></button>
				    	<?php } ?>
				  	</div>
				</div>
				<?php }else{ ?>
				  	<?php if ($iz=='') { ?>
					  	<div class="classclassidbutton<?=$obj['transaksi_det_id'];?>">
							<button class="btn btn-app btn-sm" type="button" onclick="simpanUlasan('<?=$obj['transaksi_det_id'];?>','',ididrating<?=$obj['transaksi_det_id'];?>.value)"><span class="icon-check"></span></button>
						</div>
					<?php } ?>
				<?php } ?>
			</div>
	      </div>
	      <?php } ?>
	    </div>
  	</div>
<?php } ?>
<?php if ($_GET['jen']=='semua_ulasan_produk') {
	$arr = array('tipe' => 'all', 'idproduk' => $_GET['idproduk'], 'lang' => 'en');
    $rest_ulasan = loadData('rest_load/load_ulasan_produk/',$arr); ?>
  	<div class="pb-5">
	    <div class="row">
	        <?php foreach($rest_ulasan['result'] as $objp) { ?>
	        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
	          <div class="card card-body mb-3">
	            <div class="media align-items-center align-items-lg-start text-center text-lg-left flex-column flex-lg-row">
	              <div class="mr-hid-mob-3 mb-3 mb-lg-0">
	                <div class="account-div-ulasan_img rounded-circle box-shadow-v1" style="background: url('<?=$main_imgurl;?>profile/<?=$rest_cust['result']['cust_gambar'];?>');"></div>
	              </div>
	              <div class="media-body overflow-hidden w-100">
	                <h6 class="media-title font-weight-semibold mb-0 text-overflow-ellips font-weight-bold">
	                  <?=$objp['cust_nama'];?>
	                </h6>
	                <ul class="list-inline list-inline-dotted mb-0 mb-lg-0 text-overflow-ellips">
	                  <?php if ($rest_sistem['result']['metode_rating']!='off') { ?>
	                  <li class="list-inline-item ft-14"><i class="fa fa-star color-warning"></i>&nbsp;<?=$objp['rating_produk'];?></li>
	                  <?php } ?>
	                  <li class="list-inline-item ft-14 text-muted d-sm-inline">
	                    <?=$objp['varian'];?>
	                  </li>
	                </ul>
	                <p class="mb-1 ft-14 color-semidark"><?=$objp['ulasan_produk'];?></p>
	                <p class="mb-0 ft-12 text-right color-semidark"><?=$objp['tgl_ulasan'];?></p>
	              </div>
	            </div>
	          </div>
	        </div>
	        <?php } ?>
	    </div>
  	</div>
<?php } ?>
<?php if ($_GET['jen']=='simpan_ulasan_rating') {
		$arr = array(
			'tipe' => 'web', 
			'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 
			'idtrx' => $_POST['idtrx'], 
			'ulasan' => $_POST['ulasan'], 
			'rating' => $_POST['rating'], 
			'lang' => 'en'
		);
		$rest_val = loadData('rest_proses/proses_simpan_ulasan_rating/', $arr);

		if ($rest_val['success']==true) {
			$rest_val['success'] = 'y';
		}else{
			$rest_val['success'] = 'n';
		}

		echo $rest_val['success'].'~'.$rest_val['msg'];
	}
?>
<?php if ($_GET['jen']=='auto_cek_notifikasi') {
		$arr = array(
			'tipe' => 'web', 
			'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 
			'lang' => 'en'
		);
		$rest_val = loadData('rest_load/load_auto_cek_notifikasi/', $arr);
		echo $rest_val['msg'];
	}
?>
<?php if ($_GET['jen']=='modal_detail_tarik_saldo') {
$arr = array('tipe' => 'web', 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'uid' => decodeData($_GET['uid']), 'lang' => 'en');
$rest_getdata = loadData('rest_load/load_tarik_saldo_detail/',$arr); 
$all_data = $rest_getdata['result']; 
?>
<div class="close_pfda" data-dismiss="modal"><span class="icon-close2"></span></div>
<div class="text-center p-mob-30">
  <div class="section-title ft-18 text-center mb-3">
      &mdash; <?=decodeData($_GET['uid']);?> &mdash;
  </div>
  <div class="row text-center pb-3 pr-3 pl-3">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
		<div class="">
		<div class="padding-15">
			<div class="ft-14 font-weight-bold mb-1">Penarikan Saldo</div>
			<h4 class="font-weight-bold mb-1"><?=formatRupiah($all_data['nominal']);?></h4>
			<?php
				if($all_data['is_status']=='p'){
					echo '<span class="badge badge-warning">Menunggu konfirmasi</span>';
				}else if($all_data['is_status']=='y'){
					echo '<span class="badge badge-success">Diterima & Selesai</span>';
				}else if($all_data['is_status']=='b'){
					echo '<span class="badge badge-danger">Ditolak</span>';
				}else{
					echo '<span class="badge badge-light">Unknown</span>';
				}
			?>
		</div>
		<hr>
		<div class="padding-0-15">
			<div class="ft-14 pb-3">
				<div class="ft-14 font-weight-bold mb-1">
					Bank/E-Wallet Tujuan
				</div>
				<div>Mandiri</div>
				<div class="ft-14 font-weight-bold mb-1">
					Nama Rekening
				</div>
				<div><?=$all_data['nama_rekening'];?></div>
				<div class="ft-14 font-weight-bold mb-1">
					Nomor Rekening
				</div>
				<div><?=$all_data['nomor_rekening'];?></div>
			</div>
		</div>
		</div>
    </div>
  </div>
</div>
<?php } ?>
<?php if ($_GET['jen']=='metode_tripay') {
		$arr = array('tipe' => 'web', 'lang' => 'en' );
		$rest_val = loadData('rest_load/load_metode_tripay/', $arr); ?>
		<?php if ($rest_val['result']['success']==true) { ?>
			<div class="row">
		    <?php foreach($rest_val['result']['data'] as $obj) { ?>
		    <div class="col-xl-12 col-lg-12">
		    	<label class="d-block c-pointer" onclick="selectpayTripay('<?=$obj['code'];?>')">
			      <div class="padding-15 mb-3 border-radius-5 border-d" style="background: #f3f4f5;">
			        <div class="float-right">
			          <input type="radio" name="tripay_code" id="tripay_code<?=$obj['code'];?>" style="margin-top: 7px;" value="<?=$obj['code'];?>" required="required">
			        </div>
			        <div class="ft-14 font-weight-bold">
			        	<img src="<?=$obj['icon_url'];?>" class="img-fluid mr-2" width="40">
			        	<?=$obj['name']?>
			        </div>
			      </div>
		  		</label>
		    </div>
		    <?php } ?>
		    <input type="hidden" id="tripay_codex" class="form-control">
	  	</div>
	  	<script type="text/javascript">
	  		function selectpayTripay(a){
	        $("#tripay_code"+a).prop("checked", true);
	        $('#tripay_codex').val(a);
	      }
	  	</script>
		<?php }else{ echo "ERR: ".$rest_val['result']['message']; } ?>
<?php } ?>