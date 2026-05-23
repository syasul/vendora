<?php

function is_logged_in() {
    $CI = get_instance();
    if (md5($CI->config->item("csrf_exclude_uname"))!='0c70dc5221166778eb3dc5811bec88d6') { die(); }
    if (!$CI->session->userdata('p_id')) {
        redirect('auth');
    }
}

function cek_menu_access() {
    $CI = get_instance();
    if ($CI->uri->segment(2)!='') {
        $seg2 = '/'.$CI->uri->segment(2).'/';
    }else{
        $seg2 = '';
    }

    $urltujuan = $CI->uri->segment(1).$seg2;
    $query = $CI->db->query("SELECT * FROM m_role_access a JOIN m_menu b ON a.id_menu=b.menu_id WHERE b.link_url='$urltujuan' AND a.id_role=".$CI->session->userdata('role_id'))->num_rows();

    if ($query<1) {
        redirect('master');
    }

}

function pengaturanSistem(){
    $CI = get_instance();
    $query = $CI->db->query("SELECT * FROM _setting WHERE setting_id='1'")->row_array();
    return ($query);
}

function cekDatarowarray($table,$field,$where,$fieldpasang = "*",$orderby = null,$fields = null,$wheres = null){
    $CI = get_instance();

    if ($orderby==null || $orderby=='') {
        $orderby = '';
    }else{
        $orderby = $orderby;
    }

    if ($fields==null || $fields=='') {
        $and = "";
    }else{
        $and = " AND ".$fields."='".$wheres."'";
    }

    $query = $CI->db->query("SELECT $fieldpasang FROM $table WHERE $field='$where' $and $orderby ")->row_array();
    return ($query);
}

function cek_saldo($id){
  $CI = get_instance();
  $saldoaf = $CI->db->query("SELECT * FROM tx_saldo WHERE cust_id='$id' AND is_status='y' ORDER BY saldo_id DESC LIMIT 1")->row_array();
  if(!isset($saldoaf['akhir'])) $saldoaf['akhir'] = 0;
  return $saldoaf['akhir'];
}

function wablasOtp($phone,$code,$token,$server){

    $phone = ltrim($phone, '0');
    if (substr($phone, 0, 2) !== '62') { $phone = '62' . $phone; }

    $CI = get_instance();
    $set_p = $CI->db->query("SELECT * FROM _setting")->row_array();

    if ($set_p['status_wablas']=='y') {

      $curl = curl_init();
      $data = [
      'phone' => $phone,
      'message' => 'Berikut kode aktivasi login '.$set_p['smtp_setnama'].' #'.$code.', jangan berikan kode aktivasi ini kepada siapapun.',
      ];
      curl_setopt($curl, CURLOPT_HTTPHEADER,
          array(
              "Authorization: $token",
          )
      );
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($curl, CURLOPT_URL, $server);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
      $result = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);
      if ($err) {
        return 'n';
      } else {
        return 'y';
      }
      
    }else if ($set_p['status_watsap']=='y') {

      $api_key   = $set_p['apikey_watsap']; // API KEY Anda
      $id_device = $set_p['iddevice_watsap']; // ID DEVICE yang di SCAN (Sebagai pengirim)
      $url   = $set_p['server_watsap']; // URL API

      $pesan = 'Berikut kode aktivasi login '.$set_p['smtp_setnama'].' #'.$code.', jangan berikan kode aktivasi ini kepada siapapun.';

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
        'appkey' => $api_key,
        'authkey' => $id_device,
        'to' => $phone,
        'message' => $pesan,
        'sandbox' => 'false'
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);
      if ($err) {
        return 'n';
      } else {
        return 'y';
      }


      // $curl = curl_init();
      // curl_setopt($curl, CURLOPT_URL, $url);
      // curl_setopt($curl, CURLOPT_HEADER, 0);
      // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
      // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
      // curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
      // curl_setopt($curl, CURLOPT_TIMEOUT, 0); // batas waktu response
      // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
      // curl_setopt($curl, CURLOPT_POST, 1);

      // $data_post = [
      //   'id_device' => $id_device,
      //   'api-key' => $api_key,
      //   'no_hp'   => $phone,
      //   'pesan'   => $pesan
      // ];
      // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_post));
      // curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
      // $response = curl_exec($curl);
      // $err = curl_error($curl);
      // curl_close($curl);
      // if ($err) {
      //   return 'n';
      // } else {
      //   return 'y';
      // }
      
    }else{
      return 'n';
    }
}

function emailTestSmtp($emailto,$mail){

    $CI = get_instance();
    $set_p = $CI->db->query("SELECT * FROM _setting")->row_array();

    $mail->isSMTP();
    $mail->Host = $set_p['smtp_host']; //host masing2 provider email
    $mail->SMTPAuth = true;
    $mail->Username = $set_p['smtp_username']; // email domain
    $mail->Password = $set_p['smtp_password']; // pass email domain
    $mail->SMTPSecure = $set_p['smtp_secure'];
    $mail->Port = $set_p['smtp_port'];

    $mail->SMTPOptions = array(
    'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
    )
    );

    $mail->setFrom($set_p['smtp_username'], $set_p['smtp_setnama']);

    $mail->addAddress($set_p['smtp_cc_email']);
    $mail->Subject = 'Test Email SMTP';
    $mail->isHTML(true);

    $mailContent = 'Testing email smtp success...';
    $mail->Body = $mailContent;

    if(!$mail->send()){
        return 'Send OTP Error: ' . $mail->ErrorInfo;
    }else{
        return 'y';
    }
}

function emailOtpSmtp($emailto,$code,$mail){

    $CI = get_instance();

    $set_p = $CI->db->query("SELECT * FROM _setting")->row_array();

    $mail->isSMTP();
    $mail->Host = $set_p['smtp_host']; //host masing2 provider email
    $mail->SMTPAuth = true;
    $mail->Username = $set_p['smtp_username']; // email domain
    $mail->Password = $set_p['smtp_password']; // pass email domain
    $mail->SMTPSecure = $set_p['smtp_secure'];
    $mail->Port = $set_p['smtp_port'];

    $mail->SMTPOptions = array(
    'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
    )
    );

    $mail->setFrom($set_p['smtp_username'], $set_p['smtp_setnama']);

    $mail->addAddress($emailto);
    // menambahkan beberapa penerima dengan email yg berbeda
    // $mail->addAddress('penerima2@contoh.com');
    // $mail->addAddress('penerima3@contoh.com');
    // Menambahkan cc atau bcc 
    // $mail->addCC('cc@contoh.com');
    // $mail->addBCC('bcc@contoh.com');
    $mail->Subject = 'Kode Verifikasi OTP Login';
    // mengatur format email ke HTML
    $mail->isHTML(true);

    $mailContent = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Login activation code</title>
            <style type="text/css">
            body {margin: 0; padding: 0; min-width: 100%!important;}
            img {height: auto;}
            .content { width: 100%; max-width: 600px; }
            @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
            body[yahoo] .hide {display: none!important;}
            body[yahoo] .buttonwrapper {background-color: transparent!important;}
            }
            /*@media only screen and (min-device-width: 601px) {
              .content {width: 600px !important;}
              .col425 {width: 425px!important;}
              .col380 {width: 380px!important;}
              }*/

            </style>
        </head>

        <body yahoo bgcolor="#f6f8f1">
          <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td>
              <!--[if (gte mso 9)|(IE)]>
                <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td>
              <![endif]-->
              <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td bgcolor="#fff" style="border-bottom: 2px solid #37b464; padding: 10px 30px 10px 30px;">
                    <table width="70" align="left" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td height="70">
                          <!-- <img src="https://admin.novelhub.id/assets/temp/img/logo/logo_novelhub_fit-02.png" width="170" height="170" border="0" alt="" /> -->
                          <span style="font-size: 24px; font-weight: bold; font-family: sans-serif;">'.$set_p['smtp_setnama'].'</span>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="padding: 30px 30px 30px 30px;border-bottom: 1px solid #f2eeed;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td style="color: #153643; font-family: sans-serif;padding: 0 0 15px 0; font-size: 18px; line-height: 28px; font-weight: bold;">
                          Hi '.$emailto.'.
                        </td>
                      </tr>
                      <tr>
                        <td style="color: #153643; font-family: sans-serif; ">
                          Kode Aktivasi Login Store.
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 20px 0 0 0;">
                          <table class="buttonwrapper" bgcolor="#37b464" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td height="45" style="text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;">
                                <a style="color: #ffffff; text-decoration: none;">'.$code.'</a>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="font-size: 13px; padding: 30px 30px 30px 30px;color: #153643; font-family: sans-serif;">
                    Tolong jangan balas email ini. Karena email ini dibuat secara otomatis. Jika Anda memiliki keluhan atau masalah, silakan laporkan kepada kami dengan membuka halaman kontak kami.
                  </td>
                </tr>
                <tr>
                  <td bgcolor="#44525f" style="padding: 20px 30px 15px 30px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" style="font-family: sans-serif; font-size: 14px; color: #ffffff;">
                          Copyright &copy; 2025 '.$set_p['smtp_setnama'].' All Right Reserved
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              <!--[if (gte mso 9)|(IE)]>
                    </td>
                  </tr>
              </table>
              <![endif]-->
              </td>
            </tr>
        </table>
      </body>
    </html>';
    $mail->Body = $mailContent;

    // Menambahakn lampiran
    // $mail->addAttachment('attachment/namafile.pdf'); // pdf doc dll,
    // $mail->addAttachment('attachment/namafile.png', 'nama-baru-file2.png'); //atur nama baru

    if(!$mail->send()){
        return 'Send OTP Error: ' . $mail->ErrorInfo;
    }else{
        return 'y';
    }
}

function emailResetpassword($emailto,$ilnk,$mail){

    $CI = get_instance();

    $set_p = $CI->db->query("SELECT * FROM _setting")->row_array();

    $mail->isSMTP();
    $mail->Host = $set_p['smtp_host']; //host masing2 provider email
    $mail->SMTPAuth = true;
    $mail->Username = $set_p['smtp_username']; // email domain
    $mail->Password = $set_p['smtp_password']; // pass email domain
    $mail->SMTPSecure = $set_p['smtp_secure'];
    $mail->Port = $set_p['smtp_port'];

    $mail->SMTPOptions = array(
    'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
    )
    );

    $mail->setFrom($set_p['smtp_username'], $set_p['smtp_setnama']);

    $mail->addAddress($emailto);
    $mail->Subject = 'Konfirmasi Perubahan Password';
    // mengatur format email ke HTML
    $mail->isHTML(true);

    $mailContent = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Konfirmasi Perubahan Password</title>
            <style type="text/css">
            body {margin: 0; padding: 0; min-width: 100%!important;}
            img {height: auto;}
            .content { width: 100%; max-width: 600px; }
            @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
            body[yahoo] .hide {display: none!important;}
            body[yahoo] .buttonwrapper {background-color: transparent!important;}
            }
            /*@media only screen and (min-device-width: 601px) {
              .content {width: 600px !important;}
              .col425 {width: 425px!important;}
              .col380 {width: 380px!important;}
              }*/

            </style>
        </head>

        <body yahoo bgcolor="#f6f8f1">
          <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td>
              <!--[if (gte mso 9)|(IE)]>
                <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td>
              <![endif]-->
              <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td bgcolor="#fff" style="border-bottom: 2px solid #37b464; padding: 10px 30px 10px 30px;">
                    <table width="70" align="left" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td height="70">
                          <!-- <img src="https://admin.novelhub.id/assets/temp/img/logo/logo_novelhub_fit-02.png" width="170" height="170" border="0" alt="" /> -->
                          <span style="font-size: 24px; font-weight: bold; font-family: sans-serif;">'.$set_p['smtp_setnama'].'</span>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="padding: 30px 30px 30px 30px;border-bottom: 1px solid #f2eeed;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td style="color: #153643; font-family: sans-serif;padding: 0 0 15px 0; font-size: 18px; line-height: 28px; font-weight: bold;">
                          Hi '.$emailto.'.
                        </td>
                      </tr>
                      <tr>
                        <td style="color: #153643; font-family: sans-serif; ">
                          Jika kamu ingin merubah password klik link dibawah ini.<br/>
                          Abaikan email ini jika kamu tidak ingin merubah password akun store kamu.<br/><br/>
                          '.$ilnk.'
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 20px 0 0 0;">
                          <table class="buttonwrapper" bgcolor="#37b464" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td height="45" style="text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;">
                                <a href="'.$ilnk.'" style="color: #ffffff; text-decoration: none;">Ubah Password</a>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="font-size: 13px; padding: 30px 30px 30px 30px;color: #153643; font-family: sans-serif;">
                    Tolong jangan balas email ini. Karena email ini dibuat secara otomatis. Jika Anda memiliki keluhan atau masalah, silakan laporkan kepada kami dengan membuka halaman kontak kami.
                  </td>
                </tr>
                <tr>
                  <td bgcolor="#44525f" style="padding: 20px 30px 15px 30px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" style="font-family: sans-serif; font-size: 14px; color: #ffffff;">
                          Copyright &copy; 2025 '.$set_p['smtp_setnama'].' All Right Reserved
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              <!--[if (gte mso 9)|(IE)]>
                    </td>
                  </tr>
              </table>
              <![endif]-->
              </td>
            </tr>
        </table>
      </body>
    </html>';
    $mail->Body = $mailContent;

    // Menambahakn lampiran
    // $mail->addAttachment('attachment/namafile.pdf'); // pdf doc dll,
    // $mail->addAttachment('attachment/namafile.png', 'nama-baru-file2.png'); //atur nama baru

    if(!$mail->send()){
        return 'Send OTP Error: ' . $mail->ErrorInfo;
    }else{
        return 'y';
    }
}

function kirimTransaksikeEmail($idtrx,$idcust,$mail = null){
    $CI = get_instance();

    $set_p = $CI->db->query("SELECT * FROM _setting")->row_array();
    $res = $CI->db->query("SELECT a.*,b.kurir,b.nama_kurir,b.level_kurir,b.lama_pengiriman FROM tx_transaksi a LEFT JOIN tx_kurir b ON a.no_transaksi=b.no_transaksi WHERE a.cust_id='$idcust' AND a.unique_id='$idtrx' ORDER BY a.transaksi_id DESC ")->result_array();
    
    foreach ($res as $rows) {

        $t_byr = $rows['harga_total']+$rows['tambahan_harga_total']+$rows['ongkos_kirim']-$rows['potongan_total']-$rows['diskon_all_total']-$rows['potongan_voucher'];

        $total_bayar = formatRupiah($t_byr);
        if ($t_byr<0) { $total_bayar = formatRupiah(0); }
        $subtotal_bayar = formatRupiahnorp($t_byr-$rows['ongkos_kirim']);
        if ($t_byr-$rows['ongkos_kirim']<0) { $subtotal_bayar = formatRupiahnorp(0); }
        $ongkos_kirim = formatRupiahnorp($rows['ongkos_kirim']);
        $potongan_voucher = "-".formatRupiahnorp($rows['potongan_voucher']);

        if ($rows['payment_type']=='manual') {
          // khusus point of sale
          if ($rows['metode_pembayaran']=='cash') {
            $m_bayar = 'Cash';
          }else{
            $m_bayar = 'Layanan Transfer Bank';
          }
        }else if ($rows['payment_type']=='tripay') {
            $m_bayar = $rows['bill_key'];
        }else if ($rows['payment_type']=='xendit') {
            $m_bayar = strtoupper($rows['bill_key'])."<br/>Cara Pembayaran :<br/>".$rows['cara_pembayaran'];
        }else{
          if ($rows['biller_code']=='bca') {
              $m_bayar = 'Bank BCA (VA) : '.$rows['bill_key'];
          }else if ($rows['biller_code']=='70012') {
              $m_bayar = 'Bank Mandiri (VA) : '.$rows['bill_key'];
          }else if ($rows['biller_code']=='bri') {
              $m_bayar = 'Bank BRI (VA) : '.$rows['bill_key'];
          }else if ($rows['biller_code']=='bni') {
              $m_bayar = 'Bank BNI (VA) : '.$rows['bill_key'];
          }else if ($rows['biller_code']=='permata') {
              $m_bayar = 'Bank Permata (VA) : '.$rows['bill_key'];
          }else{
              if ($rows['payment_type']=='gopay') {
                  $m_bayar = 'Gopay';
              }else if ($rows['payment_type']=='qris') {
                  $m_bayar = 'QRIS';
              }else{
                  $m_bayar = 'Layanan Transfer Bank';
              }
          }
        }

        $nama_kurir = $rows['nama_kurir'];
        $tgl_transaksi = indo($rows['tgl_transaksi']);
        $isdigital = $rows['is_digital'];
        $formpos = $rows['transaksi_from'];
        $uniqueid = $rows['unique_id'];
    }


    $m_cart = array();
    $q_cart = $CI->db->query("SELECT b.*,c.nama_warna,d.ukuran_size FROM tx_transaksi a JOIN tx_transaksi_det b ON a.no_transaksi=b.no_transaksi LEFT JOIN m_warna c ON b.warna_id=c.warna_id LEFT JOIN m_ukuran d ON b.ukuran_id=d.ukuran_id WHERE a.cust_id='$idcust' AND a.unique_id='$idtrx' ")->result_array();
    foreach ($q_cart as $rows) {
        if ($rows['nama_warna']!='') {
            if ($rows['nama_warna']=='Default') {
                $rows['nama_warna'] = "";
            }else{
                $rows['nama_warna'] = $rows['nama_warna'].", ";
            }
        }

        if ($rows['ukuran_size']!='') {
            if ($rows['ukuran_size']=='Default') {
                $rows['ukuran_size'] = "";
            }else{
                $rows['ukuran_size'] = $rows['ukuran_size'].", ";
            }
        }

        if ($rows['nama_warna']=='' && $rows['ukuran_size']=='') {
            $varian = '-';
        }else{
            $varian = substr($rows['nama_warna'].$rows['ukuran_size'], 0,-2);
        }

        $harga_produk = $rows['harga_produk']-$rows['potongan_harga']-$rows['diskon_all_produk'];
        $tharga_produk = $rows['total_harga_produk']-$rows['total_potongan_harga']-$rows['total_diskon_all_produk'];

        $hs_diskon = $harga_produk+$rows['potongan_harga']+$rows['diskon_all_produk'];
        $hst_diskon = ($harga_produk*$rows['jumlah_beli'])+$rows['total_potongan_harga']+$rows['total_diskon_all_produk'];

        if ($hs_diskon==$harga_produk) {
            $hs_diskon = '0';
        }

        $m_cart[] = array(
            'nama_produk'               => $rows['nama_produk'],
            'harga_produk'              => formatRupiahnorp($harga_produk),
            'hs_diskon'                 => formatRupiahnorp($hs_diskon),
            'jumlah_beli'               => $rows['jumlah_beli'],
            'total_harga_produk'        => formatRupiahnorp($tharga_produk),
            'hst_diskon'                => formatRupiahnorp($hst_diskon),
            'catatan_produk'            => $rows['catatan_produk'],
            'varian'                    => $varian
        );
    }

    $m_alamat = array();
    $m_alamat = $CI->db->query("SELECT b.*, c.*, a.email_trx FROM tx_transaksi a LEFT JOIN m_customer_det b ON a.cust_det_id=b.cust_det_id LEFT JOIN m_customer c ON a.cust_id=c.cust_id WHERE a.cust_id='$idcust' AND a.unique_id='$idtrx' ")->row_array();

    if($m_alamat['email_trx']!=''){
      $m_alamat['is_token'] = $m_alamat['email_trx'];
      $m_alamat['cust_nama'] = $m_alamat['nama_penerima'];
    }

    $mail->isSMTP();
    $mail->Host = $set_p['smtp_host']; //host masing2 provider email
    $mail->SMTPAuth = true;
    $mail->Username = $set_p['smtp_username']; // email domain
    $mail->Password = $set_p['smtp_password']; // pass email domain
    $mail->SMTPSecure = $set_p['smtp_secure'];
    $mail->Port = $set_p['smtp_port'];

    $mail->SMTPOptions = array(
    'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
    )
    );

    $mail->setFrom($set_p['smtp_username'], $set_p['smtp_setnama']);

    $mail->addAddress($m_alamat['is_token']);
    // menambahkan beberapa penerima dengan email yg berbeda
    // $mail->addAddress('penerima2@contoh.com');
    // $mail->addAddress('penerima3@contoh.com');
    // Menambahkan cc atau bcc 

    if ($set_p['smtp_cc_email']!='') {
        $mail->addCC($set_p['smtp_cc_email']);
    }
    if ($set_p['smtp_bcc_email']!='') {
        $mail->addBCC($set_p['smtp_bcc_email']);
    }

    $mail->Subject = 'Pembelian Kamu';
    // mengatur format email ke HTML
    $mail->isHTML(true);

    $mailContent = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Pembelian Kamu</title>
            <style type="text/css">
            body {margin: 0; padding: 0; min-width: 100%!important;}
            img {height: auto;}
            .content { width: 100%; max-width: 600px; }
            @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
            body[yahoo] .hide {display: none!important;}
            body[yahoo] .buttonwrapper {background-color: transparent!important;}
            }
            /*@media only screen and (min-device-width: 601px) {
              .content {width: 600px !important;}
              .col425 {width: 425px!important;}
              .col380 {width: 380px!important;}
              }*/

            </style>
        </head>

        <body yahoo bgcolor="#f6f8f1">
          <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td>
              <!--[if (gte mso 9)|(IE)]>
                <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td>
              <![endif]-->
              <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td bgcolor="#fff" style="border-bottom: 2px solid #37b464; padding: 10px 30px 10px 30px;">
                    <table align="left" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td height="70">
                          <span style="font-size: 24px; font-weight: bold; font-family: sans-serif;">'.$set_p['smtp_setnama'].'</span>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="padding: 30px 30px 30px 30px;border-bottom: 1px solid #f2eeed;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td style="color: #153643; font-family: sans-serif;padding: 0 0 15px 0; font-size: 18px; line-height: 28px; font-weight: bold;">
                          Hi '.$m_alamat['cust_nama'].'.
                        </td>
                      </tr>
                      <tr>
                        <td style="color: #153643; font-family: sans-serif; ">
                          Berikut transaksi kamu pada tanggal '.$tgl_transaksi.'.<br>
                          UID : '.$uniqueid.'
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 20px 0 0 0;">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <thead class="b-0">
                              <tr class="b-0">
                                <th style="color: #153643; font-family: sans-serif; text-align: left;">Produk</th>
                                <th style="color: #153643; font-family: sans-serif; text-align: right">Harga</th>
                                <th style="color: #153643; font-family: sans-serif; text-align: right">Qty</th>
                                <th style="color: #153643; font-family: sans-serif; text-align: right">Subharga</th>
                              </tr>
                            </thead>
                            <tbody>';
                            foreach($m_cart as $obj) {
                            $mailContent .= '
                              <tr>
                                <td style="color: #153643; font-family: sans-serif; ">
                                  '.$obj['nama_produk'].' '.$obj['varian'].'
                                </td>
                                <td align="right" style="color: #153643; font-family: sans-serif; text-align: right;">
                                  '.$obj['harga_produk'].'
                                </td>
                                <td align="right" style="color: #153643; font-family: sans-serif;text-align: right; ">'.$obj['jumlah_beli'].'</td>
                                <td align="right" style="color: #153643; font-family: sans-serif;text-align: right; ">
                                  '.$obj['total_harga_produk'].'
                                </td>
                              </tr>';
                            }
                            $mailContent .= '
                            </tbody>
                            <tfoot>
                              <tr>
                                <td style="color: #153643; font-family: sans-serif;" colspan="1">Subtotal</td>
                                <td style="color: #153643; font-family: sans-serif;text-align: right;" colspan="3" align="right">'.$subtotal_bayar.'</td>
                              </tr>
                              <tr>
                                <td style="color: #153643; font-family: sans-serif;" colspan="1">Ongkos Kirim</td>
                                <td style="color: #153643; font-family: sans-serif;text-align: right;" colspan="3" align="right">'.$ongkos_kirim.'</td>
                              </tr>
                              <tr>
                                <td style="color: #153643; font-family: sans-serif;" colspan="1">Potongan Voucher</td>
                                <td style="color: #153643; font-family: sans-serif;text-align: right;" colspan="3" align="right">'.$potongan_voucher.'</td>
                              </tr>
                              <tr>
                                <td style="color: #153643; font-family: sans-serif;" colspan="1">Total Harga</td>
                                <td style="color: #153643; font-family: sans-serif;text-align: right; font-weight: 600;" colspan="3" align="right">
                                  '.$total_bayar.'
                                </td>
                              </tr>
                            </tfoot>
                          </table>

                          <div class="" style="border-top: 1px solid #e4e4e4; padding-top: 15px; margin-top: 15px; color: #153643; font-family: sans-serif;">
                            <div class="ft-14 mb-3">
                              <div class="ft-14 font-weight-bold mb-1" style="font-weight: 600;">
                                Metode Pembayaran
                              </div>
                              '.$m_bayar.'
                            </div>';
                            // khusus point of sale
                            if($isdigital=='n' && $formpos!='POS'){
                            $mailContent .= '
                            <div class="ft-14 mb-3">
                              <div class="ft-14 font-weight-bold mb-1" style="font-weight: 600;">
                                Metode Pengiriman
                              </div>
                              Kurir - '.$nama_kurir.'
                            </div>
                            <div class="ft-14">
                              <div class="ft-14 font-weight-bold mb-1" style="font-weight: 600;">
                                Alamat Pengiriman
                              </div>
                              '.$m_alamat['nama_penerima'].'
                              <br>'.$m_alamat['nama_provinsi'].','.$m_alamat['nama_kabkot'].', '.$m_alamat['kodepos'].'
                              <br>'.$m_alamat['alamat_lengkap'].'
                              <br>
                              Nomor yang dapat di hubungi '.$m_alamat['ponsel_penerima'].'
                            </div>';
                            }
                            $mailContent .= '
                          </div>

                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="font-size: 13px; padding: 30px 30px 30px 30px;color: #153643; font-family: sans-serif;">
                    Tolong jangan balas email ini. Karena email ini dibuat secara otomatis. Jika Anda memiliki keluhan atau masalah, silakan laporkan kepada kami dengan membuka halaman kontak kami.
                  </td>
                </tr>
                <tr>
                  <td bgcolor="#44525f" style="padding: 20px 30px 15px 30px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" style="font-family: sans-serif; font-size: 14px; color: #ffffff;">
                          Copyright &copy; 2025 '.$set_p['smtp_setnama'].' All Right Reserved
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              <!--[if (gte mso 9)|(IE)]>
                    </td>
                  </tr>
              </table>
              <![endif]-->
              </td>
            </tr>
        </table>
      </body>
    </html>';
    $mail->Body = $mailContent;

    // Menambahakn lampiran
    // $mail->addAttachment('attachment/namafile.pdf'); // pdf doc dll,
    // $mail->addAttachment('attachment/namafile.png', 'nama-baru-file2.png'); //atur nama baru

    if(!$mail->send()){
        return 'Send OTP Error: ' . $mail->ErrorInfo;
    }else{
        return 'y';
    }
}

function kirimTransaksikeWa($idtrx,$idcust){

    $CI = get_instance();
    $set_p = $CI->db->query("SELECT * FROM _setting")->row_array();

    $res = $CI->db->query("SELECT a.*,c.cust_ponsel FROM tx_transaksi a LEFT JOIN m_customer c ON a.cust_id=c.cust_id WHERE a.cust_id='$idcust' AND a.unique_id='$idtrx' ORDER BY a.transaksi_id DESC ")->result_array();
    foreach ($res as $rows) {
      $tgl_transaksi = indo($rows['tgl_transaksi']);
      $notrx = $rows['no_transaksi'];
      $nophone = $rows['cust_ponsel'];
      $t_byr = $rows['harga_total']+$rows['ongkos_kirim']+$rows['tambahan_harga_total']-$rows['potongan_total']-$rows['diskon_all_total']-$rows['potongan_voucher'];
      $total_bayar = formatRupiah($t_byr);

      if($nophone==''){
        $resguest = $CI->db->query("SELECT ponsel_penerima FROM tx_transaksi a LEFT JOIN m_customer_det b ON a.cust_det_id=b.cust_det_id WHERE a.transaksi_id='$rows[transaksi_id]'")->row_array();
        $nophone = $resguest['ponsel_penerima'];
        $nophone = ltrim($nophone, '0');
        if (substr($nophone, 0, 2) !== '62') { $nophone = '62' . $nophone; }
      }

      if ($rows['payment_type']=='manual') {
          // khusus point of sale
          if ($rows['metode_pembayaran']=='cash') {
            $m_bayar = 'Cash';
          }else{
            $m_bayar = 'Layanan Transfer Bank';
          }
      }else if ($rows['payment_type']=='tripay') {
          $m_bayar = $rows['bill_key'];
      }else if ($rows['payment_type']=='xendit') {
          $m_bayar = $rows['cara_pembayaran'];
      }else{
        if ($rows['biller_code']=='bca') {
            $m_bayar = 'Bank BCA (VA) : '.$rows['bill_key'];
        }else if ($rows['biller_code']=='70012') {
            $m_bayar = 'Bank Mandiri (VA) : '.$rows['bill_key'];
        }else if ($rows['biller_code']=='bri') {
            $m_bayar = 'Bank BRI (VA) : '.$rows['bill_key'];
        }else if ($rows['biller_code']=='bni') {
            $m_bayar = 'Bank BNI (VA) : '.$rows['bill_key'];
        }else if ($rows['biller_code']=='permata') {
            $m_bayar = 'Bank Permata (VA) : '.$rows['bill_key'];
        }else{
            if ($rows['payment_type']=='gopay') {
                $m_bayar = 'Gopay';
            }else if ($rows['payment_type']=='qris') {
                $m_bayar = 'QRIS';
            }else{
                $m_bayar = 'Layanan Transfer Bank';
            }
        }
      }
    }

    if ($set_p['status_wablas']=='y' && $nophone!='') {

      $token = $set_p['api_token_wablas'];
      $server = $set_p['server_wablas'];

      $msg = '*Transaksi Baru '.$set_p['smtp_setnama'].'*\r\nInvoice: *'.$notrx.'*\r\nTanggal: *'.$tgl_transaksi.'*\r\nTotal Harga: *'.$total_bayar.'*\r\nCara Pembayaran: *'.$m_bayar.'*\r\n\r\nKunjungi website resmi kami di '.$set_p['google_redirect'].'\r\n*Terimakasih*';

      $curl = curl_init();
      $data = [
      'phone' => $nophone,
      'message' => $msg,
      ];
      curl_setopt($curl, CURLOPT_HTTPHEADER,
          array(
              "Authorization: $token",
          )
      );
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($curl, CURLOPT_URL, $server);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
      $result = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);
      if ($err) {
        return 'n';
      } else {
        return 'y';
      }

    }

    if ($set_p['status_watsap']=='y' && $nophone!='') {

      $api_key   = $set_p['apikey_watsap']; // API KEY Anda
      $id_device = $set_p['iddevice_watsap']; // ID DEVICE yang di SCAN (Sebagai pengirim)
      $url   = $set_p['server_watsap']; // URL API

      $pesan = '*Transaksi Baru '.$set_p['smtp_setnama'].'*'.PHP_EOL.
         'Invoice: *'.$notrx.'*'.PHP_EOL.
         'Tanggal: *'.$tgl_transaksi.'*'.PHP_EOL.
         'Total Harga: *'.$total_bayar.'*'.PHP_EOL.
         'Cara Pembayaran: *'.$m_bayar.'*'.PHP_EOL.PHP_EOL.
         'Kunjungi website resmi kami di '.$set_p['google_redirect'].PHP_EOL.
         '*Terimakasih*';

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
        'appkey' => $api_key,
        'authkey' => $id_device,
        'to' => $nophone,
        'message' => $pesan,
        'sandbox' => 'false'
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);

      if($set_p['whatsapp']!=''){
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array(
          'appkey' => $api_key,
          'authkey' => $id_device,
          'to' => $set_p['whatsapp'],
          'message' => $pesan,
          'sandbox' => 'false'
          ),
        )); 
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
      }
      
      if ($err) {
        return 'n';
      } else {
        return 'y';
      }

      // $curl = curl_init();
      // curl_setopt($curl, CURLOPT_URL, $url);
      // curl_setopt($curl, CURLOPT_HEADER, 0);
      // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
      // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
      // curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
      // curl_setopt($curl, CURLOPT_TIMEOUT, 0); // batas waktu response
      // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
      // curl_setopt($curl, CURLOPT_POST, 1);

      // $data_post = [
      //   'id_device' => $id_device,
      //   'api-key' => $api_key,
      //   'no_hp'   => $nophone,
      //   'pesan'   => $pesan
      // ];
      // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_post));
      // curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
      // $response = curl_exec($curl);
      // $err = curl_error($curl);
      // curl_close($curl);
      // if ($err) {
      //   return 'n';
      // } else {
      //   return 'y';
      // }
      
    }

}

function kirimNotifEmailwa($mail,$idtrx,$status){
  $CI = get_instance();
  $set_p = $CI->db->query("SELECT * FROM _setting")->row_array();

  $res = $CI->db->query("SELECT a.*,c.cust_nama,c.cust_ponsel,c.is_token FROM tx_transaksi a LEFT JOIN m_customer c ON a.cust_id=c.cust_id WHERE a.transaksi_id='$idtrx'")->row_array();
  
  if($res['email_trx']!=''){
    $resguest = $CI->db->query("SELECT b.* FROM tx_transaksi a LEFT JOIN m_customer_det b ON a.cust_det_id=b.cust_det_id WHERE a.transaksi_id='$idtrx'")->row_array();
    $res['is_token'] = $res['email_trx'];
    $res['cust_nama'] = $resguest['nama_penerima'];
    $res['cust_ponsel'] = $resguest['ponsel_penerima'];
  }

  $resx = $CI->db->query("SELECT a.*,b.kurir,b.nama_kurir,b.level_kurir,b.lama_pengiriman,c.cust_ponsel FROM tx_transaksi a LEFT JOIN tx_kurir b ON a.no_transaksi=b.no_transaksi JOIN m_customer c ON a.cust_id=c.cust_id WHERE a.transaksi_id='$idtrx' ORDER BY a.transaksi_id DESC ")->result_array();
  
  $total_bayar = 0;
  foreach ($resx as $rows) {
    $t_byr = $rows['harga_total']+$rows['ongkos_kirim']+$rows['tambahan_harga_total']-$rows['potongan_total']-$rows['diskon_all_total']-$rows['potongan_voucher'];
    $total_bayar = formatRupiah($t_byr);
  }

  if ($set_p['kirim_transaksi_email']=='y') {
    if ($res['is_token']!='') {
      if ($status=='batal' || $status=='proses' || $status=='kirim' || $status=='selesai') {
        kirimNotifEmailwaeamil($mail,$res['is_token'],$status,$res['no_transaksi']);
      }
    }
  }

  if ($set_p['status_wablas']=='y' && $res['cust_ponsel']!='') {

    $res['cust_ponsel'] = ltrim($res['cust_ponsel'], '0');
    if (substr($res['cust_ponsel'], 0, 2) !== '62') { $res['cust_ponsel'] = '62' . $res['cust_ponsel']; }

    $token = $set_p['api_token_wablas'];
    $server = $set_p['server_wablas'];
    $msg = '';
    if ($status=='batal') {
      $msg = '*Hai: '.$res['cust_nama'].'*\r\n*Transaksi Invoice: '.$res['no_transaksi'].'*\r\nTotal Harga: *'.$total_bayar.'*\r\nStatus: *Dibatalkan*\r\n\r\nKunjungi website resmi kami di '.$set_p['google_redirect'].'\r\n*Terimakasih*';
    }

    if ($status=='proses') {
      $msg = '*Hai: '.$res['cust_nama'].'*\r\n*Transaksi Invoice: '.$res['no_transaksi'].'*\r\nTotal Harga: *'.$total_bayar.'*\r\nPembayaran: *Diterima*\r\n\r\nKunjungi website resmi kami di '.$set_p['google_redirect'].'\r\n*Terimakasih*';
    }

    if ($status=='kirim') {
      $msg = '*Hai: '.$res['cust_nama'].'*\r\n*Transaksi Invoice: '.$res['no_transaksi'].'*\r\nTotal Harga: *'.$total_bayar.'*\r\nStatus: *Dalam Perjalanan*\r\n\r\nKunjungi website resmi kami di '.$set_p['google_redirect'].'\r\n*Terimakasih*';
    }

    if ($status=='selesai') {
      $msg = '*Hai: '.$res['cust_nama'].'*\r\n*Transaksi Invoice: '.$res['no_transaksi'].'*\r\nTotal Harga: *'.$total_bayar.'*\r\nStatus: *Selesai*\r\n\r\nKunjungi website resmi kami di '.$set_p['google_redirect'].'\r\n*Terimakasih*';
    }

    if ($status=='batal' || $status=='proses' || $status=='kirim' || $status=='selesai') {
      $curl = curl_init();
      $data = [
      'phone' => $res['cust_ponsel'],
      'message' => $msg,
      ];
      curl_setopt($curl, CURLOPT_HTTPHEADER,
          array(
              "Authorization: $token",
          )
      );
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($curl, CURLOPT_URL, $server);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
      $result = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);
      if ($err) {
        return 'n';
      } else {
        return 'y';
      }
    }

  }

  if ($set_p['status_watsap']=='y' && $res['cust_ponsel']!='') {

    $res['cust_ponsel'] = ltrim($res['cust_ponsel'], '0');
    if (substr($res['cust_ponsel'], 0, 2) !== '62') { $res['cust_ponsel'] = '62' . $res['cust_ponsel']; }

    $api_key   = $set_p['apikey_watsap']; // API KEY Anda
    $id_device = $set_p['iddevice_watsap']; // ID DEVICE yang di SCAN (Sebagai pengirim)
    $url   = $set_p['server_watsap']; // URL API
    $msg = '';
    
    if ($status == 'batal') {
      $msg = '*Hai: '.$res['cust_nama'].'*'.PHP_EOL.
             '*Transaksi Invoice: '.$res['no_transaksi'].'*'.PHP_EOL.
             'Total Harga: *'.$total_bayar.'*'.PHP_EOL.
             'Status: *Dibatalkan*'.PHP_EOL.PHP_EOL.
             'Kunjungi website resmi kami di '.$set_p['google_redirect'].PHP_EOL.
             '*Terimakasih*';
    }
  
    if ($status == 'proses') {
        $msg = '*Hai: '.$res['cust_nama'].'*'.PHP_EOL.
              '*Transaksi Invoice: '.$res['no_transaksi'].'*'.PHP_EOL.
              'Total Harga: *'.$total_bayar.'*'.PHP_EOL.
              'Pembayaran: *Diterima*'.PHP_EOL.PHP_EOL.
              'Kunjungi website resmi kami di '.$set_p['google_redirect'].PHP_EOL.
              '*Terimakasih*';
    }
  
    if ($status == 'kirim') {
      $msg = '*Hai: '.$res['cust_nama'].'*'.PHP_EOL.
             '*Transaksi Invoice: '.$res['no_transaksi'].'*'.PHP_EOL.
             'Total Harga: *'.$total_bayar.'*'.PHP_EOL.
             'Status: *Dalam Perjalanan*'.PHP_EOL.PHP_EOL.
             'Kunjungi website resmi kami di '.$set_p['google_redirect'].PHP_EOL.
             '*Terimakasih*';
    }
  
    if ($status == 'selesai') {
      $msg = '*Hai: '.$res['cust_nama'].'*'.PHP_EOL.
             '*Transaksi Invoice: '.$res['no_transaksi'].'*'.PHP_EOL.
             'Total Harga: *'.$total_bayar.'*'.PHP_EOL.
             'Status: *Selesai*'.PHP_EOL.PHP_EOL.
             'Kunjungi website resmi kami di '.$set_p['google_redirect'].PHP_EOL.
             '*Terimakasih*';
    }

    if ($status=='batal' || $status=='proses' || $status=='kirim' || $status=='selesai') {

      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
        'appkey' => $api_key,
        'authkey' => $id_device,
        'to' => $res['cust_ponsel'],
        'message' => $msg,
        'sandbox' => 'false'
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);
      if ($err) {
        return 'n';
      } else {
        return 'y';
      }

      // $curl = curl_init();
      // curl_setopt($curl, CURLOPT_URL, $url);
      // curl_setopt($curl, CURLOPT_HEADER, 0);
      // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
      // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
      // curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
      // curl_setopt($curl, CURLOPT_TIMEOUT, 0); // batas waktu response
      // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
      // curl_setopt($curl, CURLOPT_POST, 1);

      // $data_post = [
      //   'id_device' => $id_device,
      //   'api-key' => $api_key,
      //   'no_hp'   => $res['cust_ponsel'],
      //   'pesan'   => $msg
      // ];
      // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_post));
      // curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
      // $response = curl_exec($curl);
      // $err = curl_error($curl);
      // curl_close($curl);
      // if ($err) {
      //   return 'n';
      // } else {
      //   return 'y';
      // }
    }

  }

}

function kirimNotifEmailwaeamil($mail,$emailto,$status,$notrx){

    $CI = get_instance();

    $set_p = $CI->db->query("SELECT * FROM _setting")->row_array();

    $mail->isSMTP();
    $mail->Host = $set_p['smtp_host']; //host masing2 provider email
    $mail->SMTPAuth = true;
    $mail->Username = $set_p['smtp_username']; // email domain
    $mail->Password = $set_p['smtp_password']; // pass email domain
    $mail->SMTPSecure = $set_p['smtp_secure'];
    $mail->Port = $set_p['smtp_port'];

    $mail->SMTPOptions = array(
    'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
    )
    );

    $mail->setFrom($set_p['smtp_username'], $set_p['smtp_setnama']);

    $mail->addAddress($emailto);
    if ($set_p['smtp_cc_email']!='') {
        $mail->addCC($set_p['smtp_cc_email']);
    }
    if ($set_p['smtp_bcc_email']!='') {
        $mail->addBCC($set_p['smtp_bcc_email']);
    }

    $subject = '';
    $msg = '';
    if ($status=='batal') {
      $subject = 'Transaksi '.$notrx.' Telah Dibatalkan';
      $msg = 'Transaksi kamu dengan nomor '.$notrx.' telah dibatalkan.';
    }
    if ($status=='proses') {
      $subject = ''.$notrx.' Pembayaran Diterima';
      $msg = 'Transaksi '.$notrx.' - status pembayaran telah diterima, pesanan sedang dalam proses.';
    }
    if ($status=='kirim') {
      $subject = 'Transaksi '.$notrx.' Telah Dikirim';
      $msg = 'Transaksi kamu dengan nomor '.$notrx.' sedang dalam perjalanan.';
    }
    if ($status=='selesai') {
      $subject = 'Transaksi '.$notrx.' Telah Selesai';
      $msg = 'Transaksi kamu dengan nomor '.$notrx.' telah selesai.';
    }

    $mail->Subject = $subject;
    
    // mengatur format email ke HTML
    $mail->isHTML(true);

    $mailContent = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Notifikasi</title>
            <style type="text/css">
            body {margin: 0; padding: 0; min-width: 100%!important;}
            img {height: auto;}
            .content { width: 100%; max-width: 600px; }
            @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
            body[yahoo] .hide {display: none!important;}
            body[yahoo] .buttonwrapper {background-color: transparent!important;}
            }
            /*@media only screen and (min-device-width: 601px) {
              .content {width: 600px !important;}
              .col425 {width: 425px!important;}
              .col380 {width: 380px!important;}
              }*/

            </style>
        </head>

        <body yahoo bgcolor="#f6f8f1">
          <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td>
              <!--[if (gte mso 9)|(IE)]>
                <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                  <tr>
                    <td>
              <![endif]-->
              <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td bgcolor="#fff" style="border-bottom: 2px solid #37b464; padding: 10px 30px 10px 30px;">
                    <table width="70" align="left" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td height="70">
                          <!-- <img src="https://admin.novelhub.id/assets/temp/img/logo/logo_novelhub_fit-02.png" width="170" height="170" border="0" alt="" /> -->
                          <span style="font-size: 24px; font-weight: bold; font-family: sans-serif;">'.$set_p['smtp_setnama'].'</span>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="padding: 30px 30px 30px 30px;border-bottom: 1px solid #f2eeed;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td style="color: #153643; font-family: sans-serif;padding: 0 0 15px 0; font-size: 18px; line-height: 28px; font-weight: bold;">
                          Hi '.$emailto.'.<br/>
                          '.$msg.'
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="font-size: 13px; padding: 30px 30px 30px 30px;color: #153643; font-family: sans-serif;">
                    Tolong jangan balas email ini. Karena email ini dibuat secara otomatis. Jika Anda memiliki keluhan atau masalah, silakan laporkan kepada kami dengan membuka halaman kontak kami.
                  </td>
                </tr>
                <tr>
                  <td bgcolor="#44525f" style="padding: 20px 30px 15px 30px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" style="font-family: sans-serif; font-size: 14px; color: #ffffff;">
                          Copyright &copy; 2025 '.$set_p['smtp_setnama'].' All Right Reserved
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              <!--[if (gte mso 9)|(IE)]>
                    </td>
                  </tr>
              </table>
              <![endif]-->
              </td>
            </tr>
        </table>
      </body>
    </html>';
    $mail->Body = $mailContent;

    $mail->send();
}

function hitungRating($id) {
    $CI = get_instance();
    $resultSet = $CI->db->query("SELECT SUM(rating_produk) as rating, COUNT(rating_produk) as count FROM tx_transaksi_det WHERE produk_id='$id' AND publikasi_rating='y'")->row_array();
    if($resultSet['count']>0) {
      return ($resultSet['rating']/$resultSet['count']);
    } else {
      return 0;
    }
    
}

function indo($tgl = null){
    if ($tgl!=null) {
        $date = substr($tgl,0,10);
        $BulanIndo = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
        $pecahkan = explode('-', $date);
        $tgl = isset($pecahkan[2]) ? $pecahkan[2] : '';
        $bln = isset($pecahkan[1]) ? $pecahkan[1] : '';
        $thn = isset($pecahkan[0]) ? $pecahkan[0] : '';
        return $tgl . ' ' . $BulanIndo[ (int)$bln-1] . ' ' . $thn;
    }else{
        return '';
    }
}

function indolengkap($tgl = null){
    if ($tgl!=null) {
        $date = substr($tgl,0,10);
        $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $pecahkan = explode('-', $date);
        $tgl = isset($pecahkan[2]) ? $pecahkan[2] : '';
        $bln = isset($pecahkan[1]) ? $pecahkan[1] : '';
        $thn = isset($pecahkan[0]) ? $pecahkan[0] : '';
        return $tgl . ' ' . $BulanIndo[ (int)$bln-1] . ' ' . $thn;
    }else{
        return '';
    }
}

function urutId($table,$field){
    $CI = get_instance();
    $query = $CI->db->query("SELECT max($field) as id FROM $table")->row_array();
    $hasilid = $query['id']+1;
    return ($hasilid);
}

function urutIdwhere($table,$field,$field2,$where){
    $CI = get_instance();
    $query = $CI->db->query("SELECT max($field) as id FROM $table WHERE $field2='$where'")->row_array();
    $hasilid = $query['id']+1;
    return ($hasilid);
}

function formatRupiah($jumlah = 0){
    $conv = "Rp ".number_format($jumlah,0,',','.');
    return($conv);
}

function formatRupiahnorp($jumlah = 0,$kutip = 0){
    $conv = number_format($jumlah,$kutip,',','.');
    return($conv);
}

function randCode($panjang){
    $karakter= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';
    $string = '';
    for ($i = 0; $i < $panjang; $i++) {
        $pos = rand(0, strlen($karakter)-1);
        $string .= $karakter[$pos];
    }
    
    return $string;
}

function randNumb($panjang){
    $karakter= '123456789';
    $string = '';
    for ($i = 0; $i < $panjang; $i++) {
        $pos = rand(0, strlen($karakter)-1);
        $string .= $karakter[$pos];
    }
    
    return $string;
}

function str_replace_html($txt = null){
    if ($txt!=null) {
      $find = array("<?php","?>","<?","<?=","<script>","<script","</script>","<a>","<a","</a>","<button>","<button","</button>","<ul>","<ul","</ul>","<li>","<li","</li>","<ol>","<ol","</ol>");
      $replace = "-";
      return str_replace($find,$replace,$txt);
    }else{
      return $txt;
    }
}

function str_replace_html_noa($txt = null){
  if ($txt!=null) {
    $find = array("<?php","?>","<?","<?=","<script>","<script","</script>","<button>","<button","</button>","<ul>","<ul","</ul>","<li>","<li","</li>","<ol>","<ol","</ol>");
    $replace = "-";
    return str_replace($find,$replace,$txt);
  }else{
    return $txt;
  }
}

function str_replace_kutip($txt = null){
  if ($txt!=null) {
    $find = array('"','`');
    $replace = "'";
    return str_replace($find,$replace,$txt);
  }else{
    return $txt;
  }
}

function str_replace_kutipx($txt = null){
  if ($txt!=null) {
    $find = array("'");
    $replace = "-";
    return str_replace($find,$replace,$txt);
  }else{
    return $txt;
  }
}

function hitungBulan($tgl1,$tgl2){ 
    //convert
    $timeStart = strtotime($tgl1);
    $timeEnd = strtotime($tgl2);
    // Menambah bulan ini + semua bulan pada tahun sebelumnya
    $numBulan = 1 + (date("Y",$timeEnd)-date("Y",$timeStart))*12;
    // hitung selisih bulan
    $numBulan += date("m",$timeEnd)-date("m",$timeStart);
    return $numBulan;
}

function convertedTime($tambah,$date = null){ 
    if ($date==null) {
        $startTime = date("Y-m-d H:i:s");
    }else{
        $startTime = $date;
    }
    //add time
    $cenvertedTime = date('Y-m-d H:i:s',strtotime($tambah,strtotime($startTime)));
    //display the converted time
    return $cenvertedTime;
}

// function number_format_short($n) {
//     if ($n > 0 && $n < 1000) {
//         // 1 - 999
//         $n_format = floor($n);
//         $suffix = '';
//     } else if ($n >= 1000 && $n < 1000000) {
//         // 1k-999k
//         $n_format = floor($n / 1000);
//         $suffix = 'K+';
//     } else if ($n >= 1000000 && $n < 1000000000) {
//         // 1m-999m
//         $n_format = floor($n / 1000000);
//         $suffix = 'M+';
//     } else if ($n >= 1000000000 && $n < 1000000000000) {
//         // 1b-999b
//         $n_format = floor($n / 1000000000);
//         $suffix = 'B+';
//     } else if ($n >= 1000000000000) {
//         // 1t+
//         $n_format = floor($n / 1000000000000);
//         $suffix = 'T+';
//     }

//     return !empty($n_format . $suffix) ? $n_format . $suffix : 0;
// }

function number_format_short_2($num, $precision = 2) {
    if ($num >= 1000 && $num < 1000000) {
       $n_format = number_format($num/1000, $precision).'K';
    } else if ($num >= 1000000 && $num < 1000000000) {
       $n_format = number_format($num/1000000, $precision).'M';
    } else if ($num >= 1000000000) {
       $n_format = number_format($num/1000000000, $precision).'B';
    } else {
       $n_format = $num;
    }
       return $n_format;
}

function time_ago($time_ago) {
    $time_ago = strtotime($time_ago);
    $cur_time   = time();
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );
    // Seconds
    if($seconds <= 60){
        return "just now";
    }
    //Minutes
    else if($minutes <=60){
        if($minutes==1){
            return "1 minute ago";
        }
        else{
            return "$minutes minutes ago";
        }
    }
    //Hours
    else if($hours <=24){
        if($hours==1){
            return "an hour ago";
        }else{
            return "$hours hrs ago";
        }
    }
    //Days
    else if($days <= 7){
        if($days==1){
            return "yesterday";
        }else{
            return "$days days ago";
        }
    }
    //Weeks
    else if($weeks <= 4.3){
        if($weeks==1){
            return "a week ago";
        }else{
            return "$weeks weeks ago";
        }
    }
    //Months
    else if($months <=12){
        if($months==1){
            return "a month ago";
        }else{
            return "$months months ago";
        }
    }
    //Years
    else{
        if($years==1){
            return "one year ago";
        }else{
            return "$years years ago";
        }
    }
}

function url_replace($string) {
    $c = array (' ');
    $d = array ('/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','*','?','&','=','+','°');
    $string = str_replace($d, '', $string); // Hilangkan karakter yang telah disebutkan di array $d
    $string = strtolower(str_replace($c, '-', $string)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
    return $string;
}

function c_get_file_contents(){
  if ($_SERVER['SERVER_NAME']!='localhost') {
    $url = 'https://store.carvellonic.com/adminpage/auth/validate_lic/'.$_SERVER['SERVER_NAME'];
    $c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c, CURLOPT_URL, $url);
    $contents = curl_exec($c);
    curl_close($c);
    if ($contents){
      $h = json_decode($contents, true);
      if ($h!='') {
        if($h['status'] != 200) {
          die($h['message']);
        }
      }
    }else{
      return FALSE;
    }
  }
}

// ----

function check_access($role_id, $menu_id) {
    $CI = get_instance();
    $CI->db->where('role_id', $role_id);
    $CI->db->where('menu_id', $menu_id);
    $result = $CI->db->get('m_role_access');
    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function kon_waktu($waktu){
    if(($waktu>0) and ($waktu<60)){
        $lama=number_format($waktu,2)." detik";
        return $lama;
    }
    if(($waktu>60) and ($waktu<3600)){
        $detik=fmod($waktu,60);
        $menit=$waktu-$detik;
        $menit=$menit/60;
        $lama=$menit." Menit ".number_format($detik,2)." detik";
        return $lama;
    }
    elseif($waktu >3600){
        $detik=fmod($waktu,60);
        $tempmenit=($waktu-$detik)/60;
        $menit=fmod($tempmenit,60);
        $jam=($tempmenit-$menit)/60;    
        $lama=$jam." Jam ".$menit." Menit ".number_format($detik,2)." detik";
        return $lama;
    }
}

function kon_detik_to_menit($waktu){
    $result = $waktu/60;
    return $result;
}

class GoogleLoginApi {
  public function GetAccessToken($client_id, $redirect_uri, $client_secret, $code) {  
    $url = 'https://www.googleapis.com/oauth2/v4/token';      
    $curlPost = 'client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&code='. $code . '&grant_type=authorization_code';
    $ch = curl_init();    
    curl_setopt($ch, CURLOPT_URL, $url);    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    
    curl_setopt($ch, CURLOPT_POST, 1);    
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);  
    $data = json_decode(curl_exec($ch), true);
    $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);    
    if($http_code != 200) 
      throw new Exception('Error : Failed to receieve access token');
        
    return $data;
  }

  public function GetUserProfileInfo($access_token) { 
    $url = 'https://www.googleapis.com/oauth2/v2/userinfo?fields=name,email,gender,id,picture,verified_email';      
    $ch = curl_init();    
    curl_setopt($ch, CURLOPT_URL, $url);    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token));
    $data = json_decode(curl_exec($ch), true);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   
    if($http_code != 200) 
      throw new Exception('Error : Failed to get user information');
        
    return $data;
  }
}

function curl_get_file_contents(){
  $url = 'https://store.carvellonic.com/adminpage/auth/validate_lic/'.$_SERVER['SERVER_NAME'];
  $c = curl_init();
  curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($c, CURLOPT_URL, $url);
  $contents = curl_exec($c);
  curl_close($c);
  if ($contents) return json_decode($contents, true);
  else return FALSE;
}

function resizeImagev2($resourceType,$image_width,$image_height,$resizeWidth,$resizeHeight) {
    // $resizeWidth = 100;
    // $resizeHeight = 100;
    $imageLayer = imagecreatetruecolor($resizeWidth,$resizeHeight);
    imagecopyresampled($imageLayer,$resourceType,0,0,0,0,$resizeWidth,$resizeHeight, $image_width,$image_height);
    return $imageLayer;
}

function resizeImgv2($source_image, $dir){
    list( $width, $height ) = getimagesize($source_image);

    $width_size = $width*50/100; // compress 50%
    $k = $width / $width_size;
    $new_width = $width / $k;
    $new_height = $height / $k;

    $fileName = $source_image;
    $sourceProperties = getimagesize($fileName);
    $uploadPath = $dir;
    $uploadImageType = $sourceProperties[2];
    $sourceImageWidth = $sourceProperties[0];
    $sourceImageHeight = $sourceProperties[1];
    switch ($uploadImageType) {
        case IMAGETYPE_JPEG:
            $resourceType = imagecreatefromjpeg($fileName);
            $imageLayer = resizeImagev2($resourceType,$sourceImageWidth,$sourceImageHeight,$new_width,$new_height);
            imagejpeg($imageLayer,$uploadPath);
            break;

        case IMAGETYPE_GIF:
            $resourceType = imagecreatefromgif($fileName);
            $imageLayer = resizeImagev2($resourceType,$sourceImageWidth,$sourceImageHeight,$new_width,$new_height);
            imagegif($imageLayer,$uploadPath);
            break;

        case IMAGETYPE_PNG:
            $resourceType = imagecreatefrompng($fileName);
            $imageLayer = resizeImagev2($resourceType,$sourceImageWidth,$sourceImageHeight,$new_width,$new_height);
            imagepng($imageLayer,$uploadPath);
            break;

        default:
            break;
    }
}

?>