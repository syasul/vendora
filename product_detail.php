<?php include "module/module.php";

  if (!$_GET['p_url']) {
    header("Location: ".$main_url); exit();
  }
  
  $get_param = $_GET['p_url'];

  if (isset($_GET['p_url'])) {
    $p_url = $get_param;
    $session_key = 'AFFILIATE_P_' . $p_url;

    // Cek apakah session sudah lebih dari 6 jam
    if (isset($_SESSION[$session_key . '_time']) && (time() - $_SESSION[$session_key . '_time']) > 10800) {
        unset($_SESSION[$session_key]); // Hapus session utama
        unset($_SESSION[$session_key . '_time']); // Hapus session waktu
    }

    // Simpan data baru jika UID tersedia
    if (isset($_GET['uid'])) {
        $_SESSION[$session_key] = ['p_url' => $p_url, 'uid' => $_GET['uid']];
        $_SESSION[$session_key . '_time'] = time(); // Simpan waktu saat session dibuat
    }
  }

  $arr = array('wishlist' => 'n', 'idproduk' => $_GET['p_url'], 'new' => '', 'tipe' => '', 'lang' => 'en');
  $rest_produk = loadData('rest_load/load_produk/', $arr); 

  $res_p = $rest_produk['result'][0];

  $arr = array('idproduk' => $res_p['produk_id'], 'lang' => 'en');
  $rest_v_varian = loadData('rest_load/load_produk_varian/', $arr);


  $uid_affiliate = '';
  if(isset($rest_cust['result']['is_token'])){
    if($rest_cust['result']['is_token']!=''){
      $uid_affiliate = "&uid=".encodeData($rest_cust['result']['is_token']);
    }else{
      $uid_affiliate = '';
    }
  }

?>
<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="<?=$res_p['meta_deskripsi'];?>">
    <meta name="keywords" content="<?=$rest_sistem['result']['meta_keywords'];?>">

    <meta property="og:title" content="<?=$res_p['meta_title'];?>">
    <meta property="og:description" content="<?=$res_p['meta_deskripsi'];?>">
    <?php if (file_exists($main_imgurl.'thumbnails/'.$res_p['all_image'][0]['logo_image'])){ ?>
    <meta property="og:image" content="<?=$main_imgurl.'thumbnails/'.$res_p['all_image'][0]['logo_image'];?>">
    <?php }else{ ?>
    <meta property="og:image" content="<?=$main_imgurl.'products/'.$res_p['all_image'][0]['logo_image'];?>">
    <?php } ?>
    <meta property="og:url" content="<?=$main_url;?>p/<?=$get_param;?>">
    
    <?php include "module/include/style.php"; ?>

    <script type="text/javascript">
      document.addEventListener("contextmenu", function(e){
        e.preventDefault();
      }, false);
    </script>

    <title><?=$res_p['meta_title'];?></title>
  </head>
  <body>
    
    <?php include "module/include/header.php"; ?>

    <section class="bg-container-2 mt-4 mb-30">
      <div class="title-category pb-3 border-bot-d font-weight-bold ft-14">
        <a href="<?=$main_url;?>">Home</a>
        &nbsp;>&nbsp;
        <a href="<?=$main_url;?>c/<?=$rest_produk['q_k']['url_k'];?>"><?=$rest_produk['q_k']['nama_k'];?></a>
        &nbsp;>&nbsp;
        <?php if ($rest_produk['q_k']['nama_k1']!='') { ?>
        <a href="<?=$main_url;?>c1/<?=$rest_produk['q_k']['url_k'];?>/<?=$rest_produk['q_k']['url_k1'];?>"><?=$rest_produk['q_k']['nama_k1'];?></a>
        &nbsp;>&nbsp;
        <?php } ?>
        <?php if ($rest_produk['q_k']['nama_k2']!='') { ?>
        <a href="<?=$main_url;?>c2/<?=$rest_produk['q_k']['url_k'];?>/<?=$rest_produk['q_k']['url_k1'];?>/<?=$rest_produk['q_k']['url_k2'];?>"><?=$rest_produk['q_k']['nama_k2'];?></a>
        &nbsp;>&nbsp;
        <?php } ?>
        <?=$res_p['nama_produk'];?>
      </div>
    </section>
    
    <section class="bg-container-2 mb-5">
      <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-5 mb-3 m-h-80">
          <div class="w-100 overflow-hidden text-center rounded-2">
            <?php $no=1; foreach($res_p['all_image'] as $objimg) { ?>
            <img src="<?=$main_imgurl.'products/'.$objimg['logo_image'];?>" id="NZoomImg<?=$no;?>" data-NZoomscale<?=$no;?>="2" class="img-fluid">
            <?php $no++; } ?>
          </div>
          <div class="flex-produk-img mt-3">
            <?php $no=1; foreach($res_p['all_image'] as $objimg) { ?>
            <div class="rounded-2" onclick="changeImg('<?=$no;?>')">
              <img src="<?=$main_imgurl.'products/'.$objimg['logo_image'];?>" class="img-fluid rounded-2">
            </div>
            <?php $no++; } ?>
          </div>
        </div>

        <div class="col-xl-9 col-lg-8 col-md-7">
          <div class="produk_detail">
            <div class="row">
              <div class="col-xl-8 col-lg-7 mb-4">
                <div class="border-bottom-dashed1 pb-3">
                  <div class="title_pd ft-18 font-weight-bold">
                    <?=$res_p['nama_produk'];?> <span class="idnamavarianproduk"></span>
                    <?php if ($rest_produk['rat_produk']>0 && $rest_sistem['result']['metode_rating']!='off') { ?>
                      <span class="float-right ft-20"><i class="fa fa-star color-warning mr-1"></i>&nbsp;<?=$rest_produk['rat_produk'];?></span>
                    <?php } ?>
                  </div>
                  <div class="promo_lbl_pd">
                    <div class="produk-detail-i">
                      <?php if ($res_p['is_new']=='y') { ?>
                      <div class="produk-detail-i-flex-new mr-2 rounded color-putih mb-2">
                        <div class="ft-12 font-weight-bold">New Arrival</div>
                      </div>
                      <?php } ?>
                      <?php if ($rest_sistem['result']['global_diskon']>0) { ?>
                      <div class="produk-detail-i-flex-diskon mr-2 rounded color-putih mb-2">
                        <div class="ft-12 font-weight-bold">Diskon <?=$rest_sistem['result']['global_diskon'];?>% Off</div>
                      </div>
                      <?php } ?>
                      <?php if ($res_p['terjual']>0) { ?>
                      <div class="produk-detail-i-flex-gongkir mr-2 rounded color-putih mb-2">
                        <div class="ft-12 font-weight-bold">Terjual : <?=$res_p['terjual'];?></div>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="harga_pd font-weight-bold color-app ft-24 mt-1">
                    <span class="mr-1" id="icanhargafixutama"><?=$res_p['harga_produk'];?></span>
                    <?php if ($res_p['potongan_status']=='y') { ?>
                    <span class="text-line-through color-semidark-m ft-14" id="icanhargafixutamaawal"><?=$res_p['harga_produk_awal'];?></span>
                    <?php } ?>
                    <span class="float-right color-semidark-m">
                      <?php if (isset($_SESSION['XID_ARRAY']) && $_SESSION['XID_ARRAY']['cust_id']!='guest') { ?>
                      <?php if ($rest_sistem['result']['fitur_chat']=='y') { ?>
                      <span class="icon-message ft-20 mr-2 c-pointer" onclick="openChat('<?=$main_url;?>p/<?=$get_param;?>');"></span>
                      <?php } ?>
                      <span id="add_to_whislist_ids" class="icon-heart ft-20 mr-2 c-pointer" onclick="prosesaddtoWhislist();"></span>
                      <?php }else{ ?>
                      <?php if ($rest_sistem['result']['fitur_chat']=='y') { ?>
                      <span class="icon-message ft-20 mr-2 c-pointer" onclick="myModalLogin();"></span>
                      <?php } ?>
                      <span class="icon-heart ft-20 mr-2 c-pointer" onclick="myModalLogin();"></span>
                      <?php } ?>
                      <span class="icon-share-alt ft-20 c-pointer" data-toggle="modal" data-target="#myModalShare"></span>
                    </span>
                  </div>
                  <div class="modal fade" id="myModalShare" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Bagikan <?=$res_p['nama_produk'];?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                              <a href='https://api.whatsapp.com/send?text=Ada produk bagus nih "<?=$res_p['nama_produk'];?>" buat kamu harganya murah loh cuma <?=$res_p['harga_produk'];?>, kunjungi sekarang <?=$main_url;?>p/<?=$get_param;?><?=$uid_affiliate;?>' target="_blank" class="btn btn-success ft-16 border-d border-radius-5 btn-block">
                                <i class="fa fa-whatsapp"></i>
                              </a>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                              <a href="javascript:;" onclick="shareToFacebook()" class="btn btn-primary ft-16 border-d border-radius-5 btn-block">
                                <i class="fa fa-facebook"></i>
                              </a>
                            </div>
                            <div class="col-xl-12 col-lg-12 mt-3">
                              <a href="javascript:;" onclick="copyLink()" class="btn btn-light ft-14 border-d border-radius-5 btn-block">
                                <i class="fa fa-copy"></i> <span id="msgsalinlink">Salin Link</span>
                              </a>
                              <?php if($_SESSION['XID_ARRAY']['cust_id']!='guest'){ ?>
                              <div class="ft-12 mt-1">Bagikan link produk dan dapatkan keuntungan <a href="<?=$main_url;?>terms-conditions" target="_blank">s&k berlaku.</a></div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="border-bottom-dashed1 pb-10 pt-10">
                  <div class="detail_pd ft-16 font-weight-bold text-center">
                    &mdash; Detail &mdash;
                  </div>
                </div>
                <div class="pb-10 pt-10">
                  <div class="detail_sec_pd ft-14 color-dark">
                    <div class="mb-1">
                      <span class="color-semidark-m mr-2">Kategori :</span>
                      <a href="<?=$main_url;?>c/<?=$rest_produk['q_k']['url_k'];?>"><?=$rest_produk['q_k']['nama_k'];?></a>
                      <?php if ($rest_produk['q_k']['nama_k1']!='') { ?>
                      &nbsp;>&nbsp;
                      <a href="<?=$main_url;?>c1/<?=$rest_produk['q_k']['url_k'];?>/<?=$rest_produk['q_k']['url_k1'];?>"><?=$rest_produk['q_k']['nama_k1'];?></a>
                      &nbsp;>&nbsp;
                      <?php } ?>
                      <?php if ($rest_produk['q_k']['nama_k2']!='') { ?>
                      <a href="<?=$main_url;?>c2/<?=$rest_produk['q_k']['url_k'];?>/<?=$rest_produk['q_k']['url_k1'];?>/<?=$rest_produk['q_k']['url_k2'];?>"><?=$rest_produk['q_k']['nama_k2'];?></a>
                      <?php } ?>
                    </div>
                    <?php if ($res_p['is_digital']=='y') { ?>
                    <div class="mb-1">
                      <span class="color-semidark-m mr-2">Produk Digital</span>
                    </div>
                    <?php } ?>
                    <?php if ($res_p['is_digital']=='n') { ?>
                    <div class="mb-2">
                      <span class="color-semidark-m mr-2">Berat :</span>
                      <?=$res_p['berat_produk'];?> Gram
                    </div>
                    <?php } ?>
                    <div class="overflow-hidden">
                      <style type="text/css">
                        .produk-s-urg {
                          max-height: 75px;
                        }
                        .more-s-urg {
                          padding-top: 5px;
                          position: absolute;
                        }
                      </style>
                      <div class="produk-s-urg" id="produk-s-urg">
                        <div class="inner-html-cstore">
                          <?=$res_p['keterangan_produk'];?>
                        </div>
                      </div>
                      <div class="ft-14 more-s-urg c-pointer color-app" onclick="moreKet();">Lihat selengkapnya... <span class="icon-arrow_drop_down"></span></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-lg-5 mb-4">
                <div class="">
                  <div class="bg-putih">
                    <div class="border-bottom-dashed1 mb-4 mt-15 d-none-991"></div>
                    <div class="border-d rounded-2 padding-10-15">
                      <?php if ($rest_produk['q_k']['s_f']!=0 && $rest_produk['q_k']['h_f']!='y') { ?>
                      <form id="form_p_add_to_cart" onsubmit="prosesaddtoCart(event)" method="POST">
                        <div class="font-weight-bold ft-16 mb-2">
                          <span id="varian_lbl_pid">Pilih Varian</span>
                        </div>
                        <?php if ($rest_v_varian['result']['row_w']>0) { ?>
                        <div class="ft-14 varian_warna">
                          <div class="form-group mb-2">
                            <label class="">Warna</label>
                            <select class="form-control" name="warna_id" id="id_warna_pid" onchange="checkStokProduk()" required="">
                              <option value="">-- Pilih --</option>
                              <?php foreach($rest_v_varian['result']['p_warna'] as $objx) { ?>
                              <option value="<?=$objx['warna_id'];?>"><?=$objx['nama_warna'];?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <?php }else{ ?>
                          <input type="hidden" id="id_warna_pid">
                        <?php } ?>
                        <?php if ($rest_v_varian['result']['row_u']>0) { ?>
                        <div class="ft-14 varian_ukuran">
                          <div class="form-group mb-2">
                            <label class="">Ukuran</label>
                            <select class="form-control" name="ukuran_id" id="id_ukuran_pid" onchange="checkStokProduk()" required="">
                              <option value="">-- Pilih --</option>
                              <?php $no=1; foreach($rest_v_varian['result']['p_ukuran'] as $objx) { ?>
                              <option value="<?=$objx['ukuran_id'];?>"><?=$objx['ukuran'];?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <?php }else{ ?>
                          <input type="hidden" id="id_ukuran_pid">
                        <?php } ?>
                        <div class="ft-14 varian_qty">
                          <div class="form-group mb-3">
                            <label class="">Jumlah / Qty</label>
                            <div class="input-group w-200px disabled-x" id="id_jumlah_qty_p">
                              <div class="input-group-prepend">
                                  <button type="button" class="btn btn-light ft-14 border-d b-lt-lb-5" id="minus-bt-p"><i class="fa fa-minus"></i></button>
                              </div>
                              <input type="number" name="qty_input_pr" id="qty_input_pr" class="form-control text-center bg-putih" value="1" min="1">
                              <div class="input-group-prepend">
                                  <button type="button" class="btn btn-light ft-14 border-d b-rt-rb-5" id="plus-bt-p"><i class="fa fa-plus"></i></button>
                              </div>
                              <div class="ml-2" style="line-height: 35px">
                                <span id="id_produk_stok_re">Stok <b>...</b></span>
                              </div>
                            </div>
                          </div>
                          <div class="form-group mb-2">
                            <textarea type="text" class="form-control ft-12" name="catatan_trx" rows="2" placeholder="Catatan..."></textarea>
                          </div>
                          <div class="varian_subtotal mt-3 w-100">
                            <?php if ($res_p['potongan_status']=='y') { ?>
                            <div class="text-right text-line-through color-semidark-m ft-14" id="subtotal_harga_ap"><?=$res_p['harga_produk_awal'];?></div>
                            <?php } ?>
                            <div class="d-flex align-items-center j-c-sb">
                              <span class="color-semidark-m">Subtotal</span>
                              <span class="color-dark ft-18 font-weight-bold" id="subtotal_harga_p"><?=$res_p['harga_produk'];?></span>
                            </div>
                          </div>
                        </div>
                        <div class="ft-14 varian_submit mt-2">
                          <div class="">
                            <input type="hidden" name="purl" value="<?=$_SESSION['AFFILIATE_P_'.$_GET['p_url']]['p_url'];?>">
                            <input type="hidden" name="uid" value="<?=$_SESSION['AFFILIATE_P_'.$_GET['p_url']]['uid'];?>">
                            <input type="hidden" name="produk_id" value="<?=$res_p['produk_id'];?>">
                            <input type="hidden" name="cart_id" value="0">
                            <?php if (isset($_SESSION['XID_ARRAY'])) { ?>
                            <button type="submit" name="keranjang" class="btn btn-primary ft-14 border-d border-radius-5 btn-block" id="produk_keranjang_submit_pid">
                              <i class="fa fa-plus"></i>&nbsp;&nbsp;Keranjang
                            </button>
                            <button type="submit" name="checkout" class="btn btn-primary ft-14 border-d border-radius-5 btn-block" id="produk_keranjang_submit_pidc">
                              <i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;Checkout
                            </button>
                            <?php }else{ ?>
                              <button type="button" onclick="myModalLogin();" class="btn btn-primary ft-14 border-d border-radius-5 btn-block" id="produk_keranjang_submit_pid">
                                <i class="fa fa-plus"></i>&nbsp;&nbsp;Keranjang
                              </button>
                            <?php } ?>
                          </div>
                        </div>
                      </form>
                      <?php }else{ ?>
                        <div class="ft-14">Mohon maaf, untuk saat ini produk tidak bisa di beli.</div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php 
      $arr = array('tipe' => 'limitweb', 'idproduk' => $res_p['produk_id'], 'lang' => 'en');
      $rest_ulasan = loadData('rest_load/load_ulasan_produk/',$arr);
    ?>

    <?php if ($rest_ulasan['nums']!=0 && $rest_sistem['result']['metode_ulasan']!='off') { ?>
    <section class="bg-container-2 mt-5 mb-5">
      <div class="title-category mb-3 font-weight-bold ft-20">
        Ulasan
        <?php if ($rest_ulasan['nums']>3) { ?>
        <a href="javascript:lihatallUlasan('<?=$res_p['produk_id'];?>')" class="ft-14 ml-2 color-app">Lihat Semua (<?=$rest_ulasan['nums'];?>)</a>
        <?php } ?>
      </div>
      <div class="row">
        <?php foreach($rest_ulasan['result'] as $objp) { ?>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
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
    </section>
    <?php } ?>

    <?php 
      $arr = array('idsubkategori' => $rest_produk['q_k']['kategori_id'], 'lang' => 'en');
      $rest_kategori_p = loadData('rest_load/load_kategori_lv2_all/',$arr);
    ?>

    <section id="carouselCatgoryColumn_id1" class="bg-container-2 mt-5 mb-5">
      <div class="title-category mb-3 font-weight-bold ft-20">
        Produk Terkait
        <?php if (count($rest_kategori_p['result'])>6) { ?>
        <a href="<?=$main_url;?>c1/<?=$rest_produk['q_k']['url_k'];?>/<?=$rest_produk['q_k']['url_k1'];?>" class="ft-12 ml-2 color-app">Lihat Semua</a>
        <?php } ?>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-carousel owl-theme" id="carouselCatgoryColumn1">
            <?php $nonov = 0; foreach($rest_kategori_p['result'] as $objp) { ?>
            <div class="item mb-1" style="margin-right: 1px;">
              <div class="default-shadow rounded-2">
                <a href="<?=$main_url;?>p/<?=$objp['url_produk'];?>">
                  <div class="">
                    <div class="bg_product_slider rounded-2_" style="background: url('<?=$main_imgurl.'products/'.$objp['logo_image'];?>');"></div>
                    <?php if ($rest_sistem['result']['global_diskon']>0) { ?>
                    <div class="fly-badge-global-diskon"><?=$rest_sistem['result']['global_diskon'];?>% Off</div>
                    <?php } ?>
                    <?php if ($objp['is_new']=='y') { ?>
                    <div class="fly-badge-<?php if ($rest_sistem['result']['global_diskon']>0) echo 'new-arrival-v2'; else echo 'new-arrival-v1';?>">
                      Baru
                    </div>
                    <?php } ?>
                  </div>
                  <div class="padding-5-15 pb-3 card-box-item-product">
                    <div class="media-title mt-1 text-overflow-ellips color-dark"> 
                      <?=$objp['nama_produk'];?>
                    </div>
                    <div class="font-weight-bold color-dark">
                      <span class="color-app"><?=$objp['harga_produk'];?></span>
                      <?php if ($objp['potongan_status']=='y') { ?>
                      <div class="text-line-through font-weight-400 color-semidark-m ft-12"><?=$objp['harga_produk_awal'];?></div>
                      <?php } ?>
                    </div>
                    <div class="text-left">
                      <div class="ft-12 badge-stok-<?php if ($objp['stok']>0) echo 'ready'; else echo 'noready'; ?>"><?=$objp['tstok'];?></div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <?php $nonov++; } ?>
          </div>
          <?php if ($nonov>2) { ?>
          <div class="custom_carouselCatgoryColumn1">
            <div class="prevcarouselCatgoryColumn1"><span class="icon-chevron-left"></span></div>
            <div class="nextcarouselCatgoryColumn1"><span class="icon-chevron-right"></span></div>
          </div>
          <?php } ?>
          <?php if ($nonov==0) { ?>
          <div class="alert alert-primary">Saat ini tidak ada produk terkait.</div>
          <?php } ?>
          <script type="text/javascript">
            $(document).ready(function() {
              var owl = $('#carouselCatgoryColumn1');
              owl.owlCarousel({
                margin: 10,
                dots: false,
                responsive: {
                  0: { items: 2 },
                  600: { items: 3 },
                  800: { items: 4 },
                  1000: { items: 5 },
                  1200: { items: 6 }
                }
              });
              $('.nextcarouselCatgoryColumn1').click(function() {
                owl.trigger('next.owl.carousel');
              });
              $('.prevcarouselCatgoryColumn1').click(function() {
                owl.trigger('prev.owl.carousel');
              });
            });
          </script>
        </div>
      </div>
    </section>

    <?php include "module/include/footer.php"; ?>
    
    <?php include "module/include/javascript.php"; ?>

    <div class="modal fade" id="myModalallUlasan" tabindex="-1" role="dialog" aria-labelledby="myModalallUlasan">
      <div class="right modal-dialog" role="document">
        <div class="modal-content h-100">
          <div class="modal-header b-0">
            <div class="font-weight-bold">&mdash; Semua Ulasan &mdash;</div>
            <button type="button" class="close ft-30" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body" style="overflow-y: auto; max-height: calc(100vh - 80px);">
            <div id="resmyModalallUlasan">Loading...</div>
          </div>
        </div>
      </div>
    </div>

    <script src="<?=$main_url;?>assets/vendor/nzoom/Nzoom.min.js" type="text/javascript"></script>

    <script type="text/javascript">
      var imore = 1;

      var h_produk_awal = '<?=$res_p['harga_produk_awal_num'];?>';
      var h_produk = '<?=$res_p['harga_produk_num'];?>';

      var id_p = '<?=$res_p['produk_id'];?>';
      var row_w = '<?=$rest_v_varian['result']['row_w'];?>';
      var row_u = '<?=$rest_v_varian['result']['row_u'];?>';
      
      var hrga_tmbhan = 0;
      var p_stok = 1;

      $(document).ready(function(){
        changeImg('all');

        if (row_w==0 && row_u==0) {
          $('#varian_lbl_pid').html('Atur Jumlah');
          $.get('<?=$main_url;?>module/action.php?jen=product_action&tipe=zero&idproduk='+id_p+'&idwarna=0&idukuran=0', function(res) {
            var data = res.split('~');
            if (data[0]>0) {
              p_stok = parseInt(data[0]);
              $('#id_produk_stok_re').html('Stok <b>'+data[0]+'</b>');
            }else{
              p_stok = 1;
              $('#id_produk_stok_re').html('Stok Habis');
              $('#produk_keranjang_submit_pid').addClass('disabled-x');
              $('#produk_keranjang_submit_pidc').addClass('disabled-x');
            }
            $('#id_jumlah_qty_p').removeClass('disabled-x');
          });
        }

        $('#qty_input_pr').prop('disabled', true);
        $('#plus-bt-p').click(function(){
          if ($('#qty_input_pr').val() < p_stok) {
            var qty_p = parseInt($('#qty_input_pr').val()) + 1;
            $('#qty_input_pr').val(qty_p);
            $('#subtotal_harga_p').html(formatRupiah((parseInt(h_produk)+parseInt(hrga_tmbhan))*parseInt(qty_p)));
            $('#subtotal_harga_ap').html(formatRupiah((parseInt(h_produk_awal)+parseInt(hrga_tmbhan))*parseInt(qty_p)));
          }
        });
        $('#minus-bt-p').click(function(){
          var qty_p = parseInt($('#qty_input_pr').val()) - 1;
          $('#qty_input_pr').val(qty_p);
          if ($('#qty_input_pr').val() == 0) {
            $('#qty_input_pr').val(1);
            if(qty_p!=0){
              $('#subtotal_harga_p').html(formatRupiah(parseInt(h_produk)+parseInt(hrga_tmbhan)));
              $('#subtotal_harga_ap').html(formatRupiah(parseInt(h_produk_awal)+parseInt(hrga_tmbhan)));
            }
          }else{
            $('#subtotal_harga_p').html(formatRupiah((parseInt(h_produk)+parseInt(hrga_tmbhan))*parseInt(qty_p)));
            $('#subtotal_harga_ap').html(formatRupiah((parseInt(h_produk_awal)+parseInt(hrga_tmbhan))*parseInt(qty_p)));
          }
        });
      });

      function moreKet() {
        if (imore==1) {
          imore = 2;
          $('#produk-s-urg').removeClass('produk-s-urg');
          $('.more-s-urg').html('Lebih sedikit... <span class="icon-arrow_drop_up"></span>');
        }else{
          $('#produk-s-urg').addClass('produk-s-urg');
          $('.more-s-urg').html('Lihat selengkapnya... <span class="icon-arrow_drop_down"></span>');
          imore = 1;
        }
      }

      function changeImg(a){
        $('#NZoomImg1').addClass('d-none');
        $('#NZoomImg2').addClass('d-none');
        $('#NZoomImg3').addClass('d-none');
        $('#NZoomImg4').addClass('d-none');
        $('#NZoomImg5').addClass('d-none');
        $('#NZoomImg6').addClass('d-none');
        if (a=='all') {
          setTimeout(function() {
            $('#NZoomImg1').removeClass('d-none');
          }, 250);
        }else{
          setTimeout(function() {
            $('#NZoomImg'+a).removeClass('d-none');
          }, 250);
        }
      }

      function checkStokProduk(){

        var id_w = $('#id_warna_pid').val();
        var id_u = $('#id_ukuran_pid').val();

        if (row_w>0 && row_u>0 && id_w!='' && id_u!='') {
          $('#id_produk_stok_re').html('Loading...');
          s_udi = id_u.split('~');
          hrga_tmbhan = s_udi[1];

          $.get('<?=$main_url;?>module/action.php?jen=product_action&tipe=zero&idproduk='+id_p+'&idwarna='+id_w+'&idukuran='+s_udi[0], function(res) {
            var data = res.split('~');
            $('.idnamavarianproduk').html(data[1]);
            if (data[0]>0) {
              p_stok = parseInt(data[0]);
              $('#id_produk_stok_re').html('Stok <b>'+data[0]+'</b>');
              $('#produk_keranjang_submit_pid').removeClass('disabled-x');
              $('#produk_keranjang_submit_pidc').removeClass('disabled-x');
            }else{
              p_stok = 1;
              $('#id_produk_stok_re').html('Stok Habis');
              $('#produk_keranjang_submit_pid').addClass('disabled-x');
              $('#produk_keranjang_submit_pidc').addClass('disabled-x');
            }
            $('#qty_input_pr').val(1)
            $('#id_jumlah_qty_p').removeClass('disabled-x');

            $('#icanhargafixutama').html(formatRupiah(parseInt(h_produk)+parseInt(hrga_tmbhan)));
            $('#icanhargafixutamaawal').html(formatRupiah(parseInt(h_produk_awal)+parseInt(hrga_tmbhan)));

            $('#subtotal_harga_p').html(formatRupiah(parseInt(h_produk)+parseInt(hrga_tmbhan)));
            $('#subtotal_harga_ap').html(formatRupiah(parseInt(h_produk_awal)+parseInt(hrga_tmbhan)));
          });
        }else if (row_w>0 && row_u==0 && id_w!='') {
          $('#id_produk_stok_re').html('Loading...');
          $.get('<?=$main_url;?>module/action.php?jen=product_action&tipe=zero&idproduk='+id_p+'&idwarna='+id_w+'&idukuran=0', function(res) {
            var data = res.split('~');
            $('.idnamavarianproduk').html(data[1]);
            if (data[0]>0) {
              p_stok = parseInt(data[0]);
              $('#id_produk_stok_re').html('Stok <b>'+data[0]+'</b>');
              $('#produk_keranjang_submit_pid').removeClass('disabled-x');
              $('#produk_keranjang_submit_pidc').removeClass('disabled-x');
            }else{
              p_stok = 1;
              $('#id_produk_stok_re').html('Stok Habis');
              $('#produk_keranjang_submit_pid').addClass('disabled-x');
              $('#produk_keranjang_submit_pidc').addClass('disabled-x');
            }
            $('#qty_input_pr').val(1)
            $('#id_jumlah_qty_p').removeClass('disabled-x');

            $('#icanhargafixutama').html(formatRupiah(parseInt(h_produk)+parseInt(hrga_tmbhan)));
            $('#icanhargafixutamaawal').html(formatRupiah(parseInt(h_produk_awal)+parseInt(hrga_tmbhan)));

            $('#subtotal_harga_p').html(formatRupiah(parseInt(h_produk)+parseInt(hrga_tmbhan)));
            $('#subtotal_harga_ap').html(formatRupiah(parseInt(h_produk_awal)+parseInt(hrga_tmbhan)));

          });
        }else if (row_w==0 && row_u>0 && id_u!='') {
          $('#id_produk_stok_re').html('Loading...');
          s_udi = id_u.split('~');
          hrga_tmbhan = s_udi[1];

          $.get('<?=$main_url;?>module/action.php?jen=product_action&tipe=zero&idproduk='+id_p+'&idwarna=0&idukuran='+s_udi[0], function(res) {
            var data = res.split('~');
            $('.idnamavarianproduk').html(data[1]);
            if (data[0]>0) {
              p_stok = parseInt(data[0]);
              $('#id_produk_stok_re').html('Stok <b>'+data[0]+'</b>');
              $('#produk_keranjang_submit_pid').removeClass('disabled-x');
              $('#produk_keranjang_submit_pidc').removeClass('disabled-x');
            }else{
              p_stok = 1;
              $('#id_produk_stok_re').html('Stok Habis');
              $('#produk_keranjang_submit_pid').addClass('disabled-x');
              $('#produk_keranjang_submit_pidc').addClass('disabled-x');
            }
            $('#qty_input_pr').val(1)
            $('#id_jumlah_qty_p').removeClass('disabled-x');

            $('#icanhargafixutama').html(formatRupiah(parseInt(h_produk)+parseInt(hrga_tmbhan)));
            $('#icanhargafixutamaawal').html(formatRupiah(parseInt(h_produk_awal)+parseInt(hrga_tmbhan)));

            $('#subtotal_harga_p').html(formatRupiah(parseInt(h_produk)+parseInt(hrga_tmbhan)));
            $('#subtotal_harga_ap').html(formatRupiah(parseInt(h_produk_awal)+parseInt(hrga_tmbhan)));
            
          });
        }else{
          $('#id_produk_stok_re').html('Stok ...');
          $('#id_jumlah_qty_p').addClass('disabled-x');
        }

      }

      function prosesaddtoCart(event){
        event.preventDefault();

        $('button').addClass('disabled');
        var formData = new FormData($("#form_p_add_to_cart")[0]);
        var buttonName = event.submitter.name;
        $.ajax({
          type: "POST",
          url: '<?=$main_url;?>module/action.php?jen=add_to_cart&jumlah_beli='+$('#qty_input_pr').val(),
          data:  formData,
          contentType: false,
          cache: false,
          processData:false,
          success: function(result){
            cekjumlahCart();
            $('button').removeClass('disabled');
            var res = result.split('~');
            if (res[0]=='y') {
              if (buttonName === 'keranjang') {
                  confirmBerhasil(res[1]);
              } else if (buttonName === 'checkout') {
                  window.location.href = "<?=$main_url;?>v/checkout";
              }
            }else{
              confirmGagal(res[1]);
            }
          } 
        });
      }

      function prosesaddtoWhislist(){

        $.get('<?=$main_url;?>module/action.php?jen=add_wo_whislist&produk_id='+id_p, function(result) {
          var res = result.split('~');
          if (res[0]=='y') {
            if (res[1]=='add') {
              $('#add_to_whislist_ids').addClass('color-danger');
            }else{
              $('#add_to_whislist_ids').removeClass('color-danger');
            }
          }else{
            confirmGagal(res[2]);
          }
        });
      }

      function lihatallUlasan(a){
        $('#myModalallUlasan').modal('toggle');
        formmyModalallUlasan(a);
      }

      function formmyModalallUlasan(a) {           
        $.get('<?=$main_url;?>module/action.php?jen=semua_ulasan_produk&idproduk='+a, function(data) {
            $('#resmyModalallUlasan').html(data);    
        });
      }

      function shareToFacebook() {
          let url = encodeURIComponent(window.location.href+"<?=$uid_affiliate;?>");
          let shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
          window.open(shareUrl, '_blank');
      }

      function copyLink() {
          let url = window.location.href+"<?=$uid_affiliate;?>"; // Ambil URL halaman saat ini
          navigator.clipboard.writeText(url).then(() => {
            $('#msgsalinlink').html('Berhasil disalin!');
            setTimeout(() => { 
              $('#msgsalinlink').html('Salin Link');
            }, 5000);
          }).catch(err => {
              $('#msgsalinlink').html('Gagal menyalin link.');
          });
      }

    </script>

  </body>
</html>