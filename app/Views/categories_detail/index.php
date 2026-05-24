<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <meta name="keywords" content="<?=$rest_sistem['result']['meta_keywords'];?>">

    <meta property="og:title" content="<?=$title_web;?>">
    <meta property="og:description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <?php if (file_exists($main_imgurl.'thumbnails/'.$rest_sistem['result']['logo_toko_image'])){ ?>
    <meta property="og:image" content="<?=$main_imgurl.'thumbnails/'.$rest_sistem['result']['logo_toko_image'];?>">
    <?php }else{ ?>
    <meta property="og:image" content="<?=$main_imgurl.'logo/'.$rest_sistem['result']['logo_toko_image'];?>">
    <?php } ?>
    <meta property="og:url" content="<?=$main_url;?>c/<?=$get_param;?>">
    
    <?php include "module/include/style.php"; ?>

    <title><?=$title_web;?></title>
  </head>
  <body>

    <?php include "module/include/header.php"; ?>

    <section id="carouselCategoryColumn_id" class="bg-container-2 mt-4 mb-5">
      <div class="title-category mb-3 font-weight-bold ft-20">
        <?=$title_web;?>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-carousel owl-theme" id="carouselCategoryColumn">
            <?php foreach($rest_kategori['result'] as $obj) { ?>
            <div class="item">
              <a href="<?=$main_url;?>c1/<?=$get_param;?>/<?=$obj['url_kategori'];?>">
                <div class="bg_kategori_slider rounded-2" style="background: url('<?=$main_imgurl.'komponen/'.$obj['logo_image'];?>');">
                  <div class="p-2 color-dark text-overflow-ellips judul-bg_kategori_slider" style="color:<?=$obj['is_color'];?>!important;"><?=$obj['nama_kategori'];?></div>
                </div>
              </a>
            </div>
            <?php } ?>
          </div>
          <?php if (count($rest_kategori['result'])>5) { ?>
          <div class="custom_carouselCategoryColumn">
            <div class="prevcarouselCategoryColumn"><span class="icon-chevron-left"></span></div>
            <div class="nextcarouselCategoryColumn"><span class="icon-chevron-right"></span></div>
          </div>
          <?php } ?>
          <script type="text/javascript">
            $(document).ready(function() {
              var owl = $('#carouselCategoryColumn');
              owl.owlCarousel({
                stagePadding: 35,
                margin: 10,
                dots: false,
                responsive: {
                  0: { items: 1 },
                  600: { items: 3 },
                  991: { items: 4 },
                  1200: { items: 5 }
                }
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
      $arr = array('idkategori' => $rest_kategori['kategori_id'], 'lang' => 'en');
      $rest_kategori_p = loadData('rest_load/load_kategori_lv1/',$arr);
      if($rest_kategori_p['result'][0]['nama_kategori']==null){ 
        echo '<script language="javascript">document.location="'.$main_url.'c0/'.$get_param.'";</script>';
      }
    ?>

    <?php $nocat = 0; foreach($rest_kategori_p['result'] as $obj) { ?>
    <section id="carouselCatgoryColumn_id<?=$nocat;?>" class="bg-container-2 mb-5">
      <div class="title-category mb-3 font-weight-bold ft-20">
        <?=$obj['nama_kategori'];?>
        <?php if (count($obj['items'])>6) { ?>
        <a href="<?=$main_url;?>c1/<?=$get_param;?>/<?=$obj['url_kategori'];?>" class="ft-14 ml-2 color-app">Lihat Semua</a>
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

    <?php include "module/include/footer.php"; ?>
    
    <?php include "module/include/javascript.php"; ?>

  </body>
</html>