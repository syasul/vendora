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
                                <th>Nama User</th>
                                <th>Email</th>
                                <th>Saldo</th>
                                <th>Status</th>
                                <th>&nbsp;</th>
                        	</tr>
                    	</thead>
                    	<tbody>
                        	<?php 
                                $no = 1; foreach ($all_data as $data) : 
                                if ($data['is_active']==1) {
                                    $lbl = 'Aktif';
                                    $badge = 'badge-success';
                                }else{
                                    $lbl = 'Tidak aktif';
                                    $badge = 'badge-primary';
                                }
                                $saldo = cek_saldo($data['cust_id']);
                            ?>
                            <tr>
                                <td><?= $no;?></td>
                                <td><?= $data['cust_nama'];?></td>
                                <td><?= $data['is_token'];?></td>
                                <td><?= formatRupiah($saldo);?></td>
                                <td><span class="badge <?=$badge;?>"><?=$lbl;?></span></td>
                                <td>
                                    <a href="javascript:" onclick="modalNormal('<?=base_url('data/rincianUser/1900/').$data['cust_id']?>','1900')" class="btn btn-info btn-sm font-size-12">Lihat</a>
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
