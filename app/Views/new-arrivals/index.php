<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <meta name="keywords" content="<?=$rest_sistem['result']['meta_keywords'];?>">

    <meta property="og:title" content="New Arrivals - <?=$rest_sistem['result']['meta_title'];?>">
    <meta property="og:description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <?php if (file_exists($main_imgurl.'thumbnails/'.$rest_sistem['result']['logo_toko_image'])){ ?>
    <meta property="og:image" content="<?=$main_imgurl.'thumbnails/'.$rest_sistem['result']['logo_toko_image'];?>">
    <?php }else{ ?>
    <meta property="og:image" content="<?=$main_imgurl.'logo/'.$rest_sistem['result']['logo_toko_image'];?>">
    <?php } ?>
    <meta property="og:url" content="<?=$main_url;?>new-arrivals">
    
    <?php include "module/include/style.php"; ?>

    <title>New Arrivals - <?=$rest_sistem['result']['meta_title'];?></title>
  </head>
  <body>

    <?php include "module/include/header.php"; ?>
    
    <?php 
      $arr = array('wishlist' => 'n', 'idproduk' => 'n', 'new' => 'y', 'tipe' => 'limit', 'start' => '0', 'limit' => '12', 'lang' => 'en');
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

    <section class="bg-container-2 mt-4 mb-3">
      <div class="row justify-content-center mb-30">
        <div class="col-xl-10 col-lg-10 col-md-11">
          <div class="section-title ft-28 text-center">
            &mdash; New Arrivals &mdash;
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-xl-11 col-lg-10">
          <?php if ($rest_produk['success']==true) { ?>
          <div class="row" id="post-data-appned">
            <?php include "product_data.php"; ?>
            <?php if (!$nullData) { ?>
              <div class="col-xl-12 col-lg-12">
                <div class="text-center mb-4">Saat ini tidak tersedia.</div>
              </div>
            <?php } ?>
          </div>
          <?php }else{ ?>
            <div class="alert alert-danger">Failed to load data, please refresh the page.</div>
          <?php } ?>
        </div>
      </div>
    </section>

    <div id="loadmore_loading" class="text-center d-none">
      <p class="pb-5">
        <img src="<?=$main_url;?>/assets/images/loading_load.gif" width="40">&nbsp;&nbsp;Loading get more data...
      </p>
    </div>

    <div id="lmore_failalrt"></div>

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
              loadMoreData(start,limit);
            }
          }
        }
      });

      function loadMoreData(a,b) {
        $.ajax({
          type: "GET",
          dataType:'html',
          timeout: 9000,
          async: true,
          url: '<?=$main_url;?>product_more.php?jen=new_arrivals&start='+a+'&limit='+b,
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