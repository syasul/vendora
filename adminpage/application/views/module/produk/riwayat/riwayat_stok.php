<?php if ($jen=='lv1') { ?>
	<ul class="nav nav-tabs b-0 mb-3" id="myTab" role="tablist">
		<?php $no=1; foreach ($all_data as $data) : ?>
	    <li class="nav-item">
	      <a class="nav-link <?php if($no==1) echo 'active'; ?>" id="stk-tab<?=$no;?>" data-toggle="tab" href="#tabstk<?=$no;?>" role="tab" aria-controls="tabstk<?=$no;?>" aria-selected="true">
	      	<?=$data['nama_warna'];?>
	      </a>
	    </li>
		<?php $no++; endforeach; ?>
	</ul>

	<div class="tab-content" id="myTabContent">
		<?php $no=1; foreach ($all_data as $datas) : ?>
		<div class="tab-pane fade <?php if($no==1) echo 'show active'; ?>" id="tabstk<?=$no;?>" role="tabpanel" aria-labelledby="stk-tab<?=$no;?>">
			<div class="mb-3">
				<?php foreach ($ukuranstok['result'] as $datax) :
					$stok = $this->produk->cekStok($datas['produk_id'],$datas['produk_warna_id'],$datax['produk_ukuran_id']); 
					if(!isset($stok['akhir'])) $st = 0; else $st = $stok['akhir'];
				?>
				<a href="javascript:onKeyup('produk/riwayat_stok_res/<?=$datas['produk_id'];?>/<?=$tgl_mulai;?>/<?=$tgl_akhir;?>/<?=$datas['produk_warna_id'];?>/<?=$datax['produk_ukuran_id'];?>/<?=$no;?>','res_stok_res<?=$no;?>')" class="btn btn-light mr-1"><?=$datax['ukuran_size'];?> - Stok <?=formatRupiahnorp($st);?></a>
				<?php endforeach; ?>
			</div>

			<div id="res_stok_res<?=$no;?>"></div>

		</div>
		<?php $no++; endforeach; ?>
	</div>
<?php } ?>

<?php if ($jen=='lv2') { ?>
	<div class="table-responsive" style="border:none;">
	    <table class="table align-items-center table-flush table-hover" id="dataTable<?=$no_tabs;?>">
	      <thead>
	        <tr>
	          <tr>
	            <th width="5%">No</th>
	            <th class="text-left">Tanggal</th>
	            <th>@</th>
	            <th>Awal</th>
	            <th>Masuk</th>
	            <th>Keluar</th>
	            <th>Akhir</th>
	            <th>Status</th>
	          </tr>
	        </tr>
	      </thead>
	      <tbody>
	      <?php 
	      	$no=1; 
	      	foreach ($all_data as $data) : 

	      		if($data['status_stok']=="1"){   // BARANG MASUK
                    $status="<span style='color:blue'><i class='fa fa-exchange-alt'></i></span>"; 
                }else if($data['status_stok']=="2"){   //BARANG KELUAR
                    $status="<span style='color:red'><i class='fa fa-chevron-down'></i></span>"; 
                }else if($data['status_stok']=="3"){ //BARANG MASUK DARI HASIL BATAL TRANSAKSI
                    $status="<span style='color:green'><i class='fa fa-chevron-up'></i></span>"; 
                }
	      ?>
	      <tr>
	          <td align="center"><?=$no;?></td>
	          <td align="left"><?=indo($data['created_at']);?></td>
	          <td align="center"><?=$status?></td>
	          <td align="right"><?=$data['awal'];?></td>
	          <td align="right"><?=$data['masuk'];?></td>
	          <td align="right"><?=$data['keluar'];?></td>
	          <td align="right"><?=$data['akhir'];?></td>
	          <td align="center"><?=$data['label_stok'];?></td>
	      </tr>
	  	  <?php $no++; endforeach; ?>
	      </tbody>
	    </table>
	    <p>
	      <a href="javascript:void(0)"><i>Lihat status keterangan stok.</i></a><br>
	      <i>Status ADP dan ADM (dilakukan oleh admin)</i><br>
	      <i>Status WEB & APP adalah pengurangan jumlah atau terjadinya transaksi sehingga mengurangi stok.</i><br>
	      <i>Status BTL adalah transaksi yang dibatalkan sehingga stok otomatis masuk kembali ke jumlah awal.</i>
	    </p>
	</div>

	<script type="text/javascript">
		$('#dataTable<?=$no_tabs;?>').DataTable({
	        ordering: false,
	        "lengthMenu": [[15, 50, 100, -1], [15, 50, 100, "All"]]
	      }); // ID From dataTable 
	</script>
<?php } ?>
