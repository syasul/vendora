<style type="text/css">
    .modal { overflow: auto !important; }
</style>

<div class="container-fluid" id="container-wrapper">
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-white"><?= $title; ?></h6>
                </div>
                <div class="table-responsive p-3">
                    <?= $this->session->flashdata('message'); ?>
                    <table class="table align-items-center table-flush table-hover" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Transaksi</th>
                                <th>Produk</th>
                                <th>Ulasan & Rating</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($all_data as $data) : ?>
                            <tr>
                                <td><?= $no;?></td>
                                <td>
                                    <a href="javascript:" onclick="modalBesar('<?=base_url('transaksi/transaksiDetail/1900/').$data['transaksi_id']?>','1900')">
                                        <?=$data['no_transaksi'];?>
                                    </a>
                                </td>
                                <td><?=$data['nama_produk'];?> ( <?=$data['varian'];?> )</td>
                                <td>
                                    <?php for ($i=1; $i < 6; $i++) { ?>
                                        <?php if ($data['rating_produk']>=$i) $colorrat = 'color-warning'; else $colorrat = ''; ?>
                                        <span class="font-size-12 <?=$colorrat;?>"><i class="fa fa-star"></i></span>
                                      <?php } ?>
                                      <br/>
                                      <?=$data['ulasan_produk'];?>
                                </td>
                                <td align="right">
                                    <?php if ($data['publikasi_rating']=='n' || $data['publikasi_ulasan']=='n') { ?>
                                    <button class="btn btn-primary btn-sm classclassidbutton<?=$data['transaksi_det_id'];?>" type="button" onclick="prosessimpanUlasan('transaksi/transaksi_ulasan/<?=$data['transaksi_det_id'];?>','<?=$data['transaksi_det_id'];?>')">
                                    Publikasi
                                    </button>
                                    <?php } ?>
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
