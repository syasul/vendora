<?php include "module/module.php";

  if (!$_GET['p_url'] || !$_GET['s_url']) {
    header("Location: ".$main_url); exit();
  }

  $get_param = $_GET['p_url'];
  $get_param2 = $_GET['s_url'];

  $arr = array('tipeid' => 'url', 'tipeid_v2' => '', 'idkategori' => $get_param, 'idsubkategori' => $get_param2, 'lang' => 'en');
  $rest_kategori = loadData('rest_load/load_sub_kategori_det/', $arr);

  if ($rest_kategori==null) {
    $title_web = $rest_sistem['result']['meta_title'];
  }else{
    $title_web = $rest_kategori['nama_kategori'].' - '.$rest_kategori['nama_kategori2'];
  }

  $arr = array('tipeid' => 'url', 'idkategori' => $get_param, 'lang' => 'en');
  $rest_kategori_f = loadData('rest_load/load_kategori_det/', $arr);

?>
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
    <meta property="og:url" content="<?=$main_url;?>c1/<?=$get_param;?>/<?=$get_param2;?>">
    
    <?php include "module/include/style.php"; ?>

    <title><?=$title_web;?></title>
  </head>
  <body>

    <?php include "module/include/header.php"; ?>

    <section id="carouselCategoryColumn_id" class="bg-container-2 mt-4 mb-5">
      <div class="title-category mb-3 font-weight-bold ft-18">
        <a href="<?=$main_url;?>c/<?=$get_param;?>"><?=$rest_kategori['nama_kategori'];?></a>
        &nbsp;>&nbsp;
        <?=$rest_kategori['nama_kategori2'];?>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-carousel owl-theme" id="carouselCategoryColumn">
            <?php foreach($rest_kategori['result'] as $obj) { ?>
            <div class="item">
              <a href="<?=$main_url;?>c2/<?=$get_param;?>/<?=$get_param2;?>/<?=$obj['url_kategori'];?>">
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

    <section class="bg-container-2 mb-5" id="ilistproduk_item">
      <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-5 d-block d-sm-none d-none d-sm-block d-md-none mb-2" style="margin-top: -30px">
          <div class="border-d border-radius-5">
            <div class="filter-kategori-left">
              Filter
            </div>
            <div class="row">
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-5 pr-1">
                <div class="ml-3 mt-3">
                  <div class="form-group mb-3">
                    <select class="form-control border-radius-10 ft-14" id="filter_sortby_mob">
                      <option value="1">Terbaru</option>
                      <option value="2">Abjad A-Z</option>
                      <option value="3">Harga Tertinggi</option>
                      <option value="4">Harga Terendah</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-7 pl-1">
                <div class="mr-3 mt-3">
                  <div class="input-group mb-3">
                    <input type="text" class="form-control border-radius-10 ft-14" id="filter_pencarian_mob" autocomplete="off" placeholder="Cari di kategori ini...">
                    <div class="input-group-append b-rt-rb-10 border-d">
                      <button class="btn btn-light b-rt-rb-10 ft-14" type="button" onclick="loadMoreData('ref')" style="height: 33px"><span class="icon-search"></span></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-5 d-none d-md-block">
          <div class="border-d border-radius-5">
            <div class="filter-kategori-left">
              Filter
            </div>
            <div class="border-bot-d padding-10-15">
              <div class="ft-14 font-weight-bold color-semidark-m mb-3">Cari di kategori ini</div>
              <div class="input-group mb-2">
                <input type="text" class="form-control border-radius-10 ft-14" id="filter_pencarian" autocomplete="off" placeholder="Cari...">
                <div class="input-group-append b-rt-rb-10 border-d">
                  <button class="btn btn-light b-rt-rb-10 ft-14" type="button" onclick="loadMoreData('ref')" style="height: 33px"><span class="icon-search"></span></button>
                </div>
              </div>
            </div>
            <div class="border-bot-d padding-10-15">
              <div class="ft-14 font-weight-bold color-semidark-m mb-3">Urutkan</div>
              <div class="input-group mb-2">
                <select class="form-control border-radius-10 ft-14" id="filter_sortby">
                  <option value="1">Terbaru</option>
                  <option value="2">Abjad A-Z</option>
                  <option value="3">Harga Tertinggi</option>
                  <option value="4">Harga Terendah</option>
                </select>
                <div class="input-group-append b-rt-rb-10 border-d">
                  <button class="btn btn-light b-rt-rb-10 ft-14" type="button" onclick="loadMoreData('ref')" style="height: 33px"><span class="icon-search"></span></button>
                </div>
              </div>
            </div>
            <div class="border-bot-d padding-10-15">
              <div class="ft-14 font-weight-bold color-semidark-m mb-3">Harga</div>
              <div class="form-group mb-3">
                <input type="text" class="form-control border-radius-10 ft-14" id="filter_price_min" autocomplete="off" placeholder="Harga Minimum" onkeydown="return angkatOnly(event.key)">
              </div>
              <div class="input-group mb-2">
                <input type="text" class="form-control border-radius-10 ft-14" id="filter_price_max" autocomplete="off" placeholder="Harga Maksimum" onkeydown="return angkatOnly(event.key)">
                <div class="input-group-append b-rt-rb-10 border-d">
                  <button class="btn btn-light b-rt-rb-10 ft-14" type="button" onclick="loadMoreData('ref')" style="height: 33px"><span class="icon-search"></span></button>
                </div>
              </div>
            </div>
            <div class="border-bot-d padding-10-15">
              <div class="ft-14 font-weight-bold color-semidark-m mb-2"><?=$rest_kategori['nama_kategori'];?></div>
              <div class="">
                <?php foreach($rest_kategori_f['result'] as $obj) { ?>
                <div class="filter-kategori-left-list-k">
                  <a href="<?=$main_url;?>c1/<?=$get_param;?>/<?=$obj['url_kategori'];?>" class="ft-14"><?=$obj['nama_kategori'];?></a>
                  <?php 
                    $arr = array('tipeid' => 'url', 'tipeid_v2' => '', 'idkategori' => $get_param, 'idsubkategori' => $obj['url_kategori'], 'lang' => 'en');
                    $rest_sub_det = loadData('rest_load/load_sub_kategori_det/',$arr);
                  ?>
                  <?php foreach($rest_sub_det['result'] as $objxx) { ?>
                  <div class="ml-3">
                    <a href="<?=$main_url;?>c2/<?=$get_param;?>/<?=$obj['url_kategori'];?>/<?=$objxx['url_kategori'];?>" class="ft-14">
                      <?=$objxx['nama_kategori'];?>
                    </a>
                  </div>
                  <?php } ?>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-9 col-lg-8 col-md-7">

          <?php 
            $arr = array('is' => 'n', 'tipe' => 'limit', 'price' => '0~0', 'sortby' => '1', 'search' => '', 'start' => '0', 'limit' => '12', 'idsubkategori' => $rest_kategori['kategori_sub_id'], 'lang' => 'en');
            $rest_kategori_p = loadData('rest_load/load_sub_kategori_pilihan_dua/',$arr);

            $result_produk = $rest_kategori_p['result'][0]['items'];
            $cols_data_infinity = 'col-xl-3 col-lg-4 col-md-6 col-sm-4 col-xs-6';

            $arr = array('is' => 'n', 'tipe' => 'limit', 'limit' => '0');
            $rest_bestview_product = loadData('rest_load/load_bestview_product/',$arr);
          ?>
          <div class="mt-2">
            <div class="row">
              <div class="col-xl-12 col-lg-12">
                <div class="ft-14 color-semidark-m">
                  <div class="float-right_">
                    <div class="w-100">
                      <div id="label-data-appned-rekom" class="d-none">
                        Menampilkan <span id=""><?=count($rest_bestview_product['result']);?></span> produk Rekomendasi
                      </div>
                      <div class="">
                        dan Menampilkan <span id="rows_flt-data-appned_produk"><?=$rest_kategori_p['result'][0]['items_count'];?></span> produk untuk <b>"<?=$rest_kategori['nama_kategori2'];?>"</b> (<b id="rows_post-data-appned_produk">1 - 12</b> of <b id="rows_flt-data-appned_produk_2"><?=$rest_kategori_p['result'][0]['items_count'];?></b>)
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-12 col-lg-12">
                <div class="mt-4">

                  <div class="row" id="post-data-appned-rekom">
                    <?php foreach($rest_bestview_product['result'] as $objp) : ?>  
                    <div class="<?=$cols_data_infinity;?> mb-4">
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
                            <div class="fly-badge-new-arrival-v1" style="top:unset;margin-top: -30px;background:#00b181;">
                              Rekomendasi
                            </div>
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
                  <div class="row" id="post-data-appned">
                    <?php include "product_data.php"; ?>
                  </div>

                  <div id="loadmore_loading" class="text-center d-none">
                    <p class="pb-2">
                      <img src="<?=$main_url;?>/assets/images/loading_load.gif" width="40">&nbsp;&nbsp;Loading get more data...
                    </p>
                  </div>

                  <div id="lmore_failalrt"></div>

                  <?php if($rest_kategori_p['result'][0]['items_count']>12){ ?>
                  <div class="row justify-content-center mt-1">
                    <div class="col-xl-4 col-lg-6 col-md-8 col-sm-8 col-xs-7">
                      <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                          <button type="button" class="btn btn-outline-primary btn-block disabled-x" id="prev_produk_id" onclick="loadMoreData('prev')">
                            <span class="icon-chevron-left"></span> 
                          </button>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                          <button type="button" class="btn btn-primary btn-block" id="next_produk_id" onclick="loadMoreData('next')">
                            <span class="icon-chevron-right"></span>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="bg-container-2 mb-5">
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
          <div class="bg-grad-1 padding-15 rounded">
            <form action="javascript:goRedirect('searchx')" method="POST">
              <div class="form-group mb-0">
                <label class="ft-16 font-weight-bold color-putih">Cari apapun disini</label>
                <div class="input-group">
                  <input type="text" class="form-control ft-16" id="searchtext_valx" placeholder="Ketikan sesuatu..." autocomplete="off">
                  <div class="input-group-append">
                    <button class="btn btn-app" type="button" onclick="goRedirect('searchx')"><span class="icon-search"></span></button>
                  </div>
                </div>
              </div>
            </form>
          </div>
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
        $nullData = $resultProduk;
      }

      $cols_data_infinity = 'col-xl-2 col-lg-3 col-md-3 col-sm-4 col-xs-6';

    ?>

    <section id="carouselProductColumn_id" class="bg-container-2 mt-5 mb-5">
      <div class="title-category mb-3 font-weight-bold ft-20">
        Produk Lainnya
      </div>
      <?php if ($rest_produk['success']==true) { ?>
      <div class="row" id="post-data-appnedx">
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

    <div id="loadmore_loadingx" class="text-center d-none">
      <p class="pb-5">
        <img src="<?=$main_url;?>/assets/images/loading_load.gif" width="40">&nbsp;&nbsp;Loading get more data...
      </p>
    </div>

    <div id="lmore_failalrtx"></div>

    <?php include "module/include/footer.php"; ?>
    
    <?php include "module/include/javascript.php"; ?>

    <script type="text/javascript">
      var start = 0;
      var limit = 12;

      function loadMoreData(a) {

        if ( window.innerWidth <= 767.5){
          var sortby = $('#filter_sortby_mob').val();
          var search = $('#filter_pencarian_mob').val();          
        }else{
          var sortby = $('#filter_sortby').val();
          var search = $('#filter_pencarian').val();
        }

        if ($('#filter_price_min').val()=='') {
          var p_min = '0';
        }else{
          var p_min = $('#filter_price_min').val();
        }

        if ($('#filter_price_max').val()=='') {
          var p_max = '0';
        }else{
          var p_max = $('#filter_price_max').val();
        }

        var price = p_min+'~'+p_max;

        if (a=='prev') {
          start = parseInt(start-limit);
          if (start==0) {
            $('#prev_produk_id').addClass('disabled-x');
          }
        }

        if (a=='next') {
          $('#prev_produk_id').removeClass('disabled-x');
          start = parseInt(start+limit);
        }

        if (a=='ref') {
          start = 0;
          $('#prev_produk_id').addClass('disabled-x');
        }

        if(search==''){
          $('#post-data-appned-rekom').removeClass('d-none');
          $('#label-data-appned-rekom').removeClass('d-none');
        }else{
          $('#post-data-appned-rekom').addClass('d-none');
          $('#label-data-appned-rekom').addClass('d-none');
        }

        $.ajax({
          type: "GET",
          dataType:'html',
          timeout: 9000,
          async: true,
          url: '<?=$main_url;?>product_more.php?jen=kategori_c1&k_subid=<?=$rest_kategori['kategori_sub_id'];?>&start='+start+'&limit='+limit+'&sortby='+sortby+'&search='+search+'&price='+price,
          beforeSend: function(){
            $('#loadmore_loading').removeClass('d-none');
          },
          success: function(data) {
            res = data.split('______irow_');
            $('#loadmore_loading').addClass('d-none');
            if (res[0]=='' || res[0]=='last') {
              $('#lmore_failalrt').html('');
              $('#next_produk_id').addClass('disabled-x');
              start = parseInt(start-limit);

              if (res[1]==0) {
                $("#post-data-appned").html('<div class="text-center w-100 mb-4">-Tidak ditemukan-</div>');
                $("#rows_flt-data-appned_produk").html('0');
                $("#rows_flt-data-appned_produk_2").html('0');
                $("#rows_post-data-appned_produk").html('1');
              }

            }else{
              $("#post-data-appned").html(res[0]);
              $('#next_produk_id').removeClass('disabled-x');

              if (a=='ref' && res[1]<12) {
                $('#next_produk_id').addClass('disabled-x');
              }

              $('html, body').animate({
                scrollTop: $('#post-data-appned').offset().top-120,
              }, 650);

              $("#rows_flt-data-appned_produk").html(res[1]);
              $("#rows_flt-data-appned_produk_2").html(res[1]);
              $("#rows_post-data-appned_produk").html(parseInt(start+1)+' - '+parseInt(start+$("div[id^=appened_more_data_produk_i]").length));


            }
          },
          error: function(xmlhttprequest, textstatus, message) {
            $('#lmore_failalrt').html('<div class="text-center"><p class="pb-2">Please check your connection...</p></div>');
            $('#loadmore_loading').addClass('d-none');
          }
        });
      }
    </script>

    <script type="text/javascript">
      var startx = 12;
      var limitx = 12;
      var prosesx = true;
      var stloadx = 'on';
      
      $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height() - $('#footer_app_inav').height()) {
          if (stloadx=='on') {
            if (prosesx==true) {
              $('#muat_lebih_banyak').html('<button type="button" onclick="loadMoreDatax(startx,limitx);" class="btn btn-outline-primary mb-5 ft-18 pl-5 pr-5">Muat Lebih Banyak</button>');
            }
          }
        }
      });

      function loadMoreDatax(a,b) {
        $('#muat_lebih_banyak').html('');
        $.ajax({
          type: "GET",
          dataType:'html',
          timeout: 9000,
          async: true,
          url: '<?=$main_url;?>product_more.php?jen=index&start='+a+'&limit='+b,
          beforeSend: function(){
            prosesx = false;
            $('#loadmore_loadingx').removeClass('d-none');
          },
          success: function(data) {
            $('#loadmore_loadingx').addClass('d-none');
            if (data=='' || data=='last') {
              stloadx = 'last';
              $('#lmore_failalrtx').html('');
            }else{
              startx = parseInt(startx+limitx);
              $("#post-data-appnedx").append(data);
            }
            prosesx = true;
          },
          error: function(xmlhttprequest, textstatus, message) {
            $('#lmore_failalrtx').html('<div class="text-center"><p class="pb-5">Please check your connection...</p></div>');
            $('#loadmore_loadingx').addClass('d-none');
            prosesx = true;
          }
        });
      }
    </script>

  </body>
</html>