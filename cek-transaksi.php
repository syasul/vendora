<?php 
  
  include "module/module.php"; 

  if ($_SESSION['XID_ARRAY'] && $_SESSION['XID_ARRAY']['cust_id']!='guest') {
    header("Location: ".$main_url."account"); exit();
  }

?>
<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <meta name="keywords" content="<?=$rest_sistem['result']['meta_keywords'];?>">
    
    <?php include "module/include/style.php"; ?>

    <title>Cek Transaksi</title>
  </head>
  <body>

    <?php include "module/include/header.php"; ?>

    <section class="bg-container-2 mt-4 mb-5">
      <div class="row justify-content-center mb-30">
        <div class="col-xl-10 col-lg-10 col-md-11">
          <div class="section-title ft-28 text-center">
            &mdash; Cek Transaksi &mdash;
          </div>
        </div>
      </div>
      <div class="row justify-content-center mb-30">
        <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
          <form id="form_ubah_password_akun" action="javascript:prosesCheckUIDinv()" method="POST">
            <div class="form-group">
              <label>Masukan UID/Invoice<i class="text-danger">*</i></label>
              <input type="text" class="form-control ft-16" name="uidinv" id="uidinv" required="">
            </div>
            <div class="">
              <button class="btn btn-app btn-block" type="submit">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </section>

    <?php include "module/include/footer.php"; ?>
    
    <?php include "module/include/javascript.php"; ?>

    <script>

      function prosesCheckUIDinv() {  
        var uidinv =  $('#uidinv').val();
        var safeUIDinv = uidinv.replace(/\//g, '-');
        window.location.href = '<?=$main_url;?>trx/' + safeUIDinv;  
      }

    </script>

  </body>
</html>