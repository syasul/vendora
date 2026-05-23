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
                                <th>No Transaksi</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Bukti Bayar</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $no = 1; foreach ($all_data as $data) : 
                                if($data['is_status']=='y'){
                                    $st = '&nbsp;Selesai&nbsp;';
                                    $stx = 'success';
                                }else if($data['is_status']=='b'){
                                    $st = '&nbsp;Dibatalkan&nbsp;';
                                    $stx = 'danger';
                                }else{
                                    $st = 'Unknown';
                                    $stx = 'light';
                                }

                                if($data['bukti_pembayaran']=='n'){
                                    $stbkti = '<i class="fa fa-times"></i>';
                                }else{
                                    $stbkti = '<i class="fa fa-check"></i>';
                                }
                            ?>
                            <tr>
                                <td><?= $no;?></td>
                                <td><?= $data['kode_topup'];?></td>
                                <td><?= indo($data['created_at']);?></td>
                                <td id="noidtrxidr<?=$data['topup_id'];?>"><span class="badge badge-<?=$stx;?>"><?=$st;?></span></td>
                                <td align="center"><?=$stbkti?></td>
                                <td>
                                    <a href="javascript:" onclick="modalNormal('<?=base_url('transaksi/topupDetail/1900/').$data['topup_id']?>','1900')" class="btn btn-info btn-sm font-size-12">Lihat</a>
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
