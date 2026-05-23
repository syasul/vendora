<div class="container-fluid" id="container-wrapper">
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-white"><?= $title; ?></h6>
                    <div class="text-right">
                        <a href="<?= base_url('produk_import/')?>" class="btn btn-info btn-sm no-hov"><i class="fa fa-download"></i>&nbsp; Bulk Import</a>
                        <a href="<?= base_url('produk/tambahProduk/')?>" class="btn btn-primary btn-sm no-hov"><i class="fa fa-plus"></i>&nbsp; Tambah</a>
                    </div>
                </div>
                <div class="table-responsive p-3">
                    <?= form_error('gambar', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                    <?= $this->session->flashdata('message'); ?>
                    <table class="table align-items-center table-flush table-hover" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th width="3%">No</th>
                                <th>Kode&nbsp;Produk</th>
                                <th>Nama&nbsp;Produk</th>
                                <th>Harga&nbsp;Produk</th>
                                <th width="18%">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no=1; foreach ($all_data as $data) : 
                                if ($data['potongan_status']=='y') {
                                    $tdlt = 'td-line-through';
                                    $hnew = formatRupiah($data['harga_produk']-$data['potongan_diskon'])."<br/><span class='font-size-12'>harga diskon mulai tgl ".date("Y/m/d", strtotime($data['potongan_mulai']))." - ".date("Y/m/d", strtotime($data['potongan_akhir']))."</span>";
                                }else{
                                    $tdlt = '';
                                    $hnew = '';
                                }

                            ?>
                            <tr class="bg-<?php if ($data['is_active']==1) echo ''; else echo 'danger';?>"  style="<?php if ($data['is_active']==1) echo ''; else echo 'color:white';?>">
                                <td><?=$no;?></td>
                                <td class="text-capitalize"><?=$data['kode_produk'];?></td>
                                <td class="text-capitalize">
                                    <?=$data['nama_produk'];?>
                                    <?php if ($data['is_new']=='y') { ?>
                                    <br/><span class="badge badge-danger">New Arrival</span>
                                    <?php } ?>
                                    <?php if ($data['is_digital']=='y') { ?>
                                    <br/><span class="badge badge-info">Produk Digital</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <span class="<?=$tdlt;?>"><?=formatRupiah($data['harga_produk']);?></span>&nbsp;
                                    <span class="d-none d-lg-inline"><?=$hnew;?></span>
                                </td>
                                <td align="right">
                                    <a href="javascript:" onclick="modalBesar('<?=base_url('produk/produkDetail/1900/').$data['produk_id']?>','1900')" class="btn btn-info btn-sm font-size-12"><i class="fa fa-eye"></i></a>
                                    <a href="javascript:prosesHapus('produk/hapusProduk/<?=$data['produk_id'];?>');" class="btn btn-danger btn-sm font-size-12"><i class="fa fa-trash"></i></a>
                                    <a href="<?= base_url('produk/editProduk/').$data['produk_id']; ?>" class="btn btn-warning btn-sm font-size-12">Edit</a>
                                </td>
                            </tr>
                            <?php $no++; endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>