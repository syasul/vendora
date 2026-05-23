<div class="container-fluid" id="container-wrapper">
	<div class="row mb-3">
		<div class="col-lg-12">
			<div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-white"><?= $title; ?></h6>
                    <div class="text-right">
                        <a href="<?= base_url('master/tambahSlider/')?>" class="btn btn-primary btn-sm no-hov"><i class="fa fa-plus"></i>&nbsp; Tambah</a>
                    </div>
                </div>
                <div class="table-responsive p-3">
                    <?= form_error('gambar', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                    <?= $this->session->flashdata('message'); ?>
                    <table class="table align-items-center table-flush table-hover" id="dataTable">
                    	<thead class="thead-light">
                        	<tr>
                                <th>Slider</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th>&nbsp;</th>
                        	</tr>
                    	</thead>
                    	<tbody>
                        	<?php 
                                $no=1; foreach ($all_data as $data) : 
                                if ($data['is_active']==1) {
                                    $lbl = 'Aktif';
                                    $badge = 'badge-success';
                                }else{
                                    $lbl = 'Tidak aktif';
                                    $badge = 'badge-primary';
                                }
                            ?>
                            <tr>
                                <td><img src='<?=$this->config->item("nhub_url");?>assets/uploaded/komponen/<?=$data["logo_image"];?>' height='30' class="rounded"></td>
                                <td class="text-capitalize"><?= $data['tipe_slider'];?></td>
                                <td><span class="badge <?=$badge;?>"><?=$lbl;?></span></td>
                                <td align="right">
                                    <a href="javascript:prosesHapus('master/hapusSlider/<?=$data['slider_id'];?>');" class="btn btn-danger btn-sm font-size-12"><i class="fa fa-trash"></i></a>
                                    <a href="<?= base_url('master/editSlider/').$data['slider_id']; ?>" class="btn btn-warning btn-sm font-size-12">Edit</a>
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