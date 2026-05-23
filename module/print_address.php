<?php 
	include "module.php";	
	$arr = array('tipe' => 'web', 'idtrx' => $_GET['noinv'], 'idcust' => $_GET['idcust'], 'lang' => 'en');
  	$i_trx = loadData('rest_load/load_riwayat_transaksi/', $arr); $rest_trx = $i_trx['result'][0];
?>
<!DOCTYPE html>
<html>
	<head>
	    <title>
	        PRINT ALAMAT #<?=$rest_trx['no_transaksi'];?>
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
                    <div style="margin-top: 10px; text-align:left;">
	                    <div style="font-size: 18px; font-weight: bold; font-family: sans-serif;">ALAMAT PENGIRIMAN</div>
	                </div>
                  </td>
                </tr>
                <tr>
                  <td style="padding: 10px 30px 30px 30px;border-bottom: 1px solid #f2eeed;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td style="padding: 20px 0 0 0;">
                          <div class="" style="color: #153643; font-family: sans-serif;">
                            <div style="font-size: 16px; line-height:22px">
                              <span style="text-transform:uppercase; font-weight:600;"><?=$i_trx['m_alamat']['nama_penerima']?></span>
                              <br><span style="text-transform:capitalize;"><?=$i_trx['m_alamat']['nama_provinsi']?>, <?=$i_trx['m_alamat']['nama_kabkot']?>, <?=$i_trx['m_alamat']['kodepos']?></span>
                              <br><?=$i_trx['m_alamat']['alamat_lengkap']?>
                              <br>
                              Nomor yang dapat di hubungi <?=$i_trx['m_alamat']['ponsel_penerima'];?>
                            </div>
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