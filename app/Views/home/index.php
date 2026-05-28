<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="https://carvellonic.com">
    <meta name="description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <meta name="keywords" content="<?=$rest_sistem['result']['meta_keywords'];?>">

    <meta property="og:title" content="<?=$rest_sistem['result']['meta_title'];?>">
    <meta property="og:description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <?php if (file_exists($main_imgurl.'thumbnails/'.$rest_sistem['result']['logo_toko_image'])){ ?>
    <meta property="og:image" content="<?=$main_imgurl.'thumbnails/'.$rest_sistem['result']['logo_toko_image'];?>">
    <?php }else{ ?>
    <meta property="og:image" content="<?=$main_imgurl.'logo/'.$rest_sistem['result']['logo_toko_image'];?>">
    <?php } ?>
    <meta property="og:url" content="<?=$main_url;?>">
    
    <?php include "module/include/style.php"; ?>

    <title><?=$rest_sistem['result']['meta_title'];?></title>
  </head>
  <body>

    <?php include "module/include/header.php"; ?>

    <?php 
      $arr = array('opsi' => 'i', 'lang' => 'en');
      $rest_slider = loadData('rest_load/load_slider/',$arr);
    ?>

    <div class="bg-container mt-30 mt-mob-30" id="carouselUsliderColumn_">

      <?php 
        if (isset($_SESSION['trxrpass_msgpass']) && $_SESSION['trxrpass_msgpass'] <> '') {
            echo '<div class="alert alert-warning mb-3 mt-3">'.$_SESSION['trxrpass_msgpass'].'</div>';
        }
        $_SESSION['trxrpass_msgpass'] = '';
      ?>
      
      <div id="carouselExampleIndicators" class="carousel slide slidehomeUtamacarousel" data-ride="carousel">
        <ol class="carousel-indicators">
          <?php $no=0; foreach($rest_slider['result'] as $objx) { ?>
          <li data-target="#carouselExampleIndicators" data-slide-to="<?=$no;?>" class="<?php if($no==1) echo 'active'; ?>"></li>
          <?php $no++; } ?>
        </ol>
        <div class="carousel-inner rounded-2">
          <?php $no=1; foreach($rest_slider['result'] as $objx) { ?>
          <div class="carousel-item <?php if($no==1) echo 'active'; ?>">
            <?php if ($objx['tipe_slider']=='default') { ?>
              <div class="header-i-auto-w" style="background: url('<?=$main_imgurl.'komponen/'.$objx['logo_image'];?>');"></div>
            <?php }else{ ?>
              <a href="<?=$main_url.'blog/'.$objx['slider_id'];?>">
                <div class="header-i-auto-w" style="background: url('<?=$main_imgurl.'komponen/'.$objx['logo_image'];?>');"></div>
              </a>
            <?php } ?>
          </div>
          <?php $no++; } ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>

    <?php 
      $arr = array('opsi' => 'i', 'lang' => 'en');
      $rest_kategori = loadData('rest_load/load_kategori/',$arr);
    ?>

    <section id="carouselCategoryColumn_id" class="bg-container mt-4 mb-5">

      <div class="title-category mb-3 font-weight-bold ft-20">
        Kategori
        <a href="<?=$main_url;?>categories" class="ft-14 ml-2 color-app">Lihat Semua</a>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-carousel owl-theme" id="carouselCategoryColumn">
            <?php $jml_kateg = count($rest_kategori['result']); foreach($rest_kategori['result'] as $obj) { ?>
            <div class="item">
              <a href="<?=$main_url;?>c0/<?=$obj['url_kategori'];?>">
                <div class="bg_kategori_slider rounded-2" style="background: url('<?=$main_imgurl.'komponen/'.$obj['logo_image'];?>');">
                  <div class="p-2 color-dark text-overflow-ellips judul-bg_kategori_slider" style="color:<?=$obj['is_color'];?>!important;"><?=$obj['nama_kategori'];?></div>
                </div>
              </a>
            </div>
            <?php } ?>
          </div>
          <div class="custom_carouselCategoryColumn">
            <div class="prevcarouselCategoryColumn"><span class="icon-chevron-left"></span></div>
            <div class="nextcarouselCategoryColumn"><span class="icon-chevron-right"></span></div>
          </div>
          <script type="text/javascript">
            $(document).ready(function() {
                var jml_kateg = Number("<?=$jml_kateg?>") || 0;
                let responsive = {};

                if (jml_kateg == 2) {
                    responsive = {
                        0: { items: 1 },
                        600: { items: 2 },
                        991: { items: 2 },
                        1200: { items: 2 }
                    };
                } 
                else if (jml_kateg == 3) {
                    responsive = {
                        0: { items: 1 },
                        600: { items: 2 },
                        991: { items: 3 },
                        1200: { items: 3 }
                    };
                } 
                else if (jml_kateg == 4) {
                    responsive = {
                        0: { items: 1 },
                        600: { items: 2 },
                        991: { items: 3 },
                        1200: { items: 4 }
                    };
                } 
                else {
                    responsive = {
                        0: { items: 1 },
                        600: { items: 3 },
                        991: { items: 4 },
                        1200: { items: 5 }
                    };
                }
                

              var owl = $('#carouselCategoryColumn');
              owl.owlCarousel({
                stagePadding: 35,
                margin: 10,
                dots: false,
                loop: true,
                responsive: responsive
              });
              $('.nextcarouselCategoryColumn').click(function() {
                owl.trigger('next.owl.carousel');
              });
              $('.prevcarouselCategoryColumn').click(function() {
                owl.trigger('prev.owl.carousel');
              });
            });
          </script>
        </div>
      </div>
    </section>

    <?php 
      $arr = array('idkategori' => 'all', 'lang' => 'en');
      $rest_kategori_p = loadData('rest_load/load_kategori_pilihan/',$arr);
    ?>

    <?php $nocat = 0; foreach($rest_kategori_p['result'] as $obj) { ?>
    <section id="carouselCatgoryColumn_id<?=$nocat;?>" class="bg-container mb-5">
      <div class="title-category mb-3 font-weight-bold ft-20">
        <?=$obj['nama_kategori'];?>
        <?php if (count($obj['items'])>6) { ?>
        <a href="<?=$main_url;?>c0/<?=$obj['url_kategori'];?>" class="ft-14 ml-2 color-app">Lihat Semua</a>
        <?php } ?>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-carousel owl-theme" id="carouselCatgoryColumn<?=$nocat;?>">
            <?php $nonov = 0; foreach($obj['items'] as $objp) { ?>
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
          <div class="custom_carouselCatgoryColumn<?=$nocat;?>">
            <div class="prevcarouselCatgoryColumn<?=$nocat;?>"><span class="icon-chevron-left"></span></div>
            <div class="nextcarouselCatgoryColumn<?=$nocat;?>"><span class="icon-chevron-right"></span></div>
          </div>
          <?php } ?>
          <?php if ($nonov==0) { ?>
          <div class="alert alert-primary">Saat ini tidak ada produk di kategori ini.</div>
          <?php } ?>
          <script type="text/javascript">
            $(document).ready(function() {
              var owl = $('#carouselCatgoryColumn<?=$nocat;?>');
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
              $('.nextcarouselCatgoryColumn<?=$nocat;?>').click(function() {
                owl.trigger('next.owl.carousel');
              });
              $('.prevcarouselCatgoryColumn<?=$nocat;?>').click(function() {
                owl.trigger('prev.owl.carousel');
              });
            });
          </script>
        </div>
      </div>
    </section>
    <?php $nocat++; } ?>

    <?php 
      $arr = array('is' => 'pilihan', 'idsubkategori' => 'all', 'lang' => 'en');
      $rest_kategori_p = loadData('rest_load/load_sub_kategori_pilihan_dua/',$arr);
    ?>

    <?php $nocat = 5; foreach($rest_kategori_p['result'] as $obj) { ?>
    <section id="carouselCatgoryColumn_id<?=$nocat;?>" class="bg-container mb-5">
      <div class="title-category mb-3 font-weight-bold ft-20">
        <?=$obj['nama_kategori'];?>
        <?php if (count($obj['items'])>6) { ?>
        <a href="<?=$main_url;?>c1/<?=$obj['url_k'];?>/<?=$obj['url_kategori'];?>" class="ft-14 ml-2 color-app">Lihat Semua</a>
        <?php } ?>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-carousel owl-theme" id="carouselCatgoryColumn<?=$nocat;?>">
            <?php $nonov = 0; foreach($obj['items'] as $objp) { ?>
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
          <div class="custom_carouselCatgoryColumn<?=$nocat;?>">
            <div class="prevcarouselCatgoryColumn<?=$nocat;?>"><span class="icon-chevron-left"></span></div>
            <div class="nextcarouselCatgoryColumn<?=$nocat;?>"><span class="icon-chevron-right"></span></div>
          </div>
          <?php } ?>
          <?php if ($nonov==0) { ?>
          <div class="alert alert-primary">Saat ini tidak ada produk di kategori ini.</div>
          <?php } ?>
          <script type="text/javascript">
            $(document).ready(function() {
              var owl = $('#carouselCatgoryColumn<?=$nocat;?>');
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
              $('.nextcarouselCatgoryColumn<?=$nocat;?>').click(function() {
                owl.trigger('next.owl.carousel');
              });
              $('.prevcarouselCatgoryColumn<?=$nocat;?>').click(function() {
                owl.trigger('prev.owl.carousel');
              });
            });
          </script>
        </div>
      </div>
    </section>
    <?php $nocat++; } ?>

    <?php 
      $arr = array('opsi' => 'i', 'lang' => 'en');
      $rest_subkategori = loadData('rest_load/load_sub_kategori/',$arr);
    ?>

    <section id="carouselCategorySubColumn_id" class="bg-container mt-4 mb-5">
      <div class="title-category mb-3 font-weight-bold ft-20">
        Kategori
        <a href="<?=$main_url;?>categories" class="ft-14 ml-2 color-app">Lihat Semua</a>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-carousel owl-theme" id="carouselCategorySubColumn">
            <?php foreach($rest_subkategori['result'] as $obj) { ?>
            <div class="item">
              <a href="<?=$main_url;?>c1/<?=$obj['url_k'];?>/<?=$obj['url_kategori'];?>">
                <div class="bg_kategori_slider rounded-2" style="background: url('<?=$main_imgurl.'komponen/'.$obj['logo_image'];?>');">
                  <div class="p-2 color-dark text-overflow-ellips judul-bg_kategori_slider" style="color:<?=$obj['is_color'];?>!important;"><?=$obj['nama_kategori'];?></div>
                </div>
              </a>
            </div>
            <?php } ?>
          </div>
          <div class="custom_carouselCategorySubColumn">
            <div class="prevcarouselCategorySubColumn"><span class="icon-chevron-left"></span></div>
            <div class="nextcarouselCategorySubColumn"><span class="icon-chevron-right"></span></div>
          </div>
          
          <script type="text/javascript">
            $(document).ready(function() {
                var jml_kateg = Number("<?=$jml_kateg?>") || 0;
                let responsives = {};

                if (jml_kateg == 2) {
                    responsives = {
                        0: { items: 1 },
                        600: { items: 2 },
                        991: { items: 2 },
                        1200: { items: 2 }
                    };
                } 
                else if (jml_kateg == 3) {
                    responsives = {
                        0: { items: 1 },
                        600: { items: 2 },
                        991: { items: 3 },
                        1200: { items: 3 }
                    };
                } 
                else if (jml_kateg == 4) {
                    responsives = {
                        0: { items: 1 },
                        600: { items: 2 },
                        991: { items: 3 },
                        1200: { items: 4 }
                    };
                } 
                else {
                    responsives = {
                        0: { items: 1 },
                        600: { items: 3 },
                        991: { items: 4 },
                        1200: { items: 5 }
                    };
                }
                

              var owl = $('#carouselCategorySubColumn');
              owl.owlCarousel({
                stagePadding: 35,
                margin: 10,
                dots: false,
                loop: true,
                responsive: responsives
              });
              $('.nextcarouselCategorySubColumn').click(function() {
                owl.trigger('next.owl.carousel');
              });
              $('.prevcarouselCategoryColumn').click(function() {
                owl.trigger('prev.owl.carousel');
              });
            });
          </script>
        </div>
      </div>
    </section>

    <?php 
      $arr = array('wishlist' => 'n', 'idproduk' => 'n', 'new' => 'all', 'tipe' => 'limit', 'start' => '0', 'limit' => '12', 'lang' => 'en');
      $rest_produk = loadData('rest_load/load_produk/', $arr); 

      if (!isset($rest_produk['success'])) {
        $rest_produk['success'] = false;
      }

      if ($rest_produk['success']==true) {
        $result_produk = $rest_produk['result'];
        $nullData = $rest_produk['result'];
      }else{
        $result_produk = array();
        $nullData = $result_produk;
      }

      $cols_data_infinity = 'col-xl-2 col-lg-3 col-md-3 col-sm-4 col-xs-6';
    ?>

    <section id="carouselProductColumn_id" class="bg-container mt-5 mb-5">
      <div class="title-category mb-3 font-weight-bold ft-20">
        <?=$rest_sistem['result']['label_produk_lainnya_home'];?>
      </div>
      <?php if ($rest_produk['success']==true) { ?>
      <div class="row" id="post-data-appned">
        <?php include "product_data.php"; ?>
        <?php if (!$nullData) { ?>
          <div class="col-xl-12 col-lg-12">
            <div class="alert alert-primary">Produk tidak ditemukan.</div>
          </div>
        <?php } ?>
      </div>
      <?php }else{ ?>
        <div class="alert alert-danger">Failed to load data, please refresh the page.</div>
      <?php } ?>
    </section>

    <div id="muat_lebih_banyak" class="text-center mb-3"></div>

    <div id="loadmore_loading" class="text-center d-none">
      <p class="pb-5">
        <img src="<?=$main_url;?>/assets/images/loading_load.gif" width="40">&nbsp;&nbsp;Loading get more data...
      </p>
    </div>

    <div id="lmore_failalrt"></div>

    <?php include "app/Views/components/cta_component.php"; ?>

    <?php include "module/include/footer.php"; ?>
    
    <?php include "module/include/javascript.php"; ?>

    <script type="text/javascript">
      var start = 12;
      var limit = 12;
      var proses = true;
      var stload = 'on';
      
      $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height() - $('#footer_app_inav').height()) {
          if (stload=='on') {
            if (proses==true) {
              $('#muat_lebih_banyak').html('<button type="button" onclick="loadMoreData(start,limit);" class="btn btn-outline-primary mb-5 ft-18 pl-5 pr-5">Muat Lebih Banyak</button>');
            }
          }
        }
      });

      function loadMoreData(a,b) {
        $('#muat_lebih_banyak').html('');
        $.ajax({
          type: "GET",
          dataType:'html',
          timeout: 9000,
          async: true,
          url: '<?=$main_url;?>product_more.php?jen=index&start='+a+'&limit='+b,
          beforeSend: function(){
            proses = false;
            $('#loadmore_loading').removeClass('d-none');
          },
          success: function(data) {
            $('#loadmore_loading').addClass('d-none');
            if (data=='' || data=='last') {
              stload = 'last';
              $('#lmore_failalrt').html('');
            }else{
              start = parseInt(start+limit);
              $("#post-data-appned").append(data);
            }
            proses = true;
          },
          error: function(xmlhttprequest, textstatus, message) {
            $('#lmore_failalrt').html('<div class="text-center"><p class="pb-5">Please check your connection...</p></div>');
            $('#loadmore_loading').addClass('d-none');
            proses = true;
          }
        });
      }
    </script>

  </body>
</html>