<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <meta name="keywords" content="<?=$rest_sistem['result']['meta_keywords'];?>">
    
    <?php include "module/include/style.php"; ?>

    <title>Lupa Password</title>
  </head>
  <body>

    <?php include "module/include/header.php"; ?>

    <section class="bg-container-2 mt-4 mb-5">
      <div class="row justify-content-center mb-30">
        <div class="col-xl-10 col-lg-10 col-md-11">
          <div class="section-title ft-28 text-center">
            &mdash; Lupa Password &mdash;
          </div>
          <?php 
            if (isset($_SESSION['trxrpassl_msg']) && $_SESSION['trxrpassl_msg'] <> '') {
                echo '<div class="alert alert-info mb-3 mt-3">'.$_SESSION['trxrpassl_msg'].'</div>';
            }
            $_SESSION['trxrpassl_msg'] = '';
          ?>
        </div>
      </div>
      <div class="row justify-content-center mb-30">
        <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
          <form id="form_ubah_password_akun" action="javascript:proseslupaPassword()" method="POST">
            <div class="form-group">
              <label>Email Address<i class="text-danger">*</i></label>
              <input type="email" class="form-control ft-16" name="email_address" required="">
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

      function proseslupaPassword(){
        $.confirm({
            title: 'Confirm!',
            content: 'Konfirmasi lupa password akan dikirimkan melalui email.',
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
                  url: '<?=$main_url;?>module/action.php?jen=lupa_password',
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