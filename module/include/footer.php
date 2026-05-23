    <?php
      $arr = array('ip' => $_SERVER['REMOTE_ADDR'], 'lang' => 'en');
      $track_visit = loadData('rest_proses/track_visit/',$arr);

      $arr = array('lang' => 'en');
      $statistic_visitors = loadData('rest_proses/get_statistic_visitors/',$arr);
    ?>    

    <div class="visible-768-s">
      <div class="navbar-bottom-fix d-i-flex a-i-c text-center">
        <div class="w-100">
          <a href="<?=$main_url;?>" class="color-dark">
           <i class="bx icon-home"></i>
           <div class="ft-14" style="margin-top: -3px;">Beranda</div>
          </a>
        </div>
        <div class="w-100">
          <a href="<?=$main_url;?>categories" class="color-dark">
            <i class="bx icon-cubes"></i>
            <div class="ft-14" style="margin-top: -3px;">Kategori</div>
          </a>
        </div>
        <div class="w-100">
          <a href="<?=$main_url;?>cek-transaksi" class="color-dark">
            <i class="bx icon-receipt"></i>
            <div class="ft-14" style="margin-top: -3px;">Cek Transaksi</div>
          </a>
        </div>
        <div class="w-100">
          <?php if (isset($_SESSION['XID_ARRAY']) && $_SESSION['XID_ARRAY']['cust_id']!='guest') { ?>
          <a href="<?=$main_url;?>account" class="color-dark">
            <i class="bx icon-user"></i>
            <div class="ft-14" style="margin-top: -3px;">Akun</div>
          </a>
          <?php }else{ ?>
          <a href="javascript:myModalLogin()" class="color-dark">
            <i class="bx icon-sign-in"></i>
            <div class="ft-14" style="margin-top: -3px;">Login</div>
          </a>
          <?php } ?>
        </div>
      </div>
    </div>

    <footer class="<?=$rest_sistem['result']['ui_footer'];?> footer footer-pb-mob" id="footer_app_inav">
      <div class="footer__addr">
        <h1 class="footer__logo"><img src="<?=$main_imgurl;?>logo/<?=$rest_sistem['result']['logo_toko_image'];?>" width="180"></h1>
        <div style="white-space: pre-line;">
          <?=$rest_sistem['result']['label_footer'];?>
        </div>
        <h2 class="nav__title mt-3 mb-3">Stay Tuned</h2>
        <div class="stay_tuned_footer">
          <?php if ($rest_sistem['result']['facebook']!=''){ ?>
          <a href="<?=$rest_sistem['result']['facebook'];?>" target="_blank" class="mr-2"><span class="icon-facebook"></span></a>
          <?php } ?>
          <?php if ($rest_sistem['result']['instagram']!=''){ ?>
          <a href="<?=$rest_sistem['result']['instagram'];?>" target="_blank" class="mr-2"><span class="icon-instagram"></span></a>
          <?php } ?>
          <?php if ($rest_sistem['result']['whatsapp']!=''){ ?>
          <a href="https://api.whatsapp.com/send?phone=<?=$rest_sistem['result']['whatsapp'];?>&amp;text=" target="_blank" class="mr-2"><span class="icon-whatsapp"></span></a>
          <?php } ?>
          <?php if ($rest_sistem['result']['call_center']!=''){ ?>
          <a href="tel:<?=$rest_sistem['result']['call_center'];?>" target="_blank" class="mr-2"><span class="icon-phone"></span></a>
          <?php } ?>
          <?php if ($rest_sistem['result']['email_address']!=''){ ?>
          <a href="mailto:<?=$rest_sistem['result']['email_address'];?>"><span class="icon-envelope"></span></a>
          <?php } ?>
        </div>
      </div>
  
      <ul class="footer__nav">
        <li class="nav__item mb-3">
          <h2 class="nav__title">Halaman</h2>
          <ul class="nav__ul">
            <li><a href="<?=$main_url;?>about-us">Tentang Kami</a></li>
            <li><a href="<?=$main_url;?>contact-us">Kontak Kami</a></li>
            <li><a href="<?=$main_url;?>faqs">FAQs</a></li>
            <li><a href="<?=$main_url;?>terms-conditions">Syarat dan Ketentuan</a></li>
            <li><a href="<?=$main_url;?>privacy-policy">Kebijakan Privasi</a></li>
          </ul>
        </li>
        <li class="nav__item mb-3">
          <h2 class="nav__title">&nbsp;</h2>
          <ul class="nav__ul">
            <li><a href="<?=$main_url;?>categories">Kategori</a></li>
            <li><a href="<?=$main_url;?>new-products">Produk Terbaru</a></li>
            <li><a href="<?=$main_url;?>best-seller">Best Seller <sup><span class="badge badge-danger">Hot</span></sup></a></li>
            <li><a href="<?=$main_url;?>new-arrivals">New Arrivals</a></li>
            <li><a href="<?=$main_url;?>cek-transaksi">Cek Transaksi</a></li>
          </ul>
        </li>
        <li class="nav__item mb-3">
          <h2 class="nav__title">Download App</h2>
          <ul class="nav__ul">
            <li><a href="javascript:myModalDownloadapp()">Google</a></li>
            <li><a href="javascript:myModalDownloadapp()">iOS</a></li>
          </ul>
          <div class="mt-3">
            <h2 class="nav__title">Keamanan & Privasi</h2>
            <img src="<?=$main_url;?>assets/images/secure_logo.png" width="220">
          </div>
          <?php if($rest_sistem['result']['status_statistik']=='y'){ ?>
          <div class="mt-3">
            <div class="" style="background: #474747;padding: 10px 15px;border-radius: 10px;border: 2px solid #fff;line-height: 25px;font-size: 14px;">
              <div class="">Total Pengunjung : <?=$statistic_visitors['total_visitors'];?></div>
              <div class="">Total Interaksi : <?=$statistic_visitors['total_visitors_pages'];?></div>
              <div class="text-success"><b>Pengunjung Hari Ini : <?=$statistic_visitors['today_visitors'];?></b></div>
              <div class="text-success"><b>Interaksi Hari Ini : <?=$statistic_visitors['visitors_pages'];?></b></div>
              <div class="text-success"><b>Online : <?=$statistic_visitors['online_visitors'];?></b></div>
            </div>
          </div>
          <?php } ?>
        </li>
      </ul>
      
      <div class="p-4 rounded mb-4 rounded-2" style="background:#f5f6f8;">
    
        <!-- Title -->
        <h5 class="font-weight-bold mb-4">Metode Pembayaran</h5>
    
        <!-- Grid Payment -->
        <div class="row align-items-center justify-content-center">
            
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/pay/qris.png" class="pay-logo">
            </div>
          </div>

          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/pay/bca.png" class="pay-logo">
            </div>
          </div>
    
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/pay/mandiri.png" class="pay-logo">
            </div>
          </div>
    
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/pay/bri.png" class="pay-logo">
            </div>
          </div>
    
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/pay/bni.png" class="pay-logo">
            </div>
          </div>
          
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/pay/bsi.png" class="pay-logo">
            </div>
          </div>
          
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/pay/permata.png" class="pay-logo">
            </div>
          </div>    
    
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/pay/dana.png" class="pay-logo">
            </div>
          </div>
    
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/pay/gopay.png" class="pay-logo">
            </div>
          </div>
    
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/pay/ovo.png" class="pay-logo">
            </div>
          </div>
    
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2 d-none">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/pay/jago.png" class="pay-logo">
            </div>
          </div>
          
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2 d-none">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/pay/linkaja.png" class="pay-logo">
            </div>
          </div>
          
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/pay/alfamart.png" class="pay-logo">
            </div>
          </div>
    
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/pay/indomaret.png" class="pay-logo">
            </div>
          </div>
    
        </div>
      </div>
      
      <div class="p-4 rounded mb-4 rounded-2" style="background:#f5f6f8;">
    
        <!-- Title -->
        <h5 class="font-weight-bold mb-4">Layanan Pengiriman</h5>
    
        <!-- Grid Payment -->
        <div class="row align-items-center justify-content-center">
            
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/expedisi/logo-jnt.png" class="pay-logo">
            </div>
          </div>
          
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/expedisi/logo-jne.png" class="pay-logo">
            </div>
          </div>
          
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/expedisi/logo-tiki.png" class="pay-logo">
            </div>
          </div>
          
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/expedisi/logo-pos.png" class="pay-logo">
            </div>
          </div>
          
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/expedisi/logo-sicepat.png" class="pay-logo">
            </div>
          </div>
          
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/expedisi/logo-ninja.png" class="pay-logo">
            </div>
          </div>
          
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/expedisi/logo-lion.png" class="pay-logo">
            </div>
          </div>
          
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/expedisi/logo-sentral-cargo.png" class="pay-logo">
            </div>
          </div>
          
          <div class="col-4 col-md-3 col-lg-2 mb-3 pl-2 pr-2">
            <div class="pay-box">
              <img src="<?=$main_url;?>assets/expedisi/logo-sap.png" class="pay-logo">
            </div>
          </div>
    
        </div>
      </div>
  
      <div class="legal">
        <p>
            <?=$rest_sistem['result']['footer'];?> 
            Powered by <a href="https://cgdev.my.id" target="_blank">cgdev</a>
        </p>
      </div>
    </footer>