<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <meta name="keywords" content="<?=$rest_sistem['result']['meta_keywords'];?>">

    <meta property="og:title" content="Best Seller - <?=$rest_sistem['result']['meta_title'];?>">
    <meta property="og:description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <?php if (file_exists($main_imgurl.'thumbnails/'.$rest_sistem['result']['logo_toko_image'])){ ?>
    <meta property="og:image" content="<?=$main_imgurl.'thumbnails/'.$rest_sistem['result']['logo_toko_image'];?>">
    <?php }else{ ?>
    <meta property="og:image" content="<?=$main_imgurl.'logo/'.$rest_sistem['result']['logo_toko_image'];?>">
    <?php } ?>
    <meta property="og:url" content="<?=$main_url;?>best-seller">
    
    <?php include "module/include/style.php"; ?>

    <title>Best Seller - <?=$rest_sistem['result']['meta_title'];?></title>
  </head>
  <body>

    <?php include "module/include/header.php"; ?>

    <?php

      $arr = array('wishlist' => 'bestseller', 'idproduk' => 'n', 'new' => 'n', 'tipe' => 'limit', 'start' => '0', 'limit' => '50', 'lang' => 'en');
      $rest_produk = loadData('rest_load/load_produk/', $arr); 
    ?>

    <section class="bg-container-2 mt-4 mb-3">
      <div class="row justify-content-center mb-30">
        <div class="col-xl-10 col-lg-10 col-md-11">
          <div class="section-title ft-28 text-center">
            &mdash; Best Seller &mdash;
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-xl-11 col-lg-10">
          <div class="row">
            <?php foreach($rest_produk['result'] as $objp) : ?>  
            <div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-xs-6 mb-4" id="appened_more_data_produk_i">
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
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </section>

    <?php include "module/include/footer.php"; ?>
    
    <?php include "module/include/javascript.php"; ?>

  </body>
</html>