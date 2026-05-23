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
                    <?= form_error('gambar', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                    <?= $this->session->flashdata('message'); ?>
                    <table class="table align-items-center table-flush table-hover" id="dataTable">
                    	<thead class="thead-light">
                        	<tr>
                                <th>Logo</th>
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
                                <td><img src='<?=$this->config->item("nhub_url");?>assets/uploaded/komponen/<?=$data["logo_image"];?>' height='60' class="rounded"></td>
                                <td><span class="badge <?=$badge;?>"><?=$lbl;?></span></td>
                                <td align="right">
                                    <a href="javascript:prosesHapus('master/hapusPartner/<?=$data['partner_id'].'/'.$data['logo_image'];?>');" class="btn btn-danger btn-sm font-size-12"><i class="fa fa-trash"></i></a>
                                    <a href="<?= base_url('master/editPartner/') . $data['partner_id']; ?>" class="btn btn-warning btn-sm font-size-12">Edit</a>
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
            <form id="tambahform" action="javascript:prosesDefault('master/partner/proses','tambahform')" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Gambar<span style="color: red">*</span></label>
                        <input type="hidden" class="form-control" name="is_active" value="1">
                        <input type="file" class="form-control" name="gambar" required="" autocomplete="off" onChange="showImgfile(this);">
                        <?= form_error('gambar','<small class="text-danger">','</small>');?>
                        <div class="font-size-12 mt-2 mb-2">Ukuran gambar maksimal 2mb, rekomendasi 650*460 pixel.</div>
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