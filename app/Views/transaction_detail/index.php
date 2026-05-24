<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="<?=$rest_sistem['result']['meta_description'];?>">
    <meta name="keywords" content="<?=$rest_sistem['result']['meta_keywords'];?>">
    
    <?php include "module/include/style.php"; ?>

    <title>Detail Transaksi</title>
  </head>
  <body>

    <?php include "module/include/header.php"; ?>

    <section class="bg-container-2 mt-4 pt-3-mob">
      <div class="row justify-content-center">
        <div class="col-xl-11 col-lg-11">
            
          <?php if ($rest_sistem['result']['lbl_info_transaksi']!='') { ?>
            <div class="alert alert-warning mb-4">
              <?=$rest_sistem['result']['lbl_info_transaksi'];?>
            </div>
          <?php } ?>
    
          <div class="row">

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
              <div class="default-shadow rounded-2">
                <div class="padding-15 text-center">

                  <?php if ($i_trx['result']) { ?>

                    <div class="alert alert-info">
                      Simpan kode transaksi ini untuk melihat perubahan status transaksi kamu
                      <div class="mt-1 d-flex align-items-center justify-content-center">
                        <b class="mr-2"><?= $rest_trx['no_transaksi']; ?></b>
                        <a href="javascript:copyTextInv();" class="btn btn-info btn-sm ft-12" id="copyTextInv">
                            <i class="fa fa-copy"></i>
                        </a>
                      </div>
                      <div class="mt-1 small">
                        Silakan kunjungi menu <a href="<?=$main_url;?>cek-transaksi"><b>Cek Transaksi</b></a> untuk melihat detail riwayat transaksi Anda
                      </div>
                    </div>

                    <input type="hidden" id="no_transaksiid" value="<?=$rest_trx['no_transaksi'];?>" class="form-control">

                    <?php if ($rest_trx['bukti_pembayaran']=='n' && $rest_trx['is_status']!='b') { ?>
                      <h3 class="mb-3 ft-18 font-weight-bold mt-3">TRANSAKSI BERHASIL <i class="fa fa-check"></i></h3>
                      <p class="color-semidark">
                        No Transaksi : <b class="font-weight-bold"><?=$rest_trx['no_transaksi'];?></b>
                        <br/>
                        Status : <b class="color-<?=$rest_trx['status_clr'];?>"><?=$rest_trx['status_lbl'];?></b>
                        <br/>
                        Tanggal : <b><?=$rest_trx['tgl_transaksi'];?></b>
                      </p>
                      <p class="color-semidark">
                        Total Pembayaran : <b class="font-weight-bold"><?=$rest_trx['total_bayar'];?></b>
                      </p>

                      <?php if ($rest_trx['is_status']=='p') { ?>
                        <p class="color-semidark ft-14">
                          Silahkan lakukan pembayaran agar transaksi kamu bisa langsung kami proses.
                        </p>
                      <?php } ?>

                      <?php if ($rest_trx['is_status']=='y' || $rest_trx['is_status']=='k' || $rest_trx['is_status']=='s') { ?>
                      <p class="color-semidark">Terima Kasih telah menggunakan layanan kami situs penjualan online terpercaya.</p>
                      <p class="color-success font-weight-bold">Pembayaran Selesai. <i class="fa fa-check"></i></p>
                      <?php } ?>

                    <?php }elseif($rest_trx['is_status']=='p' || $rest_trx['is_status']=='y' || $rest_trx['is_status']=='k' || $rest_trx['is_status']=='s') { ?>
                      <h3 class="mb-3 ft-18 font-weight-bold mt-2">TRANSAKSI BERHASIL <i class="fa fa-check"></i></h3>
                      <p class="color-semidark">
                        No Transaksi : <b class="font-weight-bold"><?=$rest_trx['no_transaksi'];?></b>
                        <br/>
                        Status : <b class="color-<?=$rest_trx['status_clr'];?>"><?=$rest_trx['status_lbl'];?></b>
                        <br/>
                        Tanggal : <b><?=$rest_trx['tgl_transaksi'];?></b>
                      </p>

                      <?php if ($rest_trx['is_status']!='s' && $rest_trx['is_status']!='k') { ?>
                        <?php if ($rest_trx['metode_pembayaran']=='saldo') { ?>
                        <p class="color-semidark">
                          <span class="font-weight-bold">Pembayaran dengan Saldo.</span>
                        </p>
                        <?php }else{ ?>
                        <p class="color-semidark">Bukti Transfer telah kami terima. Terima Kasih telah menggunakan layanan kami situs penjualan online terpercaya.
                          <br>
                          <span class="font-weight-bold">Pesanan kamu akan kami proses lebih lanjut.</span>
                        </p>
                        <?php } ?>
                      <?php } ?>

                      <?php if ($rest_trx['is_status']=='k' || $rest_trx['is_status']=='s') { ?>
                      <p class="color-semidark">Terima Kasih telah menggunakan layanan kami situs penjualan online terpercaya.</p>
                      <?php } ?>
      
                      <p class="color-semidark">
                        Total Pembayaran : <b class="font-weight-bold"><?=$rest_trx['total_bayar'];?></b>
                      </p>
                    
                      <?php if ($rest_trx['is_status']=='p') { ?>
                        <p class="color-app font-weight-bold">
                          Pembayaran kamu sedang kami cek. <i class="fa fa-hourglass-half"></i>
                        </p>
                        <div class="alert alert-primary">
                          Bukti pembayaran telah terkirim, proses pengecekan membutuhkan waktu hingga 1x24 jam.
                        </div>
                      <?php } else if ($rest_trx['is_status']=='y' || $rest_trx['is_status']=='k' || $rest_trx['is_status']=='s'){ ?>
                        <p class="color-success font-weight-bold">Pembayaran Selesai. <i class="fa fa-check"></i></p>
                      <?php } ?>

                      <?php if($rest_trx['is_status']=='y' || $rest_trx['is_status']=='k') { ?>
                        <p class="font-weight-bold color-semidark">Pesanan kamu akan segera tiba.</p>
                      <?php } ?>

                    <?php }else{ ?>
                      <h3 class="mb-3 ft-18 font-weight-bold mt-2">TRANSAKSI DIBATALKAN <i class="fa fa-times"></i></h3>
                      <p class="color-semidark">
                        No Transaksi : <b class="font-weight-bold"><?=$rest_trx['no_transaksi'];?></b>
                        <br/>
                        Status : <b class="color-<?=$rest_trx['status_clr'];?>"><?=$rest_trx['status_lbl'];?></b>
                        <br/>
                        Tanggal : <b><?=$rest_trx['tgl_transaksi'];?></b>
                      </p>

                      <p class="color-semidark"><?=$rest_trx['if_cancel'];?></p>

                      <p class="color-semidark">
                        Total Yang Harus Dibayarkan : <b class="font-weight-bold"><?=$rest_trx['total_bayar'];?></b>
                      </p>
                    <?php } ?>


                    <?php if ($rest_trx['is_status']=='p') { ?>
                      <p class="color-semidark">
                        <span class="font-weight-bold">Cara Pembayaran</span>
                        <br>
                        <span class="ft-14">Lakukan pembayaran melalui salah satu cara / bank dibawah ini :</span>
                      </p>
                      
                      <div class="alert alert-warning font-weight-bold">
                        Dimohon untuk tidak melakukan pembayaran untuk setiap transaksi.<br>
                        Karna ini adalah simulasi untuk Demo Toko Online.
                      </div>
                      
                      <?php if ($rest_trx['payment_type']=='tripay') { ?>
                        <div class="row">
                          <?php foreach(json_decode($rest_trx['cara_pembayaran'], true) as $valc){ ?>
                            <div class="col-xl-12 col-lg-12 text-left pb-3">
                              <div class="padding-0-15 ft-14">
                                <div class="mb-3 ft-16 text-uppercase">
                                  <b><?=$valc['title'];?></b>
                                </div>
                                <div class="">
                                  <?php $no = 0; foreach($valc['steps'] as $valcx){ ?>
                                  <div class="">
                                    <?=$valcx;?>
                                  </div>
                                  <?php $no++; } ?>
                                </div>
                              </div>
                            </div>
                          <?php } ?>
                          <?php if ($rest_trx['biller_code']!='OVO' && $rest_trx['qr_code']!='') { ?>
                          <div class="padding-15 text-center w-100">
                            <img src="<?=$rest_trx['qr_code'];?>" class="img-fluid" width="220px">
                          </div>
                          <?php } ?>
                          <?php if ($rest_trx['biller_code']=='OVO' && $rest_trx['qr_code']!='') { ?>
                          <div class="padding-15 text-center w-100">
                            <a href="<?=$rest_trx['qr_code'];?>" class="btn btn-primary btn-sm" target="_blank"> 
                            Klik untuk melihat cara pembayaran. 
                          </a>
                          </div>
                          <?php } ?>
                        </div>
                      <?php }else if ($rest_trx['payment_type']=='xendit') { ?>
                        <!-- Jika menggunakan manual transfer -->
                        <div class="manual_bank_pay ft-14">
                          Batas Pembayaran 24 Jam.<br/><br/>
                          <a href="<?=$rest_trx['cara_pembayaran'];?>" class="btn btn-primary btn-sm" target="_blank"> 
                            Klik untuk melihat cara pembayaran. 
                          </a>
                        </div>
                      <?php }else if ($rest_trx['payment_type']=='manual') { ?>
                        <!-- Jika menggunakan manual transfer -->
                        <div class="manual_bank_pay ft-14">
                          <?php foreach($i_trx['m_bank'] as $valb){ ?>
                            <img src="<?=$main_imgurl.'komponen/'.$valb['logo_image'];?>" width="80"> &nbsp;
                            Bank <?=$valb['nama_bank'];?> a/n <?=$valb['nama_rekening'];?><br>
                            Nomor Rekening : <?=$valb['nomor_rekening'];?><br><br>
                          <?php } ?>
                        </div>
                      <?php }else if ($rest_trx['payment_type']=='cstore') { ?>
                        <div class="manual_bank_pay ft-14">
                          Batas Pembayaran 24 Jam.<br/><br/>
                          <a href="<?=$rest_trx['cara_pembayaran'];?>" class="btn btn-primary btn-sm" target="_blank"> 
                            Klik untuk melihat cara pembayaran. 
                          </a>
                        </div>
                      <?php }else if ($rest_trx['payment_type']=='qris' || $rest_trx['payment_type']=='gopay') { ?>
                        <div class="manual_bank_pay ft-14">
                          <b>Dimohon untuk cek email Anda untuk melihat cara pembayaran.</b><br/>
                        </div>
                      <?php }else{ ?>
                        <div class="row">
                          <div class="col-xl-12 col-lg-12">
                            <ul class="nav nav-tabs b-0_ mb-4 justify-content-center" id="myTab" role="tablist">
                              <?php $no='1'; foreach($rest_trx['cara_bayar'] as $valc){ ?>
                              <li class="nav-item">
                                <a class="nav-link ft-16 <?php if($no=='1') echo 'active';?>" id="cbyr-tab<?=$valc['cara_bayar_id'];?>" data-toggle="tab" href="#tabcbyr<?=$valc['cara_bayar_id'];?>" role="tab" aria-controls="tabcbyr<?=$valc['cara_bayar_id'];?>" aria-selected="true"><?=$valc['jenis_bayar'];?></a>
                              </li>
                              <?php $no++; } ?>
                            </ul>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xl-12 col-lg-12 text-left">
                            <div class="tab-content" id="myTabContent">
                              <?php $no = 0; foreach($rest_trx['cara_bayar'] as $valc){ ?>
                              <div class="tab-pane fade <?php if($no==0) echo 'show active';?>" id="tabcbyr<?=$valc['cara_bayar_id'];?>" role="tabpanel" aria-labelledby="cbyr-tab<?=$valc['cara_bayar_id'];?>">
                                <div class="padding-0-15 ft-14">
                                  <div class="mb-3 ft-16"><b>Kode Pembayaran / VA : <?=$rest_trx['bill_key'];?></b></div>
                                  <?php $nox = 1; foreach($rest_trx['cara_bayar'][$no]['cara_bayar'] as $valcc){ ?>
                                  <?=$nox.'. '.$valcc['cara_bayar'];?><br/>
                                  <?php $nox++; } ?>
                                </div>
                              </div>
                              <?php $no++; } ?>
                            </div>
                          </div>
                        </div>
                      <?php } ?>

                      <div class="pt-3"><hr></div>

                      <form id="form_kirim_bukti_bayar" class="mt-3" action="javascript:sendPayment()" enctype="multipart/form-data" method="POST">
                        <div class="row">
                          
                          <?php if ($rest_trx['payment_type']!='manual') { ?>
                          <input type="hidden" name="bank_id" value="0" class="form-control">
                          <?php }else{ ?>
                          <!-- Jika menggunakan manual transfer -->
                          <div class="col-sm-12 col-md-12">
                            <div class="form-label-group text-left">
                              <label class="text-left">Transfer Ke</label>
                              <select class="form-control" required="" name="bank_id">
                                <option value=""> -- Pilih Bank -- </option>
                                <?php foreach($i_trx['m_bank'] as $valb){ ?>
                                <option value="<?=$valb['bank_id'];?>"><?=$valb['nama_bank'];?> - <?=$valb['nama_rekening'];?> - <?=$valb['nomor_rekening'];?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <?php } ?>

                          <div class="col-sm-12 col-md-12">
                            <div class="form-label-group text-left mt-2">
                              <label style="text-align: left;">Bukti Pembayaran</label>
                              <input type="file" name="gambar" class="form-control" required="">
                              <input type="hidden" name="no_transaksi" value="<?=$rest_trx['no_transaksi'];?>" class="form-control">
                            </div>
                          </div>

                          <div class="col-sm-12 col-md-12">
                            <?php 
                              if (isset($_SESSION['pesanbukti']) && $_SESSION['pesanbukti'] <> '') {
                                  echo '<br><div class="pesan alert alert-success">'.$_SESSION['pesanbukti'].'</div>';
                              }
                              $_SESSION['pesanbukti'] = '';
                            ?>
                          </div>

                          <div class="col-sm-12 col-md-12">
                            <div id="checkSave" class="mt-4">
                              <button class="btn btn-primary btn-block" type="submit">Kirim Bukti Pembayaran</button>
                            </div>
                          </div>

                        </div>
                      </form>

                    <?php } ?>

                  <?php }else{ ?>
                    <div class="pb-3">
                      <h3 class="ft-18 font-weight-bold mt-3 mb-4">TRANSAKSI TIDAK DITEMUKAN</h3>
                      <a href="<?=$main_url;?>account" class="btn btn-primary">Kembali Ke Riwayat Transaksi</a>
                    </div>
                  <?php } ?>

                </div>
              </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tabtrx" role="tabpanel" aria-labelledby="trx-tab">
                  <div class="default-shadow rounded-2">
                    <div class="padding-15">
                      <div class="">
                        
                        <div class="mb-2">
                          <a href="<?=$main_url;?>account" class="btn btn-light btn-sm">Kembali</a>
                          <?php if($_SESSION['XID_ARRAY']['cust_id']!='guest'){ ?>
                            <?php if($rest_trx['is_status']=='p'){ ?>
                              <button class="btn btn-danger btn-sm ml-2" onClick="batalPesanan()">
                                <i class="fa fa-times"></i>&nbsp;&nbsp;Batalkan Transaksi
                              </button>
                            <?php } ?>

                            <?php if($rest_trx['is_status']=='k'){ ?>
                              <button class="btn btn-success btn-sm ml-2" onClick="datangPesanan()">
                                <i class="fa fa-check"></i>&nbsp;&nbsp;Konfirmasi Pesanan Sampai
                              </button>
                            <?php } ?>
                          <?php } ?>
                          <div class="mt-3">
                            <!-- khusus point of sale -->
                            <?php if($rest_trx['is_digital']=='n' && $rest_trx['transaksi_from']!='POS'){ ?>
                            <p class="color-dark ft-14">Nomor Resi Pengiriman : <br>
                              <?php 
                                if ($rest_trx['nomor_resi']=='') {
                                  echo '<b class="ft-18 font-weight-bold">Belum tersedia</b>';
                                }else{ ?>
                                  <b class="ft-18 font-weight-bold color-app c-pointer" onclick="lacakResi('<?=$rest_trx['nomor_resi'];?>','<?=$rest_trx['kurir'];?>')"><?=$rest_trx['nomor_resi'];?> - Lacak</b>
                                <?php } ?>
                            </p>
                            <?php } ?>
                            <!-- khusus point of sale -->
                            <?php if($rest_trx['transaksi_from']=='POS'){ ?>
                              <p class="color-dark ft-14">Transaksi Offline - POS</p>
                            <?php } ?>
                          </div>
                        </div>

                        <div class="ft-14 font-weight-bold mb-3">
                          Pesanan
                        </div>

                        <div class="table-responsive mt-10 b-0">
                          <table class="table table-hover b-0">
                            <thead class="b-0">
                              <tr class="b-0">
                                <th class="ft-14">Produk</th>
                                <th class="ft-14 text-right">Harga</th>
                                <th class="ft-14 text-right">Jumlah</th>
                                <th class="ft-14 text-right">Subharga</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach($i_trx['m_cart'] as $obj) { ?>
                              <tr>
                                <td class="ft-14">
                                  <?=$obj['nama_produk'];?>
                                  <br/>
                                  <span class="ft-12"><?=$obj['varian'];?></span>
                                  <?php if ($obj['catatan']!='') { ?>
                                  <br/><span class="ft-12">Catatan: <?=$obj['catatan'];?></span>
                                  <?php } ?>
                                  <?php if($obj['is_digital']=='y' && $obj['file_digital']!='' && $obj['file_x_digital']==''){ ?>
                                    <?php if ($rest_trx['is_status']=='p') { ?>
                                      <br/>
                                      <a href="#" class="badge badge-info p-1 mt-1">File : Menunggu konfirmasi pembayaran</a>
                                    <?php }else if($rest_trx['is_status']=='y' || $rest_trx['is_status']=='k' || $rest_trx['is_status']=='s'){ ?>
                                      <br/>
                                      <a href="<?=$main_imgurl.'products/'.$obj['file_digital'];?>" target="_blank" class="badge badge-info p-2 mt-1">Download / Lihat File : <?=$obj['file_digital'];?></a>
                                    <?php } ?>
                                  <?php } ?>
                                  <?php if($obj['is_digital']=='y' && $obj['file_digital']==''){ ?>
                                    <?php if ($rest_trx['is_status']=='p') { ?>
                                      <br/>
                                      <a href="#" class="badge badge-info p-1 mt-1">Menunggu konfirmasi pembayaran</a>
                                    <?php }else if($rest_trx['is_status']=='y' || $rest_trx['is_status']=='k' || $rest_trx['is_status']=='s'){ ?>
                                      <?php if ($obj['file_x_digital']!='') { ?>
                                        <br/>
                                        <a href="<?=$main_imgurl.'products/'.$obj['file_x_digital'];?>" target="_blank" class="badge badge-info p-2 mt-1">Download / Lihat File : <?=$obj['file_x_digital'];?></a>
                                        <?php if ($obj['text_x_digital']!='') { ?>
                                          <br/><?=$obj['text_x_digital'];?>
                                        <?php } ?>
                                      <?php }else{ ?>
                                        <?php if ($obj['text_x_digital']=='') { ?>
                                        <br/>
                                        <a href="#" class="badge badge-info p-1 mt-1">Mohon tunggu, admin akan update sesegera mungkin.</a>
                                        <?php }else{ ?>
                                        <br/><?=$obj['text_x_digital'];?>
                                        <?php } ?>
                                      <?php } ?>
                                    <?php } ?>
                                  <?php } ?>
                                </td>
                                <td align="right" class="ft-14">
                                  <?=$obj['harga_produk'];?>
                                  <?php if ($obj['hs_diskon']!='0') { ?>
                                    <span class="ft-12 text-line-through color-semidark"><br/><?=$obj['hs_diskon'];?></span>
                                  <?php } ?>
                                </td>
                                <td align="right" class="ft-14"><?=$obj['jumlah_beli'];?></td>
                                <td align="right" class="ft-14">
                                  <?=$obj['total_harga_produk'];?>
                                  <?php if ($obj['hs_diskon']!='0') { ?>
                                  <span class="ft-12 text-line-through color-semidark"><br/><?=$obj['hst_diskon'];?></span>
                                  <?php } ?>
                                </td>
                              </tr>
                              <?php } ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <td class="ft-14" colspan="1">Subtotal</td>
                                <td class="ft-14" colspan="3" align="right"><?=$rest_trx['subtotal_bayar'];?></td>
                              </tr>
                              <tr>
                                <td class="ft-14" colspan="1">Ongkos Kirim</td>
                                <td class="ft-14" colspan="3" align="right"><?=$rest_trx['ongkos_kirim'];?></td>
                              </tr>
                              <tr>
                                <td class="ft-14" colspan="1">Potongan Voucher</td>
                                <td class="ft-14 color-danger" colspan="3" align="right"><?=$rest_trx['potongan_voucher'];?></td>
                              </tr>
                              <tr>
                                <th class="ft-14" colspan="1">Total Harga</th>
                                <td class="ft-14 font-weight-bold" colspan="3" align="right">
                                  <?=$rest_trx['total_bayar'];?>
                                </td>
                              </tr>
                            </tfoot>
                          </table>
                        </div>

                        <div class="">
                          <div class="ft-14 mb-3">
                            <div class="ft-14 font-weight-bold mb-1">
                              Catatan
                            </div>
                            <?=$rest_trx['catatan'];?>
                          </div>
                          <div class="ft-14 mb-3">
                            <div class="ft-14 font-weight-bold mb-1">
                              Metode Pembayaran
                            </div>
                            <?php if ($rest_trx['metode_pembayaran']=='saldo') { ?>
                              Saldo
                            <?php }else{ ?>
                              <?=$rest_trx['m_bayar'];?>
                            <?php } ?>
                          </div>
                          <!-- khusus point of sale -->
                          <?php if($rest_trx['is_digital']=='n' && $rest_trx['transaksi_from']!='POS'){ ?>
                          <div class="ft-14 mb-3">
                            <div class="ft-14 font-weight-bold mb-1">
                              Metode Pengiriman
                            </div>
                            Kurir - <?=$rest_trx['nama_kurir'];?>
                            <br>Tingkat - <?=$rest_trx['level_kurir']?> (<?=$rest_trx['lama_pengiriman']?>hari)
                          </div>
                          <div class="ft-14">
                            <div class="ft-14 font-weight-bold mb-1">
                              Alamat Pengiriman
                            </div>
                            <?=$i_trx['m_alamat']['nama_penerima']?>
                            <br><?=$i_trx['m_alamat']['nama_provinsi']?>, <?=$i_trx['m_alamat']['nama_kabkot']?>, <?=$i_trx['m_alamat']['kodepos']?>
                            <br><?=$i_trx['m_alamat']['alamat_lengkap']?>
                            <br>
                            <?php if($_SESSION['XID_ARRAY']['cust_id']=='guest'){ ?>
                            Nomor yang dapat di hubungi <?=substr($i_trx['m_alamat']['ponsel_penerima'],0,4);?>****<?=substr($i_trx['m_alamat']['ponsel_penerima'],-2);?>
                            <br>Alamat Email <?=substr($rest_trx['email_trx'],0,2);?>****<?=substr($rest_trx['email_trx'],-6);?>
                            <?php }else{ ?>
                            Nomor yang dapat di hubungi <?=$i_trx['m_alamat']['ponsel_penerima'];?>
                            <?php } ?>
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
      </div>
    </section>

    <div id="myTrackingresi" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Lacak Pesanan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <style type="text/css"> 
              .tanda0 { border-left: 3px solid #663f91; padding-left: 15px; }
              .tandamore { border-left: 2px solid #999; padding-left: 15px; }
            </style>
            <div id="lihatTrackingresi">Loading...</div>
          </div>
        </div>
      </div>
    </div>

    <?php
    if($_SESSION['XID_ARRAY']['cust_id']!='guest'){
      $arr = array('opsi' => 'idsync', 'idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'idnotif' => $_GET['p_url'], 'lang' => 'en');
      loadData('rest_proses/proses_baca_notifikasi/', $arr);
      }
    ?>

    <?php include "module/include/footer.php"; ?>
    
    <?php include "module/include/javascript.php"; ?>

    <script type="text/javascript">
      function sendPayment(){
        $.confirm({
            title: 'Confirm!',
            content: 'Pastikan bukti pembayaran yang di masukan benar!',
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
                var formData = new FormData($("#form_kirim_bukti_bayar")[0]);
                $.ajax({
                  type: "POST",
                  url: '<?=$main_url;?>module/action.php?jen=kirim_bukti_bayar',
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
      function batalPesanan(){
        $.confirm({
            title: 'Confirm!',
            content: 'Transaksi akan dibatalkan, kamu yakin?',
            theme: 'modern',
            closeIcon: true,
            draggable: false,
            animation: 'scale',
            type: 'red',
            buttons: {
              Batal: function () {

              },
              Simpan: function () {
                $('button').addClass('disabled');
                var notrx = $('#no_transaksiid').val();
                $.ajax({
                  type : "POST",
                  url : "<?=$main_url;?>module/action.php?jen=batalkan_transaksi",
                  data :  { 'notrx' : notrx },
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
      
      function datangPesanan(){
        $.confirm({
            title: 'Confirm!',
            content: 'Pastikan pesanan sudah kamu terima, yakin?',
            theme: 'modern',
            closeIcon: true,
            draggable: false,
            animation: 'scale',
            type: 'red',
            buttons: {
              Batal: function () {

              },
              Selesai: function () {
                $('button').addClass('disabled');
                var notrx = $('#no_transaksiid').val();
                $.ajax({
                  type : "POST",
                  url : "<?=$main_url;?>module/action.php?jen=tiba_transaksi",
                  data :  { 'notrx' : notrx },
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

      function lacakResi(a,b){
        $('#myTrackingresi').modal('toggle');
        formTrackingresi(a,b);
      }

      function formTrackingresi(a,b) {
        $.get('<?=$main_url;?>module/action.php?jen=cek_resi&resi='+a+'&kurir='+b, function(data) {
          $('#lihatTrackingresi').html(data);
        });
      }

      function copyTextInv() {
        const text = "<?=$rest_trx['no_transaksi'];?>";
        navigator.clipboard.writeText(text)
        .then(() => {
          $('#copyTextInv').html('<i class="fa fa-copy"></i>&nbsp;&nbsp;disalin');
          console.log("Teks berhasil disalin: " + text);
        })
        .catch(err => {
          alert("Salin gagal, silahkan salin text manual ya!");
        });
      }

    </script>

  </body>
</html>