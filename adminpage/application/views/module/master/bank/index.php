<div class="container-fluid" id="container-wrapper">
	<div class="row mb-3">
		<div class="col-lg-12">
			<div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white"><?= $title; ?></h6>
                    <div class="text-right">
                        <a href="" class="btn btn-primary btn-sm no-hov" data-toggle="modal" data-target="#modalData"><i class="fa fa-plus"></i>&nbsp; Tambah</a>
                    </div>
                </div>
                <div class="table-responsive p-3">
                    <div class="alert alert-primary">
                        Berlaku jika metode pembayaran = <b>Manual Transfer</b><br/>
                        <a href="<?=base_url('pengaturan/sistem');?>" class="color-putih">Klik untuk merubah metode pembayaran</a>
                    </div>
                    <?= form_error('gambar', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                    <?= $this->session->flashdata('message'); ?>
                    <table class="table align-items-center table-flush table-hover" id="dataTable">
                    	<thead class="thead-light">
                        	<tr>
                                <th>Bank</th>
                                <th>Nama Rekening</th>
                                <th>Nomor Rekening</th>
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
                                <td><?= $data['nama_rekening'];?></td>
                                <td><?= $data['nomor_rekening'];?></td>
                                <td><span class="badge <?=$badge;?>"><?=$lbl;?></span></td>
                                <td align="right">
                                    <a href="javascript:prosesHapus('master/hapusBank/<?=$data['bank_id'];?>');" class="btn btn-danger btn-sm font-size-12"><i class="fa fa-trash"></i></a>
                                    <a href="<?= base_url('master/editBank/') . $data['bank_id']; ?>" class="btn btn-warning btn-sm font-size-12">Edit</a>
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

<!-- Modal -->
<div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="tambahform" action="javascript:prosesDefault('master/bank/proses','tambahform')" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Nama Bank<span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="nama_bank" required="" autocomplete="off">
                                <?= form_error('nama_bank','<small class="text-danger">','</small>');?>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label>Nama Rekening<span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="nama_rekening" required="">
                                <?= form_error('nama_rekening','<small class="text-danger">','</small>');?>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label>Nomor Rekening<span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="nomor_rekening" required="" autocomplete="off">
                                <?= form_error('nomor_rekening','<small class="text-danger">','</small>');?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Gambar<span style="color: red">*</span></label>
                        <input type="file" class="form-control" name="gambar" required="" autocomplete="off" onChange="showImgfile(this);">
                        <?= form_error('gambar','<small class="text-danger">','</small>');?>
                        <div class="font-size-12 mt-2 mb-2">Ukuran gambar maksimal 2mb dan maksimal 3024 pixel.</div>
                        <center><div id="targetfileimg" style="margin-top: 15px;"></div></center>
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