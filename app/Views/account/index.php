<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <meta name="keywords" content="<?=$rest_sistem['result']['meta_keywords'];?>">
    
    <?php include "module/include/style.php"; ?>

    <title><?=$rest_cust['result']['cust_nama'];?></title>
  </head>
  <body>

    <?php include "module/include/header.php"; ?>

    <section class="bg-container mt-4">
      <!-- <div class="row justify-content-center mb-30">
        <div class="col-xl-10 col-lg-10 col-md-11">
          <div class="section-title ft-28 text-center">
            &mdash; <?php //if ($rest_cust['result']['cust_nama']=='') echo 'Akun'; else echo $rest_cust['result']['cust_nama']; ?> &mdash;
          </div>
        </div>
      </div> -->
      <div class="row justify-content-center">
        <div class="col-xl-12 col-lg-12 col-xl-10_ col-lg-10_ col-md-11_">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12 mb-4">
              <div class="default-shadow rounded-2">
                <div class="padding-15">
                  <div class="m-h-90">
                    <div class="p-absolute right-30 c-pointer" onclick="myModaleditProfil();"><span class="icon-pencil-square-o"></span></div>
                    <div class="bg_akun_informasi-set rounded-circle p-absolute" style="background: url('<?=$main_imgurl.'profile/'.$rest_cust['result']['cust_gambar'];?>'); background-color: #fff;"></div>
                    <div class="pt-2 pb-1" style="margin-left: 105px;">
                      <div class="ft-16 font-weight-bold">
                        <?php if ($rest_cust['result']['cust_nama']==''){ ?>
                          <span class="c-pointer color-danger" onclick="myModaleditProfil();">Klik lengkapi data...</span>
                        <?php }else{ echo $rest_cust['result']['cust_nama']; } ?>
                      </div>
                      <div class="ft-14 pt-1 color-semidark-m">
                        <?php if ($rest_cust['result']['cust_ponsel']=='') echo '-'; else echo $rest_cust['result']['cust_ponsel']; ?>
                      </div>
                      <div class="text-overflow-ellips color-semidark-m">
                        <div class="ft-14 pr-3"><?=$rest_cust['result']['is_token'];?></div>
                      </div>
                    </div>
                    <?php if ($rest_sistem['result']['fitur_saldo']=='y') { ?>
                    <div class="ft-16 color-app mt-3">
                      <a href="<?=$main_url;?>balance">
                        <span class="ft-14">Saldo :</span> <b><?=$rest_cust['saldo'];?></b>
                      </a>
                    </div>
                    <?php } ?>
                  </div>

                  <hr>

                  <div class="">
                    <form id="form_ubah_password_akun" action="javascript:goEditakunPassword()" method="POST">
                      <div class="ft-14 font-weight-bold mb-3">
                        Ubah Password
                      </div>
                      <?php if ($rest_cust['result']['is_password']=='') { ?>
                        <div class="alert alert-warning">Set password agar kamu bisa login/masuk dengan menggunakan password.</div>
                      <?php }else{ ?>
                      <div class="form-group">
                        <input type="password" class="form-control ft-16" name="password_lama" placeholder="Password lama" required="">
                      </div>
                      <?php } ?>
                      <div class="form-group">
                        <input type="password" class="form-control ft-16" name="password_baru" placeholder="Password baru" required="">
                      </div>
                      <div class="form-group">
                        <div class="input-group">
                          <input type="password" class="form-control ft-16" name="password_confirm" placeholder="Ulangi password baru" required="">
                          <div class="input-group-append">
                            <button class="btn btn-app" type="submit">Simpan</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12 mb-4">
              <ul class="nav nav-tabs b-0 mb-4" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="trx-tab" data-toggle="tab" href="#tabtrx" role="tab" aria-controls="tabtrx" aria-selected="true">Transaksi</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="alamat-tab" data-toggle="tab" href="#tabalamat" role="tab" aria-controls="tabalamat" aria-selected="false">Alamat Tersimpan</a>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tabtrx" role="tabpanel" aria-labelledby="trx-tab">
                  <div class="default-shadow rounded-2">
                    <div class="padding-15">
                      <div class="">
                        <div class="ft-14 font-weight-bold mb-3">
                          Riwayat Transaksi
                        </div>

                        <?php 
                          $arr = array('tipe' => 'web', 'idtrx' => 'n', 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'lang' => 'en');
                          $rest_trx = loadData('rest_load/load_riwayat_transaksi/', $arr);
                        ?>

                        <div class="table-responsive mt-10 b-0" style="height:310px; overflow-y: auto;">
                          <table class="table table-hover b-0">
                            <thead class="b-0">
                              <tr class="b-0">
                                <th class="ft-14">No Transaksi</th>
                                <th class="ft-14">Status</th>
                                <th class="ft-14">Tanggal</th>
                                <?php if($rest_sistem['result']['metode_rating']!='off' || $rest_sistem['result']['metode_ulasan']!='off'){ ?>
                                <th class="ft-14">&nbsp;</th>
                                <?php } ?>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($rest_trx['result'] as $obj) { ?>
                              <tr>
                                <td class="ft-14">
                                  <a href="<?=$main_url;?>trx/<?=$obj['unique_id'];?>" class="font-weight-bold">
                                    <?=$obj['no_transaksi'];?>
                                  </a>
                                </td>
                                <td class="ft-14"><span class="color-<?=$obj['status_clr'];?>"><?=$obj['status_lbl'];?></span></td>
                                <td class="ft-14"><?=$obj['tgl_transaksi'];?></td>
                                <?php if($obj['is_status']=='s' && ($rest_sistem['result']['metode_rating']!='off' || $rest_sistem['result']['metode_ulasan']!='off')){ ?>
                                <td class="ft-14" align="right">
                                  <a href="javascript:lihatUlasan('<?=$obj['unique_id'];?>');">
                                    <?php 
                                      if($rest_sistem['result']['metode_rating']!='off' && $rest_sistem['result']['metode_ulasan']!='off'){
                                        echo 'Ulasan & Rating';
                                      }else if ($rest_sistem['result']['metode_rating']!='off') {
                                        echo 'Rating';
                                      }else{
                                        echo 'Ulasan';
                                      }
                                    ?>
                                  </a>
                                </td>
                                <?php }else{ ?>
                                <?php if($rest_sistem['result']['metode_rating']!='off' || $rest_sistem['result']['metode_ulasan']!='off'){ ?>
                                <td>&nbsp;</td>
                                <?php } ?>
                                <?php } ?>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="tabalamat" role="tabpanel" aria-labelledby="alamat-tab">
                  <div class="default-shadow rounded-2">
                    <div class="padding-15">
                      <div class="">
                        <div class="ft-14 font-weight-bold mb-3">
                          Alamat Tersimpan
                          <a href="#" onclick="actionAlamat('add')" class="ft-14 float-right">
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;Alamat&nbsp;
                          </a>
                        </div>

                        <?php 
                          $arr = array('tipe' => 'all', 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'lang' => 'en');
                          $rest_alamat = loadData('rest_load/load_alamat_customer/',$arr);
                        ?>

                        <?php if ($rest_alamat['nums']>0) { ?>
                          <div class="row" style="max-height:310px; overflow-y: auto;">
                            <?php foreach($rest_alamat['result'] as $obj) { ?>
                              <div class="col-xl-12 col-lg-12 mb-3">
                                <div class="alamat_nya_my_send padding-10-15 rounded-2 border-d" style="background: #f3f4f5;">
                                  <div class="ft-14 font-weight-bold mb-1">
                                    <?=$obj['label_alamat'];?>
                                    <span class="float-right"><span class="icon-pencil-square-o c-pointer" onclick="actionAlamat('edit','<?=$obj['cust_det_id']?>')"></span></span>
                                  </div>
                                  <div class="ft-14">Penerima : <?=$obj['nama_penerima'];?></div>
                                  <div class="ft-14"><?=$obj['alamat_lengkap'];?>, 
                                    <span class="text-lowercase"><?=$obj['nama_provinsi'];?>, <?=$obj['nama_kabkot'];?> - <?=$obj['kodepos'];?></span>
                                  </div>
                                  <div class="ft-14">Nomor yang dapat di hubungi <?=$obj['ponsel_penerima'];?></div>
                                </div>
                              </div>
                            <?php } ?>
                          </div>
                        <?php }else{ ?>
                          <div class="alamat_nya_my_send padding-10-15 rounded-2 border-d" style="background: #f3f4f5;">
                            <div class="ft-14 font-weight-bold mb-1">
                              Tidak ada alamat tersimpan
                            </div>
                            <div class="ft-14">Tambah alamat untuk melanjutkan.</div>
                          </div>
                        <?php } ?>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="modal fade" id="mymodalUlasan">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal body -->
          <img src="<?=$main_url;?>assets/images/komponen/bubble_x3_v1.png" class="p-absolute h-100 left-0">
          <img src="<?=$main_url;?>assets/images/komponen/bubble_x3_v2.png" class="p-absolute h-100 right-0">
          <div class="modal-body">
            <div class="close_pfda" data-dismiss="modal"><span class="icon-close2"></span></div>
            <div class="text-center p-mob-30">
              <div class="section-title ft-18 text-center mb-3">
                  &mdash; Ulasan & Rating &mdash;
              </div>
              <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <div id="reslihatulasan"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include "module/include/footer.php"; ?>
    
    <?php include "module/include/javascript.php"; ?>

    <script type="text/javascript">
      function lihatUlasan(a){
        $('#mymodalUlasan').modal('toggle');
        formmodalUlasan(a);
      }

      function formmodalUlasan(a) {
        $.get('<?=$main_url;?>module/action.php?jen=ulasan_transaksi&idtrx='+a, function(data) {
          $('#reslihatulasan').html(data);
        });
      }

      function iRating(a,b){
        if (a==1) {
          $('#rat_trx_star1'+b).addClass('color-warning');
          $('#rat_trx_star2'+b).removeClass('color-warning');
          $('#rat_trx_star3'+b).removeClass('color-warning');
          $('#rat_trx_star4'+b).removeClass('color-warning');
          $('#rat_trx_star5'+b).removeClass('color-warning');
          $('#ididrating'+b).val(1);
        }else if (a==2) {
          $('#rat_trx_star1'+b).addClass('color-warning');
          $('#rat_trx_star2'+b).addClass('color-warning');
          $('#rat_trx_star3'+b).removeClass('color-warning');
          $('#rat_trx_star4'+b).removeClass('color-warning');
          $('#rat_trx_star5'+b).removeClass('color-warning');
          $('#ididrating'+b).val(2);
        }else if (a==3) {
          $('#rat_trx_star1'+b).addClass('color-warning');
          $('#rat_trx_star2'+b).addClass('color-warning');
          $('#rat_trx_star3'+b).addClass('color-warning');
          $('#rat_trx_star4'+b).removeClass('color-warning');
          $('#rat_trx_star5'+b).removeClass('color-warning');
          $('#ididrating'+b).val(3);
        }else if (a==4) {
          $('#rat_trx_star1'+b).addClass('color-warning');
          $('#rat_trx_star2'+b).addClass('color-warning');
          $('#rat_trx_star3'+b).addClass('color-warning');
          $('#rat_trx_star4'+b).addClass('color-warning');
          $('#rat_trx_star5'+b).removeClass('color-warning');
          $('#ididrating'+b).val(4);
        }else if (a==5) {
          $('#rat_trx_star1'+b).addClass('color-warning');
          $('#rat_trx_star2'+b).addClass('color-warning');
          $('#rat_trx_star3'+b).addClass('color-warning');
          $('#rat_trx_star4'+b).addClass('color-warning');
          $('#rat_trx_star5'+b).addClass('color-warning');
          $('#ididrating'+b).val(5);
        }else{
          $('#rat_trx_star1'+b).removeClass('color-warning');
          $('#rat_trx_star2'+b).removeClass('color-warning');
          $('#rat_trx_star3'+b).removeClass('color-warning');
          $('#rat_trx_star4'+b).removeClass('color-warning');
          $('#rat_trx_star5'+b).removeClass('color-warning');
          $('#ididrating'+b).val(5);
        }
      }

      function simpanUlasan(a,b,c){
        $.confirm({
            title: 'Confirm!',
            content: 'Ulasan & Rating akan disimpan!',
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
                $.ajax({
                  type: "POST",
                  url: '<?=$main_url;?>module/action.php?jen=simpan_ulasan_rating',
                  data :  { 'idtrx' : a, 'ulasan' : b, 'rating' : c },
                  success: function(result){
                    $('button').removeClass('disabled');
                    var res = result.split('~');
                    if (res[0]=='y') {
                      $('.classclassidbutton'+a).addClass('d-none');
                    }else{
                      confirmGagal(res[2]);
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