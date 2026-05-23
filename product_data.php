        <?php foreach($result_produk as $objp) : ?>  
        <div class="<?=$cols_data_infinity;?> mb-4" id="appened_more_data_produk_i">
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