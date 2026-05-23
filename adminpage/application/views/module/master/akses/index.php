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
                                <th>Nama Akses</th>
                        	    <th>&nbsp;</th>
                        	</tr>
                    	</thead>
                    	<tbody>
                        	<?php $no=1; foreach ($all_role as $data) : ?>
                            <tr class="bg-<?=$data['is_active']=='0'?'danger':''?>" style="<?=$data['is_active']=='0'?'color: white':''?>">
                                <td><?= $data['nama_role'];?></td>
                                <td align="right">
                                    <a href="<?= base_url('master/editAkses/') . $data['role_id']; ?>" class="btn btn-warning btn-sm font-size-12">Edit</a>
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
            <form id="tambahform" action="javascript:prosesDefault('master/akses/proses','tambahform')" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" name="nama_akses" placeholder="Nama akses" required="" autocomplete="off">
                        <?= form_error('nama_akses','<small class="text-danger">','</small>');?>
                    </div>
	                <div class="form-group">
	                  <label for="exampleInputEmail1">Status<span style="color: red">*</span></label>
	                  <select class="form-control" name="is_active" required="">
	                    <option value="1">Aktif</option>
	                    <option value="0">Tidak Aktif</option>
	                  </select>
	                  <?= form_error('is_active','<small class="text-danger">','</small>');?>
	                </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Akses Menu</label><br>
                      <div class="row">
                        <?php $menu = $this->menu->getMenu(); ?>
                        <?php foreach ($menu as $m) : ?>
                          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <b><?=$m['nama_menu'];?></b><br>
                        <?php $subMenu = $this->menu->getSubMenu('',$m['menu_id']); ?>
                        <?php foreach ($subMenu as $sm) : ?>
                        <label style="margin-bottom: 0px;"><input type="checkbox" name="hak[]" id="hak[]" class="flat" <?php if($sm['id_menu']<>''){ echo "checked";} ?> value="<?=$m['menu_id']."~".$sm['menu_id']?>"> <?=$sm['nama_menu']?></label><br>
                        <?php endforeach; ?>
                        </div>
                        <?php endforeach; ?>
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