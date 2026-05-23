    <style type="text/css">
        .modal { overflow: auto !important; }
    </style>

    <div class="modal-header bg-35 border-radius0">
        <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;"><?=$all_data['result'][0]['no_transaksi'];?></h5>
        <button class="close color-putih" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body bg-f9">
        <div class="row">
            <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">
                <div class="border-radius5 bg-putih">
                    <div class="">
                        <div class="padding-15">
                            <div class="mb-3">
                                <div id="loadingtrxdetaction"></div>
                                <div class="row">
                                    <?php if ($all_data['result'][0]['is_status']=='p') { ?>
                                      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <a href="javascript:prosesActionTransaksi('<?=$all_data['result'][0]['transaksi_id'];?>','b');" class="btn btn-danger btn-sm btn-block"><i class="fa fa-times"></i>&nbsp;&nbsp;Batalkan Transaksi</a>
                                      </div>
                                    <?php } ?>
                                    <?php if ($all_data['result'][0]['is_status']=='p' && $all_data['result'][0]['transaksi_from']=='POS') { ?>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                      <a href="javascript:prosesActionTransaksi('<?=$all_data['result'][0]['transaksi_id'];?>','s')" class="btn btn-primary btn-sm btn-block"><i class="fa fa-check"></i>&nbsp;&nbsp;Transaksi Selesai</a>
                                    </div>
                                    <?php } ?>
                                    <?php if ($all_data['result'][0]['transaksi_from']!='POS') { ?>
                                      <?php if ($all_data['result'][0]['is_status']=='p' && $all_data['result'][0]['is_digital']=='y') { ?>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                          <a href="javascript:prosesActionTransaksi('<?=$all_data['result'][0]['transaksi_id'];?>','s')" class="btn btn-primary btn-sm btn-block"><i class="fa fa-check"></i>&nbsp;&nbsp;Proses & Selesaikan Transaksi</a>
                                        </div>
                                      <?php } ?>
                                      <?php if ($all_data['result'][0]['is_status']=='p' && $all_data['result'][0]['is_digital']=='n') { ?>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                          <a href="javascript:prosesActionTransaksi('<?=$all_data['result'][0]['transaksi_id'];?>','y')" class="btn btn-success btn-sm btn-block"><i class="fa fa-check"></i>&nbsp;&nbsp;Proses Transaksi</a>
                                        </div>
                                      <?php } else if ($all_data['result'][0]['is_status']=='y') { ?>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                          <a href="javascript:prosesActionTransaksi('<?=$all_data['result'][0]['transaksi_id'];?>','k')" class="btn btn-info btn-sm btn-block"><i class="fa fa-truck"></i>&nbsp;&nbsp;Kirim Pesanan</a>
                                        </div>
                                      <?php } else if ($all_data['result'][0]['is_status']=='k') { ?>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                          <a href="javascript:prosesActionTransaksi('<?=$all_data['result'][0]['transaksi_id'];?>','s')" class="btn btn-primary btn-sm btn-block"><i class="fa fa-check"></i>&nbsp;&nbsp;Transaksi Selesai</a>
                                        </div>
                                      <?php } ?>
                                    <?php } ?>
                                </div>
                                <?php if ($all_data['result'][0]['is_status']=='b') { ?>
                                  <div class="color-danger">
                                    <?=$all_data['result'][0]['if_cancel'];?>
                                  </div>
                                <?php } ?>
                                <?php if ($all_data['result'][0]['is_status']=='p') { ?>
                                  <div class="color-danger mt-3">
                                    Klik button <b>"Batalkan"</b> jika ingin membatalkan transaksi.
                                  </div>
                                  <?php if ($all_data['result'][0]['transaksi_from']!='POS') { ?>
                                  <div class="color-success">
                                    Klik button <b>"Proses Transaksi"</b> jika transaksi akan diproses lebih lanjut, pastikan pembayaran sudah diterima.
                                  </div>
                                  <?php } ?>
                                <?php } ?>
                                <?php if ($all_data['result'][0]['is_status']=='y') { ?>
                                  <div class="mt-3">
                                    Klik button <b>"Kirim Pesanan"</b> jika pesanan akan dikirim atau sudah dikirim, sehingga dapat input nomor resi pengiriman.
                                  </div>
                                <?php } ?>
                                <?php if ($all_data['result'][0]['is_status']=='k') { ?>
                                  <div class="mt-3">
                                    Pastikan pesanan sudah sampai tujuan sebelum klik button <b>"Transaksi Selesai"</b>. Pembeli juga dapat melakukan hal yang serupa.
                                  </div>
                                <?php } ?>
                                <?php if ($all_data['result'][0]['is_status']=='s' && $all_data['result'][0]['transaksi_from']!='POS') { ?>
                                  <div class="font-weight-bold">
                                    Transaksi selesai, pesanan sudah sampai tujuan.
                                  </div>
                                <?php } ?>

                                <?php if($all_data['result'][0]['transaksi_from']=='POS'){ ?>
                                  <div class="text-right mt-1">
                                    <?php if ($all_data['result'][0]['is_status']=='s') { ?>
                                    <button class="btn btn-success btn-xs mr-1">Status Selesai</button>
                                    <?php } ?>
                                    <?php if ($all_data['result'][0]['is_status']=='b') { ?>
                                    <button class="btn btn-danger btn-xs mr-1">Status Dibatalkan</button>
                                    <?php } ?>
                                    <button class="btn btn-secondary btn-xs">Transaksi POS</button>
                                  </div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="rounded">
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
                                              <?php foreach($all_data['m_cart'] as $obj) { ?>
                                              <tr>
                                                <td class="ft-14">
                                                  <?=$obj['nama_produk'];?>
                                                  <br/>
                                                  <span class="font-size-12"><?=$obj['varian'];?></span>
                                                  <?php if ($obj['catatan']!='') { ?>
                                                  <br/><span class="ft-12">Catatan: <?=$obj['catatan'];?></span>
                                                  <?php } ?>
                                                  <?php if($obj['is_digital']=='y' && $obj['file_digital']!='' && $obj['file_x_digital']==''){ ?>
                                                  <br/>
                                                  <a href="<?=$this->config->item("nhub_url");?>assets/uploaded/products/<?=$obj['file_digital'];?>" target="_blank">Download / Lihat File : <?=$obj['file_digital'];?></a>
                                                  <?php } ?>
                                                  <?php if($obj['is_digital']=='y' && $obj['file_digital']==''){ ?>
                                                  <br/>
                                                  <a href="#" class="badge badge-info p-1 mt-1" data-toggle="modal" data-target="#modalProdukDigx<?=$obj['transaksi_det_id'];?>">Upload / Lihat</a>
                                                  <?php } ?>
                                                  <!-- Modal -->
                                                  <div class="modal fade" id="modalProdukDigx<?=$obj['transaksi_det_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                      <div class="modal-dialog" role="document">
                                                          <div class="modal-content">
                                                              <form id="editformxdigx" action="javascript:prosesDefault('transaksi/transaksi_x_digital/<?=$obj['transaksi_det_id'];?>','editformxdigx')" method="POST" enctype="multipart/form-data">
                                                                  <div class="modal-body">
                                                                    <div class="form-group">
                                                                      <label>File</label>
                                                                      <input type="file" class="form-control" name="digital" autocomplete="off">
                                                                      <input type="hidden" class="form-control" name="old_digital" value="<?=$obj['file_x_digital'];?>" autocomplete="off">
                                                                      <?php if ($obj['file_x_digital']!='') { ?>
                                                                      <div class="mt-1">
                                                                        <a href="<?=$this->config->item("nhub_url");?>assets/uploaded/products/<?=$obj['file_x_digital'];?>" target="_blank">Lihat File</a></div>
                                                                      <?php } ?>
                                                                    </div>
                                                                    <div class="form-group">
                                                                      <label>Text</label>
                                                                      <textarea type="text" class="form-control" name="text_x_digital"><?=$obj['text_x_digital'];?></textarea>
                                                                    </div>
                                                                  </div>
                                                                  <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
                                                                    <button type="submit" class="btn btn-primary">&nbsp;Submit&nbsp;</button>
                                                                  </div>
                                                              </form>
                                                          </div>
                                                      </div>
                                                  </div>
                                                </td>
                                                <td align="right" class="ft-14">
                                                  <?php if ($obj['hs_diskon']!='0') { ?>
                                                    <span class="font-size-12 color-semidark" style="text-decoration: line-through;"><?=$obj['hs_diskon'];?></span><br/>
                                                  <?php } ?>
                                                  <?=$obj['harga_produk'];?>
                                                </td>
                                                <td align="right" class="ft-14"><?=$obj['jumlah_beli'];?></td>
                                                <td align="right" class="ft-14">
                                                  <?php if ($obj['hs_diskon']!='0') { ?>
                                                  <span class="font-size-12 color-semidark" style="text-decoration: line-through;"><?=$obj['hst_diskon'];?></span><br/>
                                                  <?php } ?>
                                                  <?=$obj['total_harga_produk'];?>
                                                </td>
                                              </tr>
                                              <?php } ?>
                                            </tbody>
                                            <tfoot>
                                              <tr>
                                                <td class="ft-14" colspan="1">Subtotal</td>
                                                <td class="ft-14" colspan="3" align="right"><?=$all_data['result'][0]['subtotal_bayar'];?></td>
                                              </tr>
                                              <?php if($all_data['result'][0]['transaksi_from']!='POS'){ ?>
                                              <tr>
                                                <td class="ft-14" colspan="1">Ongkos Kirim</td>
                                                <td class="ft-14" colspan="3" align="right"><?=$all_data['result'][0]['ongkos_kirim'];?></td>
                                              </tr>
                                              <?php } ?>
                                              <tr>
                                                <td class="ft-14" colspan="1">Potongan Voucher 
                                                  <span class="font-weight-bold"><?=$all_data['result'][0]['kode_voucher'];?></span>
                                                </td>
                                                <td class="ft-14 color-danger" colspan="3" align="right"><?=$all_data['result'][0]['potongan_voucher'];?></td>
                                              </tr>
                                              <tr>
                                                <th class="ft-14" colspan="1">Total Harga</th>
                                                <td class="ft-14 font-weight-bold" colspan="3" align="right">
                                                  <?=$all_data['result'][0]['total_bayar'];?>
                                                </td>
                                              </tr>
                                            </tfoot>
                                          </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($all_data['result'][0]['transaksi_from']!='POS') { ?>
                <?php if ($all_data['result'][0]['is_status']=='y' || $all_data['result'][0]['is_status']=='k') { ?>
                <div class="border-radius5 bg-putih mt-3">
                  <div class="">
                    <div class="padding-15">
                      <div class="ft-14">
                        <div class="input-group">
                          <input type="text" class="form-control ft-16" value="<?=$all_data['result'][0]['nomor_resi'];?>" id="searchtext_val" placeholder="Input nomor resi" autocomplete="off">
                          <div class="input-group-append">
                            <button class="btn btn-primary" type="button" onclick="prosesInputResi('transaksi/transaksi_resi/<?=$all_data['result'][0]['transaksi_id'];?>/'+searchtext_val.value)"><i class="fa fa-check"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php }else if($all_data['result'][0]['is_status']=='b' || $all_data['result'][0]['is_status']=='s') { ?>
                <div class="border-radius5 bg-putih mt-3">
                  <div class="">
                    <div class="padding-15">
                      <div class="ft-14">
                        <b>Nomor Resi : <?=$all_data['result'][0]['nomor_resi'];?></b>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <?php } ?>

                <?php if($all_data['result'][0]['transaksi_from']!='POS'){ ?>
                <?php if ($all_data['result'][0]['is_status']!='b') { ?>
                <div class="border-radius5 bg-putih mt-3">
                  <div class="">
                    <div class="padding-15">
                      <div class="ft-14 font-weight-bold mb-1">Ulasan & Rating</div>
                      <div class="ft-14 mt-3">
                        <?php foreach($all_data['m_cart'] as $obj) { ?>
                          <div class="form-group">
                            <label class="text-left mb-0"><?=$obj['nama_produk'];?> ( <?=$obj['varian'];?> )</label>
                            <div class="rat_produk_trx mb-2 text-left c-pointer">
                              <?php for ($i=1; $i < 6; $i++) { ?>
                                <?php if ($obj['rating_produk']>=$i) $colorrat = 'color-warning'; else $colorrat = ''; ?>
                                <span class="ft-20 <?=$colorrat;?>"><i class="fa fa-star"></i></span>
                              <?php } ?>
                            </div>
                            <div class="input-group">
                              <input type="text" readonly="true" value="<?=$obj['ulasan_produk'];?>" class="form-control">
                              <div class="input-group-append classclassidbutton<?=$obj['transaksi_det_id'];?>">
                                <?php if($obj['publikasi_ulasan']!='y' && $obj['publikasi_rating']!='y'){ ?>
                                  <?php if($all_data['result'][0]['is_status']=='s'){ ?>
                                  <button class="btn btn-primary" type="button" onclick="prosessimpanUlasan('transaksi/transaksi_ulasan/<?=$obj['transaksi_det_id'];?>','<?=$obj['transaksi_det_id'];?>')">
                                    Publikasi
                                  </button>
                                  <?php }else{ ?>
                                  <button class="btn btn-primary" type="button" disabled=""><i class="fa fa-hourglass-half"></i></button>
                                  <?php } ?>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <?php } ?>

                <?php if($all_data['result'][0]['transaksi_from']=='POS'){ ?>
                  <?php if ($all_data['result'][0]['is_status']=='p') { ?>
                  <div class="border-radius5 bg-putih mt-3">
                    <div class="padding-15">
                      <p class="color-semidark">
                        <span class="font-weight-bold">Cara Pembayaran</span>
                        <br>
                        <span class="ft-14">Lakukan pembayaran melalui salah satu cara / bank dibawah ini :</span>
                      </p>
                      
                      <?php if ($all_data['result'][0]['payment_type']=='tripay') { ?>
                        <div class="row">
                          <?php foreach(json_decode($all_data['result'][0]['cara_pembayaran'], true) as $valc){ ?>
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
                          <?php if ($all_data['result'][0]['biller_code']!='OVO' && $all_data['result'][0]['qr_code']!='') { ?>
                          <div class="padding-15 text-center w-100">
                            <img src="<?=$all_data['result'][0]['qr_code'];?>" class="img-fluid" width="220px">
                          </div>
                          <?php } ?>
                          <?php if ($all_data['result'][0]['biller_code']=='OVO' && $all_data['result'][0]['qr_code']!='') { ?>
                          <div class="padding-15 text-center w-100">
                            <a href="<?=$all_data['result'][0]['qr_code'];?>" class="btn btn-primary btn-sm" target="_blank"> 
                            Klik untuk melihat cara pembayaran. 
                          </a>
                          </div>
                          <?php } ?>
                        </div>
                      <?php }else if ($all_data['result'][0]['payment_type']=='xendit') { ?>
                        <!-- Jika menggunakan manual transfer -->
                        <div class="manual_bank_pay ft-14">
                          Batas Pembayaran 24 Jam.<br/><br/>
                          <a href="<?=$all_data['result'][0]['cara_pembayaran'];?>" class="btn btn-primary btn-sm" target="_blank"> 
                            Klik untuk melihat cara pembayaran. 
                          </a>
                        </div>
                      <?php }else if ($all_data['result'][0]['payment_type']=='manual') { ?>
                        <!-- Jika menggunakan manual transfer -->
                        <div class="manual_bank_pay ft-14">
                          <?php foreach($all_data['m_bank'] as $valb){ ?>
                            <img src="<?=$this->config->item("nhub_url").'assets/uploaded/komponen/'.$valb['logo_image'];?>" width="80"> &nbsp;
                            Bank <?=$valb['nama_bank'];?> a/n <?=$valb['nama_rekening'];?><br>
                            Nomor Rekening : <?=$valb['nomor_rekening'];?><br><br>
                          <?php } ?>
                        </div>
                      <?php }else if ($all_data['result'][0]['payment_type']=='cstore') { ?>
                        <div class="manual_bank_pay ft-14">
                          Batas Pembayaran 24 Jam.<br/><br/>
                          <a href="<?=$all_data['result'][0]['cara_pembayaran'];?>" class="btn btn-primary btn-sm" target="_blank"> 
                            Klik untuk melihat cara pembayaran. 
                          </a>
                        </div>
                      <?php }else if ($all_data['result'][0]['payment_type']=='qris' || $all_data['result'][0]['payment_type']=='gopay') { ?>
                        <div class="manual_bank_pay ft-14">
                          <b>Dimohon untuk cek email Anda untuk melihat cara pembayaran.</b><br/>
                        </div>
                      <?php }else{ ?>
                        <div class="row">
                          <div class="col-xl-12 col-lg-12">
                            <ul class="nav nav-tabs b-0_ mb-4 justify-content-center" id="myTab" role="tablist">
                              <?php $no='1'; foreach($all_data['result'][0]['cara_bayar'] as $valc){ ?>
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
                              <?php $no = 0; foreach($all_data['result'][0]['cara_bayar'] as $valc){ ?>
                              <div class="tab-pane fade <?php if($no==0) echo 'show active';?>" id="tabcbyr<?=$valc['cara_bayar_id'];?>" role="tabpanel" aria-labelledby="cbyr-tab<?=$valc['cara_bayar_id'];?>">
                                <div class="padding-0-15 ft-14">
                                  <div class="mb-3 ft-16"><b>Kode Pembayaran / VA : <?=$all_data['result'][0]['bill_key'];?></b></div>
                                  <?php $nox = 1; foreach($all_data['result'][0]['cara_bayar'][$no]['cara_bayar'] as $valcc){ ?>
                                  <?=$nox.'. '.$valcc['cara_bayar'];?><br/>
                                  <?php $nox++; } ?>
                                </div>
                              </div>
                              <?php $no++; } ?>
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                  <?php } ?>
                <?php } ?>
            </div>

            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="border-radius5 bg-putih">
                            <div class="">
                                <div class="padding-15">
                                    <?php if($all_data['result'][0]['transaksi_from']=='POS'){ ?>
                                    <div class="ft-14 font-weight-bold mb-1">Data Toko & Kasir</div>
                                    <div class="ft-14 mb-3 mt-3">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td width="35%">Nama Toko</td>
                                                    <td>: <?=$all_data['result'][0]['nama_toko'];?></td>
                                                </tr>
                                                <tr>
                                                    <td width="35%">Nama Kasir</td>
                                                    <td>: <?=$all_data['result'][0]['nama_kasir'];?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                    <?php } ?>
                                    <div class="ft-14 font-weight-bold mb-1">Data Pembeli</div>
                                    <div class="ft-14 mb-3 mt-3">
                                        <table class="table">
                                            <tbody>
                                              <?php if ($all_data['m_alamat']['label_alamat']=='GUEST') { ?>
                                                <tr>
                                                    <td width="35%">Nama Pembeli</td>
                                                    <td>: <?=$all_data['m_alamat']['nama_penerima']?> [GUEST]</td>
                                                </tr>
                                                <tr>
                                                    <td width="35%">Nomor Ponsel</td>
                                                    <td>: <?=$all_data['m_alamat']['ponsel_penerima']?></td>
                                                </tr>
                                                <tr>
                                                    <td width="35%">Alamat Email</td>
                                                    <td>: <?=$all_data['result'][0]['email_trx'];?></td>
                                                </tr>
                                              <?php }else{ ?>
                                                <tr>
                                                    <td width="35%">Nama Pembeli</td>
                                                    <td>: <?=$all_data['m_alamat']['cust_nama']?></td>
                                                </tr>
                                                <?php if ($all_data['m_alamat']['cust_id']!=0) { ?>
                                                <tr>
                                                    <td width="35%">Nomor Ponsel</td>
                                                    <td>: <?=$all_data['m_alamat']['cust_ponsel']?></td>
                                                </tr>
                                                <tr>
                                                    <td width="35%">Alamat Email</td>
                                                    <td>: <?=$all_data['m_alamat']['is_token']?></td>
                                                </tr>
                                                <?php } ?>
                                              <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                    <div class="mb-3">
                                      <a href="javascript:cetakInvoice('<?=$all_data['result'][0]['unique_id'];?>','<?=$all_data['result'][0]['cust_id'];?>')" class="btn btn-warning btn-block btn-sm">PRINT INVOICE</a>
                                    </div>
                                    <div class="">
                                      <?php if ($all_data['result'][0]['metode_pembayaran']=='bank') { ?>
                                        <div class="ft-14 mb-3">
                                          <div class="ft-14 font-weight-bold mb-1">
                                            Bukti Pembayaran
                                          </div>
                                          <?php if ($all_data['result'][0]['bukti_pembayaran']=='n') { ?>
                                              Belum ada bukti pembayaran.
                                          <?php }else if ($all_data['result'][0]['bukti_pembayaran']=='y') { ?>
                                              Tidak ada bukti pembayaran. - Otomatis Payment Gateway
                                          <?php }else{ ?>
                                              Customer Unggah Bukti Transfer.<br>
                                              <a class="fancybox" rel="ligthbox" href="<?=$this->config->item("nhub_url");?>assets/uploaded/komponen/<?=$all_data['result'][0]['bukti_pembayaran'];?>">Lihat Bukti Pembayaran</a>
                                          <?php } ?>
                                        </div>
                                      <?php } ?>
                                      <?php if($all_data['result'][0]['transaksi_from']!='POS'){ ?>
                                      <div class="ft-14 mb-3">
                                        <div class="ft-14 font-weight-bold mb-1">
                                          Catatan :
                                        </div>
                                        <?=$all_data['result'][0]['catatan'];?>
                                      </div>
                                      <?php } ?>
                                      <div class="ft-14 mb-3">
                                        <div class="ft-14 font-weight-bold mb-1">
                                          Metode Pembayaran
                                        </div>
                                        <?=$all_data['result'][0]['m_bayar'];?>
                                      </div>
                                      <?php if($all_data['result'][0]['is_digital']=='n' && $all_data['result'][0]['transaksi_from']!='POS'){ ?>
                                        <div class="ft-14 mb-3">
                                          <div class="ft-14 font-weight-bold mb-1">
                                            Metode Pengiriman
                                          </div>
                                          Kurir - <?=$all_data['result'][0]['nama_kurir'];?>
                                          <br>Tingkat - <?=$all_data['result'][0]['level_kurir']?> (<?=$all_data['result'][0]['lama_pengiriman']?>hari)
                                        </div>
                                        <div class="ft-14">
                                          <div class="ft-14 font-weight-bold mb-1">
                                            Alamat Pengiriman
                                          </div>
                                          <?=$all_data['m_alamat']['nama_penerima']?>
                                          <br><?=$all_data['m_alamat']['nama_provinsi']?>, <?=$all_data['m_alamat']['nama_kabkot']?>, <?=$all_data['m_alamat']['kodepos']?>
                                          <br><?=$all_data['m_alamat']['alamat_lengkap']?>
                                          <br>
                                          Nomor yang dapat di hubungi <?=$all_data['m_alamat']['ponsel_penerima'];?>
                                        </div>
                                        <div class="mt-3">
                                          <a href="javascript:cetakAlamat('<?=$all_data['result'][0]['unique_id'];?>','<?=$all_data['result'][0]['cust_id'];?>')" class="btn btn-warning btn-block btn-sm">PRINT ALAMAT</a>
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

    <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
    </div>

    <script>
      $(document).ready(function(){
        $(".fancybox").fancybox({
          openEffect: "none",
          closeEffect: "none"
        });
      });
      function cetakInvoice(a,b){
        window.open("<?=$this->config->item("nhub_url");?>module/print_invoice.php?jen=bayar&noinv="+a+"&idcust="+b,"", "width=800,height=600");
      }
      function cetakAlamat(a,b){
        window.open("<?=$this->config->item("nhub_url");?>module/print_address.php?jen=bayar&noinv="+a+"&idcust="+b,"", "width=800,height=600");
      }
    </script>