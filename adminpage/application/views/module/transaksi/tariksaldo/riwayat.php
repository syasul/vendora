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
                                <th>Nominal</th>
                                <th>Status</th>
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
                            ?>
                            <tr>
                                <td><?= $no;?></td>
                                <td><?= $data['kode_tarik'];?></td>
                                <td><?= indo($data['created_at']);?></td>
                                <td><?= formatRupiah($data['nominal']);?></td>
                                <td id="noidtrxidr<?=$data['saldo_tarik_id'];?>"><span class="badge badge-<?=$stx;?>"><?=$st;?></span></td>
                                <td>
                                    <a href="javascript:" onclick="modalNormal('<?=base_url('transaksi/tariksaldoDetail/1900/').$data['saldo_tarik_id']?>','1900')" class="btn btn-info btn-sm font-size-12">Lihat</a>
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
