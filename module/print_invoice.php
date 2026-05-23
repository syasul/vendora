<?php 
	include "module.php";	
	$arr = array('tipe' => 'web', 'idtrx' => $_GET['noinv'], 'idcust' => $_GET['idcust'], 'lang' => 'en');
  	$i_trx = loadData('rest_load/load_riwayat_transaksi/', $arr); $rest_trx = $i_trx['result'][0];
?>
<!DOCTYPE html>
<html>
	<head>
	    <title>
	        PRINT INVOICE #<?=$rest_trx['no_transaksi'];?>
	    </title>
		<script> window.print(); </script>
	</head>
	<body>
        <table cellpadding="0" cellspacing="0" border="0" style="width:98%;">
          <tr>
            <td>
              <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                  <td style="border-bottom: 2px solid #000; padding: 10px 30px 10px 30px;">
                    <table border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td height="40">
                        	<img src="<?=$main_imgurl;?>logo/<?=$rest_sistem['result']['logo_toko_image'];?>" width="120">
                        </td>
                      </tr>
                    </table>
                    <div style="margin-top: 10px;">
	                    <div style="font-size: 14px; font-family: sans-serif; float:left">
	                    	<?=$rest_sistem['result']['kontak_kami'];?> 
	                    	- Phone : <?=$rest_sistem['result']['call_center'];?>&nbsp;&nbsp;&nbsp;
	                    </div>
	                    <div style="font-size: 24px; font-weight: bold; font-family: sans-serif; float:right">INVOICE</div>
	                </div>
                  </td>
                </tr>
                <tr>
                  <td style="padding: 30px 30px 30px 30px;border-bottom: 1px solid #f2eeed;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td style="color: #153643; font-family: sans-serif;padding: 0 0 15px 0; line-height: 24px;">
                          <div style="font-weight: bold; font-size: 18px;">#NO INVOICE : <?=$rest_trx['no_transaksi'];?></div>
                          <div style="font-size: 14px;">
                          	Tanggal : <?=$rest_trx['tgl_transaksi'];?>
                          	<span style="float: right; font-weight: bold">
                          		<?php if ($rest_trx['bukti_pembayaran']=='n') { ?>
                          			<?php if ($rest_trx['metode_pembayaran']=='cash') { ?>
                                  Lunas
                                <?php }else{ ?>
                                  Belum Dibayar
                                <?php } ?>
                          		<?php }else{ ?>
                          			Lunas
                          		<?php } ?>
                          	</span>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td style="color: #153643; font-size: 14px; font-family: sans-serif; ">
                          Berikut rincian transaksi kamu :
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 20px 0 0 0;">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <thead>
                              <tr>
                                <th style="padding-bottom:10px; font-size: 14px; color: #153643; font-family: sans-serif; text-align: left;">Produk</th>
                                <th style="padding-bottom:10px; font-size: 14px; color: #153643; font-family: sans-serif; text-align: right">Harga</th>
                                <th style="padding-bottom:10px; font-size: 14px; color: #153643; font-family: sans-serif; text-align: right">Jumlah</th>
                                <th style="padding-bottom:10px; font-size: 14px; color: #153643; font-family: sans-serif; text-align: right">Subharga</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php foreach($i_trx['m_cart'] as $obj) { ?>
                              <tr>
                                <td style="color: #153643; font-size: 14px; font-family: sans-serif; padding-bottom:5px;">
                                  <?=$obj['nama_produk'];?> <?=$obj['varian'];?>
                                </td>
                                <td align="right" style="color: #153643; font-size: 14px; font-family: sans-serif; text-align: right; padding-bottom:5px;">
                                  <?php if ($obj['hs_diskon']!='0') { ?>
                                    <span style="font-size: 12px; text-decoration: line-through;"><?=$obj['hs_diskon'];?></span><br/>
                                  <?php } ?>
                                  <?=$obj['harga_produk'];?>
                                </td>
                                <td align="right" style="color: #153643; font-size: 14px; font-family: sans-serif;text-align: right; padding-bottom:5px;">
                                	<?=$obj['jumlah_beli'];?>
                                </td>
                                <td align="right" style="color: #153643; font-size: 14px; font-family: sans-serif;text-align: right; padding-bottom:5px;">
                                  <?php if ($obj['hs_diskon']!='0') { ?>
                                  <span style="font-size: 12px; text-decoration: line-through;"><?=$obj['hst_diskon'];?></span><br/>
                                  <?php } ?>
                                  <?=$obj['total_harga_produk'];?>
                                </td>
                              </tr>
                             <?php } ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <td style="padding-top:10px; font-size: 14px; color: #153643; font-family: sans-serif;" colspan="1">Subtotal</td>
                                <td style="padding-top:10px; font-size: 14px; color: #153643; font-family: sans-serif;text-align: right;" colspan="3" align="right">
                                	<?=$rest_trx['subtotal_bayar'];?>
                                </td>
                              </tr>
                              <?php if($rest_trx['transaksi_from']!='POS'){ ?>
                              <tr>
                                <td style="padding-top:5px; font-size: 14px; color: #153643; font-family: sans-serif;" colspan="1">Ongkos Kirim</td>
                                <td style="padding-top:5px; font-size: 14px; color: #153643; font-family: sans-serif;text-align: right;" colspan="3" align="right">
                                	<?=$rest_trx['ongkos_kirim'];?>
                                </td>
                              </tr>
                              <?php } ?>
                              <tr>
                                <td style="padding-top:5px; font-size: 14px; color: #153643; font-family: sans-serif;" colspan="1">Potongan Voucher</td>
                                <td style="padding-top:5px; font-size: 14px; color: #153643; font-family: sans-serif;text-align: right;" colspan="3" align="right">
                                  <?=$rest_trx['potongan_voucher'];?>
                                </td>
                              </tr>
                              <tr>
                                <td style="padding-top:5px; font-size: 14px; color: #153643; font-family: sans-serif; font-weight: bold;" colspan="1">Total Harga</td>
                                <td style="padding-top:5px; font-size: 14px; color: #153643; font-family: sans-serif;text-align: right; font-weight: 600;" colspan="3" align="right">
                                  <?=$rest_trx['total_bayar'];?>
                                </td>
                              </tr>
                            </tfoot>
                          </table>

                          <div class="" style="border-top: 1px solid #e4e4e4; padding-top: 15px; margin-top: 15px; color: #153643; font-family: sans-serif;">
                            <div style="font-size: 14px; padding-bottom:10px;">
                              <div style="font-weight: 600; padding-bottom:5px;">
                                Metode Pembayaran
                              </div>
                              <?=$rest_trx['m_bayar'];?>
                            </div>
                            <?php if($rest_trx['is_digital']=='n' && $rest_trx['transaksi_from']!='POS'){ ?>
                            <div style="font-size: 14px; padding-bottom:10px;">
                              <div style="font-weight: 600; padding-bottom:5px;">
                                Metode Pengiriman
                              </div>
                              Kurir - <?=$rest_trx['nama_kurir'];?>
                            </div>
                            <div style="font-size: 14px;">
                              <div style="font-weight: 600; padding-bottom:5px;">
                                Alamat Pengiriman
                              </div>
                              <?=$i_trx['m_alamat']['nama_penerima']?>
                              <br><?=$i_trx['m_alamat']['nama_provinsi']?>, <?=$i_trx['m_alamat']['nama_kabkot']?>, <?=$i_trx['m_alamat']['kodepos']?>
                              <br><?=$i_trx['m_alamat']['alamat_lengkap']?>
                              <br>
                              Nomor yang dapat di hubungi <?=$i_trx['m_alamat']['ponsel_penerima'];?>
                            </div>
                            <?php } ?>
                          </div>

                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              </td>
            </tr>
        </table>
		<br>
	</body>
</html>