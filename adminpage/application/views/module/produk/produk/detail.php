    <style type="text/css">
        .modal { overflow: auto !important; }
    </style>

    <div class="modal-header bg-35 border-radius0">
        <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;"><?=$detail['nama_produk'];?></h5>
        <button class="close color-putih" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body bg-f9">
        <div class="row">
            <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                <div class="border-radius5 bg-putih">
                    <div class="">
                        <div class="padding-15">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 text-center mb-3">
                                    <?php if ($detail['is_active']==1) { ?>
                                        <span class="badge badge-success position-absolute" style="right: 15px;">
                                            <i class="fa fa-check"></i>&nbsp;&nbsp;Aktif&nbsp;
                                        </span>
                                    <?php }else{ ?>
                                        <span class="badge badge-warning position-absolute" style="right: 15px;">
                                            <i class="fa fa-times"></i>&nbsp;&nbsp;Tidak Aktif&nbsp;
                                        </span>
                                    <?php } ?>
                                    <?php if ($detail['is_new']=='y') { ?>
                                        <span class="badge badge-danger position-absolute" style="right: 15px; top: 25px;">
                                            New Arrival
                                        </span>
                                    <?php } ?>
                                    <div class="mt-3_">
                                        <div class="f-bold"><?= $detail['nama_produk'];?></div>
                                        <div class="color-999">Kode : <?= $detail['kode_produk'];?></div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12">
                                    <div class="rounded" style="background: #ededed; padding: 10px 15px;">
                                        <div class="row b-botff pb-2 mb-2">
                                            <div class="col-xl-4 col-lg-5 col-md-4 col-sm-5 col-xs-5">
                                                Kategori
                                            </div>
                                            <div class="col-xl-8 col-lg-7 col-md-8 col-sm-7 col-xs-7">
                                                : <?=$kategori['datatext'];?>
                                            </div>
                                        </div>
                                        <div class="row b-botff pb-2 mb-2">
                                            <div class="col-xl-4 col-lg-5 col-md-4 col-sm-5 col-xs-5">
                                                Sub Kategori
                                            </div>
                                            <div class="col-xl-8 col-lg-7 col-md-8 col-sm-7 col-xs-7">
                                                : <?=$subkategori['datatext'];?>
                                            </div>
                                        </div>
                                        <div class="row b-botff pb-2 mb-2">
                                            <div class="col-xl-4 col-lg-5 col-md-4 col-sm-5 col-xs-5">
                                                Lv2 / Etalase
                                            </div>
                                            <div class="col-xl-8 col-lg-7 col-md-8 col-sm-7 col-xs-7">
                                                : <?=$subkategorilv2['datatext'];?>
                                            </div>
                                        </div>
                                        <?php if ($detail['is_digital']=='n') { ?>
                                        <div class="row b-botff pb-2 mb-2">
                                            <div class="col-xl-4 col-lg-5 col-md-4 col-sm-5 col-xs-5">
                                                Berat
                                            </div>
                                            <div class="col-xl-8 col-lg-7 col-md-8 col-sm-7 col-xs-7">
                                                : <?=formatRupiahnorp($detail['berat_produk']);?> gr
                                            </div>
                                        </div>
                                        <div class="row b-botff pb-2 mb-2">
                                            <div class="col-xl-4 col-lg-5 col-md-4 col-sm-5 col-xs-5">
                                                Warna
                                            </div>
                                            <div class="col-xl-8 col-lg-7 col-md-8 col-sm-7 col-xs-7">
                                                : <?=$warna['datatext'];?>
                                            </div>
                                        </div>
                                        <div class="row b-botff pb-2 mb-2">
                                            <div class="col-xl-4 col-lg-5 col-md-4 col-sm-5 col-xs-5">
                                                Ukuran
                                            </div>
                                            <div class="col-xl-8 col-lg-7 col-md-8 col-sm-7 col-xs-7">
                                                : <?=$ukuran['datatext'];?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="row b-botff pb-2 mb-2">
                                            <div class="col-xl-4 col-lg-5 col-md-4 col-sm-5 col-xs-5">
                                                Diskon
                                            </div>
                                            <div class="col-xl-8 col-lg-7 col-md-8 col-sm-7 col-xs-7">
                                                : 
                                                <?php if ($detail['potongan_status']=='y') { ?>
                                                <?=formatRupiah($detail['potongan_diskon']);?><br/>
                                                <span class="font-size-12">
                                                    mulai dari <?=date("Y/m/d", strtotime($detail['potongan_mulai']))." - ".date("Y/m/d", strtotime($detail['potongan_akhir']));?>
                                                </span>
                                                <?php } ?>
                                                <?php if ($detail['potongan_status']!='y') { ?>
                                                <span class="badge badge-warning">Tidak Aktif</span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 text-center mb-1">
                                                Harga per Ukuran
                                            </div>
                                            <?php foreach ($ukuran['result'] as $dataukuran) : ?>
                                            <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-xs-4">
                                                <div class="font-size-12 text-center mb-1">
                                                    <?=$dataukuran['ukuran_size'];?>
                                                    <br/>
                                                    <b><?=formatRupiah($detail['harga_produk']+$dataukuran['tambahan_harga']);?></b>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="row">
                        <?php foreach ($gambar as $dgambar) : ?>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <a class="fancybox" rel="ligthbox" href="<?=$this->config->item("nhub_url");?>assets/uploaded/products/<?=$dgambar["logo_image"];?>">
                                <img src='<?=$this->config->item("nhub_url");?>assets/uploaded/products/<?=$dgambar["logo_image"];?>' class="rounded img-fluid">
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="border-radius5 bg-putih">
                            <div class="">
                                <div class="padding-15">
                                    <div class="row">
                                        <?php $tstok = 0; $wrnstok = $this->produk->dataprodWarna($detail['produk_id'],'y'); ?>
                                        <?php foreach ($wrnstok['result'] as $wrnqukr) : ?>
                                        <?php $ukuranstok = $this->produk->dataprodUkuran($detail['produk_id'],'y'); ?>
                                        <?php foreach ($ukuranstok['result'] as $qukr) : ?>
                                        <?php $stok = 
                                            $this->produk->cekStok($detail['produk_id'],$wrnqukr['produk_warna_id'],$qukr['produk_ukuran_id']); 
                                            if (!isset($stok['akhir'])) { $stok['akhir'] = 0; }
                                        ?>
                                        <?php $tstok += $stok['akhir']; ?>
                                        <?php endforeach; ?>
                                        <?php endforeach; ?>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <div class="mt-3_">
                                                <div class="f-bold">Terjual</div>
                                                <div class="color-999">0x</div>
                                            </div>
                                            <hr class="mb-0">
                                        </div>
                                        <div class="col-xl-4 col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                            <div class="mt-3_">
                                                <div class="f-bold">Stok</div>
                                                <div class="color-999"><?=$tstok;?> dari keseluruhan</div>
                                            </div>
                                            <hr class="mb-0">
                                        </div>
                                        <div class="col-xl-4 col-lg-12 col-md-12 d-block d-lg-none d-xl-block mt-mob-1rem">
                                            <div class="mt-3_ text-center-mob">
                                                <div class="#">
                                                    <a href="<?=base_url('produk/stok');?>" target="_blank" class="text-decoration-none color-primary">Tambah Stok</a>
                                                </div>
                                                <div class="">
                                                    <a href="<?=$this->config->item("nhub_url");?>p/<?=$detail["url_produk"];?>" target="_blank" class="text-decoration-none color-primary">Lihat Produk</a>
                                                </div>
                                            </div>
                                            <hr class="mb-0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if($detail['is_digital']=='y'){ ?>
                    <div class="col-xl-12 col-lg-12 mt-3">
                        <div class="border-radius5 bg-putih">
                            <div class="">
                                <div class="padding-15">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="mt-3_">
                                                <div class="f-bold">File Digital : 
                                                    <a href="<?=$this->config->item("nhub_url");?>assets/uploaded/products/<?=$detail["file_digital"];?>" target="_blank"> <?=$detail["file_digital"];?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="col-xl-12 col-lg-12 mt-3">
                        <div class="border-radius5 bg-putih">
                            <div class="">
                                <div class="padding-15">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="mt-3_">
                                                <div class="f-bold">Deskripsi Produk</div>
                                            </div>
                                            <hr>
                                            <div class="mt-3_">
                                                <div class="inner-htmlinfo"><?=$detail['keterangan_produk'];?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-12 col-lg-12 mt-3">
                        <div class="border-radius5 bg-putih">
                            <div class="">
                                <div class="padding-15">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="mt-3_">
                                                <div class="f-bold">Meta Title : <?=$detail['meta_title'];?></div>
                                            </div>
                                            <hr>
                                            <div class="mt-3_">
                                                <div class="inner-htmlinfo"><?=$detail['meta_deskripsi'];?></div>
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
    </script>