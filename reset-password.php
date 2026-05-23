<?php 
  
  include "module/module.php"; 

  if (!$_GET['p_url']) {
    header("Location: ".$main_url); exit();
  }
  if ($_SESSION['XID_ARRAY'] && $_SESSION['XID_ARRAY']['cust_id']!='guest') {
    $_SESSION['trxrpass_msgpass'] = 'Logout dari akun untuk melanjutkan.';
    header("Location: ".$main_url); exit();
  }

  $arr = array('idunique' => $_GET['p_url'], 'lang' => 'en');
  $reset_check = loadData('rest_load/reset_password/', $arr); 

?>
<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <meta name="keywords" content="<?=$rest_sistem['result']['meta_keywords'];?>">
    
    <?php include "module/include/style.php"; ?>

    <title>Reset Password</title>
  </head>
  <body>

    <?php include "module/include/header.php"; ?>

    <?php if ($reset_check['result']==0) { ?>

    <section class="bg-container-2 mt-4 mb-5">
      <div class="row justify-content-center mb-30">
        <div class="col-xl-10 col-lg-10 col-md-11">
          <div class="section-title ft-28 text-center">
            &mdash; Halaman Tidak Ada &mdash;
          </div>
          <?php 
            if (isset($_SESSION['trxrpass_msg']) && $_SESSION['trxrpass_msg'] <> '') {
                echo '<div class="alert alert-success mb-3 mt-3">'.$_SESSION['trxrpass_msg'].'</div>';
            }
            $_SESSION['trxrpass_msg'] = '';
          ?>
        </div>
      </div>


    </section>

    <?php }else{ ?>

    <section class="bg-container-2 mt-4 mb-5">
      <div class="row justify-content-center mb-30">
        <div class="col-xl-10 col-lg-10 col-md-11">
          <div class="section-title ft-28 text-center">
            &mdash; Reset Password &mdash;
          </div>
        </div>
      </div>
      <div class="row justify-content-center mb-30">
        <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
          <form id="form_ubah_password_akun" action="javascript:prosesgantiPassword()" method="POST">
            <div class="form-group">
              <label>Password Baru<i class="text-danger">*</i></label>
              <input type="hidden" class="form-control" name="unique_id" value="<?=$_GET['p_url'];?>" required="">
              <input type="password" class="form-control ft-16" name="password_baru" placeholder="****************" required="">
            </div>
            <div class="form-group">
              <label>Ulangi Password Baru<i class="text-danger">*</i></label>
              <input type="password" class="form-control ft-16" name="password_confirm" placeholder="****************" required="">
            </div>
            <div class="">
              <button class="btn btn-app btn-block" type="submit">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </section>

    <?php } ?>

    <?php include "module/include/footer.php"; ?>
    
    <?php include "module/include/javascript.php"; ?>

    <script>

      function prosesgantiPassword(){
        $.confirm({
            title: 'Confirm!',
            content: 'Pastikan password yang di masukan slalu kamu ingat!',
            theme: 'modern',
            closeIcon: true,
            draggable: false,
            animation: 'scale',
            type: 'dark',
            buttons: {
              Batal: function () {

              },
              Simpan: function () {
                $('button').addClass('disabled');
                var formData = new FormData($("#form_ubah_password_akun")[0]);
                $.ajax({
                  type: "POST",
                  url: '<?=$main_url;?>module/action.php?jen=reset_password',
                  data:  formData,
                  contentType: false,
                  cache: false,
                  processData:false,
                  success: function(result){
                    $('button').removeClass('disabled');
                    var res = result.split('~');
                    if (res[0]=='y') {
                      confirmBerhasil(res[1],'reload');
                    }else{
                      confirmGagal(res[1]);
                    }
                  } 
                });
              }
            }
        });
      }
    </script>

  </body>
</html>