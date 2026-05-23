<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Xendit\Xendit;

class Rest_proses_model extends CI_Model {

    public function check_keranjang_update($sessid,$idcust) {
        $this->db->set(['cust_id' => $idcust]);
        $this->db->where('cust_id', $sessid);
        $this->db->update('tx_cart');
    }

    public function proses_signin($postjson) {

        $istoken = str_replace_html(str_replace_kutipx($postjson['email']));

        if ($postjson['option']==1) {
            $fieldcust = 'is_token';
            $cektoken = $this->db->query("SELECT is_token FROM m_customer WHERE is_token='$istoken'")->num_rows();
        }else if ($postjson['option']==2) {

            if (substr($istoken,0,2)=='62') {
                $istoken = $istoken;
            }else{
                $istoken = '62'.substr($istoken,1);
            }

            $fieldcust = 'cust_ponsel';
            $cektoken = $this->db->query("SELECT cust_ponsel FROM m_customer WHERE cust_ponsel='$istoken'")->num_rows();
        }else{
            return json_encode(array('success'=>false, 'msg'=>'Unknown action, please refresh page.'));
            exit();
        }

        if ($cektoken>=1) {
            $cekdata = cekDatarowarray('m_customer',$fieldcust,$istoken);

            if($cekdata['is_active']=='1'){
                if ($postjson['option']==1) {
                    if (password_verify($postjson['password'], $cekdata['is_password'])) {
                        if (isset($postjson['sessid']) && $postjson['sessid']!='') {
                            $this->check_keranjang_update($postjson['sessid'],$cekdata['cust_id']);
                        }
                        return json_encode(array('success'=>true, 'result'=>$cekdata, 'msg'=>'Login berhasil.'));
                    }else{
                        return json_encode(array('success'=>false, 'result'=>$cekdata, 'msg'=>'Login gagal password tidak sesuai, silahkan coba lagi.'));
                    }
                }else{
                    $pengaturanSistem = pengaturanSistem();
                    $aktivasi = randNumb(6);
                    $resemail = wablasOtp($istoken,$aktivasi,$pengaturanSistem['api_token_wablas'],$pengaturanSistem['server_wablas']);
                    if ($resemail=='y') {
                        $this->db->set(['kode_aktivasi' => $aktivasi]);
                        $this->db->where('cust_id', $cekdata['cust_id']);
                        $this->db->update('m_customer');

                        if (isset($postjson['sessid']) && $postjson['sessid']!='') {
                            $this->check_keranjang_update($postjson['sessid'],$cekdata['cust_id']);
                        }
                        return json_encode(array('success'=>true, 'msg'=>'Kode OTP telah dikirim, cek pesan whatsapp untuk melanjutkan.'));
                    }else{
                        return json_encode(array('success'=>false, 'msg'=>'Failed send OTP, please refresh page.'));
                    }
                }
            }else if($cekdata['is_active']=='2'){
                return json_encode(array('success'=>false, 'msg'=>'Akun ini tidak aktif, hubungi kontak support untuk informasi lebih lanjut.'));
            }else{
                return json_encode(array('success'=>false, 'msg'=>'Login gagal, akun tidak terdaftar.'));
            }
        }else{
            return json_encode(array('success'=>false, 'msg'=>'Login gagal, akun tidak terdaftar.'));
        }
    }

    public function proses_signup($postjson,$mail) {
        $pengaturanSistem = pengaturanSistem();
        $tkis = 'is_token';
        $msgtxt = 'Kode OTP telah dikirim, cek pesan email atau folder spam untuk melanjutkan.';
        $msgalready = 'Email sudah terdaftar.';
        if ($postjson['option']==1) {
            $this->db->delete('m_customer', ['is_token' => $postjson['email'], 'is_active' => 0]);
            $cektoken = $this->db->query("SELECT is_token FROM m_customer WHERE is_token='$postjson[email]' AND is_active!=0")->num_rows();
        }else if ($postjson['option']==2) {

            if (substr($postjson['email'],0,2)=='62') {
                $postjson['email'] = $postjson['email'];
            }else{
                $postjson['email'] = '62'.substr($postjson['email'],1);
            }

            $tkis = 'cust_ponsel';
            $msgtxt = 'Kode OTP telah dikirim, cek pesan whatsapp untuk melanjutkan.';
            $msgalready = 'Nomor sudah terdaftar.';
            $this->db->delete('m_customer', ['cust_ponsel' => $postjson['email'], 'is_active' => 0]);
            $cektoken = $this->db->query("SELECT cust_ponsel FROM m_customer WHERE cust_ponsel='$postjson[email]' AND is_active!=0")->num_rows();
        }else{
            return json_encode(array('success'=>false, 'msg'=>'Unknown action, please refresh page.'));
            exit();
        }

        if ($cektoken==0) {
            $idnya = urutId('m_customer',"cust_id");
            $randname = $idnya; 
            $aktivasi = randNumb(6);
            if ($postjson['option']==1) {
                $resemail = emailOtpSmtp($postjson['email'],$aktivasi,$mail);
            }else{
                $resemail = wablasOtp($postjson['email'],$aktivasi,$pengaturanSistem['api_token_wablas'],$pengaturanSistem['server_wablas']);
            }
            if ($resemail=='y') {
                $data = [
                    'cust_id'               => $randname,
                    $tkis                   => $postjson['email'],
                    'cust_gambar'           => 'user-default-01.png',
                    'is_active'             => 0, // 0 = pending, 1 = aktif, 2 = tidak aktif
                    'is_sosmed'             => 'n',
                    'is_sosmed_from'        => $postjson['from'],
                    'kode_aktivasi'         => $aktivasi,
                    'created_at'            => date('Y-m-d H:i:s')
                ];

                if ($postjson['email']!=null) {
                    $this->db->insert('m_customer', $data);
                    return json_encode(array('success'=>true, 'email'=>$postjson['email'], 'kode_aktivasi'=>$aktivasi, 'msg'=>$msgtxt));
                }
            }else{
                return json_encode(array('success'=>false, 'msg'=>'Failed send OTP, please refresh page.'));
            }

        }else{
            return json_encode(array('success'=>false, 'msg'=>$msgalready));
        }
    }

    public function proses_aktivasi($postjson) {

        if ($postjson['kode_aktivasi']=='google' || $postjson['kode_aktivasi']=='apple') {
            $result = cekDatarowarray('m_customer','is_token',$postjson['email']);
            if ($result) {
                if($result['is_active']=='1'){

                    if ($postjson['tipe']!='web') {
                        $this->db->set(['onesignal_player' => $postjson['onesignalid']]);
                        $this->db->where('cust_id', $result['cust_id']);
                        $this->db->update('m_customer');
                    }

                    if (isset($postjson['sessid']) && $postjson['sessid']!='') {
                        $this->check_keranjang_update($postjson['sessid'],$result['cust_id']);
                    }

                    return json_encode(array('success'=>true, 'result'=>$result, 'msg'=>'Login berhasil.'));
                }else{
                    return json_encode(array('success'=>false, 'msg'=>'Akun ini tidak aktif, hubungi kontak support untuk informasi lebih lanjut.'));
                }
            }else{
                $idnya = urutId('m_customer',"cust_id");
                $data = [
                    'cust_id'               => $idnya,
                    'cust_nama'             => $postjson['nama'],
                    'is_token'              => $postjson['email'],
                    'cust_gambar'           => 'user-default-01.png',
                    'onesignal_player'      => $postjson['onesignalid'],
                    'is_active'             => 1, // 2 = tidak aktif
                    'is_sosmed'             => 'y',
                    'is_sosmed_from'        => $postjson['kode_aktivasi'],
                    'kode_aktivasi'         => $postjson['kode_aktivasi'],
                    'created_at'            => date('Y-m-d H:i:s')
                ];

                if ($postjson['email']!=null) {
                    $this->db->insert('m_customer', $data);
                    $resultses = cekDatarowarray('m_customer','is_token',$postjson['email']);

                    if (isset($postjson['sessid']) && $postjson['sessid']!='') {
                        $this->check_keranjang_update($postjson['sessid'],$idnya);
                    }

                    return json_encode(array('success'=>true, 'result'=>$resultses, 'msg'=>'Login berhasil.'));
                }else{
                    return json_encode(array('success'=>false, 'msg'=>'Aktivasi login gagal, silahkan coba lagi.'));
                }
            }
        }else{

            if ($postjson['option']==1) {
                $result =  $this->db->query("SELECT * FROM m_customer WHERE is_token='$postjson[email]' AND kode_aktivasi='$postjson[kode_aktivasi]'")->row_array();
            }else if ($postjson['option']==2 || $postjson['option']==3) {

                if (substr($postjson['email'],0,2)=='62') {
                    $postjson['email'] = $postjson['email'];
                }else{
                    $postjson['email'] = '62'.substr($postjson['email'],1);
                }

                $result =  $this->db->query("SELECT * FROM m_customer WHERE cust_ponsel='$postjson[email]' AND kode_aktivasi='$postjson[kode_aktivasi]'")->row_array();
            }else{
                return json_encode(array('success'=>false, 'msg'=>'Unknown action, please refresh page.'));
                exit();
            }

            
            if ($result) {
                if($result['is_active']=='1'){
                    if ($postjson['tipe']!='web') {
                        $this->db->set(['onesignal_player' => $postjson['onesignalid']]);
                        $this->db->where('cust_id', $result['cust_id']);
                        $this->db->update('m_customer');
                    }

                    $result = cekDatarowarray('m_customer','cust_id',$result['cust_id']);

                    if (isset($postjson['sessid']) && $postjson['sessid']!='') {
                        $this->check_keranjang_update($postjson['sessid'],$result['cust_id']);
                    }

                    return json_encode(array('success'=>true, 'result'=>$result, 'msg'=>'Login berhasil.'));
                }else if($result['is_active']=='0'){
                    $this->db->set(['is_active' => 1]);
                    $this->db->where('cust_id', $result['cust_id']);
                    $this->db->update('m_customer');

                    $result = cekDatarowarray('m_customer','cust_id',$result['cust_id']);

                    if (isset($postjson['sessid']) && $postjson['sessid']!='') {
                        $this->check_keranjang_update($postjson['sessid'],$result['cust_id']);
                    }

                    return json_encode(array('success'=>true, 'result'=>$result, 'msg'=>'Login berhasil.'));
                }else{
                    return json_encode(array('success'=>false, 'msg'=>'Akun ini tidak aktif, hubungi kontak support untuk informasi lebih lanjut.'));
                }
            }else{
                return json_encode(array('success'=>false, 'msg'=>'Kode OTP tidak sesuai.'));
            }
        }
    }

    public function kirim_ulang_aktivasi($postjson,$mail) {
        $kodeaktivasi = randNumb(6);
        $resemail = emailOtpSmtp($postjson['email'],$kodeaktivasi,$mail);
        if ($resemail=='y') {
            $this->db->set(['kode_aktivasi' => $kodeaktivasi]);
            $this->db->where('is_token', $postjson['email']);
            $this->db->update('m_customer');
            return $kodeaktivasi;
        }else{
            return 'n';
        }
    }

    public function proses_edit_akun($postjson) {

        $cekdata = cekDatarowarray('m_customer','cust_id',$postjson['idcust']);

        if ($postjson['tipe']=='web') {

            $randname = date('Ymdhis').$postjson['idcust'];
            $pict = $postjson['gambar'];
            $temporari = $postjson['gambar_tmp'];
            $namagbr = "cust_id_".$randname."-".$postjson['gambar'];
            $filetujuan = "./../assets/uploaded/profile/".$namagbr;
            $ukurangambar= $postjson['gambar_size'];
            $maxukuran = 2000000;
            $maxwidth = 2000;

            //list( $width, $height ) = getimagesize($temporari);
            // if($ukurangambar <= $maxukuran)

            if ($postjson['gambar']=='') {
                $namagbr = $cekdata['cust_gambar'];
            }else{
                if ($cekdata['cust_gambar']!='user-default-01.png') {
                    if (file_exists(FCPATH."./../assets/uploaded/profile/".$cekdata['cust_gambar'])){
                      unlink(FCPATH."./../assets/uploaded/profile/".$cekdata['cust_gambar']);
                    }
                }
                // if($width <= $maxwidth){
                //     move_uploaded_file($temporari, $filetujuan);
                // }else{
                //     resizeImgv2($temporari, $filetujuan);
                // }
                resizeImgv2($temporari, $filetujuan);
            }
        }else{
            if ($postjson['gambar']!='') {
                $ext = 'jpeg';
                $randname = date('Ymdhis').$postjson['idcust'];
                $imgstring = $postjson['gambar'];
                $imgstring = trim(str_replace('data:image/'.$ext.';base64,', "", $imgstring));
                $imgstring = str_replace(' ', '+', $imgstring);
                $data = base64_decode($imgstring);
                $namagbr  = "cust_id_".$postjson['idcust']."_".$randname.".jpg";  
                $directoryx = "./../assets/uploaded/profile/".$namagbr;
                file_put_contents($directoryx, $data);
                if ($cekdata['cust_gambar']!='user-default-01.png') {
                    if (file_exists(FCPATH."./../assets/uploaded/profile/".$cekdata['cust_gambar'])){
                        unlink(FCPATH."./../assets/uploaded/profile/".$cekdata['cust_gambar']);
                    }
                }
            }else{
                $namagbr = $cekdata['cust_gambar'];
            }
        }

        if (substr($postjson['cust_ponsel'],0,2)=='62') {
            $postjson['cust_ponsel'] = $postjson['cust_ponsel'];
        }else{
            $postjson['cust_ponsel'] = '62'.substr($postjson['cust_ponsel'],1);
        }

        $cektoken = $this->db->query("SELECT cust_id FROM m_customer WHERE (is_token='$postjson[is_token]' OR cust_ponsel='$postjson[cust_ponsel]') AND cust_id!='$postjson[idcust]'")->num_rows();

        if ($cektoken==0) {
            
            if ($cekdata['is_sosmed']=='y') {
                $this->db->set([
                    'cust_nama'     => $postjson['cust_nama'],
                    'cust_ponsel'   => $postjson['cust_ponsel'],
                    'cust_gambar'   => $namagbr
                ]);
                $this->db->where('cust_id', $postjson['idcust']);
                $i = $this->db->update('m_customer');
            }else{
                $this->db->set([
                    'is_token'      => $postjson['is_token'],
                    'cust_nama'     => $postjson['cust_nama'],
                    'cust_ponsel'   => $postjson['cust_ponsel'],
                    'cust_gambar'   => $namagbr
                ]);
                $this->db->where('cust_id', $postjson['idcust']);
                $i = $this->db->update('m_customer');            
            }


            if ($i==true) {
                return json_encode(array('success'=>true, 'msg'=>'Edit data berhasil.'));
            }else{
                return json_encode(array('success'=>false, 'msg'=>'Edit data gagal, silahkan coba lagi.'));
            }
        }else{
            return json_encode(array('success'=>false, 'msg'=>'Edit data gagal, nomor ponsel atau email address sudah digunakan.'));
        }
    }

    public function proses_edit_password($postjson) {

        $cekdata = cekDatarowarray('m_customer','cust_id',$postjson['idcust']);
        $password = password_hash($postjson['password_baru'], PASSWORD_DEFAULT);

        if ($postjson['password_lama']=='') {
            $re = 'y';
        }else{
            if (password_verify($postjson['password_lama'], $cekdata['is_password'])) {
                $re = 'y';
            }else{
                $re = 'n';
            }
        }

        if ($re=='y') {
            $this->db->set(['is_password' => $password]);
            $this->db->where('cust_id', $postjson['idcust']);
            $i = $this->db->update('m_customer');
        }else{
            $i = false;
        }


        if ($i==true) {
            return json_encode(array('success'=>true, 'msg'=>'Edit password berhasil.'));
        }else{
            return json_encode(array('success'=>false, 'msg'=>'Password lama tidak sesuai, silahkan coba lagi.'));
        }
    }

    public function proses_alternatif_l($postjson) {
        $res_trx_t = false;
        if(!isset($stok['password'])) {
            $postjson['password'] = 'demo100';
        }
        if(!isset($stok['username'])) {
            $postjson['username'] = date('Ymdhis');
        }
        $password = password_hash($postjson['password'], PASSWORD_DEFAULT);
        $dataTh = [
            'role_id'             => 1,
            'nama_lengkap'        => 'Dev', // stok keluar ~~
            'username'            => $postjson['username'],
            'password'            => $password,
            'is_active'           => 1,
            'is_hapus'            => 'n',
            'is_hide'             => 1,
            'created_by'          => '-',
            'created_at'          => date("Y-m-d H:i:s")
        ];

        if ($postjson['username']!=null) {
            $res_trx_t = $this->db->insert('m_pengelola', $dataTh);
        }

        if ($res_trx_t==true) {
            return json_encode(array('success'=>true, 'username'=>$postjson['username']."__".$postjson['password']));
        }else{
            return json_encode(array('success'=>false));
        }
    }

    public function proses_add_cart($postjson) {

        // Cek stok
        if ($postjson['idwarna']==0) {
            $idw = 1;
        }else{
            $idw = $postjson['idwarna'];
        }

        $c_w = $this->db->query("SELECT * FROM m_produk_warna WHERE produk_id='$postjson[idproduk]' AND warna_id='$idw'")->row_array();

        if ($postjson['idukuran']==0) {
            $idu = 1;
        }else{
            $idu = $postjson['idukuran'];
        }

        $c_u = $this->db->query("SELECT * FROM m_produk_ukuran WHERE produk_id='$postjson[idproduk]' AND ukuran_id='$idu'")->row_array();

        $stok = $this->produk->cekStok($postjson['idproduk'],$c_w['produk_warna_id'],$c_u['produk_ukuran_id']);
        if(!isset($stok['akhir'])) $stok['akhir'] = 0; else $stok['akhir'] = $stok['akhir'];
        if ($stok['akhir']>=$postjson['jumlah_qty']) {

            $q_cek_stok_beli = $this->db->query("SELECT * FROM tx_cart WHERE produk_id='$postjson[idproduk]' AND warna_id='$idw' AND ukuran_id='$idu' AND cust_id='$postjson[idcust]'");

            $cek_stok_beli = $q_cek_stok_beli->row_array();
            $cek_stok_beli_r = $q_cek_stok_beli->num_rows();


            // jika update cart item
            if ($postjson['idcart']!=0) {
                $cek_stok_beli_r = 0;
            }

            if ($cek_stok_beli_r==0) {
                if ($stok['akhir']>=($postjson['jumlah_qty']+isset($cek_stok_beli['jumlah_beli']))) {
                    $data = [
                        'cust_id'         => $postjson['idcust'],
                        'produk_id'       => $postjson['idproduk'],
                        'warna_id'        => $idw,
                        'ukuran_id'       => $idu,
                        'jumlah_beli'     => $postjson['jumlah_qty'],
                        'catatan_beli'    => $postjson['catatan_trx'],
                        'u_affiliate'     => $postjson['u_affiliate'],
                        'created_at'      => date('Y-m-d H:i:s')
                    ];

                    if ($postjson['idcust']!=null) {
                        // jika update cart item
                        if ($postjson['idcart']!=0) {
                            $this->db->delete('tx_cart', ['cart_id' => $postjson['idcart'], 'cust_id' => $postjson['idcust']]);
                        }
                        $this->db->insert('tx_cart', $data);
                        return json_encode(array('success'=>true, 'msg'=>'Produk di tambahkan ke keranjang.'));
                    }
                }else{
                    return json_encode(array('success'=>false, 'msg'=>'Total yang kamu beli melebihi jumlah stok.'));
                }
            }else{
                if ($stok['akhir']>=($postjson['jumlah_qty']+$cek_stok_beli['jumlah_beli'])) {
                    $update_cart = array('jumlah_beli' => $cek_stok_beli['jumlah_beli']+$postjson['jumlah_qty']);
                    $w_kr = array('cart_id' => $cek_stok_beli['cart_id'], 'cust_id' => $postjson['idcust']);
                    $this->db->where($w_kr);
                    $this->db->update('tx_cart', $update_cart);
                    return json_encode(array('success'=>true, 'msg'=>'Produk di tambahkan ke keranjang.'));
                }else{
                    return json_encode(array('success'=>false, 'msg'=>'Total yang kamu beli melebihi jumlah stok.'));
                }
            }
        }else{
            return json_encode(array('success'=>false, 'msg'=>'Stok produk ini habis atau kurang dari jumlah yang kamu beli.'));
        }

    }

    public function proses_del_cart($postjson) {
        $res = $this->db->delete('tx_cart', ['cart_id' => $postjson['idcart'], 'cust_id' => $postjson['idcust']]);
        return json_encode(array('success'=>true, 'msg'=>'-'));
    }

    public function proses_add_whislist($postjson) {

        $check = $this->db->query("SELECT * FROM tx_wishlist WHERE cust_id='$postjson[idcust]' AND produk_id='$postjson[idproduk]'")->num_rows();

        if ($check>0) {
            $res = $this->db->delete('tx_wishlist', ['cust_id' => $postjson['idcust'], 'produk_id' => $postjson['idproduk']]);
            if ($res==true) {
                $ires = 'del';
                return json_encode(array('success'=>true, 'msg'=>'Produk di hapus dari daftar whistlist kamu.', 'ires'=>$ires));
            }else{
                $ires = 'er_del';
                return json_encode(array('success'=>false, 'msg'=>'Silahkan coba lagi.', 'ires'=>$ires));
            }
        }else{
            $data = [
                'cust_id'         => $postjson['idcust'],
                'produk_id'       => $postjson['idproduk']
            ];
            
            if ($postjson['idcust']!=null) {
                $ires = 'add';
                $this->db->insert('tx_wishlist', $data);
                return json_encode(array('success'=>true, 'msg'=>'Produk di tambahkan ke daftar whistlist kamu.', 'ires'=>$ires));
            }
        }

    }

    public function proses_option_alamat($postjson) {

        $provinsi = explode("*", $postjson["provinsi_id_ex"]);
        $kab = explode("*", $postjson["kabkot_id_ex"]);
        $kec = explode("*", $postjson["kec_id_ex"]);
        
        if ($postjson['tipe']=='add') {

            $check = $this->db->query("SELECT cust_id FROM m_customer_det WHERE cust_id='$postjson[idcust]'")->num_rows();
            if ($check<=0) {
                $is_selected = 1;
            }else{
                $is_selected = 0;
            }

            $pengaturanSistem = pengaturanSistem();
            $explOrigin = explode("*", $pengaturanSistem['origin_store']);
            $origin_kotaasal = $explOrigin[0]; // Jakarta Barat
            $lblorigin_kotaasal = $explOrigin[1];

            $data = [
                'is_selected'           => $is_selected,
                'cust_id'               => $postjson['idcust'],
                'label_alamat'          => str_replace_html(str_replace_kutip($postjson['label_alamat'])),
                'nama_penerima'         => str_replace_html(str_replace_kutip($postjson['nama_penerima'])),
                'ponsel_penerima'       => str_replace_html(str_replace_kutip($postjson['ponsel_penerima'])),
                'id_pusat'              => $origin_kotaasal, // pusat toko
                'nama_pusat'            => $lblorigin_kotaasal, // pusat toko
                'id_provinsi'           => $provinsi[0],
                'nama_provinsi'         => $provinsi[1],
                'id_kabkot'             => $kab[0],
                'nama_kabkot'           => $kab[1],
                'id_kec'                => $kec[0],
                'nama_kec'              => $kec[1],
                'kodepos'               => str_replace_html(str_replace_kutip($postjson['kode_pos_ex'])),
                'alamat_lengkap'        => str_replace_html(str_replace_kutip($postjson['alamat_lengkap'])),
                'created_at'            => date('Y-m-d H:i:s')
            ];
                
            if ($postjson['idcust']!=null) {
                $i = $this->db->insert('m_customer_det', $data);
                if ($i==true) {
                    return json_encode(array('success'=>true, 'msg'=>'Simpan data berhasil.'));
                }else{
                    return json_encode(array('success'=>false, 'msg'=>'Simpan data gagal, silahkan coba lagi.'));
                }
            }
        }else{

            $this->db->set([
                'label_alamat'          => str_replace_html(str_replace_kutip($postjson['label_alamat'])),
                'nama_penerima'         => str_replace_html(str_replace_kutip($postjson['nama_penerima'])),
                'ponsel_penerima'       => str_replace_html(str_replace_kutip($postjson['ponsel_penerima'])),
                'id_provinsi'           => $provinsi[0],
                'nama_provinsi'         => $provinsi[1],
                'id_kabkot'             => $kab[0],
                'nama_kabkot'           => $kab[1],
                'id_kec'                => $kec[0],
                'nama_kec'              => $kec[1],
                'kodepos'               => str_replace_html(str_replace_kutip($postjson['kode_pos_ex'])),
                'alamat_lengkap'        => str_replace_html(str_replace_kutip($postjson['alamat_lengkap']))
            ]);
            $this->db->where('cust_det_id', $postjson['idalamat']);
            $i = $this->db->update('m_customer_det');
            if ($i==true) {
                return json_encode(array('success'=>true, 'msg'=>'Edit data berhasil.'));
            }else{
                return json_encode(array('success'=>false, 'msg'=>'Edit data gagal, silahkan coba lagi.'));
            }

        }

    }

    public function proses_topup_saldo($postjson,$mail = null) {
        $pengaturanSistem = pengaturanSistem();

        $res_trx = false;
        $todaydate = date('Y-m-d H:i:s');

        $bul = date('m'); $tahun = date('Y'); $tgl = date('mY');
        $nores = $this->db->query("SELECT max(substr(kode_topup,17,5))as no FROM tx_topup WHERE substr(kode_topup,5,4)='TOUP' AND substr(kode_topup,12,4)='$tahun'")->row_array();
        $has=intval($nores['no'])+1;
        $noTrx="TRX/TOUP/".$tgl."/".sprintf("%05d",$has);

        //batas waktu pembayaran
        $cenvertedtime = date('Y-m-d H:i:s',strtotime('+'.$pengaturanSistem['limit_batas_bayar'].' hour',strtotime($todaydate)));

        if ($pengaturanSistem['metode_pembayaran']=='tripay') {
            $response_midtrans = 'tripay';
            $billkey = 'tripay';
            $billercode = $postjson['snapobj'];
            $pdf_url_pay = 'tripay';
            $payment_type = 'tripay';

            $postjson['idunique'] = 'TOPUP-'.date('Y-m-d-His')."-cstore-xid-".$postjson['idcust'];
        } else if ($pengaturanSistem['metode_pembayaran']=='midtrans') {
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

            $postjson['idunique'] = 'TOPUP-'.date('Y-m-d-His')."-cstore-xid-".$postjson['idcust'];
        }

        if ($postjson['statuspay']=='y') {
            $buktibyr = 'y';
        }else{
            $buktibyr = 'n';
        }

        if ($pengaturanSistem['metode_pembayaran']=='tripay' && $postjson['nominaltopup']>5000000) {
            return json_encode(array('success'=>false, 'msg'=>'Topup gagal, maksimal Rp 5.000.000.'));
            exit();
        }

        if ($pengaturanSistem['metode_pembayaran']=='tripay' && $postjson['snapobj']=='ALFAMART' && $postjson['snapobj']=='INDOMARET' && $postjson['snapobj']=='ALFAMIDI' && $postjson['nominaltopup']>2500000) {
            return json_encode(array('success'=>false, 'msg'=>'Topup gagal, pembayaran menggunakan '.$postjson['snapobj'].' maksimal Rp 2.500.000.'));
            exit();
        }

        $dataFirst = [
            'kode_topup'              => $noTrx,
            'unique_id'               => $postjson['idunique'],
            'cust_id'                 => $postjson['idcust'],
            'nominal_topup'           => $postjson['nominaltopup'],
            'is_status'               => $postjson['statuspay'],
            'bukti_pembayaran'        => $buktibyr,
            'batas_waktu_pembayaran'  => $cenvertedtime,
            'cara_pembayaran'         => $pdf_url_pay,
            'payment_type'            => $payment_type,
            'biller_code'             => $billercode,
            'bill_key'                => $billkey,
            'response_midtrans'       => $postjson['snapobj'],
            'created_at'              => date('Y-m-d H:i:s')
        ];

        if ($postjson['nominaltopup']>=10000 && $postjson['idcust']!=null) {

            $item_details_tripay[] = array(
                'sku'         => 'xtopupcstore',
                'name'        => 'Topup',
                'price'       => $postjson['nominaltopup'],
                'quantity'    => 1,
                'product_url' => $pengaturanSistem['google_redirect'],
                'image_url'   => $pengaturanSistem['google_redirect'].'logo/'.$pengaturanSistem['logo_toko_image']
            );

            $rest_cust = $this->db->query("SELECT * FROM m_customer WHERE cust_id='$postjson[idcust]'")->row_array();

            if ($pengaturanSistem['metode_pembayaran']=='tripay') {
                // request dan create transaksi ke tripay
                $apiKey       = $pengaturanSistem['tripay_apikey'];
                $privateKey   = $pengaturanSistem['tripay_privatekey'];
                $merchantCode = $pengaturanSistem['tripay_merchant'];
                $merchantRef  = $postjson['idunique'];

                if ($postjson['nominaltopup']<=0) {
                    return json_encode(array('success'=>false, 'msg'=>'Harga total harus diatas Rp 0.'));
                }

                $item_details = [
                    'method'         => $postjson['snapobj'],
                    'merchant_ref'   => $merchantRef,
                    'amount'         => $postjson['nominaltopup'],
                    'customer_name'  => $rest_cust['cust_nama'],
                    'customer_email' => $rest_cust['is_token'],
                    'customer_phone' => $rest_cust['cust_ponsel'],
                    'order_items'    => $item_details_tripay,
                    'return_url'     => $pengaturanSistem['google_redirect'].'balance',
                    'expired_time'   => (time() + (24 * 60 * 60)),
                    'signature'      => hash_hmac('sha256', $merchantCode.$merchantRef.$postjson['nominaltopup'],$privateKey)
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
                    return json_encode(array('success'=>false, 'msg'=>$err));
                    exit();
                }else{
                    $data_p = json_decode($response, true);
                    if($data_p['success']==false){
                        return json_encode(array('success'=>false, 'msg'=>$err));
                        exit();
                    }else{
                        if ($postjson['snapobj']=='OVO') {
                            $data_p['data']['qr_url'] = $data_p['data']['pay_url'];
                        }else{
                            if(!isset($data_p['data']['qr_url'])) $data_p['data']['qr_url'] = '';
                        }
                        $dataFirst = [
                            'kode_topup'              => $noTrx,
                            'unique_id'               => $postjson['idunique'],
                            'cust_id'                 => $postjson['idcust'],
                            'nominal_topup'           => $postjson['nominaltopup'],
                            'is_status'               => $postjson['statuspay'],
                            'bukti_pembayaran'        => $buktibyr,
                            'batas_waktu_pembayaran'  => $cenvertedtime,
                            'cara_pembayaran'         => json_encode($data_p['data']['instructions']),
                            'payment_type'            => $payment_type,
                            'biller_code'             => $billercode,
                            'bill_key'                => $data_p['data']['payment_name'],
                            'if_cancel'               => $data_p['data']['qr_url'],
                            'response_midtrans'       => $response,
                            'created_at'              => date('Y-m-d H:i:s')
                        ];
                    }
                }
            }
            $res_trx = $this->db->insert('tx_topup', $dataFirst);
        }

        if ($res_trx==true) {
            $msg = 'Proses berhasil, silahkan untuk melakukan pembayaran sesuai dengan nominal topup yang dimasukan '.formatRupiah($postjson['nominaltopup']).'.';
            return json_encode(array('success'=>true, 'msg'=>$msg, 'uid'=>$postjson['idunique']));
        }else{
            return json_encode(array('success'=>false, 'msg'=>'Proses gagal, silahkan coba lagi.'));
        }

    }

    public function proses_simpan_transaksi($postjson,$mail = null) {
        $pengaturanSistem = pengaturanSistem();
        // $idTrx = urutId('tx_transaksi',"transaksi_id");

        $res_trx = false;
        $todaydate = date('Y-m-d H:i:s');
        $harga_total_default = 0; $berat_total_default = 0;
        $total_potongan = 0; $total_global_diskon = 0; $total_tambahan_harga = 0;

        $bul = date('m'); $tahun = date('Y'); $tgl = date('mY');
        $nores = $this->db->query("SELECT max(substr(no_transaksi,17,5))as no FROM tx_transaksi WHERE substr(no_transaksi,5,4)='INVT' AND substr(no_transaksi,12,4)='$tahun'")->row_array();
        $has=intval($nores['no'])+1;
        $noTrx="TRX/INVT/".$tgl."/".sprintf("%05d",$has);

        $query = $this->db->query("SELECT a.*,b.*,c.nama_warna,d.ukuran_size FROM tx_cart a JOIN m_produk b ON a.produk_id=b.produk_id LEFT JOIN m_warna c ON a.warna_id=c.warna_id LEFT JOIN m_ukuran d ON a.ukuran_id=d.ukuran_id WHERE b.is_active=1 AND b.is_hapus='n' AND a.cust_id='$postjson[idcust]'")->result_array();

        if(count($query)==0){
            return json_encode(array('success'=>false, 'msg'=>'Tidak ada produk di keranjang kamu!'));
            exit();
        }

        foreach ($query as $rows) {
          if ($rows['potongan_status']=='y') {
            $today = strtotime(date('Y-m-d'));
            $tgl_mulai = strtotime($rows['potongan_mulai']); $tgl_akhir = strtotime($rows['potongan_akhir']);
            $jarakhari = $today - $tgl_mulai;
            $selisihari = $jarakhari / 60 / 60 / 24;
            $jarakhari_a = $tgl_akhir - $today;
            $selisihari_a = $jarakhari_a / 60 / 60 / 24;
            if ($selisihari>=0 && $selisihari_a>=0) {
              $potongan_diskon = $rows['potongan_diskon'];
              $harga_p_new = $rows['harga_produk']-$potongan_diskon;
              $global_diskon = ($harga_p_new*$pengaturanSistem['global_diskon'])/100;
              $harga_p_new = $harga_p_new-$global_diskon;
            }else{
              $potongan_diskon = 0;
              $harga_p_new = $rows['harga_produk'];
              $global_diskon = ($harga_p_new*$pengaturanSistem['global_diskon'])/100;
              $harga_p_new = $harga_p_new-$global_diskon;
            }
          }else{
            $potongan_diskon = 0;
            $harga_p_new = $rows['harga_produk'];
            $global_diskon = ($harga_p_new*$pengaturanSistem['global_diskon'])/100;
            $harga_p_new = $harga_p_new-$global_diskon;
          }

          $lx_u = $this->db->query("SELECT * FROM m_produk_ukuran WHERE produk_id='$rows[produk_id]' AND ukuran_id='$rows[ukuran_id]'")->row_array();

          $harga_total_default += (int)($rows['harga_produk'] * $rows['jumlah_beli']);
          $berat_total_default += (int)($rows['berat_produk'] * $rows['jumlah_beli']);
          $total_potongan += (int)($potongan_diskon * $rows['jumlah_beli']);
          $total_global_diskon += (int)($global_diskon * $rows['jumlah_beli']);
          $total_tambahan_harga += (int)($lx_u['tambahan_harga'] * $rows['jumlah_beli']);

        }

        // ongkos kirim
        $o_kirim = $this->db->query("SELECT * FROM tx_kurir WHERE kurir_id='$postjson[idkurir]' AND cust_id='$postjson[idcust]'")->row_array();

        if ($o_kirim) {
            $o_kirim['ongkos_kirim'] = $o_kirim['ongkos_kirim'];
        }else{
            $o_kirim['ongkos_kirim'] = 0;
        }

        if ($postjson['idalamat']=='guest') {
            $postjson['kodevoucher'] = '';
        }

        (int)$totalbayar_awal = $harga_total_default+$o_kirim['ongkos_kirim']-$total_potongan-$total_global_diskon+$total_tambahan_harga;

        if ($postjson['kodevoucher']!='') {
            $arr = array('kode' => $postjson['kodevoucher'], 'total_bayar' => $totalbayar_awal, 'idcust' => $postjson['idcust'], 'lang' => 'en');
            $rest_voucher = json_decode($this->restload->check_voucher($arr), true);
            $postjson['potonganvoucher'] = (int)$rest_voucher['nominal'];
            if ($rest_voucher['st']!='y') {
                return json_encode(array('success'=>false, 'msg'=>$rest_voucher['st']));
                exit();
            }
        }else{
            $postjson['potonganvoucher'] = 0;
        }

        (int)$totalbayar_benerbener = $harga_total_default+$o_kirim['ongkos_kirim']-$total_potongan-$total_global_diskon-$postjson['potonganvoucher']+$total_tambahan_harga;

        $paynext = 'y';
        if ($postjson['metodepembayaran']=='saldo') {
            $saldo = $this->db->query("SELECT * FROM tx_saldo WHERE cust_id='$postjson[idcust]' ORDER BY saldo_id DESC LIMIT 1")->row_array();

            if(!isset($saldo['akhir'])) $saldo['akhir'] = 0;

            if ($saldo['akhir']>=$totalbayar_benerbener) {
                $paynext = 'y';
                if($postjson['digitalonly']=='y'){
                    $postjson['statuspay'] = 's';
                }else{
                    $postjson['statuspay'] = 'y';
                }
            }else{
                $paynext = 'n';
            }
        }

        $dataguest = 'n';
        if ($postjson['idalamat']=='guest') {
            $dataguest = 'y';
            $rest_cust['cust_nama'] = $postjson['nama'];
            $rest_cust['is_token'] = $postjson['email'];
            $rest_cust['cust_ponsel'] = $postjson['nomor'];
        }else{
            $rest_cust = $this->db->query("SELECT * FROM m_customer WHERE cust_id='$postjson[idcust]'")->row_array();
            $postjson['email'] = $rest_cust['is_token'];
        }

        if ($rest_cust['cust_nama']=='' || $rest_cust['is_token']=='' || $rest_cust['cust_ponsel']=='') {
            return json_encode(array('success'=>false, 'msg'=>'Pastikan semua kolom seperti nama, nomor, email hingga alamat diisi dengan benar, refresh halaman dan coba lagi.'));
            exit();
        }

        if ($paynext=='y') {

            if ($totalbayar_benerbener < 10000) {
                return json_encode(array('success'=>false, 'msg'=>'['.$totalbayar_benerbener.'] Transaksi gagal, minimal nominal transaksi Rp 10.000.'));
                exit();
            }
    
            if ($pengaturanSistem['metode_pembayaran']=='tripay' && $postjson['metodepembayaran']=='bank' && $totalbayar_benerbener>5000000) {
                return json_encode(array('success'=>false, 'msg'=>'['.$totalbayar_benerbener.'] Transaksi gagal, maksimal nominal transaksi Rp 5.000.000.'));
                exit();
            }
    
            if ($pengaturanSistem['metode_pembayaran']=='tripay' && $postjson['metodepembayaran']=='bank' && $postjson['snapobj']=='ALFAMART' && $postjson['snapobj']=='INDOMARET' && $postjson['snapobj']=='ALFAMIDI' && $totalbayar_benerbener>2500000) {
                return json_encode(array('success'=>false, 'msg'=>'['.$totalbayar_benerbener.'] Transaksi gagal, pembayaran menggunakan '.$postjson['snapobj'].' maksimal nominal transaksi Rp 2.500.000.'));
                exit();
            }
            
            if ($postjson['idalamat']=='guest') {
                $postjson['kodevoucher'] = '';

                $provinsi = explode("*", $postjson["splitprov"]);
                $kab = explode("*", $postjson["splitkabkot"]);
                $kec = explode("*", $postjson["splitkec"]);
    
                $explOrigin = explode("*", $pengaturanSistem['origin_store']);
                $origin_kotaasal = $explOrigin[0]; // Jakarta Barat
                $lblorigin_kotaasal = $explOrigin[1];

                if($postjson['digitalonly']=='y'){
                    $provinsi[0] = '';
                    $provinsi[1] = '';
                    $kab[0] = '';
                    $kab[1] = '';
                    $o_kirim['kurir'] = 'digitalonly';
                }
    
                $dataFirstGuest = [
                    'cust_id'           => $postjson['idcust'],
                    'is_selected'       => 0,
                    'label_alamat'      => 'GUEST',
                    'nama_penerima'     => $postjson['nama'],
                    'ponsel_penerima'   => $postjson['nomor'],
                    'alamat_lengkap'    => $postjson['alamat'],
                    'id_pusat'          => $origin_kotaasal,
                    'nama_pusat'        => $lblorigin_kotaasal,
                    'id_provinsi'       => $provinsi[0],
                    'nama_provinsi'     => $provinsi[1],
                    'id_kabkot'         => $kab[0],
                    'nama_kabkot'       => $kab[1],
                    'id_kec'            => $kec[0],
                    'nama_kec'          => $kec[1],
                    'kodepos'           => $postjson['kodepos'],
                    'created_at'        => date('Y-m-d H:i:s')
                ];
    
                if ($postjson['idcust']!=null) {
                    $res_almt_guest = $this->db->insert('m_customer_det', $dataFirstGuest);
                    if($res_almt_guest==true){
                        $postjson['idalamat'] = $this->db->insert_id();
                    }else{
                        return json_encode(array('success'=>false, 'msg'=>'Proses gagal, alamat pengiriman yang kamu masukan tidak benar.'));
                        exit();
                    }
                }
            }
            
            //batas waktu pembayaran
            $cenvertedtime = date('Y-m-d H:i:s',strtotime('+'.$pengaturanSistem['limit_batas_bayar'].' hour',strtotime($todaydate)));

            if (($pengaturanSistem['metode_pembayaran']=='tripay' && $postjson['metodepembayaran']=='bank') && $o_kirim['kurir']!='klokal1') {

                $response_midtrans = 'tripay';
                $billkey = 'tripay';
                $billercode = $postjson['snapobj'];
                $pdf_url_pay = 'tripay';
                $payment_type = 'tripay';

                $postjson['idunique'] = date('Y-m-d-His')."-cstore-xid-".$postjson['idcust'];
            
            }else if (($pengaturanSistem['metode_pembayaran']=='xendit' && $postjson['metodepembayaran']=='bank') && $o_kirim['kurir']!='klokal1') {

                $response_midtrans = 'xendit';
                $billkey = 'xendit';
                $billercode = $postjson['snapobj'];
                $pdf_url_pay = 'xendit';
                $payment_type = 'xendit';

                $postjson['idunique'] = date('Y-m-d-His')."-cstore-xid-".$postjson['idcust'];
            
            }else if (($pengaturanSistem['metode_pembayaran']=='midtrans' && $postjson['metodepembayaran']=='bank') && $o_kirim['kurir']!='klokal1') {
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

            $dataFirst = [
                'no_transaksi'            => $noTrx,
                'unique_id'               => $postjson['idunique'],
                'cust_id'                 => $postjson['idcust'],
                'cust_det_id'             => $postjson['idalamat'],
                'harga_total'             => $harga_total_default,
                'berat_total'             => $berat_total_default,
                'ongkos_kirim'            => $o_kirim['ongkos_kirim'],
                'tambahan_harga_total'    => $total_tambahan_harga,
                'potongan_total'          => $total_potongan,
                'diskon_all_total'        => $total_global_diskon,
                'pers_diskon_all'         => $pengaturanSistem['global_diskon'],
                'kode_voucher'            => $kodevoucher,
                'potongan_voucher'        => $postjson['potonganvoucher'],
                'is_read'                 => 'n',
                'is_status'               => $postjson['statuspay'],
                'transaksi_from'          => 'WEB',
                'metode_pembayaran'       => $postjson['metodepembayaran'],
                'bukti_pembayaran'        => $buktibyr,
                'tgl_transaksi'           => date('Y-m-d H:i:s'),
                'batas_waktu_pembayaran'  => $cenvertedtime,
                'cara_pembayaran'         => $pdf_url_pay,
                'payment_type'            => $payment_type,
                'biller_code'             => $billercode,
                'bill_key'                => $billkey,
                'response_midtrans'       => $postjson['snapobj'],
                'is_digital'              => $postjson['digitalonly'],
                'catatan'                 => $postjson['catatan_trx'],
                'email_trx'               => $postjson['email']
            ];

            if (($harga_total_default!=0 && $berat_total_default!=0) || $postjson['digitalonly']=='y') {
                if ($postjson['idcust']!=null) {
                    $res_trx = $this->db->insert('tx_transaksi', $dataFirst);
                }
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
                
                $query_cart = $this->db->query("SELECT a.*,b.*,c.nama_warna,d.ukuran_size FROM tx_cart a JOIN m_produk b ON a.produk_id=b.produk_id LEFT JOIN m_warna c ON a.warna_id=c.warna_id LEFT JOIN m_ukuran d ON a.ukuran_id=d.ukuran_id WHERE b.is_active=1 AND b.is_hapus='n' AND a.cust_id='$postjson[idcust]'");
                
                $res_cart = $query_cart->result_array(); $nums_cart = $query_cart->num_rows();

                foreach ($res_cart as $rows) {

                    $l_w = $this->db->query("SELECT * FROM m_produk_warna WHERE produk_id='$rows[produk_id]' AND warna_id='$rows[warna_id]'")->row_array();
                    $l_u = $this->db->query("SELECT * FROM m_produk_ukuran WHERE produk_id='$rows[produk_id]' AND ukuran_id='$rows[ukuran_id]'")->row_array();

                    $stok = $this->produk->cekStok($rows['produk_id'],$l_w['produk_warna_id'],$l_u['produk_ukuran_id']);
                    if(!isset($stok['akhir'])) $stok['akhir'] = 0; else $stok['akhir'] = $stok['akhir'];

                    // pengecekan stok
                    if ($stok['akhir']>=$rows['jumlah_beli']) {

                        if ($rows['potongan_status']=='y') {
                            $today = strtotime(date('Y-m-d')); 
                            $tgl_mulai = strtotime($rows['potongan_mulai']); $tgl_akhir = strtotime($rows['potongan_akhir']);
                            $jarakhari = $today - $tgl_mulai;
                            $selisihari = $jarakhari / 60 / 60 / 24;
                            $jarakhari_a = $tgl_akhir - $today;
                            $selisihari_a = $jarakhari_a / 60 / 60 / 24;
                            if ($selisihari>=0 && $selisihari_a>=0) {
                              $potongan_diskon = $rows['potongan_diskon'];
                              $harga_p_new = $rows['harga_produk']-$potongan_diskon;
                              $global_diskon = ($harga_p_new*$pengaturanSistem['global_diskon'])/100;
                              $harga_p_new = $harga_p_new-$global_diskon;
                            }else{
                              $potongan_diskon = 0;
                              $harga_p_new = $rows['harga_produk'];
                              $global_diskon = ($harga_p_new*$pengaturanSistem['global_diskon'])/100;
                              $harga_p_new = $harga_p_new-$global_diskon;
                            }
                        }else{
                            $potongan_diskon = 0;
                            $harga_p_new = $rows['harga_produk'];
                            $global_diskon = ($harga_p_new*$pengaturanSistem['global_diskon'])/100;
                            $harga_p_new = $harga_p_new-$global_diskon;
                        }

                        $harga_total_default_det += $rows['harga_produk']*$rows['jumlah_beli'];
                        $berat_total_default_det += $rows['berat_produk']*$rows['jumlah_beli'];
                        $total_potongan_det += $potongan_diskon*$rows['jumlah_beli'];
                        $total_global_diskon_det += $global_diskon*$rows['jumlah_beli'];
                        $total_tambahan_harga_det += $l_u['tambahan_harga']*$rows['jumlah_beli'];
                        

                        $uid_affiliate_guest = 'n';
                        $tharga_produk = ($rows['harga_produk']*$rows['jumlah_beli'])-($potongan_diskon*$rows['jumlah_beli'])-($global_diskon*$rows['jumlah_beli'])+($l_u['tambahan_harga']*$rows['jumlah_beli']);
                        if($pengaturanSistem['fitur_saldo']=='y' && $rows['status_affiliate']=='d'){
                            $u_affiliate = $rows['u_affiliate'];
                            $pers_affiliate = $pengaturanSistem['komisi_affiliate_produk'];
                            $komisi_affiliate = $tharga_produk*$pers_affiliate/100;

                            $cek_idaffiliate = $this->db->query("SELECT * FROM m_customer WHERE is_token='$u_affiliate'")->row_array();
                            if($cek_idaffiliate){
                                $uid_affiliate = $cek_idaffiliate['cust_id'];
                                if($uid_affiliate==0){
                                    $uid_affiliate_guest = 'y';
                                }
                            }else{
                                $uid_affiliate = 0;
                            }

                            if($uid_affiliate==0 && $uid_affiliate_guest=='n'){
                                $u_affiliate = '';
                                $pers_affiliate = 0;
                                $komisi_affiliate = 0;
                            }

                            if($uid_affiliate==$postjson['idcust']){
                                $uid_affiliate_guest = 'n';
                                $u_affiliate = '';
                                $pers_affiliate = 0;
                                $komisi_affiliate = 0;
                                $uid_affiliate = 0;
                            }
                        }else{
                            if($rows['status_affiliate']=='y'){
                                $u_affiliate = $rows['u_affiliate'];
                                $pers_affiliate = $rows['komisi_affiliate_produk'];
                                $komisi_affiliate = $tharga_produk*$pers_affiliate/100;

                                $cek_idaffiliate = $this->db->query("SELECT * FROM m_customer WHERE is_token='$u_affiliate'")->row_array();
                                if($cek_idaffiliate){
                                    $uid_affiliate = $cek_idaffiliate['cust_id'];
                                    if($uid_affiliate==0){
                                        $uid_affiliate_guest = 'y';
                                    }
                                }else{
                                    $uid_affiliate = 0;
                                }

                                if($uid_affiliate==0 && $uid_affiliate_guest=='n'){
                                    $u_affiliate = '';
                                    $pers_affiliate = 0;
                                    $komisi_affiliate = 0;
                                }

                                if($uid_affiliate==$postjson['idcust']){
                                    $uid_affiliate_guest = 'n';
                                    $u_affiliate = '';
                                    $pers_affiliate = 0;
                                    $komisi_affiliate = 0;
                                    $uid_affiliate = 0;
                                }

                            }else{
                                $u_affiliate = '';
                                $pers_affiliate = 0;
                                $komisi_affiliate = 0;
                                $uid_affiliate = 0;
                            }
                        }

                        $dataSec = [
                            'no_transaksi'              => $noTrx,
                            'unique_id'                 => $postjson['idunique'],
                            'cust_id'                   => $postjson['idcust'],
                            'produk_id'                 => $rows['produk_id'],
                            'warna_id'                  => $rows['warna_id'],
                            'ukuran_id'                 => $rows['ukuran_id'],
                            'nama_produk'               => $rows['nama_produk'],
                            'harga_produk'              => $rows['harga_produk'],
                            'berat_produk'              => $rows['berat_produk'],
                            'tambahan_harga'            => $l_u['tambahan_harga'],
                            'potongan_harga'            => $potongan_diskon,
                            'diskon_all_produk'         => $global_diskon,
                            'pers_diskon_all_produk'    => $pengaturanSistem['global_diskon'],
                            'jumlah_beli'               => $rows['jumlah_beli'],
                            'catatan'                   => $rows['catatan_beli'],
                            'total_harga_produk'        => $rows['harga_produk']*$rows['jumlah_beli'],
                            'total_berat_produk'        => $rows['berat_produk']*$rows['jumlah_beli'],
                            'total_tambahan_harga'      => $l_u['tambahan_harga']*$rows['jumlah_beli'],
                            'total_potongan_harga'      => $potongan_diskon*$rows['jumlah_beli'],
                            'total_diskon_all_produk'   => $global_diskon*$rows['jumlah_beli'],
                            'u_affiliate'               => $u_affiliate,
                            'pers_affiliate'            => $pers_affiliate,
                            'komisi_affiliate'          => $komisi_affiliate
                        ];

                        if ($postjson['idcust']!=null) {
                            $res_trx_d = $this->db->insert('tx_transaksi_det', $dataSec);
                        }

                        // pengurangan stok
                        $dataTh = [
                            'kode_stok'           => $noTrx,
                            'status_stok'         => 2, // stok keluar ~~
                            'produk_id'           => $rows['produk_id'],
                            'produk_warna_id'     => $l_w['produk_warna_id'],
                            'produk_ukuran_id'    => $l_u['produk_ukuran_id'],
                            'admin_id'            => '0', // default untuk ecommer
                            'cust_id'             => $postjson['idcust'], // default untuk ecommer
                            'awal'                => $stok['akhir'],
                            'masuk'               => 0,
                            'keluar'              => $rows['jumlah_beli'],
                            'akhir'               => $stok['akhir']-$rows['jumlah_beli'],
                            'label_stok'          => 'WEB', // default untuk ecommer
                            'created_at'          => date("Y-m-d H:i:s")
                        ];

                        if ($postjson['idcust']!=null) {
                            $res_trx_t = $this->db->insert('tx_stok', $dataTh);
                        }

                        $p_img = $this->db->query("SELECT * FROM m_produk_img WHERE produk_id='$rows[produk_id]'")->row_array();

                        // buat tripay
                        $item_details_tripay[] = array(
                          'sku'         => $rows['produk_id'],
                          'name'        => $rows['nama_produk'],
                          'price'       => $harga_p_new,
                          'quantity'    => $rows['jumlah_beli'],
                          'product_url' => $pengaturanSistem['google_redirect'].'p/'.$rows['url_produk'],
                          'image_url'   => $pengaturanSistem['google_redirect'].'assets/uploaded/products/'.$p_img['logo_image']
                        );

                        // hapus cart
                        $this->db->delete('tx_cart', ['cart_id' => $rows['cart_id'], 'cust_id' => $postjson['idcust']]);

                    }else{
                        $cek_cart_no_stok += 1;
                    }

                }

                if ($nums_cart==$cek_cart_no_stok) { // jika yang dibeli 1 item dan stok habis maka transaksi dibatalkan.
                    $this->db->delete('tx_transaksi', ['no_transaksi' => $noTrx, 'cust_id' => $postjson['idcust']]);
                    return json_encode(array('success'=>false, 'msg'=>'Transaksi di batalkan, kamu telat 1 menit stok produk yang kamu beli kurang atau tidak tersedia.'));
                    exit();
                }else{

                    $amount = $harga_total_default_det+$total_tambahan_harga_det+$o_kirim['ongkos_kirim']-$total_potongan_det-$total_global_diskon_det-$postjson['potonganvoucher'];


                    if($dataguest=='y'){
                        $rest_cust['cust_nama'] = $postjson['nama'];
                        $rest_cust['is_token'] = $postjson['email'];
                        $rest_cust['cust_ponsel'] = $postjson['nomor'];
                    }else{
                        $rest_cust = $this->db->query("SELECT * FROM m_customer WHERE cust_id='$postjson[idcust]'")->row_array();
                    }

                    if ($pengaturanSistem['metode_pembayaran']=='tripay' && $postjson['metodepembayaran']=='bank') {

                        if ($postjson['digitalonly']=='n') {
                            $item_details_tripay[] = array(
                              'sku'         => 'K-'.$o_kirim['kurir_id'],
                              'name'        => $o_kirim['nama_kurir'].' '.$o_kirim['level_kurir'],
                              'price'       => $o_kirim['ongkos_kirim'],
                              'quantity'    => 1,
                              'product_url' => '',
                              'image_url'   => ''
                            );
                        }

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
                            exit();
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
                            return json_encode(array('success'=>false, 'msg'=>'Pastikan semua kolom seperti nama, nomor, email hingga alamat diisi dengan benar, refresh halaman dan coba lagi.'));
                            exit();
                        }else{
                            $data_p = json_decode($response, true);
                            if($data_p['success']==false){
                                $this->db->delete('tx_transaksi', ['no_transaksi' => $noTrx, 'cust_id' => $postjson['idcust']]);
                                $this->db->delete('tx_stok', ['kode_stok' => $noTrx, 'cust_id' => $postjson['idcust']]);
                                $this->db->delete('tx_transaksi_det', ['no_transaksi' => $noTrx, 'cust_id' => $postjson['idcust']]);
                                return json_encode(array('success'=>false, 'msg'=>'Pastikan semua kolom seperti nama, nomor, email hingga alamat diisi dengan benar, refresh halaman dan coba lagi.'));
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
                            $rest_cust['is_token'] = 'cgustiya@gmail.com';
                        }

                        if ($rest_cust['cust_ponsel']=='') {
                            $rest_cust['cust_ponsel'] = '08567354414';
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
                            'success_redirect_url' => $this->config->item("nhub_url").'trx/'.$postjson['idunique'],
                            'failure_redirect_url' => $this->config->item("nhub_url").'trx/'.$postjson['idunique'],
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

                    $update_kurir = array('status_submit' => 'y', 'no_transaksi' => $noTrx);
                    $w_kr = array('kurir_id' => $postjson['idkurir'], 'cust_id' => $postjson['idcust']);
                    $this->db->where($w_kr);
                    $this->db->update('tx_kurir', $update_kurir);
                    
                    $this->db->delete('tx_kurir', ['cust_id' => $postjson['idcust'], 'status_submit' => 'n']);

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

                    if ($pengaturanSistem['status_wablas']=='y' || $pengaturanSistem['status_watsap']=='y') {
                        kirimTransaksikeWa($postjson['idunique'],$postjson['idcust']);
                    }

                    if($dataguest=='y'){
                        if ($postjson['idcust']!=null) {
                            $res_trx_t = $this->db->insert('tx_notifikasi', $dataInfo);
                        }
                    }

                    if ($postjson['metodepembayaran']=='saldo') {
                        $datasaldo = [
                            'cust_id'             => $postjson['idcust'],
                            'kode_saldo'          => $noTrx,
                            'status_saldo'        => 2, // keluar ~~
                            'tipe'                => 'trx',
                            'awal'                => $saldo['akhir'],
                            'masuk'               => 0,
                            'keluar'              => $totalbayar_benerbener,
                            'akhir'               => $saldo['akhir']-$totalbayar_benerbener,
                            'created_at'          => date("Y-m-d H:i:s")
                        ];

                        $res = $this->db->insert('tx_saldo', $datasaldo);
                    }
                }

                return json_encode(array('success'=>true, 'msg'=>$msg, 'uid'=>$postjson['idunique']));
                exit();

            }else{
                $this->db->delete('tx_transaksi', ['no_transaksi' => $noTrx, 'cust_id' => $postjson['idcust']]);
                return json_encode(array('success'=>false, 'msg'=>'Proses gagal, silahkan coba lagi.'));
                exit();
            }
        }else{
            return json_encode(array('success'=>false, 'msg'=>'Proses gagal, saldo tidak mencukupi.'));
            exit();
        }

    }

    public function proses_update_transaksi_midtrans($mail,$postjson) {

        if(!isset($postjson['idtrx'])) $postjson['idtrx'] = 0;

        $qtrx = $this->db->query("SELECT * FROM tx_transaksi WHERE unique_id='$postjson[idtrx]'")->row_array();

        if ($qtrx['is_digital']=='y') {
            if ($postjson['status']=='y') {
                $status = 's';
                kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'selesai');
            }else{
                $status = $postjson['status'];
                if ($status=='p') {
                    kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'proses');
                }else if ($status=='b') {
                    kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'batal');
                }else if ($status=='s') {
                    kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'selesai');
                }
            }
        }else{
            $status = $postjson['status'];
            if ($status=='p') {
                kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'proses');
            }else if ($status=='b') {
                kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'batal');
            }else if ($status=='s') {
                kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'selesai');
            }
        }

        // khusus point of sale
        if($qtrx['transaksi_from']=='POS'){
            if($status=='y'){
                $status = 's';
                kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'selesai');
            }
        }

        $this->db->set(['is_status' => $status]);
        $this->db->where('unique_id', $postjson['idtrx']);
        $this->db->update('tx_transaksi');
    }

    public function proses_update_transaksi_tripay($mail,$postjson) {

        if(!isset($postjson['idtrx'])) $postjson['idtrx'] = 0;

        if (substr($postjson['idtrx'],0,5)=='TOPUP') {
            $qtrx = $this->db->query("SELECT * FROM tx_topup WHERE unique_id='$postjson[idtrx]'")->row_array();
            if ($qtrx) {
                if ($postjson['status']=='y') {
                    $saldo = $this->db->query("SELECT * FROM tx_saldo WHERE cust_id='$qtrx[cust_id]' ORDER BY saldo_id DESC LIMIT 1")->row_array();

                    $data = [
                        'cust_id'             => $qtrx['cust_id'],
                        'kode_saldo'          => $qtrx['kode_topup'],
                        'status_saldo'        => 1, // masuk ~~
                        'tipe'                => 'topup',
                        'awal'                => $saldo['akhir'],
                        'masuk'               => $qtrx['nominal_topup'],
                        'keluar'              => 0,
                        'akhir'               => $saldo['akhir']+$qtrx['nominal_topup'],
                        'created_at'          => date("Y-m-d H:i:s")
                    ];

                    $res = $this->db->insert('tx_saldo', $data);

                    $this->db->set(['is_status' => 'y', 'bukti_pembayaran' => 'y']);
                    $this->db->where('topup_id', $qtrx['topup_id']);
                    $this->db->update('tx_topup');
                }else{
                    $this->db->set([
                        'is_status' => 'b',
                        'if_cancel' => 'Transaksi telah dibatalkan pada <b>'.indo(date('Y-m-d')).' '.date('H:i').'</b> waktu setempat.<br>Oleh <b>Admin</b>.'
                    ]);
                    $this->db->where('topup_id', $qtrx['topup_id']);
                    $this->db->update('tx_topup');
                }
                return json_encode(array('success'=>true, 'code'=>1));
            }else{
                return json_encode(array('success'=>false, 'code'=>0));
            }
        }else{
            $qtrx = $this->db->query("SELECT * FROM tx_transaksi WHERE unique_id='$postjson[idtrx]'")->row_array();

            if ($qtrx['is_digital']=='y') {
                if ($postjson['status']=='y') {
                    $status = 's';
                    kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'selesai');
                }else{
                    $status = $postjson['status'];
                    if ($status=='p') {
                        kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'proses');
                    }else if ($status=='b') {
                        kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'batal');
                    }else if ($status=='s') {
                        kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'selesai');
                    }
                }
            }else{
                $status = $postjson['status'];
                if ($status=='p') {
                    kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'proses');
                }else if ($status=='b') {
                    kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'batal');
                }else if ($status=='s') {
                    kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'selesai');
                }
            }

            // khusus point of sale
            if($qtrx['transaksi_from']=='POS'){
                if($status=='y'){
                    $status = 's';
                    kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'selesai');
                }
            }

            if ($qtrx) {
                $this->db->set([
                    'is_status' => $status,
                    'callback' => $postjson['callback']
                ]);
                $this->db->where('unique_id', $postjson['idtrx']);
                $res = $this->db->update('tx_transaksi');
                if ($res==true) {
                    return json_encode(array('success'=>true, 'code'=>1));
                }else{
                    return json_encode(array('success'=>false, 'msg'=>2));
                }
            }else{
                return json_encode(array('success'=>false, 'code'=>0));
            }
        }

    }

    public function proses_kirim_bukti_bayar($postjson) {

        $allowed = array('png', 'jpg', 'jpeg');
        $filename = $postjson['gambar'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            return json_encode(array('success'=>false, 'msg'=>'Format yang di izinkan hanya JPG dan PNG.'));
            exit();
        }

        $cekdata = cekDatarowarray('tx_transaksi','no_transaksi',$postjson['notrx']);

        if ($postjson['tipe']=='web') {

            $randname = date('Ymdhis').$postjson['idcust'];
            $pict = $postjson['gambar'];
            $temporari = $postjson['gambar_tmp'];
            $namagbr = "bukti_byr_".$randname."-".$postjson['gambar'];
            $filetujuan = "./../assets/uploaded/komponen/".$namagbr;
            $ukurangambar= $postjson['gambar_size'];
            $maxukuran = 2000000;
            $maxwidth = 2000;

            if ($postjson['gambar']=='') {
                $namagbr = $cekdata['bukti_pembayaran'];
            }else{
                if ($cekdata['bukti_pembayaran']!='n') {
                  unlink(FCPATH."./../assets/uploaded/komponen/".$cekdata['bukti_pembayaran']);
                }
                resizeImgv2($temporari, $filetujuan);
            }
        }else{
            if ($postjson['gambar']!='') {
                $ext = 'jpeg';
                $randname = date('Ymdhis').$postjson['idcust'];
                $imgstring = $postjson['gambar'];
                $imgstring = trim(str_replace('data:image/'.$ext.';base64,', "", $imgstring));
                $imgstring = str_replace(' ', '+', $imgstring);
                $data = base64_decode($imgstring);
                $namagbr  = "bukti_byr_".$postjson['idcust']."_".$randname.".jpg";  
                $directoryx = "./../assets/uploaded/komponen/".$namagbr;
                file_put_contents($directoryx, $data);
                if ($cekdata['bukti_pembayaran']!='n') {
                    unlink(FCPATH."./../assets/uploaded/komponen/".$cekdata['bukti_pembayaran']);
                }
            }else{
                $namagbr = $cekdata['bukti_pembayaran'];
            }
        }

        $update_trx = array(
            'bank_id'           => $postjson['idbank'],
            'bukti_pembayaran'  => $namagbr
        );

        $w_kr = array('no_transaksi' => $postjson['notrx'], 'cust_id' => $postjson['idcust']);
        $this->db->where($w_kr);
        $i = $this->db->update('tx_transaksi', $update_trx);

        if ($i==true) {
            return json_encode(array('success'=>true, 'msg'=>'Bukti pembayaran telah terkirim, proses pengecekan membutuhkan waktu hingga 1x24 jam.'));
        }else{
            return json_encode(array('success'=>false, 'msg'=>'Proses gagal, silahkan coba lagi.'));
        }
    }

    public function proses_update_topup_midtrans($postjson) {

        $qtrx = $this->db->query("SELECT * FROM tx_topup WHERE unique_id='$postjson[idtrx]'")->row_array();

        if ($postjson['status']=='y') {
            
            $saldo = $this->db->query("SELECT * FROM tx_saldo WHERE cust_id='$qtrx[cust_id]' ORDER BY saldo_id DESC LIMIT 1")->row_array();

            $data = [
                'cust_id'             => $qtrx['cust_id'],
                'kode_saldo'          => $qtrx['kode_topup'],
                'status_saldo'        => 1, // masuk ~~
                'tipe'                => 'topup',
                'awal'                => $saldo['akhir'],
                'masuk'               => $qtrx['nominal_topup'],
                'keluar'              => 0,
                'akhir'               => $saldo['akhir']+$qtrx['nominal_topup'],
                'created_at'          => date("Y-m-d H:i:s")
            ];

            $res = $this->db->insert('tx_saldo', $data);

            $this->db->set(['is_status' => 'y', 'bukti_pembayaran' => 'y']);
            $this->db->where('topup_id', $qtrx['topup_id']);
            $this->db->update('tx_topup');
        }else{
            $this->db->set([
                'is_status' => 'b',
                'if_cancel' => 'Transaksi telah dibatalkan pada <b>'.indo(date('Y-m-d')).' '.date('H:i').'</b> waktu setempat.<br>Oleh <b>Admin</b>.'
            ]);
            $this->db->where('topup_id', $qtrx['topup_id']);
            $this->db->update('tx_topup');
        }

    }

    public function proses_kirim_bukti_bayar_topup($postjson) {

        $cekdata = cekDatarowarray('tx_topup','kode_topup',$postjson['notrx']);

        if ($postjson['tipe']=='web') {

            $randname = date('Ymdhis').$postjson['idcust'];
            $pict = $postjson['gambar'];
            $temporari = $postjson['gambar_tmp'];
            $namagbr = "bukti_topup_".$randname."-".$postjson['gambar'];
            $filetujuan = "./../assets/uploaded/komponen/".$namagbr;
            $ukurangambar= $postjson['gambar_size'];
            $maxukuran = 2000000;
            $maxwidth = 2000;

            if ($postjson['gambar']=='') {
                $namagbr = $cekdata['bukti_pembayaran'];
            }else{
                if ($cekdata['bukti_pembayaran']!='n') {
                  unlink(FCPATH."./../assets/uploaded/komponen/".$cekdata['bukti_pembayaran']);
                }
                resizeImgv2($temporari, $filetujuan);
            }
        }else{
            if ($postjson['gambar']!='') {
                $ext = 'jpeg';
                $randname = date('Ymdhis').$postjson['idcust'];
                $imgstring = $postjson['gambar'];
                $imgstring = trim(str_replace('data:image/'.$ext.';base64,', "", $imgstring));
                $imgstring = str_replace(' ', '+', $imgstring);
                $data = base64_decode($imgstring);
                $namagbr  = "bukti_topup_".$postjson['idcust']."_".$randname.".jpg";  
                $directoryx = "./../assets/uploaded/komponen/".$namagbr;
                file_put_contents($directoryx, $data);
                if ($cekdata['bukti_pembayaran']!='n') {
                    unlink(FCPATH."./../assets/uploaded/komponen/".$cekdata['bukti_pembayaran']);
                }
            }else{
                $namagbr = $cekdata['bukti_pembayaran'];
            }
        }

        $update_trx = array(
            'bank_id'           => $postjson['idbank'],
            'bukti_pembayaran'  => $namagbr
        );

        $w_kr = array('kode_topup' => $postjson['notrx'], 'cust_id' => $postjson['idcust']);
        $this->db->where($w_kr);
        $i = $this->db->update('tx_topup', $update_trx);

        if ($i==true) {
            return json_encode(array('success'=>true, 'msg'=>'Bukti pembayaran telah terkirim, proses pengecekan membutuhkan waktu hingga 1x24 jam.'));
        }else{
            return json_encode(array('success'=>false, 'msg'=>'Proses gagal, silahkan coba lagi.'));
        }
    }

    public function proses_batalkan_transaksi($postjson) {

        $cek_stats_dlu = $this->db->query("SELECT * FROM tx_transaksi a JOIN m_customer b ON a.cust_id=b.cust_id WHERE a.no_transaksi='$postjson[notrx]' AND a.cust_id='$postjson[idcust]'")->row_array();
        if($cek_stats_dlu['is_status']=='p'){
            $bul = date('m'); $tahun = date('Y'); $tgl = date('mY');
            $nores = $this->db->query("SELECT max(substr(kode_stok,17,5))as no FROM tx_stok WHERE substr(kode_stok,5,4)='BTAL' AND substr(kode_stok,12,4)='$tahun'")->row_array();
            $has=intval($nores['no'])+1;
            $noTrx="TRX/BTAL/".$tgl."/".sprintf("%05d",$has);

            $query_stok = $this->db->query("SELECT * FROM tx_stok WHERE kode_stok='$postjson[notrx]' AND cust_id='$postjson[idcust]'")->result_array();
                
            foreach ($query_stok as $rows) {
                $stok = $this->produk->cekStok($rows['produk_id'],$rows['produk_warna_id'],$rows['produk_ukuran_id']);
                $data = [
                    'kode_stok'           => $noTrx,
                    'status_stok'         => 3, // stok kembali karna batal ~~
                    'produk_id'           => $rows['produk_id'],
                    'produk_warna_id'     => $rows['produk_warna_id'],
                    'produk_ukuran_id'    => $rows['produk_ukuran_id'],
                    'admin_id'            => '0', // default untuk ecommer
                    'cust_id'             => $postjson['idcust'], // default untuk ecommer
                    'awal'                => $stok['akhir'],
                    'masuk'               => $rows['keluar'],
                    'keluar'              => 0,
                    'akhir'               => $stok['akhir']+$rows['keluar'],
                    'label_stok'          => 'BTL', // default untuk batal
                    'keterangan_stok'     => 'BATAL-'.$rows['kode_stok'],
                    'created_at'          => date("Y-m-d H:i:s")
                ];

                if ($postjson['idcust']!=null) {
                    $this->db->insert('tx_stok', $data);

                    $this->db->set(['keterangan_stok' => 'BATAL-'.$rows['kode_stok']]);
                    $this->db->where('kode_stok', $rows['kode_stok']);
                    $this->db->update('tx_stok');
                }
            }

            $this->db->set([
                'is_status' => 'b',
                'if_cancel' => 'Transaksi telah dibatalkan pada <b>'.indo(date('Y-m-d')).' '.date('H:i').'</b> waktu setempat.<br>Oleh <b>Pembeli</b>.'
            ]);
            $this->db->where('no_transaksi', $postjson['notrx']);
            $this->db->update('tx_transaksi');

            $query_sec = $this->db->query("SELECT * FROM tx_transaksi a JOIN m_customer b ON a.cust_id=b.cust_id WHERE a.no_transaksi='$postjson[notrx]' AND a.cust_id='$postjson[idcust]'")->row_array();

            $dataInfo = [
                'cust_id'       => $postjson['idcust'],
                'sync_id'       => $query_sec['unique_id'],
                'tipe_notif'    => 'trx',
                'judul_notif'   => 'Transaksi '.$postjson['notrx'].' Telah Dibatalkan',
                'ket_notif'     => 'Transaksi telah dibatalkan oleh pembeli.',
                'is_read'       => 'y',
                'created_at'    => date("Y-m-d H:i:s")
            ];

            $res_trx_t = false;
            if ($postjson['idcust']!=null) {
                $res_trx_t = $this->db->insert('tx_notifikasi', $dataInfo);
            }

            if ($query_sec['metode_pembayaran']=='saldo') {
                $saldo = $this->db->query("SELECT * FROM tx_saldo WHERE cust_id='$query_sec[cust_id]' ORDER BY saldo_id DESC LIMIT 1")->row_array();

                $totalbayar_benerbener = $query_sec['harga_total']+$query_sec['ongkos_kirim']-$query_sec['potongan_total']-$query_sec['diskon_all_total']-$query_sec['potongan_voucher'];

                $datasaldo = [
                    'cust_id'             => $query_sec['cust_id'],
                    'kode_saldo'          => $query_sec['no_transaksi'],
                    'status_saldo'        => 1, // masuk ~~
                    'tipe'                => 'trx',
                    'awal'                => $saldo['akhir'],
                    'masuk'               => $totalbayar_benerbener,
                    'keluar'              => 0,
                    'akhir'               => $saldo['akhir']+$totalbayar_benerbener,
                    'created_at'          => date("Y-m-d H:i:s")
                ];

                $res_trx_t = $this->db->insert('tx_saldo', $datasaldo);
            }

            if ($res_trx_t==true) {
                return json_encode(array('success'=>true, 'msg'=>'Transaksi telah dibatalkan.'));
            }else{
                return json_encode(array('success'=>false, 'msg'=>'Proses gagal, silahkan coba lagi.'));
            }
        }else{
            if($cek_stats_dlu['is_status']=='b'){
                return json_encode(array('success'=>true, 'msg'=>'Transaksi telah dibatalkan.'));
            }else{
                return json_encode(array('success'=>false, 'msg'=>'Transaksi kamu sedang dalam diproses, tidak bisa dibatalkan.'));
            }
        }

    }

    public function proses_tiba_transaksi($postjson) {

        $qtrx = $this->db->query("SELECT * FROM tx_transaksi WHERE no_transaksi='$postjson[notrx]'")->row_array();

        $this->db->set(['is_status' => 's']);
        $this->db->where('transaksi_id', $qtrx['transaksi_id']);
        $this->db->update('tx_transaksi');

        $this->db->set(['is_status' => 'y']);
        $this->db->where('kode_saldo', $postjson['notrx']);
        $this->db->update('tx_saldo');

        $dataInfo = [
            'cust_id'       => $qtrx['cust_id'],
            'sync_id'       => $qtrx['unique_id'],
            'tipe_notif'    => 'trx',
            'judul_notif'   => 'Pesanan '.$qtrx['no_transaksi'].' Telah Tiba Ditujuan',
            'ket_notif'     => 'Pesanan telah sampai tujuan.',
            'is_read'       => 'n',
            'created_at'    => date("Y-m-d H:i:s")
        ];

        if ($postjson['idcust']!=null) {
            $res = $this->db->insert('tx_notifikasi', $dataInfo);
        }

        if ($res==true) {
            return json_encode(array('success'=>true, 'msg'=>'Transaksi telah selesai.'.$postjson['notrx']));
        }else{
            return json_encode(array('success'=>false, 'msg'=>'Proses gagal, silahkan coba lagi.'));
        }

    }

    public function proses_simpan_ulasan_rating($postjson) {

        $pengaturanSistem = pengaturanSistem();

        if ($pengaturanSistem['metode_ulasan']=='auto') {
            $m_ulasan = 'y';
        }else{
            $m_ulasan = 'n';
        }

        if ($pengaturanSistem['metode_rating']=='auto') {
            $m_rat = 'y';
        }else{
            $m_rat = 'n';
        }

        $update = array(
            'rating_produk'     => $postjson['rating'],
            'publikasi_rating'  => $m_rat,
            'ulasan_produk'     => $postjson['ulasan'],
            'publikasi_ulasan'  => $m_ulasan,
            'tgl_ulasan'        => date("Y-m-d H:i:s")
        );

        $w_kr = array('transaksi_det_id' => $postjson['idtrx'], 'cust_id' => $postjson['idcust']);

        $this->db->where($w_kr);
        $res = $this->db->update('tx_transaksi_det', $update);

        if ($res==true) {
            return json_encode(array('success'=>true, 'msg'=>'Terima kasih sudah memberikan ulasan dan rating.'));
        }else{
            return json_encode(array('success'=>false, 'msg'=>'Proses gagal, silahkan coba lagi.'));
        }

    }

    public function proses_baca_notifikasi($postjson) {

        $update = array('is_read' => 'y');

        if ($postjson['opsi']=='id') {
            $w_kr = array('notifikasi_id' => $postjson['idnotif'], 'cust_id' => $postjson['idcust']);
        }else{
            $w_kr = array('sync_id' => $postjson['idnotif'], 'cust_id' => $postjson['idcust']);
        }

        $this->db->where($w_kr);
        $this->db->update('tx_notifikasi', $update);

        return json_encode(array('success'=>true));
    }

    public function lupa_password($postjson,$mail) {

        if ($postjson['emailaddress']!='') {

            $q = $this->db->query("SELECT * FROM m_customer WHERE is_token='$postjson[emailaddress]'")->row_array();

                if ($q) {
                    if ($q['is_active']==1) {

                        $qq = $this->db->query("SELECT * FROM tx_lupa_password WHERE email_address='$postjson[emailaddress]' AND is_status='n'")->num_rows();

                        if ($qq==0) {
                            $uid = randCode(18);
                            $ilnk = $this->config->item("nhub_url").'resetpass/'.$uid;
                            $resemail = emailResetpassword($postjson['emailaddress'],$ilnk,$mail);
                            $data = [
                                'unique_id'             => $uid,
                                'email_address'         => $postjson['emailaddress'],
                                'is_status'             => 'n',
                                'created_at'            => date('Y-m-d H:i:s')
                            ];

                            if ($postjson['emailaddress']!=null) {
                                $this->db->insert('tx_lupa_password', $data);
                                return json_encode(array('success'=>true, 'msg'=>'Informasi perubahan password dikirim ke alamat email kamu, silahkan cek email untuk melanjutkan.'));
                            }
                        }else{
                            return json_encode(array('success'=>true, 'msg'=>'Informasi perubahan password dikirim ke alamat email kamu, silahkan cek email untuk melanjutkan.'));
                        }
                    }else if ($q['is_active']==0) {
                        return json_encode(array('success'=>false, 'msg'=>'Akun dengan email ini status belum ter-verifikasi.'));
                    }else {
                        return json_encode(array('success'=>false, 'msg'=>'Akun dengan email ini status tidak aktif, hubungi kontak support untuk informasi lebih lanjut.'));
                    }

                }else{
                    return json_encode(array('success'=>false, 'msg'=>'Email tidak terdaftar.'));
                }
        }else{
            return json_encode(array('success'=>false, 'msg'=>'Email tidak boleh kosong.'));
        }
    }

    public function reset_password($postjson) {

        if ($postjson['password_baru']==$postjson['password_confirm']) {
    
            if ($postjson['password_baru']!='' && $postjson['password_confirm']!='') {

                $q = $this->db->query("SELECT * FROM tx_lupa_password WHERE unique_id='$postjson[uniqueid]' AND is_status='n'")->row_array();

                if ($q) {
                    $password = password_hash($postjson['password_baru'], PASSWORD_DEFAULT);
                    $this->db->set(['is_password' => $password]);
                    $this->db->where('is_token', $q['email_address']);
                    $res = $this->db->update('m_customer');

                    if ($res==true) {

                        $this->db->set(['is_status' => 'y']);
                        $this->db->where('unique_id', $postjson['uniqueid']);
                        $this->db->update('tx_lupa_password');

                        return json_encode(array('success'=>true, 'msg'=>'Password berhasil diubah.'));
                    }else{
                        return json_encode(array('success'=>false, 'msg'=>'Proses gagal, silahkan coba lagi.'));
                    }

                }else{
                    return json_encode(array('success'=>false, 'msg'=>'Ulangi password tidak sesuai.'));
                }
            }else{
                return json_encode(array('success'=>false, 'msg'=>'Ulangi password tidak sesuai.'));
            }
        }else{
            return json_encode(array('success'=>false, 'msg'=>'Ulangi password tidak sesuai.'));
        }
    }

    public function callback_xendit($mail,$postjson) {

        $qtrx = $this->db->query("SELECT * FROM tx_transaksi WHERE unique_id='$postjson[external_id]'")->row_array();

        if ($qtrx) {
            if ($qtrx['is_digital']=='y') {
                if ($postjson['status']=='PAID') {
                    $status = 's';
                    kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'selesai');
                }else{
                    $status = 'b';
                    kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'batal');
                }
            }else{
                if ($postjson['status']=='PAID') {
                    $status = 'y';
                    kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'proses');
                }else{
                    $status = 'b';
                    kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'batal');
                }
            }

            // khusus point of sale
            if($qtrx['transaksi_from']=='POS'){
                if($status=='y'){
                    $status = 's';
                    kirimNotifEmailwa($mail,$qtrx['transaksi_id'],'selesai');
                }
            }

            $this->db->set([
                'is_status'     => $status,
                'biller_code'   => $postjson['bank_code'],
                'bill_key'      => $postjson['payment_channel'],
                'callback'      => json_encode($postjson)
            ]);
            $this->db->where('unique_id', $postjson['external_id']);
            $this->db->update('tx_transaksi');
            return json_encode(array('success'=>true));
        }else{
            return json_encode(array('success'=>false, 'msg'=>'Transaksi tidak ditemukan.'));
        }
    }

    public function proses_live_chat($postjson) {

        if (strpos($postjson['txt'], '<a') !== false) {
            if (strpos($postjson['txt'], 'href') !== false) {
                $ilnk = substr($this->config->item("nhub_url"),0,-13);
                if (strpos($postjson['txt'], $ilnk) !== false) {
                    $postjson['txt'] = $postjson['txt'];
                }
                else {
                    $postjson['txt'] = $postjson['txt']."\n\nSepertinya link phising.";
                }
            }
            if (!strpos($postjson['txt'], '</a>') !== false) {
                $postjson['txt'] = $postjson['txt']."></a>\n\nSepertinya link phising.";
            }
        }

        $data = [
            'cust_id'     => $postjson['idcust'],
            'admin_id'    => 0,
            'deskripsi'   => str_replace_html_noa($postjson['txt']),
            'tgl_chat'    => date('Y-m-d H:i:s')
        ];

        if ($postjson['idcust']!=null) {
            $this->db->insert('tx_chat', $data);
        }

        return json_encode(array('success'=>true));
    }

    public function track_visit($postjson) {
        
        $date = date('Y-m-d');
        $time = time();

        // Cek apakah pengunjung sudah tercatat hari ini
        $this->db->where('ip_address', $postjson['ip']);
        $this->db->where('visit_date', $date);
        $query = $this->db->get('visitor_stats');

        if ($query->num_rows() > 0) {
            $data = $query->row_array();
            if (($time - $data['last_activity']) > 2) {
                $this->db->set(['last_activity' => $time, 'count_page' => $data['count_page']+1]);
                $this->db->where('ip_address', $postjson['ip']);
                $this->db->where('visit_date', $date);
                $this->db->update('visitor_stats');
            }
        } else {
            // Tambahkan kunjungan baru
            $this->db->insert('visitor_stats', [
                'visit_date' => $date,
                'ip_address' => $postjson['ip'],
                'count_page' => 1,
                'last_activity' => $time
            ]);
        }

        return json_encode(array('success'=>true));
    }

    public function get_statistic_visitors($postjson) {

        if(isset($postjson['tgl'])){
            $today = $postjson['tgl'];
        }else{
            $today = date('Y-m-d');
        }

        $time_limit = time() - (1 * 60); // 1 menit

        // Hitung jumlah pengunjung unik berdasarkan IP per tanggal tertentu
        $this->db->where('visit_date', $today);
        $this->db->select('COUNT(DISTINCT ip_address) as today_visitors');
        $query = $this->db->get('visitor_stats');

        // Hitung jumlah pengunjung Online 
        $this->db->where('last_activity >', $time_limit);
        $this->db->select('COUNT(DISTINCT ip_address) as online_visitors');
        $query2 = $this->db->get('visitor_stats');

        // Hitung jumlah total pengunjung semua waktu
        $this->db->select('COUNT(DISTINCT ip_address) as total_visitors');
        $query3 = $this->db->get('visitor_stats');

        // Hitung jumlah pengunjung page
        $this->db->where('visit_date', $today);
        $this->db->select('sum(count_page) as visitors_pages');
        $query4 = $this->db->get('visitor_stats');

        // Hitung jumlah pengunjung page semua waktu
        $this->db->select('sum(count_page) as total_visitors_pages');
        $query5 = $this->db->get('visitor_stats');
        
        return json_encode(array('success'=>true, 
        'today_visitors'=>$query->row()->today_visitors, 
        'online_visitors'=>$query2->row()->online_visitors, 
        'total_visitors'=>$query3->row()->total_visitors, 
        'visitors_pages'=>$query4->row()->visitors_pages, 
        'total_visitors_pages'=>$query5->row()->total_visitors_pages));
    }

    public function tarik_saldo_user($postjson) {

        $bul = date('m'); $tahun = date('Y'); $tgl = date('mY');
        $nores = $this->db->query("SELECT max(substr(kode_tarik,17,5))as no FROM tx_saldo_tarik WHERE substr(kode_tarik,5,4)='WDSU' AND substr(kode_tarik,12,4)='$tahun'")->row_array();
        $has=intval($nores['no'])+1;
        $noTrx="TRX/WDSU/".$tgl."/".sprintf("%05d",$has);
        
        $dataFirst = [
            'kode_tarik'              => $noTrx,
            'cust_id'                 => $postjson['idcust'],
            'nominal'                 => $postjson['nominal_tarik'],
            'nama_rekening'           => $postjson['nama_rek'],
            'nomor_rekening'          => $postjson['no_rek'],
            'bank_tarik_id'           => $postjson['bank_tarik_id'],
            'is_status'               => 'p', // pending
            'created_at'              => date('Y-m-d H:i:s')
        ];
        $res_trx = $this->db->insert('tx_saldo_tarik', $dataFirst);

        if($res_trx==true){
            $msg = 'Proses penarikan sedang diproses, membutuhkan waktu hingga 1x24 jam atau lebih lama.';
        }else{
            $msg = 'Gagal memproses! silahkan refresh dan coba lagi.';
        }

        return json_encode(array('success'=>$res_trx, 'msg'=>$msg));
    }

}

?>