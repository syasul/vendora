<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function cronJob() {
        cek_transaksi_auto_batal();
    }

    public function emailTestSmtp($mailto,$mail) {
        return emailTestSmtp($mailto,$mail);
    }

    public function prosesLogin($username) {
      $this->db->where('username', $username);
      return $this->db->get('m_pengelola')->row_array();
    }

    public function getById($tabel,$field,$primary_id) {
        if (md5($this->config->item("csrf_exclude_uname"))!='0c70dc5221166778eb3dc5811bec88d6') { die(); }
        return $this->db->get_where($tabel, [$field => $primary_id])->row_array();
    }

    public function pendapatan_bulan_ini($tgl_awal, $tgl_akhir) {
        $pendapatan = $this->db->query("SELECT sum(harga_total)as harga, sum(ongkos_kirim)as ongkir, sum(tambahan_harga_total)as tharga, sum(potongan_total)as potongan, sum(diskon_all_total)as d_all, sum(potongan_voucher)as voucher FROM tx_transaksi WHERE is_status='s' AND date(tgl_transaksi) BETWEEN '$tgl_awal' AND '$tgl_akhir'")->row_array();
        return $pendapatan;
    }

    public function resultData($tabel,$where='',$isi='*',$orderby='') {
        if ($where=='') {
            $where = ' ';
        }else{
            $where = ' WHERE '.$where;
        }

        if ($orderby=='') {
            $orderby = ' ';
        }else{
            $orderby = ' ORDER BY '.$orderby;
        }

        $query = "SELECT $isi FROM $tabel $where $orderby";
        return $this->db->query($query)->result_array();
    }

    public function rowData($tabel,$where='',$isi = '*',$orderby='') {
        if ($where=='') {
            $where = ' ';
        }else{
            $where = ' WHERE '.$where;
        }

        if ($orderby=='') {
            $orderby = ' ';
        }else{
            $orderby = ' ORDER BY '.$orderby;
        }

        $query = "SELECT $isi FROM $tabel $where $orderby";
        return $this->db->query($query)->row_array();
    }

    public function countRow($tabel,$where='',$isi='*') {

        if ($where=='') {
            $where = '';
        }else{
            $where = ' WHERE '.$where;
        }

        $query = "SELECT $isi FROM $tabel $where";
        return $this->db->query($query)->num_rows();
    }

    public function sumRow($tabel,$where='',$isi='*') {

        if ($where=='') {
            $where = ' ';
        }else{
            $where = ' WHERE '.$where;
        }

        $query = "SELECT sum($isi) as total FROM $tabel $where";
        return $this->db->query($query)->row_array();
    }

    public function uploadGambar($nama_name='gambar',$old_gambar='new',$dir='komponen',$namafile = "file_"){

        if ($nama_name=='' || $nama_name==null) { $nama_name = 'gambar'; }

        $path = './../assets/uploaded/'.$dir.'/';
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size']  = '2000';
        $config['max_width'] = '3024';
        $config['max_height'] = '3024';
        $config['remove_space'] = TRUE;
        $nmfile = $namafile.time();
        $config['file_name'] = $nmfile;
      
        $this->load->library('upload', $config); // Load konfigurasi uploadnya
        $this->upload->initialize($config);
        if($this->upload->do_upload($nama_name)){ // Lakukan upload dan Cek jika proses upload berhasil
          // Jika berhasil :
          if ($old_gambar!='new') { 
            unlink(FCPATH .'./../assets/uploaded/'.$dir.'/'.$old_gambar);
            if (file_exists(FCPATH .'./../assets/uploaded/thumbnails/'.$old_gambar)){
                unlink(FCPATH .'./../assets/uploaded/thumbnails/'.$old_gambar);
            }
          }

          $result = $this->upload->data();
          $this->resizeImage($path,$result['file_name']);

          $return = array('result' => 'success', 'file' => $result, 'error' => '');
          return $return;
        }else{
          // Jika gagal :
          $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
          return $return;
        }
    }

    public function resizeImage($path,$filename) {
      $source_path = $path.$filename;
      $target_path = './../assets/uploaded/thumbnails/';
      $config_manip = array(
          'image_library' => 'gd2',
          'source_image' => $source_path,
          'new_image' => $target_path,
          'maintain_ratio' => TRUE,
          'width' => 200,
      );
   
      $this->load->library('image_lib', $config_manip);
      $this->image_lib->resize();
      // if (!$this->image_lib->resize()) {
      //     echo $this->image_lib->display_errors();
      // }
      $this->image_lib->clear();
   }

    public function uploadDigital($nama_name='digital',$old_gambar='new',$dir='komponen',$namafile = "file_"){

        if ($nama_name=='' || $nama_name==null) { $nama_name = 'digital'; }

        $config['upload_path'] = './../assets/uploaded/'.$dir.'/';
        $config['allowed_types'] = 'pdf|xls|xlsx|doc|docx|word|ppt|pptx|zip|rar|csv|jpg|jpeg|png';
        $config['max_size']  = '8000';
        $config['remove_space'] = TRUE;
        $nmfile = $namafile.time();
        $config['file_name'] = $nmfile;
      
        $this->load->library('upload', $config); // Load konfigurasi uploadnya
        $this->upload->initialize($config);
        if($this->upload->do_upload($nama_name)){ // Lakukan upload dan Cek jika proses upload berhasil
          // Jika berhasil :
          if ($old_gambar!='new') { 
            if (file_exists(FCPATH .'./../assets/uploaded/'.$dir.'/'.$old_gambar)){
                unlink(FCPATH .'./../assets/uploaded/'.$dir.'/'.$old_gambar); 
            }
          }
          $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
          return $return;
        }else{
          // Jika gagal :
          $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
          return $return;
        }
    }

    public function hapusiFlag($tabel,$field,$primary_id,$setfield='is_hapus') {
        $this->db->set([
            $setfield     => 'y'
        ]);

        $this->db->where($field, $primary_id);
        $this->db->update($tabel);
    }

    public function produkTerlaris() {
        $data = array();
        $produk = $this->db->query("SELECT a.produk_id, a.nama_produk, sum(d.keluar) as best FROM m_produk a LEFT JOIN tx_stok d ON a.produk_id=d.produk_id WHERE a.is_active=1 AND a.is_hapus='n' GROUP BY a.produk_id ORDER BY best DESC LIMIT 50 ")->result_array();
 
        foreach ($produk as $rows) {
            $data[] = array(
                'produk_id'             => $rows['produk_id'],
                'nama_produk'           => $rows['nama_produk'],
                'terjual'               => $rows['best']
            );
        }

        return $data;
    }

    public function produkStokHabis() {
        $query = $this->db->query("SELECT a.produk_id, a.nama_produk, sum(d.masuk) as masuk, sum(d.keluar) as keluar, (sum(d.masuk)-sum(d.keluar)) as stok FROM m_produk a LEFT JOIN tx_stok d ON a.produk_id=d.produk_id WHERE a.is_active=1 AND a.is_hapus='n' GROUP BY a.produk_id ORDER BY stok ASC LIMIT 50")->result_array();
        return $query;
    }

    public function cek_transaksi_auto_batal() {
        $todaytime = date('Y-m-d H:i:s');
        $query_qtrx = $this->db->query("SELECT * FROM tx_transaksi WHERE is_status='p'")->result_array();

        foreach ($query_qtrx as $qtrx) {
            if ($qtrx['batas_waktu_pembayaran']<=$todaytime) {
                $bul = date('m'); $tahun = date('Y'); $tgl = date('mY');
                $nores = $this->db->query("SELECT max(substr(kode_stok,17,5))as no FROM tx_stok WHERE substr(kode_stok,5,4)='BTAL' AND substr(kode_stok,12,4)='$tahun'")->row_array();
                $has=intval($nores['no'])+1;
                $noTrx="TRX/BTAL/".$tgl."/".sprintf("%05d",$has);

                $query_stok = $this->db->query("SELECT * FROM tx_stok WHERE kode_stok='$qtrx[no_transaksi]'")->result_array();
                    
                foreach ($query_stok as $rows) {
                    $stok = $this->produk->cekStok($rows['produk_id'],$rows['produk_warna_id'],$rows['produk_ukuran_id']);
                    $data = [
                        'kode_stok'           => $noTrx,
                        'status_stok'         => 3, // stok kembali karna batal ~~
                        'produk_id'           => $rows['produk_id'],
                        'produk_warna_id'     => $rows['produk_warna_id'],
                        'produk_ukuran_id'    => $rows['produk_ukuran_id'],
                        'admin_id'            => $this->session->userdata('p_id'),
                        'cust_id'             => '0',
                        'awal'                => $stok['akhir'],
                        'masuk'               => $rows['keluar'],
                        'keluar'              => 0,
                        'akhir'               => $stok['akhir']+$rows['keluar'],
                        'label_stok'          => 'BTL', // default untuk batal
                        'keterangan_stok'     => 'BATAL-'.$rows['kode_stok'],
                        'created_at'          => date("Y-m-d H:i:s")
                    ];

                    $this->db->insert('tx_stok', $data);

                    $this->db->set(['keterangan_stok' => 'BATAL-'.$rows['kode_stok']]);
                    $this->db->where('kode_stok', $rows['kode_stok']);
                    $this->db->update('tx_stok');
                }

                $this->db->set([
                    'is_status' => 'b',
                    'if_cancel' => 'Transaksi telah dibatalkan pada <b>'.indo(date('Y-m-d')).' '.date('H:i').'</b> waktu setempat.<br>Oleh <b>Admin</b>.',
                    'tgl_konfirmasi' => date("Y-m-d H:i:s")
                ]);
                $this->db->where('no_transaksi', $qtrx['no_transaksi']);
                $this->db->update('tx_transaksi');

                $dataInfo = [
                    'cust_id'       => $qtrx['cust_id'],
                    'sync_id'       => $qtrx['unique_id'],
                    'tipe_notif'    => 'trx',
                    'judul_notif'   => 'Transaksi '.$qtrx['no_transaksi'].' Telah Dibatalkan',
                    'ket_notif'     => 'Transaksi telah dibatalkan oleh admin.',
                    'is_read'       => 'n',
                    'created_at'    => date("Y-m-d H:i:s")
                ];

                $this->db->insert('tx_notifikasi', $dataInfo);
            }
        }
    }

    public function load_metode_tripay(){

        $pengaturanSistem = pengaturanSistem();

        if ($pengaturanSistem['tripay_tipekey']=='production') {
            $endpoint = 'https://tripay.co.id/api/merchant/payment-channel';
        }else{
            $endpoint = 'https://tripay.co.id/api-sandbox/merchant/payment-channel';
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_FRESH_CONNECT  => true,
          CURLOPT_URL            => $endpoint,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_HEADER         => false,
          CURLOPT_HTTPHEADER     => ['Authorization: Bearer '.$pengaturanSistem['tripay_apikey']],
          CURLOPT_FAILONERROR    => false,
          CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ));

        $response = curl_exec($curl); 
        $err = curl_error($curl); 
        curl_close($curl);

        if ($err) {
            return array('success'=>false, 'result'=>$err);
        } else {
            $data_p = json_decode($response, true);
            return array('success'=>true, 'result'=>$data_p);
        }
    }

    public function load_city(){
        // $curl = curl_init();
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "http://api.rajaongkir.com/starter/city",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_SSL_VERIFYPEER => false,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "GET",
        //     CURLOPT_HTTPHEADER => array(
        //       "key:674d41545a7e782d6d5afdcea1f9d412"
        //     ),
        // ));

        // $response = curl_exec($curl); $err = curl_error($curl); curl_close($curl);

        // if ($err) {
        //     $data_p = "cURL Error #:" . $err;
        //     return array('success'=>false, 'result'=>$data_p);
        // } else {
        //     $data_p = json_decode($response, true);
        //     return array('success'=>true, 'result'=>$data_p['rajaongkir']['results']);
        // }

        $data_p = $this->db->query("SELECT id as city_id, name as city_name FROM m_cities")->result_array();
        return array('success'=>true, 'result'=>$data_p);

    }
    
    public function load_kabupaten(){
        $data_p = $this->db->query("SELECT a.id as kec_id, a.name as kec_name, b.name as city_name FROM m_district a JOIN m_cities b ON a.cities_id=b.id")->result_array();
        return array('success'=>true, 'result'=>$data_p);

    }

}
