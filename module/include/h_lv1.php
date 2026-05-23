      <div class="navbarv1-store">
        <div class="overlay" id="sidebarCollapseStoreXx"></div>
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

        <div class="header-shadow js-sticky-header bg-putih">
          <nav class="navbar navbar-expand-md navbar-light bg-light main-menu-store pb-0 mb-imob-5 pt-imob-3" style="box-shadow:none!important">
            <div class="container inavcontainer-x">

              <a href="<?=$main_url;?>" class="navbar-brand">
                <img src="<?=$main_imgurl;?>logo/<?=$rest_sistem['result']['logo_toko_image'];?>" style="max-height:30px;">
              </a>

              <ul class="navbar-nav ml-auto d-block d-md-none">
                <li class="nav-item">
                  <a href="javascript:myModalCart()" class="btn btn-link pr-0">
                    <span class="bx icon-shopping-basket icon-single icartcount"></span>&nbsp;&nbsp;<span class="jumlah_cart_my_idx badge badge-danger">0+</span>
                  </a>
                  <a href="javascript:" id="sidebarCollapseStore" class="btn btn-link d-inline d-md-none">
                    <span class="bx icon-menu icon-single icartcount"></span>
                  </a>
                </li>
              </ul>

              <div class="collapse navbar-collapse">
                <form action="javascript:goRedirect('search')" method="POST" class="form-inline my-2 my-lg-0 mx-auto">
                  <input type="search" class="form-control" id="searchtext_val" placeholder="Cari apapun disini..." autocomplete="off">
                  <button class="btn btn-app my-2 my-sm-0" type="submit"><i class="bx icon-search"></i></button>
                </form>

                <?php if (isset($_SESSION['XID_ARRAY']) && $_SESSION['XID_ARRAY']['cust_id']!='guest') { ?>
                <ul class="navbar-nav a-i-c navmvsec">
                  <li class="has-children account-div-signin">
                    <a href="#account-section" class="nav-link btn-daftar-menubar navbrvsec mt-sm-0">Akun</a>
                    <ul class="dropdown arrow-top mt-2">
                      <?php if ($rest_sistem['result']['fitur_saldo']=='y') { ?>
                      <li class="border-bottom1">
                        <a href="<?=$main_url;?>balance" class="nav-link ft-14">
                          <span class="ft-12">Saldo :</span> <span class="color-dark font-weight-500"><?=$rest_cust['saldo'];?></span>
                        </a>
                      </li>
                      <?php } ?>
                      <li class="border-bottom1"><a href="<?=$main_url;?>account" class="nav-link">Data&nbsp;Informasi</a></li>
                      <li class="border-bottom1"><a href="<?=$main_url;?>account" class="nav-link">Riwayat&nbsp;Transaksi</a></li>
                      <li class="border-bottom1"><a href="javascript:openNotifikasi()" class="nav-link">Notifikasi <span class="notifikasiidcheckcls notifikasiidcheck" id="notifikasiidcheck">&nbsp;</span></a></li>
                      <?php if ($rest_sistem['result']['fitur_chat']=='y') { ?>
                      <li class="border-bottom1"><a href="javascript:openChat()" class="nav-link">Live Chat <span class="notifikasiidcheck" id="livechatidcheck">&nbsp;</span></a></li>
                      <?php } ?>
                      <li><a href="javascript:pSignout()" class="nav-link text-center"><span class="icon-sign-out mr-3"></span></a></li>
                    </ul>
                  </li>
                  <li class="nav-item ml-lg-4 ml-md-3">
                    <a href="<?=$main_url;?>wishlist" class="btn btn-link pl-xl-0">
                      <span class="bx icon-heart icon-single icartcount"></span>
                    </a>
                  </li>
                  <li class="nav-item ml-lg-2 ml-md-0">
                    <a href="javascript:myModalCart()" class="btn btn-link pl-xl-0">
                      <span class="bx icon-shopping-basket icon-single icartcount"></span>&nbsp;&nbsp;<span class="jumlah_cart_my_id badge badge-danger">0+</span>
                    </a>
                  </li>
                </ul>
                <?php }else{ ?>
                <ul class="navbar-nav a-i-c">
                  <li class="nav-item">
                    <a href="javascript:myModalCart()" class="btn btn-link pl-xl-0">
                      <span class="bx icon-shopping-basket icon-single icartcount"></span>&nbsp;&nbsp;<span class="jumlah_cart_my_id badge badge-danger">0+</span>
                    </a>
                  </li>
                  <li class="nav-item ml-md-3">
                    <a href="javascript:myModalDaftar()" class="nav-link btn-daftar-menubar mt-sm-0">Daftar</a>
                  </li>
                  <li class="nav-item ml-md-3">
                    <a href="javascript:myModalLogin()" class="nav-link btn-login-menubar navbrvsec mt-sm-0">Masuk</a>
                  </li>
                </ul>
                <?php } ?>
              </div>

            </div>
          </nav>

          <nav class="navbar navbar-expand-md navbar-light bg-light sub-menu-store">
            <div class="container">
              <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav ml-auto" id="selectedmenunax">
                  <li class="nav-item">
                    <a class="nav-link ft-14" href="<?=$main_url;?>">Beranda <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link ft-14" href="<?=$main_url;?>categories">Kategori</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link ft-14" href="<?=$main_url;?>best-seller">Best Seller <sup><span class="badge badge-danger">Hot</span></sup></a>
                  </li>
                  <?php if ($rest_sistem['result']['is_hide_menu_digital']=='n') { ?>
                  <li class="nav-item">
                    <a class="nav-link ft-14 pr-0" href="<?=$main_url;?>product-digitals">Produk Digital</a>
                  </li>
                  <?php } ?>
                  <li class="nav-item">
                    <a class="nav-link ft-14 pr-0" href="<?=$main_url;?>new-products">Produk Terbaru</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link ft-14 pr-0" href="<?=$main_url;?>new-arrivals">New Arrivals</a>
                  </li>
                  <!-- <li class="nav-item dropdown">
                    <a class="nav-link ft-14 pr-0 dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Support</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="#">Privacy Policy</a>
                      <a class="dropdown-item" href="#">Terms & Conditions</a>
                    </div>
                  </li> -->
                </ul>
              </div>
            </div>
          </nav>
        </div>

        <!-- Sidebar -->
        <nav id="sidebarStore">
          <div class="sidebar-header-store">
            <div class="container">
              <div class="row align-items-center">
                <div class="col-10 pl-0">
                  <?php if (isset($_SESSION['XID_ARRAY']) && $_SESSION['XID_ARRAY']['cust_id']!='guest') { ?>
                    <a href="<?=$main_url;?>account" class="produk-detail-i-flex-normal a-i-c">
                      <div class="account-div-signin_imgsec rounded-circle box-shadow-v1 mr-3" style="background: url('<?=$main_imgurl;?>profile/<?=$rest_cust['result']['cust_gambar'];?>');"></div>
                      <div class="font-weight-bold"><?=$rest_cust['result']['cust_nama'];?></div>
                    </a>
                    <?php if ($rest_sistem['result']['fitur_saldo']=='y') { ?>
                    <div class="mt-2">
                      <a href="<?=$main_url;?>balance">
                        <span class="ft-12_">Saldo :</span> <span class="color-dark font-weight-500"><?=$rest_cust['saldo'];?></span>
                      </a>
                    </div>
                    <?php } ?>
                    <div class="mt-2">
                      <a href="<?=$main_url;?>account" class="badge badge-primary mr-1">Riwayat Transaksi</a>
                      <a href="<?=$main_url;?>wishlist" class="badge badge-primary mr-1">Wishlist</a>
                      <a href="javascript:openNotifikasi()" class="badge badge-primary mr-1">Notifikasi</a>
                      <?php if ($rest_sistem['result']['fitur_chat']=='y') { ?>
                      <a href="javascript:openChat()" class="badge badge-primary mr-1">Live Chat</a>
                      <?php } ?>
                      <a href="javascript:pSignout()" class="badge badge-danger mr-1"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;Keluar</a>
                    </div>
                  <?php }else{ ?>
                  <a href="javascript:myModalDaftar()" class="btn btn-primary mr-1">Daftar</a>
                  <a href="javascript:myModalLogin()" class="btn btn-outline-primary mr-1">Masuk</a>
                  <?php } ?>
                </div>

                <div class="col-2 pr-0 text-right">
                  <a href="javascript:" type="button" id="sidebarCollapseStoreX" class="btn btn-link pr-0">
                    <i class="bx icon-close2 icon-single"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <ul class="list-unstyled components links" id="selectedmenunaximob">
            <li>
              <a href="<?=$main_url;?>"><i class="bx icon-home mr-3"></i> Beranda</a>
            </li>
            <li>
              <a href="<?=$main_url;?>categories"><i class="bx icon-cubes mr-3"></i> Kategori</a>
            </li>
            <li>
              <a href="<?=$main_url;?>best-seller"><i class="bx icon-star mr-3"></i> Best Seller</a>
            </li>
            <?php if ($rest_sistem['result']['is_hide_menu_digital']=='n') { ?>
            <li>
              <a href="<?=$main_url;?>product-digitals"><i class="bx icon-leaf mr-3"></i> Produk Digital</a>
            </li>
            <?php } ?>
            <li>
              <a href="<?=$main_url;?>new-products"><i class="bx icon-heart mr-3"></i> Produk Terbaru</a>
            </li>
            <li>
              <a href="<?=$main_url;?>new-arrivals"><i class="bx icon-tags mr-3"></i> New Arrivals</a>
            </li>
            <!-- <li>
              <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="bx icon-help mr-3"></i> Support
              </a>
              <ul class="collapse list-unstyled" id="pageSubmenu">
                <li><a href="#">Privacy Policy</a></li>
              </ul>
            </li> -->
          </ul>

          <form action="javascript:goRedirect('searchmob')" method="POST">
            <div class="input-group">
              <input type="text" class="form-control ft-16" id="searchtext_valmob" placeholder="Cari apapun di sini..." autocomplete="off">
              <div class="input-group-append">
                <button class="btn btn-app" type="submit"><span class="icon-search"></span></button>
              </div>
            </div>
          </form>

        </nav>
      </div>

      <script type="text/javascript">
        $(document).ready(function() {
        $("#sidebarCollapseStore").on("click", function() {
          $("#sidebarStore").addClass("active");
        });

        $("#sidebarCollapseStoreX").on("click", function() {
          $("#sidebarStore").removeClass("active");
        });

        $("#sidebarCollapseStoreXx").on("click", function() {
          $("#sidebarStore").removeClass("active");
        });

        $("#sidebarCollapseStore").on("click", function() {
          if ($("#sidebarStore").hasClass("active")) {
            $(".overlay").addClass("visible");
            console.log("it's working!");
          }
        });

        $("#sidebarCollapseStoreX").on("click", function() {
          $(".overlay").removeClass("visible");
        });

        $("#sidebarCollapseStoreXx").on("click", function() {
          $(".overlay").removeClass("visible");
        });
      });
      </script>