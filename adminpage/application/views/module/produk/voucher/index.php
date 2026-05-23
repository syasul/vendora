<div class="container-fluid" id="container-wrapper">
	<div class="row mb-3">
		<div class="col-lg-12">
			<div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-white"><?= $title; ?></h6>
                    <div class="text-right">
                        <a href="<?= base_url('produk/tambahVoucher/')?>" class="btn btn-primary btn-sm no-hov"><i class="fa fa-plus"></i>&nbsp; Tambah</a>
                    </div>
                </div>

                <div class="p-3">
                    <form id="tambahform" action="javascript:prosesDefault('produk/editLabelVoucher?>','tambahform')" method="POST">
                        <div class="input-group">
                          <input type="text" class="form-control" name="label_voucher" value="<?=$sistem['label_voucher'];?>" placeholder="Masukan sesuatu..." autocomplete="off">
                          <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                          </div>
                        </div>
                      </form>
                </div>

                <div class="table-responsive p-3">
                    <?= form_error('gambar', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                    <?= $this->session->flashdata('message'); ?>
                    <table class="table align-items-center table-flush table-hover" id="dataTable">
                    	<thead class="thead-light">
                        	<tr>
                                <th width="3%">No</th>
                                <th>Nama&nbsp;/&nbsp;Kode&nbsp;Voucher</th>
                                <th>Voucher&nbsp;Valid</th>
                				<th>Diskon</th>
                				<th>Min.Belanja</th>
                				<th>Maks.Diskon</th>
                                <th>&nbsp;</th>
                        	</tr>
                    	</thead>
                    	<tbody>
                        	<?php 
                                $no=1; foreach ($all_data as $data) : 
                                if ($data['tipe_voucher']==1) {
                                    $hlbl = formatRupiah($data['nominal_voucher']);
                                }else{
                                    $hlbl = $data['nominal_voucher'].'%';
                                }

				                if ($data['maksimal_diskon']==0) {
                                    $xlbl = 'Tidak ada batasan';
                                }else{
                                    $xlbl = formatRupiah($data['maksimal_diskon']);
				                }

				                if ($data['khusus_cust_baru']=='y') {
                                    $llbl = '-';
                                }else{
                                    $llbl = indo($data['tgl_mulai'])." s/d ".indo($data['tgl_akhir']);
				                }

                            ?>
                            <tr class="bg-<?php if ($data['status_voucher']=='y') echo ''; else echo 'danger';?>"  style="<?php if ($data['status_voucher']=='y') echo ''; else echo 'color:white';?>">
                                <td><?=$no;?></td>
                                <td class="text-capitalize"><?=$data['nama_voucher'];?><br/>
                				    <b>Kode Voucher : <?=$data['kode_voucher'];?></b><br/>
                				    <b>Digunakan : <?=$data['dipakai'];?>/<?=$data['jumlah_voucher'];?></b>
                				</td>
                				<td><?=$llbl;?></td>
                				<td class="text-capitalize"><?=$hlbl;?></td>
                				<td class="text-capitalize"><?=formatRupiah($data['minimal_belanja']);?></td>
                				<td class="text-capitalize"><?=$xlbl;?></td>
                                <td align="right">
                                    <a href="<?= base_url('produk/editVoucher/').$data['voucher_id']; ?>" class="btn btn-warning btn-sm font-size-12">Edit</a>
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