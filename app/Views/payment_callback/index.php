<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <?php include "module/include/style.php"; ?>

    <title>Status Transaksi</title>
  </head>
  <body>

    <?php include "module/include/header.php"; ?>

    <section class="bg-container-2 mt-4 mb-5">
      <div class="row justify-content-center mb-3">
        <div class="col-xl-10 col-lg-10 col-md-11">
          <div class="section-title ft-28 text-center">
            &mdash; <?=$t_stpay;?> &mdash;
          </div>
        </div>
      </div>
      <div class="row justify-content-center mb-30">
        <div class="col-xl-10 col-lg-10 col-md-11">

          <?php 
            if (isset($_SESSION['trxidunique_msg']) && $_SESSION['trxidunique_msg'] <> '') {
                echo '<div class="alert alert-warning text-center">'.$_SESSION['trxidunique_msg'].'</div>';
            }
            $_SESSION['trxidunique_msg'] = '';
          ?>

          <?php if (isset($_SESSION['trxidunique_xix']) && $_SESSION['trxidunique_xix'] <> '') { ?>
            <?php if ($_GET['p_url']=='success') { ?>
              <div class="box_ text-center">
                <p class="color-dark">Terima kasih telah memilih layanan kami, transaksi sedang kami proses.
                  <?php if (isset($_SESSION['XID_ARRAY']) && $_SESSION['XID_ARRAY']['cust_id']!='guest') { ?>
                  <br>Cek riwayat transaksi <a href="<?=$main_url;?>account" class="font-weight-bold">Riwayat Transaksi.</a>
                  <?php } ?>
                </p>
                    
                <div class="mt-4 mb-4">
                  dalam <span class="font-weight-bold" id="secredirect">5</span> 
                  detik akan di arahkan ke <b>Rincian Transaksi</b> atau kamu bisa klik <a href="<?=$main_url;?>trx/<?=$_SESSION['trxidunique_xix'];?>" class="font-weight-bold">redirect url</a>.
                </div>

                <a href="<?=$main_url;?>" class="btn btn-primary">Belanja lagi</a> 
              </div>
            <?php }else if ($_GET['p_url']=='pending') { ?>
              <div class="box_ text-center">
                <p class="color-dark">Terima kasih telah memilih layanan kami.<br>
                  Segera selesaikan pembayaran agar transaksi dapat kami proses.
                  <?php if (isset($_SESSION['XID_ARRAY']) && $_SESSION['XID_ARRAY']['cust_id']!='guest') { ?>
                  <br>Cek riwayat transaksi <a href="<?=$main_url;?>account" class="font-weight-bold">Riwayat Transaksi.</a>
                  <?php } ?>
                </p>
                    
                <div class="mt-4 mb-4">
                  dalam <span class="font-weight-bold" id="secredirect">5</span> 
                  detik akan di arahkan ke <b>Rincian Transaksi</b> atau kamu bisa klik <a href="<?=$main_url;?>trx/<?=$_SESSION['trxidunique_xix'];?>" class="font-weight-bold">redirect url</a>.
                </div>

                <a href="<?=$main_url;?>" class="btn btn-primary">Belanja lagi</a> 
              </div>
            <?php }else if ($_GET['p_url']=='unsuccess') { ?>
              <div class="box_ text-center">
                <p class="color-dark">Transaksi tidak selesai, silahkan coba lagi.</p>
                <a href="<?=$main_url;?>" class="btn btn-primary">Belanja lagi</a> 
              </div> 
            <?php }else if ($_GET['p_url']=='error') { ?>
              <div class="box_ text-center">
                <p class="color-dark">Transaksi gagal, silahkan coba lagi.</p>
                <a href="<?=$main_url;?>" class="btn btn-primary">Belanja lagi</a> 
              </div>
            <?php }else{ ?>
              <div class="box_ text-center">
                <p class="color-dark">Halaman tidak ditemukan.</p>
                <a href="<?=$main_url;?>" class="btn btn-primary">Belanja lagi</a> 
              </div> 
            <?php } ?>
          <?php }else if ($_GET['p_url']=='error') { ?>
            <div class="box_ text-center">
              <p class="color-dark">Transaksi gagal, silahkan coba lagi.</p>
              <a href="<?=$main_url;?>" class="btn btn-primary">Belanja lagi</a> 
            </div>
          <?php }else{ ?>
            <div class="box_ text-center">
              <p class="color-dark">Halaman tidak ditemukan.</p>
              <a href="<?=$main_url;?>" class="btn btn-primary">Belanja lagi</a> 
            </div>
          <?php } ?>
          <?php $_SESSION['trxidunique_xix'] = ''; ?>
        </div>
      </div>
    </section>

    <?php include "module/include/footer.php"; ?>
    
    <?php include "module/include/javascript.php"; ?>

    <script type="text/javascript">
      $(document).ready(function(){
        var counter = 5;
        var interval = setInterval(function() {
            counter--;
            $('#secredirect').html(counter)
            if (counter == 0) {
                clearInterval(interval);
                redirectKetikaBayar();
            }
        }, 1000);
      });

      function redirectKetikaBayar(){
        window.location.href='<?=$main_url;?>trx/<?=$trxid;?>';
      }
    </script>

  </body>
</html>