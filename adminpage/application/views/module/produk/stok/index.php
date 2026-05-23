<div class="container-fluid" id="container-wrapper">
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card mb-4">
                <form id="tambahform" action="javascript:prosesDefault('produk/stok/proses','tambahform')" method="POST">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-white"><?= $title; ?></h6>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary btn-sm" style="border:1px solid #fff;"><i class="fa fa-check"></i>&nbsp; Submit</button>
                        </div>
                    </div>
                    <div class="table-responsive p-3">
                        <?= $this->session->flashdata('message'); ?>

                        <div class="alert alert-light">
                            Note:<br/>
                            1. Background dengan berwarna <span class="color-danger">merah</span> = produk tidak aktif / tidak dipublikasikan.<br/>
                            2. Font color (warna font) dengan berwarna <span class="color-danger">merah</span> = tidak aktif / tidak digunakan lagi.
                        </div>

                        <table class="table align-items-center table-flush table-hover" id="dataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th width="35%">Produk</th>
                                    <th width="40%">Tambah&nbsp;Stok</th>
                                    <th class="hidden-xs-y">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach ($all_data as $data) : ?>
                                <?php $ukuranstok = $this->produk->dataprodUkuran($data['produk_id']); ?>
                                <tr class="bg-<?php if ($data['is_active']==1) echo ''; else echo 'danger';?>"  style="<?php if ($data['is_active']==1) echo ''; else echo 'color:white';?>">
                                    <td class="text-capitalize">
                                        <?=$data['nama_produk'];?><br/>
                                        <span class="font-size-12 <?php if ($data['is_status']=='y') echo ''; else echo 'color-danger';?>"><?=$data['nama_warna'];?> - <?=$data['kode_produk'];?></span>
                                        <input type="hidden" name="produk_id[]" value="<?=$data['produk_id']?>">
                                        <input type="hidden" name="produk_warna_id[]" value="<?=$data['produk_warna_id']?>">
                                    </td>
                                    <td style="display: flex; flex-wrap: wrap; align-content: space-between;">
                                        <?php foreach ($ukuranstok['result'] as $qukr) : ?>
                                        <?php $stok = $this->produk->cekStok($data['produk_id'],$data['produk_warna_id'],$qukr['produk_ukuran_id']); 
                                            if(!isset($stok['akhir'])) $st = 0; else $st = $stok['akhir']; ?>
                                            <div class="mr-2">
                                                <div class="mb-1 <?php if ($qukr['is_status']=='y') echo ''; else echo 'color-danger';?>"><?=$qukr['ukuran_size'];?> : <?=formatRupiahnorp($st);?></div>
                                                <div class="mb-1">
                                                    <input type="text" class="form-control" name="stok<?=$data['produk_warna_id']?>[]" autocomplete="off" style="width:100px">
                                                    <input type="hidden" class="form-control" name="produk_ukuran_id<?=$data['produk_warna_id']?>[]" value="<?=$qukr['produk_ukuran_id'];?>" style="width:100px">
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </td>
                                    <td class="hidden-xs-y">
                                        <textarea type="text" class="form-control" name="keterangan[]" placeholder="Keterangan...." rows="3"></textarea>
                                    </td>
                                </tr>
                                <?php $no++; endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>