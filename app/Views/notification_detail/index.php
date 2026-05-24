<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <meta name="keywords" content="<?=$rest_sistem['result']['meta_keywords'];?>">
    
    <?php include "module/include/style.php"; ?>

    <title>Notifikasi</title>
  </head>
  <body>

    <?php include "module/include/header.php"; ?>

    <section class="bg-container-2 mt-4 mb-5">
      <div class="row justify-content-center mb-30">
        <div class="col-xl-10 col-lg-10 col-md-11">
          <div class="section-title ft-20 text-center">
            &mdash; <?=$res_n['judul_notif'];?> &mdash;
          </div>
        </div>
      </div>
      <div class="row justify-content-center mb-30">
        <div class="col-xl-10 col-lg-10 col-md-11">
          <div class="inner-html-cstore">
            <?=$res_n['ket_notif'];?>
          </div>
        </div>
      </div>
    </section>

    <?php
      $arr = array('opsi' => 'id', 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'idnotif' => $_GET['p_url'], 'lang' => 'en');
      loadData('rest_proses/proses_baca_notifikasi/', $arr);
    ?>

    <?php include "module/include/footer.php"; ?>
    
    <?php include "module/include/javascript.php"; ?>

  </body>
</html>