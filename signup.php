<?php 
  
  include "module/module.php"; 

  if ($_SESSION['XID_ARRAY'] && $_SESSION['XID_ARRAY']['cust_id']!='guest') {
    header("Location: ".$main_url); exit();
  }

  $arr = array('idunique' => $_GET['p_url'], 'lang' => 'en');
  $reset_check = loadData('rest_load/reset_password/', $arr); 

?>
<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <meta name="keywords" content="<?=$rest_sistem['result']['meta_keywords'];?>">
    
    <meta property="og:title" content="Signin - <?=$rest_sistem['result']['meta_title'];?>">
    <meta property="og:description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <meta property="og:image" content="<?=$main_imgurl.'logo/'.$rest_sistem['result']['logo_toko_image'];?>">
    <meta property="og:url" content="<?=$main_url;?>signin">
    
    <?php include "module/include/style.php"; ?>

    <title>Signin - <?=$rest_sistem['result']['meta_title'];?></title>
  </head>
  <body>

    <?php include "module/include/header.php"; ?>

    <section class="bg-container-2 mt-4 mb-5">
      <div class="row justify-content-center mb-30">
        <div class="col-xl-10 col-lg-10 col-md-11">
          <div class="section-title ft-28 text-center">
            &mdash; Form Daftar &mdash;
          </div>
          <?php 
            if (isset($_SESSION['trxrpassl_msg']) && $_SESSION['trxrpassl_msg'] <> '') {
                echo '<div class="alert alert-info mb-3 mt-3">'.$_SESSION['trxrpassl_msg'].'</div>';
            }
            $_SESSION['trxrpassl_msg'] = '';
          ?>
        </div>
      </div>
      <div class="row justify-content-center mb-30">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-9">
        <?php if ($rest_sistem['result']['login_whatsapp']=='y') { ?>
		    <ul class="nav nav-tabs b-0 mb-4" id="myTab" role="tablist">
			    <li class="nav-item">
			      <a class="nav-link active ft-14" id="wa-ltaba" data-toggle="tab" href="#tabwaa" role="tab" aria-controls="tabwaa" aria-selected="false">WhatsApp</a>
			    </li>
			    <li class="nav-item">
			      <a class="nav-link ft-14" id="email-ltabl" data-toggle="tab" href="#tabemaill" role="tab" aria-controls="tabemaill" aria-selected="true">Email Address</a>
			    </li>
                <!-- <li class="nav-item">
                  <a class="nav-link active ft-14" id="email-ltabl" data-toggle="tab" href="#tabemaill" role="tab" aria-controls="tabemaill" aria-selected="true">Email Address</a>
                </li>
                <li class="nav-item">
			      <a class="nav-link ft-14" id="wa-ltaba" data-toggle="tab" href="#tabwaa" role="tab" aria-controls="tabwaa" aria-selected="false">WhatsApp</a>
			    </li> -->
			</ul>
			<?php } ?>
			<div class="tab-content" id="myTabContent">
            	<div class="tab-pane fade <?php if($rest_sistem['result']['login_whatsapp']=='n') echo 'show active'; ?>" id="tabemaill" role="tabpanel" aria-labelledby="email-ltab">
			      	<form id="form_registration" action="javascript:goRegistrasi(1)" method="POST">
				       	<div class="form-group mb-1 text-left">
				       		<label class="">Alamat Email</label>
							<div class="input-group">
							  	<input type="text" class="form-control ft-16" name="alamat_email" required="">
							  	<div class="input-group-append">
								    <button class="btn btn-app" type="submit"><span class="icon-sign-in"></span></button>
								</div>
							</div>
						</div>
					</form>
			      	<form class="d-none" id="form_activation_otp_resis" action="javascript:goActivationOtp(1)" method="POST">
						<div class="form-group text-left">
				       		<label class="">Aktivasi</label>
							<div class="input-group">
							  	<input type="text" class="form-control ft-16" name="kode_otp" placeholder="Masukan kode OTP">
							  	<input type="hidden" class="form-control ft-16" name="alamat_email" id="val_activation_otp_email">
							  	<div class="input-group-append">
								    <button class="btn btn-app" type="submit"><span class="icon-sign-in"></span></button>
								</div>
							</div>
						</div>
					</form>
					<div id="xxxnotif_otp"></div>
				</div>
				<div class="tab-pane fade <?php if($rest_sistem['result']['login_whatsapp']=='y') echo 'show active'; ?>" id="tabwaa" role="tabpanel" aria-labelledby="wa-ltab">
			      	<form id="form_registrationwa" action="javascript:goRegistrasi(2)" method="POST">
				       	<div class="form-group mb-1 text-left">
				       		<label class="">Nomor WhatsApp</label>
							<div class="input-group">
							  	<input type="text" class="form-control ft-16" name="alamat_email" required="">
							  	<div class="input-group-append">
								    <button class="btn btn-app" type="submit"><span class="icon-sign-in"></span></button>
								</div>
							</div>
						</div>
					</form>
			      	<form class="d-none" id="form_activation_otp_resiswa" action="javascript:goActivationOtp(2)" method="POST">
						<div class="form-group text-left">
				       		<label class="">Aktivasi</label>
							<div class="input-group">
							  	<input type="text" class="form-control ft-16" name="kode_otp" placeholder="Masukan kode OTP">
							  	<input type="hidden" class="form-control ft-16" name="alamat_email" id="val_activation_otp_emailwa">
							  	<div class="input-group-append">
								    <button class="btn btn-app" type="submit"><span class="icon-sign-in"></span></button>
								</div>
							</div>
						</div>
					</form>
					<div id="xxxnotif_otpwa"></div>
				</div>
			</div>
			<div class="ft-14 mt-3 mb-3 text-center">atau daftar dengan</div>
		    <a href="<?=$google_login_url?>" class="btn btn-danger btn-block p-2 border-e4 hv-a-google" style="border-radius: 100px">
		    	<span class="icon-google mr-2"></span> <span class="ft-14"> Daftar dengan Google </span>
		    </a>
		    <div class="text-left mt-4 color-semidark">
		    	Dengan melanjutkan, Anda menunjukkan bahwa Anda menerima kami <a href="<?=$main_url;?>terms-of-use">Syarat dan Ketentuan</a> dan <a href="<?=$main_url;?>privacy-policy">Kebijakan Privasi</a>.
		    </div>
	    </div>
	  </div>
    </section>

    <?php include "module/include/footer.php"; ?>
    
    <?php include "module/include/javascript.php"; ?>

  </body>
</html>