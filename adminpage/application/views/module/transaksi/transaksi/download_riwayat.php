	<?php 

		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=laporan-trx-periode-".$tgl_awal."-sd-".$tgl_akhir.".xls");

	?>

	<p>&nbsp;</p>

	<p style="font-weight: bold;">
		LAPORAN TRANSAKSI PERIODE - <?=indolengkap($tgl_awal);?> s/d <?=indolengkap($tgl_akhir);?>
	</p>

	<p style="font-weight: bold;">
		TOTAL DIBATALKAN : <?=$all_data['total_batal'];?><br/>
		TOTAL SELESAI ( PENDAPATAN ) : <?=$all_data['total_selesai'];?><br/>
		TOTAL KESELURUHAN : <?=$all_data['total_all'];?>
	</p>

	<style type="text/css">
		thead th {
			line-height: 25px !important; height: 25px !important;
			vertical-align: middle !important;
		}

		tfoot td {
			line-height: 25px !important; height: 25px !important;
			vertical-align: middle !important;
		}

		tbody td {
			line-height: 30px !important; height: 30px !important;
			vertical-align: middle !important;
		}
	</style>

	<table class="table" width="100%" border="1">
		<thead>			                
			<tr>
				<th style="text-align: center;background: #418AD4; color: #FFF;">No</th>
				<th style="text-align: center;background: #418AD4; color: #FFF;">No Transaksi</th>
				<th style="text-align: center;background: #418AD4; color: #FFF;">Tanggal</th>
				<th style="text-align: center;background: #418AD4; color: #FFF;">Status</th>
				<th style="text-align: center;background: #418AD4; color: #FFF;">Nama Produk</th>
				<th style="text-align: center;background: #418AD4; color: #FFF;">Harga</th>
				<th style="text-align: center;background: #418AD4; color: #FFF;">Jumlah</th>
				<th style="text-align: center;background: #418AD4; color: #FFF;">Total Harga</th>
				<th style="text-align: center;background: #418AD4; color: #FFF;">Ongkos Kirim</th>
				<th style="text-align: center;background: #418AD4; color: #FFF;">Voucher</th>
				<th style="text-align: center;background: #418AD4; color: #FFF;">Total Bayar</th>
			</tr>
		</thead>
		<tbody>
			<?php $no = 1; foreach ($all_data['result'] as $data) : ?>
			<tr>
				<td align="center"><?=$no;?></td>
				<td align="center"><?=$data['no_transaksi'];?></td>
				<td align="center"><?=$data['tgl_transaksi'];?></td>
				<td align="center"><?=$data['status'];?></td>
				<td align="center">
					<table class="table" width="100%" border="1">
						<?php foreach ($data['cart'] as $pr) : ?>
						<tr>
		                  <td align="center"> <?=$pr['nama_produk']?></td> 
		                </tr>
		                <?php endforeach; ?>
		            </table>
                </td>
                <td align="center">
                 	<table class="table" width="100%" border="1">
						<?php foreach ($data['cart'] as $pr) : ?>
						<tr>
		                  <td align="center"> <?=$pr['harga_produk']?></td> 
		                </tr>
		                <?php endforeach; ?>
		            </table>
                </td>
                <td align="center">
                 	<table class="table" width="100%" border="1">
						<?php foreach ($data['cart'] as $pr) : ?>
						<tr>
		                  <td align="center"> <?=$pr['jumlah_beli']?></td> 
		                </tr>
		                <?php endforeach; ?>
		            </table>
	            </td>
	            <td align="center">
                 	<table class="table" width="100%" border="1">
						<?php foreach ($data['cart'] as $pr) : ?>
						<tr>
		                  <td align="center"> <?=$pr['total_harga_produk']?></td> 
		                </tr>
		                <?php endforeach; ?>
		            </table>
	            </td>
                <td align="center">
                 	<?=$data['ongkos_kirim'];?>
	            </td>
	            <td align="center">
                 	<?=$data['potongan_voucher'];?>
	            </td>
	            <td align="center">
                 	<?=$data['total_bayar'];?>
	            </td>
			</tr>

			<?php $no++; endforeach; ?>
									 
		</tbody>

		<tfoot>
			<tr>
			  	<td colspan="9" align="right" style="background: #e33f36; color: #FFF;"><b>TOTAL DIBATALKAN &nbsp;</b></td>
				<td align="right" colspan="2">&nbsp;<b><?=$all_data['total_batal'];?></b>&nbsp;</td>
			</tr>
			<tr>
			  	<td colspan="9" align="right" style="background: #3ab717; color: #FFF;"><b>TOTAL SELESAI ( PENDAPATAN ) &nbsp;</b></td>
				<td align="right" colspan="2">&nbsp;<b><?=$all_data['total_selesai'];?></b>&nbsp;</td>
			</tr>
			<tr>
			  	<td colspan="9" align="right" style="background: #418AD4; color: #FFF;"><b>TOTAL KESELURUHAN &nbsp;</b></td>
				<td align="right" colspan="2">&nbsp;<b><?=$all_data['total_all'];?></b>&nbsp;</td>
			</tr>
		</tfoot>
	</table>