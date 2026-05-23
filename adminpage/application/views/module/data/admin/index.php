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
                    <?= $this->session->flashdata('message'); ?>
                    <table class="table align-items-center table-flush table-hover" id="dataTable">
                    	<thead class="thead-light">
                        	<tr>
                        	    <th width="5%">No</th>
                                <th>Nama Lengkap</th>
                        	    <th>Username</th>
                        	    <th>Akses</th>
                        	    <th>Dibuat</th>
                                <th>&nbsp;</th>
                        	</tr>
                    	</thead>
                    	<tbody>
                        	<?php $no = 1; foreach ($all_peng as $data) : ?>
                            <tr class="bg-<?=$data['is_active']=='0'?'danger':''?>" style="<?=$data['is_active']=='0'?'color: white':''?>">
                                <td><?= $no;?></td>
                                <td><?= $data['nama_lengkap'];?></td>
                                <td><?= $data['username']; ?></td>
                                <td><?= $data['nama_role'];?></td>
                                <td><?= indo($data['created_at']);?></td>
                                <td align="right">
                                    <a href="#" onclick="prosesHapus('data/hapusAdmin/<?=$data['pengelola_id']?>')" class="btn btn-danger btn-sm font-size-12"><i class="fa fa-trash"></i></a>
                                    <a href="#" onclick="modalNormal('<?=base_url('data/editAdmin/').$data['pengelola_id']?>')" class="btn btn-warning btn-sm font-size-12">Edit</a>
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
            <form id="tambahform" action="javascript:prosesDefault('data/admin/proses','tambahform')" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-4 col-xs-5">
                            <div class="form-group">
                                <label>Akses<span style="color: red">*</span></label>
                                <select class="form-control" name="role_id" required="">
                                  <option value="">-- Pilih --</option>
                                  <?php foreach ($all_role as $datarl) : ?>
                                  <option value="<?=$datarl['role_id'];?>"><?=$datarl['nama_role'];?></option>
                                  <?php endforeach; ?>
                                </select>
                                <?= form_error('role_id','<small class="text-danger">','</small>');?>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <label>Nama lengkap<span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="nama" required="" autocomplete="off">
                                <?= form_error('nama','<small class="text-danger">','</small>');?>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Username<span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="name" required="" autocomplete="off">
                                <?= form_error('name','<small class="text-danger">','</small>');?>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Password<span style="color: red">*</span></label>
                                <input type="password" class="form-control" name="password" placeholder="*************" required="" autocomplete="off">
                            </div>
                        </div>
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