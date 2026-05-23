<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Xendit\Xendit;

class Rest_pos_model extends CI_Model {

    public function get_settings($postjson) {
        $cekdata = pengaturanSistem();
        if ($cekdata) {
            return json_encode(array('success'=>true, 'result'=>$cekdata));
        }else{
            return json_encode(array('success'=>false));
        }
    }

    public function get_data_login($postjson) {
        $cekdata = $this->db->query("SELECT a.*, b.nama_toko FROM m_pengelola a JOIN m_toko b ON a.toko_id=b.toko_id WHERE a.pengelola_id='$postjson[idlogin]'")->row_array();
        if ($cekdata) {
            return json_encode(array('success'=>true, 'result'=>$cekdata));
        }else{
            return json_encode(array('success'=>false));
        }
    }

    public function get_data_users($postjson) {
        $data = array();
        $q = $this->db->query("SELECT * FROM m_customer WHERE is_active!='0' ORDER BY cust_nama ASC")->result_array();
        foreach ($q as $rows) {            
            $data[] = array(
                'cust_id'           => $rows['cust_id'],
                'cust_nama'         => $rows['cust_nama']." - ".$rows['cust_ponsel']
            );
        }

        return json_encode(array('success'=>true, 'result'=>$data));
    }

    public function get_data_transaksi($postjson) {
        $data = array();
        $q = $this->db->query("SELECT * FROM m_pengelola WHERE pengelola_id='$postjson[idlogin]'")->row_array();
        $trx = $this->db->query("SELECT a.*, b.cust_nama FROM tx_transaksi a LEFT JOIN m_customer b ON a.cust_id=b.cust_id WHERE a.pos_toko_id='$q[toko_id]' AND a.transaksi_from='POS' ORDER BY a.transaksi_id DESC ");
    
        foreach ($trx->result_array() as $rows) {

            $totalbayar = $rows['harga_total']+$rows['ongkos_kirim']-$rows['potongan_total']-$rows['diskon_all_total']+$rows['tambahan_harga_total'];

            if($rows['is_status']=='s'){
                $st = 'Transaksi Selesai';
                $stx = 'color-success';
            }else if($rows['is_status']=='b'){
                $st = 'Dibatalkan';
                $stx = 'color-danger';
            }else if($rows['is_status']=='p'){
                $st = 'Menunggu Pembayaran';
                $stx = 'color-orange';
            }else{
              $st = 'Unknown';
              $stx = 'color-default';
            }
            
            $data[] = array(
                'transaksiid'       => $rows['transaksi_id'],
                'uniqueid'          => $rows['unique_id'],
                'cust_id'           => $rows['cust_id'],
                'custnama'          => $rows['cust_nama'],
                'notrx'             => $rows['no_transaksi'],
                'harga_total'       => formatRupiah($totalbayar),
                'status_lbl'        => $st,
                'status_clr'        => $stx,
                'tgl_transaksi'     => indo($rows['tgl_transaksi'])
            );
        }

        return json_encode(array('success'=>true, 'result'=>$data, 'numrows'=>$trx->num_rows()));
    }

    public function get_data_transaksi_pday($postjson) {
        $data = array();
        $today = date('Y-m-d');
        $pendapatanperday = 0;
        $q = $this->db->query("SELECT * FROM m_pengelola WHERE pengelola_id='$postjson[idlogin]'")->row_array();
        $trx = $this->db->query("SELECT a.*, b.cust_nama FROM tx_transaksi a LEFT JOIN m_customer b ON a.cust_id=b.cust_id WHERE a.pos_toko_id='$q[toko_id]' AND a.transaksi_from='POS' AND date(a.tgl_transaksi) BETWEEN '$today' AND '$today' ORDER BY a.transaksi_id DESC LIMIT 3 ");
    
        foreach ($trx->result_array() as $rows) {

            $totalbayar = $rows['harga_total']+$rows['ongkos_kirim']-$rows['potongan_total']-$rows['diskon_all_total']+$rows['tambahan_harga_total'];
            
            $data[] = array(
                'transaksiid'       => $rows['transaksi_id'],
                'cust_id'           => $rows['cust_id'],
                'uniqueid'          => $rows['unique_id'],
                'custnama'          => $rows['cust_nama'],
                'notrx'             => $rows['no_transaksi'],
                'harga_total'       => formatRupiah($totalbayar),
                'tgl_transaksi'     => indo($rows['tgl_transaksi'])
            );

            $pendapatanperday += $totalbayar;
        }

        return json_encode(array('success'=>true, 'result'=>$data, 'pendapatanperday'=>formatRupiah($pendapatanperday), 'numrows'=>$trx->num_rows()));
    }

    public function get_data_products($postjson) {

        $data = array();
        if (isset($postjson['idkategori'])) {
            $produk = $this->db->query("SELECT distinct(b.produk_id), a.* FROM m_produk a JOIN m_produk_kategori b ON a.produk_id=b.produk_id WHERE a.is_active=1 AND a.is_hapus='n' AND b.kategori_id='$postjson[idkategori]' ORDER BY a.nama_produk ASC ")->result_array();
        }else if (isset($postjson['valuekey'])) {
            $produk = $this->db->query("SELECT * FROM m_produk WHERE is_active=1 AND is_hapus='n' AND (nama_produk LIKE '%$postjson[valuekey]%' OR kode_produk LIKE '%$postjson[valuekey]%') ORDER BY nama_produk ASC ")->result_array();
        }else{
            $produk = $this->db->query("SELECT * FROM m_produk WHERE is_active=1 AND is_hapus='n' ORDER BY nama_produk ASC ")->result_array();
        }
    
        foreach ($produk as $rows) {
            $gambar = $this->db->query("SELECT * FROM m_produk_img WHERE produk_id='$rows[produk_id]'")->row_array();
            $data[] = array(
                'produk_id'             => $rows['produk_id'],
                'nama_produk'           => $rows['nama_produk'],
                'logo_image'            => "assets/uploaded/products/".$gambar['logo_image']
            );
        }

        return json_encode(array('success'=>true, 'result'=>$data));
    }

    public function get_data_carts($postjson){

        $data = array();
        $pengaturanSistem = pengaturanSistem();
        $total_bayar = 0;

        if (!$postjson) { exit(); }

        $mcart = $postjson['carts'];
        foreach ($mcart as $rows) {

            $qproduk = $this->db->query("SELECT * FROM m_produk WHERE produk_id='$rows[idproduk]'")->row_array();
            $qwarna = $this->db->query("SELECT nama_warna FROM m_warna WHERE warna_id='$rows[idwarna]'")->row_array();
            $qukuran = $this->db->query("SELECT ukuran_size FROM m_ukuran WHERE ukuran_id='$rows[idukuran]'")->row_array();

            $gambar = $this->db->query("SELECT * FROM m_produk_img WHERE produk_id='$rows[idproduk]'")->row_array();

            $l_w = $this->db->query("SELECT * FROM m_produk_warna WHERE produk_id='$rows[idproduk]' AND warna_id='$rows[idwarna]'")->row_array();
            $l_u = $this->db->query("SELECT * FROM m_produk_ukuran WHERE produk_id='$rows[idproduk]' AND ukuran_id='$rows[idukuran]'")->row_array();

            if(!isset($l_u['tambahan_harga'])) $l_u['tambahan_harga'] = 0; else $l_u['tambahan_harga'] = $l_u['tambahan_harga'];

            $stok = $this->produk->cekStok($rows['idproduk'],$l_w['produk_warna_id'],$l_u['produk_ukuran_id']);
            if(!isset($stok['akhir'])) $stok['akhir'] = 0; else $stok['akhir'] = $stok['akhir'];
            if ($stok['akhir']>=$rows['jumlah_qty']) {
                $stk_lbl = 'y';
            }else{
                $stk_lbl = 'Tidak dapat di proses, stok tidak tersedia.';
            }

            if ($qproduk['potongan_status']=='y') {
                $today = strtotime(date('Y-m-d')); 
                $tgl_mulai = strtotime($qproduk['potongan_mulai']); $tgl_akhir = strtotime($qproduk['potongan_akhir']);
                $jarakhari = $today - $tgl_mulai;
                $selisihari = $jarakhari / 60 / 60 / 24;
                $jarakhari_a = $tgl_akhir - $today;
                $selisihari_a = $jarakhari_a / 60 / 60 / 24;

                if ($selisihari>=0 && $selisihari_a>=0) {
                    $potongan_diskon = $qproduk['potongan_diskon'];
                    $harga_p_new = $qproduk['harga_produk']-$potongan_diskon;
                    $global_diskon = ($harga_p_new*$pengaturanSistem['global_diskon'])/100;
                    $harga_p_new = $harga_p_new-$global_diskon;
                    $potongan_status = 'y';
                }else{
                    $potongan_diskon = 0;
                    $harga_p_new = $qproduk['harga_produk'];
                    $global_diskon = ($harga_p_new*$pengaturanSistem['global_diskon'])/100;
                    $harga_p_new = $harga_p_new-$global_diskon;
                    $potongan_status = 'n';
                }
            }else{
                $potongan_diskon = 0;
                $harga_p_new = $qproduk['harga_produk'];
                $global_diskon = ($harga_p_new*$pengaturanSistem['global_diskon'])/100;
                $harga_p_new = $harga_p_new-$global_diskon;
                $potongan_status = 'n';
            }
            
            $harga_p_new = $harga_p_new+$l_u['tambahan_harga'];

            if ($pengaturanSistem['global_diskon']>0) {
                $hrga_awal = $qproduk['harga_produk']-$potongan_diskon;
                $potongan_status = 'y';
            }else{
                $hrga_awal = $qproduk['harga_produk'];
            }

            if ($qwarna['nama_warna']!='') {
                if ($qwarna['nama_warna']=='Default') {
                    $qwarna['nama_warna'] = "";
                }else{
                    $qwarna['nama_warna'] = $qwarna['nama_warna'].", ";
                }
            }

            if ($qukuran['ukuran_size']!='') {
                if ($qukuran['ukuran_size']=='Default') {
                    $qukuran['ukuran_size'] = "";
                }else{
                    $qukuran['ukuran_size'] = $qukuran['ukuran_size'].", ";
                }
            }

            if ($qwarna['nama_warna']=='' && $qukuran['ukuran_size']=='') {
                if ($qwarna['nama_warna']!='') {
                    $varian = '-';
                }else{
                    $varian = '';
                }
            }else{
                $varian = substr($qwarna['nama_warna'].$qukuran['ukuran_size'], 0,-2);
            }

            if ($stk_lbl=='y') {
                $total_bayar += ($harga_p_new*$rows['jumlah_qty']);
            }
   
            $data[] = array(
                'cart_id'               => $rows['idcart'],
                'produk_id'             => $rows['idproduk'],
                'nama_produk'           => $qproduk['nama_produk'],
                'url_produk'            => $qproduk['url_produk'],
                'harga_produk_awal'     => formatRupiah($hrga_awal),
                'harga_produk_awal_q'   => formatRupiah($hrga_awal*$rows['jumlah_qty']),
                'harga_produk'          => formatRupiah($harga_p_new),
                'harga_produk_num'      => $harga_p_new,
                'harga_produk_q'        => formatRupiah($harga_p_new*$rows['jumlah_qty']),
                'potongan_status'       => $potongan_status,
                'is_new'                => $qproduk['is_new'],
                'is_digital'            => $qproduk['is_digital'],
                'logo_image'            => $gambar['logo_image'],
                'tstok'                 => $stk_lbl,
                'varian'                => $varian,
                'jumlah_beli'           => $rows['jumlah_qty']
            );
        }

        return json_encode(array('result'=>$data, 'total_bayar'=>formatRupiah($total_bayar+0), 'total_bayar_num'=>$total_bayar));

    }

    public function proses_signin($postjson) {

        $cekdata = $this->db->query("SELECT * FROM m_pengelola WHERE username='$postjson[username]' AND is_hapus='n' AND role_id=4");

        if ($cekdata->num_rows()>=1) {
            $cekdata = $cekdata->row_array();
            if($cekdata['is_active']==1){
                if (password_verify($postjson['password'], $cekdata['password'])) {
                    return json_encode(array('success'=>true, 'result'=>$cekdata, 'msg'=>'Login berhasil.'));
                }else{
                    return json_encode(array('success'=>false, 'msg'=>'Login gagal, password tidak sesuai.'));
                }
            }else{
                return json_encode(array('success'=>false, 'msg'=>'Login gagal, akun tidak aktif.'));
            }
        }else{
            return json_encode(array('success'=>false, 'msg'=>'Login gagal, akun tidak terdaftar.'));
        }
    }

    public function proses_add_to_cart($postjson) {

        if ($postjson['qty_input_pr']!=null) {
            $loginid = $this->session->userdata('p_id');
            $check = $this->db->query("SELECT * FROM tx_cart_pos WHERE idproduk='$postjson[pid]' AND idwarna='$postjson[warna_id]' AND idukuran='$postjson[ukuran_id]' AND idadmin='$loginid'");
            $datacart = $check->row_array();
            if ($check->num_rows()==0) {
                $data_c = [
                    'idadmin'          => $loginid,
                    'idproduk'         => $postjson['pid'],
                    'idwarna'          => $postjson['warna_id'],
                    'idukuran'         => $postjson['ukuran_id'],
                    'jumlah_qty'       => $postjson['qty_input_pr'],
                    'created_at'       => date('Y-m-d H:i:s')
                ];
                $res = $this->db->insert('tx_cart_pos', $data_c);
            }else{
                $this->db->set([
                    // 'jumlah_qty' => $datacart['jumlah_qty']+$postjson['qty_input_pr']
                    'jumlah_qty' => $postjson['qty_input_pr']
                ]);
                $this->db->where('idcart', $datacart['idcart']);
                $res = $this->db->update('tx_cart_pos');
            }
        }
        return json_encode(array('success'=>$res));
    }

    public function snap_token_midtrans($postjson,$rest_cart){

        require APPPATH.'libraries/midtrans/veritrans.php';

        $pengaturanSistem = pengaturanSistem();

        Veritrans_Config::$serverKey = $pengaturanSistem['midtrans_serverkey'];
        // Uncomment for production environment enable if production
        if ($pengaturanSistem['midtrans_tipekey']=='production') {
        Veritrans_Config::$isProduction = true;
        }
        // Enable sanitization
        Veritrans_Config::$isSanitized = true;
        // Enable 3D-Secure
        Veritrans_Config::$is3ds = true;

        $uniquecode = date('Y-m-d-His')."-cstore-xid-".$postjson['idcust'];

        // load alamat customer
        $rest_cust = $this->db->query("SELECT * FROM m_customer WHERE cust_id='$postjson[idcust]'")->row_array();

        $arr = array('kode' => $postjson['kodevoucher'], 'total_bayar' => $rest_cart['total_bayar_num'], 'idcust' => $postjson['idcust'], 'lang' => 'en');
        $rest_voucher = $this->restload->check_voucher($arr);
        $rest_voucher = json_decode($rest_voucher, true);

        $explname = explode(" ", $rest_cust['cust_nama']);
        $firstname = $explname[0];
        $lastname = ' ';

        $item_details = array();

        foreach($rest_cart['result'] as $obj) {
            if ($obj['tstok']=='y') {
              $item_details[] = array(
                'id'       => $obj['produk_id'],
                'price'    => $obj['harga_produk_num'],
                'quantity' => $obj['jumlah_beli'],
                'name'     => $obj['nama_produk'].' - '.$obj['varian']
              );
            }
        }

        $gross_amount = is_numeric($rest_cart['total_bayar_num']);
        $gross_amountx = $rest_cart['total_bayar_num'];

        if ($rest_voucher['st']=='y') {
            $item_details[] = array(
              'id'       => "v-".date('Ymdhis').$postjson['idcust'],
              'price'    => -$rest_voucher['nominal'],
              'quantity' => 1,
              'name'     => "Potongan Voucher"
            );

            //cek jika total = min
            $gross_amount_check_voucher = $gross_amountx-$rest_voucher['nominal'];
        }else{
            //cek jika total = min
            $gross_amount_check_voucher = $gross_amountx;
        }

        // Fill transaction details
        $transaction_details = array(
          'order_id' => $uniquecode,
          'gross_amount' => $gross_amount, // no decimal allowed
        );

        $customer_details = array(
          'first_name'    => $firstname, //optional
          'last_name'     => $lastname, //optional
          'email'         => $rest_cust['is_token'], //mandatory
          'phone'         => $rest_cust['cust_ponsel']
        );

        // Optional, remove this to display all available payment methods
        $enable_payments = array("credit_card", "gopay", "shopeepay", "permata_va", "bca_va", "bni_va", "bri_va", "echannel", "other_va", "Indomaret", "alfamart", "akulaku", "kredivo");

        // Fill transaction details
        $transaction = array(
          'enabled_payments' => $enable_payments,
          'transaction_details' => $transaction_details,
          'customer_details' => $customer_details,
          'item_details' => $item_details
        );

        if ($gross_amount_check_voucher>0) {
            $snapToken = Veritrans_Snap::getSnapToken($transaction);
            $result = json_encode(array('snapMidtrans'=>$snapToken, 'uniquecode'=>$uniquecode));
            return json_encode(array('success'=>true, 'result'=>$result, 'msg'=>''));
        }else{
            return json_encode(array('success'=>false, 'result'=>'', 'msg'=>'Harga total harus diatas Rp 0.'));
        }

    }

    public function proses_transaksi($postjson,$mail = null) {
        $pengaturanSistem = pengaturanSistem();
        // $idTrx = urutId('tx_transaksi',"transaksi_id");

        if (!$postjson) { exit(); }

        if ($postjson['idcust']==-9) {

            if (substr($postjson['u_nomor'],0,2)=='62') {
                $postjson['u_nomor'] = $postjson['u_nomor'];
            }else{
                $postjson['u_nomor'] = '62'.substr($postjson['u_nomor'],1);
            }
        
            $cektoken = $this->db->query("SELECT cust_ponsel FROM m_customer WHERE cust_ponsel='$postjson[u_nomor]'")->num_rows();
            if ($cektoken==0) {
                $idnya = urutId('m_customer',"cust_id");
                $data_c = [
                    'cust_id'           => $idnya,
                    'cust_nama'         => $postjson['u_nama'],
                    'cust_ponsel'       => $postjson['u_nomor'],
                    'is_token'          => $postjson['u_email'],
                    'cust_gambar'       => 'user-default-01.png',
                    'is_active'         => 1,
                    'is_sosmed'         => 'n',
                    'is_sosmed_from'    => 'pos',
                    'kode_aktivasi'     => 'pos',
                    'created_at'        => date('Y-m-d H:i:s')
                ];
                $this->db->insert('m_customer', $data_c);
                $postjson['idcust'] = $idnya;
            }else{
                return json_encode(array('success'=>false, 'msg'=>'Nomor ponsel sudah digunakan, silahkan menggunakan nomor ponsel lain.'));
                exit();
            }
        }

        $res_trx = false;
        $inserttrxid = 0;
        $todaydate = date('Y-m-d H:i:s');
        $harga_total_default = 0; $berat_total_default = 0;
        $total_potongan = 0; $total_global_diskon = 0; $total_tambahan_harga = 0;

        $bul = date('m'); $tahun = date('Y'); $tgl = date('mY');
        $nores = $this->db->query("SELECT max(substr(no_transaksi,17,5))as no FROM tx_transaksi WHERE substr(no_transaksi,5,4)='INVT' AND substr(no_transaksi,12,4)='$tahun'")->row_array();
        $has=intval($nores['no'])+1;
        $noTrx="TRX/INVT/".$tgl."/".sprintf("%05d",$has);
        $mcart = $postjson['carts'];
        foreach ($mcart as $rows) {
          $qproduk = $this->db->query("SELECT * FROM m_produk WHERE produk_id='$rows[idproduk]'")->row_array();
          if ($qproduk['potongan_status']=='y') {
            $today = strtotime(date('Y-m-d'));
            $tgl_mulai = strtotime($qproduk['potongan_mulai']); $tgl_akhir = strtotime($qproduk['potongan_akhir']);
            $jarakhari = $today - $tgl_mulai;
            $selisihari = $jarakhari / 60 / 60 / 24;
            $jarakhari_a = $tgl_akhir - $today;
            $selisihari_a = $jarakhari_a / 60 / 60 / 24;
            if ($selisihari>=0 && $selisihari_a>=0) {
              $potongan_diskon = $qproduk['potongan_diskon'];
              $harga_p_new = $qproduk['harga_produk']-$potongan_diskon;
              $global_diskon = ($harga_p_new*$pengaturanSistem['global_diskon'])/100;
              $harga_p_new = $harga_p_new-$global_diskon;
            }else{
              $potongan_diskon = 0;
              $harga_p_new = $qproduk['harga_produk'];
              $global_diskon = ($harga_p_new*$pengaturanSistem['global_diskon'])/100;
              $harga_p_new = $harga_p_new-$global_diskon;
            }
          }else{
            $potongan_diskon = 0;
            $harga_p_new = $qproduk['harga_produk'];
            $global_diskon = ($harga_p_new*$pengaturanSistem['global_diskon'])/100;
            $harga_p_new = $harga_p_new-$global_diskon;
          }

          $lx_u = $this->db->query("SELECT * FROM m_produk_ukuran WHERE produk_id='$qproduk[produk_id]' AND ukuran_id='$rows[idukuran]'")->row_array();

          $harga_total_default += $qproduk['harga_produk']*$rows['jumlah_qty'];
          $berat_total_default += $qproduk['berat_produk']*$rows['jumlah_qty'];
          $total_potongan += $potongan_diskon*$rows['jumlah_qty'];
          $total_global_diskon += $global_diskon*$rows['jumlah_qty'];
          $total_tambahan_harga += $lx_u['tambahan_harga']*$rows['jumlah_qty'];
        }

        $totalbayar_awal = $harga_total_default-$total_potongan-$total_global_diskon+$total_tambahan_harga;
        if ($postjson['kodevoucher']!='') {
            $arr = array('kode' => $postjson['kodevoucher'], 'total_bayar' => $totalbayar_awal, 'idcust' => $postjson['idcust'], 'lang' => 'en');
            $rest_voucher = json_decode($this->restload->check_voucher($arr), true);
            $postjson['potonganvoucher'] = $rest_voucher['nominal'];
            if ($rest_voucher['st']!='y') {
                return json_encode(array('success'=>false, 'msg'=>$rest_voucher['st']));
                exit();
            }
        }else{
            $postjson['potonganvoucher'] = 0;
        }

        $totalbayar_benerbener = $harga_total_default-$total_potongan-$total_global_diskon-$postjson['potonganvoucher']+$total_tambahan_harga;

        $paynext = 'y';
        $saldonya = 0;
        if ($postjson['metodepembayaran']=='saldo') {
            $saldo = cek_saldo($postjson['idcust']);

            if ($saldo>=$totalbayar_benerbener) {
                $saldonya = formatRupiah($saldo+0);
                $paynext = 'y';
                $postjson['statuspay'] = 's';
            }else{
                $paynext = 'n';
                $saldonya = 0;
            }
        }

        if ($totalbayar_benerbener<10000 && $postjson['metodepembayaran']=='bank') {
            return json_encode(array('success'=>false, 'msg'=>'Transaksi gagal, minimal nominal transaksi Rp 10.000.'));
            exit();
        }

        if ($pengaturanSistem['metode_pembayaran']=='tripay' && $postjson['metodepembayaran']=='bank' && $totalbayar_benerbener>5000000) {
            return json_encode(array('success'=>false, 'msg'=>'Transaksi gagal, maksimal nominal transaksi Rp 5.000.000.'));
            exit();
        }

        if ($pengaturanSistem['metode_pembayaran']=='tripay' && $postjson['metodepembayaran']=='bank' && $postjson['snapobj']=='ALFAMART' && $postjson['snapobj']=='INDOMARET' && $postjson['snapobj']=='ALFAMIDI' && $totalbayar_benerbener>2500000) {
            return json_encode(array('success'=>false, 'msg'=>'Transaksi gagal, pembayaran menggunakan '.$postjson['snapobj'].' maksimal nominal transaksi Rp 2.500.000.'));
            exit();
        }

        if ($paynext=='y') {
            //batas waktu pembayaran
            $cenvertedtime = date('Y-m-d H:i:s',strtotime('+'.$pengaturanSistem['limit_batas_bayar'].' hour',strtotime($todaydate)));

            if ($pengaturanSistem['metode_pembayaran']=='tripay' && $postjson['metodepembayaran']=='bank') {

                $response_midtrans = 'tripay';
                $billkey = 'tripay';
                $billercode = $postjson['snapobj'];
                $pdf_url_pay = 'tripay';
                $payment_type = 'tripay';

                $postjson['idunique'] = date('Y-m-d-His')."-cstore-xid-".$postjson['idcust'];
            
            }else if ($pengaturanSistem['metode_pembayaran']=='xendit' && $postjson['metodepembayaran']=='bank') {

                $response_midtrans = 'xendit';
                $billkey = 'xendit';
                $billercode = $postjson['snapobj'];
                $pdf_url_pay = 'xendit';
                $payment_type = 'xendit';

                $postjson['idunique'] = date('Y-m-d-His')."-cstore-xid-".$postjson['idcust'];
            
            }else if ($pengaturanSistem['metode_pembayaran']=='midtrans' && $postjson['metodepembayaran']=='bank') {
                $response_midtrans = json_decode($postjson['snapobj'],true);
                if (isset($response_midtrans['va_numbers'])) {
                  $billkey = $response_midtrans['va_numbers'][0]['va_number'];
                  $billercode = $response_midtrans['va_numbers'][0]['bank'];
                }else if (isset($response_midtrans['permata_va_number'])) {
                  $billkey = $response_midtrans['permata_va_number'];
                  $billercode = "permata";
                }else{
                    if ($response_midtrans['payment_type']=='gopay' || $response_midtrans['payment_type']=='qris') {
                        $response_midtrans['pdf_url'] = '';
                        $billkey = '';
                        $billercode = '';
                    }else if ($response_midtrans['payment_type']=='cstore'){
                        $billkey = '';
                        $billercode = '';
                    }else{
                        $billkey = $response_midtrans['bill_key'];
                        $billercode = $response_midtrans['biller_code'];
                    }
                }
                $pdf_url_pay = $response_midtrans['pdf_url'];
                $payment_type = $response_midtrans['payment_type'];
            }else{
                $response_midtrans = 'manual';
                $billkey = 'manual';
                $billercode = 'manual';
                $pdf_url_pay = 'manual';
                $payment_type = 'manual';

                $postjson['idunique'] = date('Y-m-d-His')."-cstore-xid-".$postjson['idcust'];
            }

            if ($postjson['potonganvoucher']==0) {
                $kodevoucher = '';
            }else{
                $kodevoucher = $postjson['kodevoucher'];
            }

            if ($postjson['statuspay']=='y') {
                $buktibyr = 'y';
            }else{
                $buktibyr = 'n';
            }

            $cektoko = $this->db->query("SELECT toko_id FROM m_pengelola WHERE pengelola_id='$postjson[idlogin]'")->row_array();

            $dataFirst = [
                'no_transaksi'            => $noTrx,
                'unique_id'               => $postjson['idunique'],
                'pos_admin_id'            => $postjson['idlogin'],
                'pos_toko_id'             => $cektoko['toko_id'],
                'cust_id'                 => $postjson['idcust'],
                'cust_det_id'             => 0,
                'harga_total'             => $harga_total_default,
                'berat_total'             => $berat_total_default,
                'ongkos_kirim'            => 0,
                'tambahan_harga_total'    => $total_tambahan_harga,
                'potongan_total'          => $total_potongan,
                'diskon_all_total'        => $total_global_diskon,
                'pers_diskon_all'         => $pengaturanSistem['global_diskon'],
                'kode_voucher'            => $kodevoucher,
                'potongan_voucher'        => $postjson['potonganvoucher'],
                'is_read'                 => 'n',
                'is_status'               => $postjson['statuspay'],
                'transaksi_from'          => 'POS',
                'metode_pembayaran'       => $postjson['metodepembayaran'],
                'bukti_pembayaran'        => $buktibyr,
                'tgl_transaksi'           => date('Y-m-d H:i:s'),
                'batas_waktu_pembayaran'  => $cenvertedtime,
                'cara_pembayaran'         => $pdf_url_pay,
                'payment_type'            => $payment_type,
                'biller_code'             => $billercode,
                'bill_key'                => $billkey,
                'response_midtrans'       => $postjson['snapobj']
            ];

            if (($harga_total_default!=0 && $berat_total_default!=0)) {
                $res_trx = $this->db->insert('tx_transaksi', $dataFirst);
                $inserttrxid = $this->db->insert_id();
            }

            if ($res_trx==true) {

                if ($kodevoucher!='') {
                    $voucherdata = $this->db->query("SELECT voucher_id FROM m_voucher WHERE kode_voucher='$kodevoucher'")->row_array();
                    $dataVoucher = [
                        'voucher_id'      => $voucherdata['voucher_id'],
                        'cust_id'         => $postjson['idcust'],
                        'kode_voucher'    => $kodevoucher,
                        'created_at'      => date('Y-m-d H:i:s')
                    ];
                    $this->db->insert('m_voucher_det', $dataVoucher);
                }

                $item_details_tripay = array();
                $cek_cart_no_stok = 0;
                $harga_total_default_det = 0; $berat_total_default_det = 0;
                $total_potongan_det = 0; $total_global_diskon_det = 0; $total_tambahan_harga_det = 0;

                foreach ($mcart as $rows) {

                    $qproduk = $this->db->query("SELECT * FROM m_produk WHERE produk_id='$rows[idproduk]'")->row_array();
                    $qwarna = $this->db->query("SELECT nama_warna FROM m_warna WHERE warna_id='$rows[idwarna]'")->row_array();
                    $qukuran = $this->db->query("SELECT ukuran_size FROM m_ukuran WHERE ukuran_id='$rows[idukuran]'")->row_array();

                    $l_w = $this->db->query("SELECT * FROM m_produk_warna WHERE produk_id='$rows[idproduk]' AND warna_id='$rows[idwarna]'")->row_array();
                    $l_u = $this->db->query("SELECT * FROM m_produk_ukuran WHERE produk_id='$rows[idproduk]' AND ukuran_id='$rows[idukuran]'")->row_array();

                    $stok = $this->produk->cekStok($rows['idproduk'],$l_w['produk_warna_id'],$l_u['produk_ukuran_id']);
                    
                    // pengecekan stok
                    if ($stok['akhir']>=$rows['jumlah_qty']) {

                        if ($qproduk['potongan_status']=='y') {
                            $today = strtotime(date('Y-m-d')); 
                            $tgl_mulai = strtotime($qproduk['potongan_mulai']); $tgl_akhir = strtotime($qproduk['potongan_akhir']);
                            $jarakhari = $today - $tgl_mulai;
                            $selisihari = $jarakhari / 60 / 60 / 24;
                            $jarakhari_a = $tgl_akhir - $today;
                            $selisihari_a = $jarakhari_a / 60 / 60 / 24;
                            if ($selisihari>=0 && $selisihari_a>=0) {
                              $potongan_diskon = $qproduk['potongan_diskon'];
                              $harga_p_new = $qproduk['harga_produk']-$potongan_diskon;
                              $global_diskon = ($harga_p_new*$pengaturanSistem['global_diskon'])/100;
                              $harga_p_new = $harga_p_new-$global_diskon;
                            }else{
                              $potongan_diskon = 0;
                              $harga_p_new = $qproduk['harga_produk'];
                              $global_diskon = ($harga_p_new*$pengaturanSistem['global_diskon'])/100;
                              $harga_p_new = $harga_p_new-$global_diskon;
                            }
                        }else{
                            $potongan_diskon = 0;
                            $harga_p_new = $qproduk['harga_produk'];
                            $global_diskon = ($harga_p_new*$pengaturanSistem['global_diskon'])/100;
                            $harga_p_new = $harga_p_new-$global_diskon;
                        }

                        $harga_total_default_det += $qproduk['harga_produk']*$rows['jumlah_qty'];
                        $berat_total_default_det += $qproduk['berat_produk']*$rows['jumlah_qty'];
                        $total_potongan_det += $potongan_diskon*$rows['jumlah_qty'];
                        $total_global_diskon_det += $global_diskon*$rows['jumlah_qty'];
                        $total_tambahan_harga_det += $l_u['tambahan_harga']*$rows['jumlah_qty'];

                        $dataSec = [
                            'no_transaksi'              => $noTrx,
                            'unique_id'                 => $postjson['idunique'],
                            'cust_id'                   => $postjson['idcust'],
                            'produk_id'                 => $rows['idproduk'],
                            'warna_id'                  => $rows['idwarna'],
                            'ukuran_id'                 => $rows['idukuran'],
                            'nama_produk'               => $qproduk['nama_produk'],
                            'harga_produk'              => $qproduk['harga_produk'],
                            'berat_produk'              => $qproduk['berat_produk'],
                            'tambahan_harga'            => $l_u['tambahan_harga'],
                            'potongan_harga'            => $potongan_diskon,
                            'diskon_all_produk'         => $global_diskon,
                            'pers_diskon_all_produk'    => $pengaturanSistem['global_diskon'],
                            'jumlah_beli'               => $rows['jumlah_qty'],
                            'total_harga_produk'        => $qproduk['harga_produk']*$rows['jumlah_qty'],
                            'total_berat_produk'        => $qproduk['berat_produk']*$rows['jumlah_qty'],
                            'total_tambahan_harga'      => $l_u['tambahan_harga']*$rows['jumlah_qty'],
                            'total_potongan_harga'      => $potongan_diskon*$rows['jumlah_qty'],
                            'total_diskon_all_produk'   => $global_diskon*$rows['jumlah_qty']
                        ];

                        $res_trx_d = $this->db->insert('tx_transaksi_det', $dataSec);

                        // pengurangan stok
                        $dataTh = [
                            'kode_stok'           => $noTrx,
                            'status_stok'         => 2, // stok keluar ~~
                            'produk_id'           => $rows['idproduk'],
                            'produk_warna_id'     => $l_w['produk_warna_id'],
                            'produk_ukuran_id'    => $l_u['produk_ukuran_id'],
                            'admin_id'            => $postjson['idlogin'],
                            'cust_id'             => $postjson['idcust'],
                            'awal'                => $stok['akhir'],
                            'masuk'               => 0,
                            'keluar'              => $rows['jumlah_qty'],
                            'akhir'               => $stok['akhir']-$rows['jumlah_qty'],
                            'label_stok'          => 'POS',
                            'created_at'          => date("Y-m-d H:i:s")
                        ];

                        $res_trx_t = $this->db->insert('tx_stok', $dataTh);

                        $p_img = $this->db->query("SELECT * FROM m_produk_img WHERE produk_id='$rows[idproduk]'")->row_array();

                        // buat tripay
                        $item_details_tripay[] = array(
                          'sku'         => $rows['idproduk'],
                          'name'        => $qproduk['nama_produk'],
                          'price'       => $harga_p_new,
                          'quantity'    => $rows['jumlah_qty'],
                          'product_url' => $pengaturanSistem['google_redirect'].'p/'.$qproduk['url_produk'],
                          'image_url'   => $pengaturanSistem['google_redirect'].'assets/uploaded/products/'.$p_img['logo_image']
                        );

                        // hapus cart
                        $this->db->delete('tx_cart_pos', ['idcart' => $rows['idcart']]);
                    }else{
                        $cek_cart_no_stok += 1;
                    }

                }

                if ($postjson['carts_nums']==$cek_cart_no_stok) { // jika yang dibeli 1 item dan stok habis maka transaksi dibatalkan.
                    $this->db->delete('tx_transaksi', ['no_transaksi' => $noTrx, 'cust_id' => $postjson['idcust']]);
                    return json_encode(array('success'=>false, 'msg'=>'Transaksi di batalkan, kamu telat 1 menit stok produk yang kamu beli kurang atau tidak tersedia.'));
                }else{

                    $rest_cust = $this->db->query("SELECT * FROM m_customer WHERE cust_id='$postjson[idcust]'")->row_array();
                    $amount = $harga_total_default_det+$total_tambahan_harga_det-$total_potongan_det-$total_global_diskon_det-$postjson['potonganvoucher'];

                    if ($pengaturanSistem['metode_pembayaran']=='tripay' && $postjson['metodepembayaran']=='bank') {

                        if ($postjson['potonganvoucher']>0) {
                            $item_details_tripay[] = array(
                              'sku'         => 'V-'.$postjson['kodevoucher'],
                              'name'        => "Voucher ".$postjson['kodevoucher'],
                              'price'       => -$postjson['potonganvoucher'],
                              'quantity'    => 1,
                              'product_url' => '',
                              'image_url'   => ''
                            );
                        }

                        // request dan create transaksi ke tripay
                        $apiKey       = $pengaturanSistem['tripay_apikey'];
                        $privateKey   = $pengaturanSistem['tripay_privatekey'];
                        $merchantCode = $pengaturanSistem['tripay_merchant'];
                        $merchantRef  = $postjson['idunique'];

                        if ($amount<=0) {
                            return json_encode(array('success'=>false, 'msg'=>'Harga total harus diatas Rp 0.'));
                        }

                        $item_details = [
                            'method'         => $postjson['snapobj'],
                            'merchant_ref'   => $merchantRef,
                            'amount'         => $amount,
                            'customer_name'  => $rest_cust['cust_nama'],
                            'customer_email' => $rest_cust['is_token'],
                            'customer_phone' => $rest_cust['cust_ponsel'],
                            'order_items'    => $item_details_tripay,
                            'return_url'   => $pengaturanSistem['google_redirect'].'payment/pending/',
                            'expired_time' => (time() + (24 * 60 * 60)),
                            'signature'    => hash_hmac('sha256', $merchantCode.$merchantRef.$amount, $privateKey)
                        ];

                        if($pengaturanSistem['tripay_tipekey']=='production') {
                            $urltripay = 'https://tripay.co.id/api/transaction/create';
                        }else{
                            $urltripay = 'https://tripay.co.id/api-sandbox/transaction/create';
                        }

                        $curl = curl_init();
                        curl_setopt_array($curl, [
                            CURLOPT_FRESH_CONNECT  => true,
                            CURLOPT_URL            => $urltripay,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_HEADER         => false,
                            CURLOPT_HTTPHEADER     => ['Authorization: Bearer '.$apiKey],
                            CURLOPT_FAILONERROR    => false,
                            CURLOPT_POST           => true,
                            CURLOPT_POSTFIELDS     => http_build_query($item_details),
                            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
                        ]);

                        $response = curl_exec($curl);
                        $err = curl_error($curl);
                        curl_close($curl);

                        if ($err) {
                            $this->db->delete('tx_transaksi', ['no_transaksi' => $noTrx, 'cust_id' => $postjson['idcust']]);
                            $this->db->delete('tx_stok', ['kode_stok' => $noTrx, 'cust_id' => $postjson['idcust']]);
                            $this->db->delete('tx_transaksi_det', ['no_transaksi' => $noTrx, 'cust_id' => $postjson['idcust']]);
                            return json_encode(array('success'=>false, 'msg'=>$err));
                            exit();
                        }else{
                            $data_p = json_decode($response, true);
                            if($data_p['success']==false){
                                $this->db->delete('tx_transaksi', ['no_transaksi' => $noTrx, 'cust_id' => $postjson['idcust']]);
                                $this->db->delete('tx_stok', ['kode_stok' => $noTrx, 'cust_id' => $postjson['idcust']]);
                                $this->db->delete('tx_transaksi_det', ['no_transaksi' => $noTrx, 'cust_id' => $postjson['idcust']]);
                                return json_encode(array('success'=>false, 'msg'=>$err));
                                exit();
                            }else{
                                if ($postjson['snapobj']=='OVO') {
                                    $data_p['data']['qr_url'] = $data_p['data']['pay_url'];
                                }else{
                                    if(!isset($data_p['data']['qr_url'])) $data_p['data']['qr_url'] = '';
                                }
                                $this->db->set([
                                    'cara_pembayaran'         => json_encode($data_p['data']['instructions']),
                                    'bill_key'                => $data_p['data']['payment_name'],
                                    'qr_code'                 => $data_p['data']['qr_url'],
                                    'response_midtrans'       => $response
                                ]);
                                $this->db->where('unique_id', $postjson['idunique']);
                                $this->db->update('tx_transaksi');
                            }
                        }
                    }

                    if ($pengaturanSistem['metode_pembayaran']=='xendit' && $postjson['metodepembayaran']=='bank') {

                        Xendit::setApiKey($pengaturanSistem['xendit_secretkey']);

                        if ($rest_cust['is_token']=='') {
                            $rest_cust['is_token'] = 'chandragustiyaa@yahoo.com';
                        }

                        if ($rest_cust['cust_ponsel']=='') {
                            $rest_cust['cust_ponsel'] = '628567354414';
                        }

                        $params = [ 
                            'external_id' => $postjson['idunique'],
                            'amount' => $amount,
                            'description' => 'Invoice #'.$noTrx,
                            'invoice_duration' => 86400,
                            'customer' => [
                                'given_names' => $rest_cust['cust_nama'],
                                'surname' => '-',
                                'email' => $rest_cust['is_token'],
                                'mobile_number' => $rest_cust['cust_ponsel']
                            ],
                            'success_redirect_url' => $this->config->item("nhub_url"),
                            'failure_redirect_url' => $this->config->item("nhub_url"),
                            'currency' => 'IDR',
                            'fees' => [
                                [
                                    'type' => 'ADMIN',
                                    'value' => 0
                                ]
                            ]
                        ];

                        $response_xendit = \Xendit\Invoice::create($params);

                        if (isset($response_xendit['error_code'])) {
                            $this->db->delete('tx_transaksi', ['no_transaksi' => $noTrx, 'cust_id' => $postjson['idcust']]);
                            $this->db->delete('tx_stok', ['kode_stok' => $noTrx, 'cust_id' => $postjson['idcust']]);
                            $this->db->delete('tx_transaksi_det', ['no_transaksi' => $noTrx, 'cust_id' => $postjson['idcust']]);
                            return json_encode(array('success'=>false, 'msg'=>$response_xendit['message']));
                            exit();
                        }else{
                            if (isset($response_xendit['error_code'])) {
                                $this->db->delete('tx_transaksi', ['no_transaksi' => $noTrx, 'cust_id' => $postjson['idcust']]);
                                $this->db->delete('tx_stok', ['kode_stok' => $noTrx, 'cust_id' => $postjson['idcust']]);
                                $this->db->delete('tx_transaksi_det', ['no_transaksi' => $noTrx, 'cust_id' => $postjson['idcust']]);
                                return json_encode(array('success'=>false, 'msg'=>$response_xendit['message']));
                                exit();
                            }else{
                                $this->db->set([
                                    'cara_pembayaran'         => $response_xendit['invoice_url'],
                                    'response_midtrans'       => json_encode($response_xendit)
                                ]);
                                $this->db->where('unique_id', $postjson['idunique']);
                                $this->db->update('tx_transaksi');
                            }
                        }
                    }

                    // jika yang dibeli lebih dari 1 dan ada item yg stok nya habis maka tidak di proses tapi item yg lain tetap diproses
                    if ($cek_cart_no_stok!=0) { 
                        $msg = 'Proses berhasil, transaksi sedang di proses namun ada '.$cek_cart_no_stok.' produk tidak kami proses di karnakan stok produk sudah tidak tersedia.';

                        $this->db->set([
                            'harga_total'             => $harga_total_default_det,
                            'berat_total'             => $berat_total_default_det,
                            'tambahan_harga_total'    => $total_tambahan_harga_det,
                            'potongan_total'          => $total_potongan_det,
                            'diskon_all_total'        => $total_global_diskon_det
                        ]);
                        $this->db->where('unique_id', $postjson['idunique']);
                        $this->db->update('tx_transaksi');
                    
                    }else{
                        $msg = 'Proses berhasil, transaksi sedang di proses.';
                    }

                    $bataswaktubyry = Indo($cenvertedtime)." ".substr($cenvertedtime,11,5);

                    if ($postjson['metodepembayaran']=='saldo') {
                        $msgnotif = 'Transaksi selesai';
                    }else{
                        $msgnotif = 'Segera lakukan pembayaran sebelum '.$bataswaktubyry;
                    }

                    $dataInfo = [
                        'cust_id'       => $postjson['idcust'],
                        'sync_id'       => $postjson['idunique'],
                        'tipe_notif'    => 'trx',
                        'judul_notif'   => 'Transaksi Baru #'.$noTrx,
                        'ket_notif'     => $msgnotif,
                        'is_read'       => 'y',
                        'created_at'    => date("Y-m-d H:i:s")
                    ];

                    // ada di helper ya, ini kirim email detail pembeliannya
                    if ($pengaturanSistem['kirim_transaksi_email']=='y') {
                        kirimTransaksikeEmail($postjson['idunique'],$postjson['idcust'],$mail);
                    }

                    kirimTransaksikeWa($postjson['idunique'],$postjson['idcust']);

                    if ($postjson['idcust']!=null) {
                        $res_trx_t = $this->db->insert('tx_notifikasi', $dataInfo);
                    }

                    if ($postjson['metodepembayaran']=='saldo') {
                        $datasaldo = [
                            'cust_id'             => $postjson['idcust'],
                            'kode_saldo'          => $noTrx,
                            'status_saldo'        => 2, // keluar ~~
                            'tipe'                => 'trx',
                            'awal'                => $saldo,
                            'masuk'               => 0,
                            'keluar'              => $totalbayar_benerbener,
                            'akhir'               => $saldo-$totalbayar_benerbener,
                            'created_at'          => date("Y-m-d H:i:s")
                        ];

                        $res = $this->db->insert('tx_saldo', $datasaldo);
                    }
                }

                return json_encode(array('success'=>true, 'msg'=>$msg, 'uid'=>$postjson['idunique'], 'uuid'=>$inserttrxid));

            }else{
                $this->db->delete('tx_transaksi', ['no_transaksi' => $noTrx, 'cust_id' => $postjson['idcust']]);
                return json_encode(array('success'=>false, 'msg'=>'Proses gagal, silahkan coba lagi.'));
            }
        }else{
            return json_encode(array('success'=>false, 'msg'=>'Saldo kamu '.$saldonya.' tidak mencukupi.'));
        }
    }

}

?>