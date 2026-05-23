      <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
          <div class="site-mobile-menu-close mt-3">
            <span class="icon-close2 js-menu-toggle"></span>
          </div>
        </div>
        <div class="site-mobile-menu-body"></div>
      </div>

      <div class="top-bar border-bottom1">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="float-right">
                <a href="#myModalVoucher" data-toggle="modal" data-target="#myModalVoucher" class="">Voucher</a>
                <span class="mx-md-2 d-inline-block"></span>
                <a href="<?=$main_url;?>about-us" class="">Tentang Kami</a>
                <span class="mx-md-2 d-inline-block"></span>
                <a href="<?=$main_url;?>contact-us" class="">Kontak Kami</a>
                <span class="mx-md-2 d-inline-block"></span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <header class="site-navbar js-sticky-header site-navbar-target header-shadow" role="banner">

        <div class="container">
          <div class="row align-items-center position-relative">

            <div class="site-logo">
              <a href="<?=$main_url;?>">
                <img src="<?=$main_imgurl;?>logo/<?=$rest_sistem['result']['logo_toko_image'];?>">
              </a>
            </div>

            <div class="col-12">
              <nav class="site-navigation text-right ml-auto " role="navigation">

                <ul class="site-menu main-menu js-clone-nav ml-auto d-none d-lg-block" id="selectedmenunav">
                  <li><a href="<?=$main_url;?>" class="nav-link ixm">Beranda</a></li>
                  <li><a href="<?=$main_url;?>categories" class="nav-link ixm">Kategori</a></li>
                  <li><a href="<?=$main_url;?>best-seller" class="nav-link ixm">Best <sup><span class="badge badge-danger">Hot</span></sup></a></li>
                  <?php if ($rest_sistem['result']['is_hide_menu_digital']=='n') { ?>
                  <li><a href="<?=$main_url;?>product-digitals" class="nav-link ixm">Produk Digital</a></li>
                  <?php } ?>
                  <li class="visible-891"><a href="<?=$main_url;?>new-products" class="nav-link ixm">Produk Terbaru</a></li>
                  <li><a href="<?=$main_url;?>new-arrivals" class="nav-link ixm">New Arrivals</a></li>
                  <li><a href="javascript:myModalsearch()" class="nav-link"><span class="icon-search"></span></a></li>
                  <li><a href="javascript:myModalCart()" class="nav-link">
                    <span class="icon-shopping-basket"></span>&nbsp;&nbsp;<span class="jumlah_cart_my_id"></span></a>
                  </li>
                  <?php if (isset($_SESSION['XID_ARRAY']) && $_SESSION['XID_ARRAY']['cust_id']!='guest') { ?>
                  <li class="has-children account-div-signin">
                    <a href="#account-section" class="nav-link">
                      <div class="account-div-signin_img rounded-circle box-shadow-v1" style="background: url('<?=$main_imgurl;?>profile/<?=$rest_cust['result']['cust_gambar'];?>');"></div>&nbsp;
                    </a>
                    <ul class="dropdown arrow-top">
                      <?php if ($rest_sistem['result']['fitur_saldo']=='y') { ?>
                      <li class="border-bottom1">
                        <a href="<?=$main_url;?>balance" class="nav-link ft-14">
                          <span class="ft-12">Saldo :</span> <span class="color-dark font-weight-500"><?=$rest_cust['saldo'];?></span>
                        </a>
                      </li>
                      <?php } ?>
                      <li class="border-bottom1"><a href="<?=$main_url;?>account" class="nav-link">Akun</a></li>
                      <li class="border-bottom1"><a href="<?=$main_url;?>account" class="nav-link">Riwayat&nbsp;Transaksi</a></li>
                      <li class="border-bottom1"><a href="<?=$main_url;?>wishlist" class="nav-link">Wishlist</a></li>
                      <li class="border-bottom1"><a href="javascript:openNotifikasi()" class="nav-link">Notifikasi <span class="notifikasiidcheckcls notifikasiidcheck" id="notifikasiidcheck">&nbsp;</span></a></li>
                      <?php if ($rest_sistem['result']['fitur_chat']=='y') { ?>
                      <li class="border-bottom1"><a href="javascript:openChat()" class="nav-link">Live Chat <span class="notifikasiidcheck" id="livechatidcheck">&nbsp;</span></a></li>
                      <?php } ?>
                      <li><a href="javascript:pSignout()" class="nav-link text-center"><span class="icon-sign-out mr-3"></span></a></li>
                    </ul>
                  </li>
                  <?php }else{ ?>
                  <li>
                    <a href="javascript:myModalDaftar()" class="nav-link btn-daftar-menubar mr-lg-1">Daftar</a>
                    <a href="javascript:myModalLogin()" class="nav-link btn-login-menubar mr-lg-1 ml-lg-1">Masuk</a>
                  </li>
                  <?php } ?>

                </ul>
              </nav>

              <?php 
                $arr = array('lang' => 'en');
                $rest_kategori_t = loadData('rest_load/load_sub_kategori_pilihan_satu/',$arr);
              ?>
              <?php if ($rest_kategori_t['rows']>0) { ?>
              <div class="text-right mr-1">
                <div class="sub-menu-k">
                  <?php foreach($rest_kategori_t['result'] as $obj) { ?>
                  <?php 
                    if ($obj['tipe_k']=='lv2') { 
                      $ulinktopkateg = $main_url.'c2/'.$obj['url_k'].'/'.$obj['url_l'].'/'.$obj['url_kategori']; 
                    }else{
                      $ulinktopkateg = $main_url.'c1/'.$obj['url_k'].'/'.$obj['url_kategori']; 
                    }
                  ?>
                  <span class="ml-2"><a href="<?=$ulinktopkateg;?>" class="ft-12"><?=$obj['nama_kategori'];?></a></span>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
            </div>

            <div class="toggle-button d-inline-block d-lg-none">
              <a href="#" class="site-menu-toggle py-5 js-menu-toggle text-black color-app"><span class="icon-menu h3"></span></a>
            </div>

          </div>
        </div>

      </header>