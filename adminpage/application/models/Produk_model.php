<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk_model extends CI_Model {

    public function hapusProdukImg($id) {
        $query = $this->db->query("SELECT * FROM m_produk_img WHERE produk_img_id='$id'")->row_array();

        if ($query) {
            $res = $this->db->delete('m_produk_img', ['produk_img_id' => $id]);
            if ($res==true) {
                unlink(FCPATH .'./../assets/uploaded/products/'.$query['logo_image']); 
                return 'y';
            }else{
                return 'n';
            }
        }else{
            return 'n';
        }
    }

    public function editProdukImg($primary_id,$upload,$cekimg,$old_gambar) {
        if ($cekimg=='') { $imgnya = $old_gambar; }else{ $imgnya = $upload['file']['file_name']; }
        $this->db->set(['logo_image'       => $imgnya]);
        $this->db->where('produk_img_id', $primary_id);
        $res = $this->db->update('m_produk_img');
    }

    public function tambahProdukImg($id,$upload) {
        $data = [
            'produk_id'       => $id,
            'logo_image'      => $upload['file']['file_name']
        ];
        $res = $this->db->insert('m_produk_img', $data);
        return $res;
    }

    public function dataprodKategori($id) {
        $datatext = '';
        $datatextid = '';
        $query = $this->db->query("SELECT distinct(a.kategori_id),b.* FROM m_produk_kategori a JOIN m_kategori b ON a.kategori_id=b.kategori_id WHERE a.produk_id='$id'")->result_array();

        foreach ($query as $row) {
            $datatext .= $row['nama_kategori'].", ";
            $datatextid .= $row['kategori_id']."-";
        }

        $datatext = substr($datatext, 0,-2);
        $datatextid = substr($datatextid, 0,-1);

        return array('success'=>true, 'result'=>$query, 'datatext'=>$datatext, 'datatextid'=>$datatextid);

    }

    public function dataprodsubKategori($id) {
        $datatext = '';
        $datatextid = '';
        $query = $this->db->query("SELECT distinct(a.kategori_sub_id),b.* FROM m_produk_kategori a JOIN m_kategori_sub b ON a.kategori_sub_id=b.kategori_sub_id WHERE a.produk_id='$id'")->result_array();

        foreach ($query as $row) {
            $datatext .= $row['nama_kategori'].", ";
        }

        $datatext = substr($datatext, 0,-2);
        $datatextid = substr($datatextid, 0,-1);

        return array('success'=>true, 'result'=>$query, 'datatext'=>$datatext);

    }

    public function dataprodsubLv2Kategori($id) {
        $datatext = '';
        $query = $this->db->query("SELECT distinct(a.kategori_sub_lv2_id),b.* FROM m_produk_kategori a JOIN m_kategori_sub_lv2 b ON a.kategori_sub_lv2_id=b.kategori_sub_lv2_id WHERE a.produk_id='$id'")->result_array();

        foreach ($query as $row) {
            $datatext .= $row['nama_kategori'].", ";
        }

        $datatext = substr($datatext, 0,-2);

        return array('success'=>true, 'result'=>$query, 'datatext'=>$datatext);

    }

    public function dataprodWarna($id,$st = null) {
        $datatext = '';

        if ($st==null) {
            $wh = " ";
        }else{
            $wh = " AND is_status='$st' ";
        }

        $query = $this->db->query("SELECT * FROM m_produk_warna a JOIN m_warna b ON a.warna_id=b.warna_id WHERE a.produk_id='$id' $wh ")->result_array();

        foreach ($query as $row) {
            $datatext .= $row['nama_warna'].", ";
        }

        $datatext = substr($datatext, 0,-2);

        return array('success'=>true, 'result'=>$query, 'datatext'=>$datatext);

    }

    public function dataprodUkuran($id,$st = null) {
        $datatext = '';

        if ($st==null) {
            $wh = " ";
        }else{
            $wh = " AND is_status='$st' ";
        }

        $query = $this->db->query("SELECT * FROM m_produk_ukuran a JOIN m_ukuran b ON a.ukuran_id=b.ukuran_id WHERE a.produk_id='$id' $wh ")->result_array();

        foreach ($query as $row) {
            $datatext .= $row['ukuran_size'].", ";
        }

        $datatext = substr($datatext, 0,-2);

        return array('success'=>true, 'result'=>$query, 'datatext'=>$datatext);

    }

    public function selectSub($id) {

        $data = array();
        $query = array();
        $query2 = array();
        $query3 = array();
        $expl = explode("-", $id);

        if ($expl[0]>0) {
            $query = $this->db->query("SELECT a.kategori_id,a.kategori_sub_id,b.nama_kategori as nama_sub,c.nama_kategori FROM m_kategori_det a JOIN m_kategori_sub b ON a.kategori_sub_id=b.kategori_sub_id JOIN m_kategori c ON a.kategori_id=c.kategori_id WHERE b.is_hapus='n' AND b.is_active='1' AND a.kategori_id='$expl[0]' ORDER BY b.nama_kategori ASC")->result_array();
        }

        foreach ($query as $row) {
            $data[] = array(
                'kategori_id'       => $row['kategori_id'],
                'kategori_sub_id'   => $row['kategori_sub_id'],
                'nama_kategori'     => $row['nama_kategori'],
                'nama_sub'          => $row['nama_sub']
            );
        }

        if (isset($expl[1])) {
            $query2 = $this->db->query("SELECT a.kategori_id,a.kategori_sub_id,b.nama_kategori as nama_sub,c.nama_kategori FROM m_kategori_det a JOIN m_kategori_sub b ON a.kategori_sub_id=b.kategori_sub_id JOIN m_kategori c ON a.kategori_id=c.kategori_id WHERE b.is_hapus='n' AND b.is_active='1' AND a.kategori_id='$expl[1]' ORDER BY b.nama_kategori ASC")->result_array();
        }

        foreach ($query2 as $row) {
            $data[] = array(
                'kategori_id'       => $row['kategori_id'],
                'kategori_sub_id'   => $row['kategori_sub_id'],
                'nama_kategori'     => $row['nama_kategori'],
                'nama_sub'          => $row['nama_sub']
            );
        }

        if (isset($expl[2])) {
            $query3 = $this->db->query("SELECT a.kategori_id,a.kategori_sub_id,b.nama_kategori as nama_sub,c.nama_kategori FROM m_kategori_det a JOIN m_kategori_sub b ON a.kategori_sub_id=b.kategori_sub_id JOIN m_kategori c ON a.kategori_id=c.kategori_id WHERE b.is_hapus='n' AND b.is_active='1' AND a.kategori_id='$expl[2]' ORDER BY b.nama_kategori ASC")->result_array();
        }

        foreach ($query3 as $row) {
            $data[] = array(
                'kategori_id'       => $row['kategori_id'],
                'kategori_sub_id'   => $row['kategori_sub_id'],
                'nama_kategori'     => $row['nama_kategori'],
                'nama_sub'          => $row['nama_sub']
            );
        }

        return array('success'=>true, 'result'=>$data);

    }

    public function selectSub2($id) {

        $data = array();
        $query = array();
        $query2 = array();
        $query3 = array();
        $query4 = array();
        $query5 = array();
        $expl = explode("-", $id);

        if ($expl[0]>0) {
            $expl1 = explode("__", $expl[0]);
            $query = $this->db->query("SELECT a.kategori_sub_id,a.kategori_sub_lv2_id,b.nama_kategori as nama_sub,c.nama_kategori,d.kategori_id FROM m_kategori_sub_det a JOIN m_kategori_sub_lv2 b ON a.kategori_sub_lv2_id=b.kategori_sub_lv2_id JOIN m_kategori_sub c ON a.kategori_sub_id=c.kategori_sub_id JOIN m_kategori_det d ON a.kategori_sub_id=d.kategori_sub_id WHERE b.is_hapus='n' AND b.is_active='1' AND a.kategori_sub_id='$expl1[1]' ORDER BY b.nama_kategori ASC")->result_array();
        }

        foreach ($query as $row) {
            $data[] = array(
                'kategori_id'               => $row['kategori_id'],
                'kategori_sub_id'           => $row['kategori_sub_id'],
                'kategori_sub_lv2_id'       => $row['kategori_sub_lv2_id'],
                'nama_kategori'             => $row['nama_kategori'],
                'nama_sub'                  => $row['nama_sub']
            );
        }

        if (isset($expl[1])) {
            $expl2 = explode("__", $expl[1]);
            $query2 = $this->db->query("SELECT a.kategori_sub_id,a.kategori_sub_lv2_id,b.nama_kategori as nama_sub,c.nama_kategori,d.kategori_id FROM m_kategori_sub_det a JOIN m_kategori_sub_lv2 b ON a.kategori_sub_lv2_id=b.kategori_sub_lv2_id JOIN m_kategori_sub c ON a.kategori_sub_id=c.kategori_sub_id JOIN m_kategori_det d ON a.kategori_sub_id=d.kategori_sub_id WHERE b.is_hapus='n' AND b.is_active='1' AND a.kategori_sub_id='$expl2[1]' ORDER BY b.nama_kategori ASC")->result_array();
        }

        foreach ($query2 as $row) {
            $data[] = array(
                'kategori_id'               => $row['kategori_id'],
                'kategori_sub_id'           => $row['kategori_sub_id'],
                'kategori_sub_lv2_id'       => $row['kategori_sub_lv2_id'],
                'nama_kategori'             => $row['nama_kategori'],
                'nama_sub'                  => $row['nama_sub']
            );
        }

        if (isset($expl[2])) {
            $expl3 = explode("__", $expl[2]);
            $query3 = $this->db->query("SELECT a.kategori_sub_id,a.kategori_sub_lv2_id,b.nama_kategori as nama_sub,c.nama_kategori,d.kategori_id FROM m_kategori_sub_det a JOIN m_kategori_sub_lv2 b ON a.kategori_sub_lv2_id=b.kategori_sub_lv2_id JOIN m_kategori_sub c ON a.kategori_sub_id=c.kategori_sub_id JOIN m_kategori_det d ON a.kategori_sub_id=d.kategori_sub_id WHERE b.is_hapus='n' AND b.is_active='1' AND a.kategori_sub_id='$expl3[1]' ORDER BY b.nama_kategori ASC")->result_array();
        }

        foreach ($query3 as $row) {
            $data[] = array(
                'kategori_id'               => $row['kategori_id'],
                'kategori_sub_id'           => $row['kategori_sub_id'],
                'kategori_sub_lv2_id'       => $row['kategori_sub_lv2_id'],
                'nama_kategori'             => $row['nama_kategori'],
                'nama_sub'                  => $row['nama_sub']
            );
        }

        if (isset($expl[3])) {
            $expl4 = explode("__", $expl[3]);
            $query4 = $this->db->query("SELECT a.kategori_sub_id,a.kategori_sub_lv2_id,b.nama_kategori as nama_sub,c.nama_kategori,d.kategori_id FROM m_kategori_sub_det a JOIN m_kategori_sub_lv2 b ON a.kategori_sub_lv2_id=b.kategori_sub_lv2_id JOIN m_kategori_sub c ON a.kategori_sub_id=c.kategori_sub_id JOIN m_kategori_det d ON a.kategori_sub_id=d.kategori_sub_id WHERE b.is_hapus='n' AND b.is_active='1' AND a.kategori_sub_id='$expl4[1]' ORDER BY b.nama_kategori ASC")->result_array();
        }

        foreach ($query4 as $row) {
            $data[] = array(
                'kategori_id'               => $row['kategori_id'],
                'kategori_sub_id'           => $row['kategori_sub_id'],
                'kategori_sub_lv2_id'       => $row['kategori_sub_lv2_id'],
                'nama_kategori'             => $row['nama_kategori'],
                'nama_sub'                  => $row['nama_sub']
            );
        }

        if (isset($expl[4])) {
            $expl5 = explode("__", $expl[4]);
            $query5 = $this->db->query("SELECT a.kategori_sub_id,a.kategori_sub_lv2_id,b.nama_kategori as nama_sub,c.nama_kategori,d.kategori_id FROM m_kategori_sub_det a JOIN m_kategori_sub_lv2 b ON a.kategori_sub_lv2_id=b.kategori_sub_lv2_id JOIN m_kategori_sub c ON a.kategori_sub_id=c.kategori_sub_id JOIN m_kategori_det d ON a.kategori_sub_id=d.kategori_sub_id WHERE b.is_hapus='n' AND b.is_active='1' AND a.kategori_sub_id='$expl5[1]' ORDER BY b.nama_kategori ASC")->result_array();
        }

        foreach ($query5 as $row) {
            $data[] = array(
                'kategori_id'               => $row['kategori_id'],
                'kategori_sub_id'           => $row['kategori_sub_id'],
                'kategori_sub_lv2_id'       => $row['kategori_sub_lv2_id'],
                'nama_kategori'             => $row['nama_kategori'],
                'nama_sub'                  => $row['nama_sub']
            );
        }

        return array('success'=>true, 'result'=>$data);

    }

    public function tambahProduk($upload,$upload2,$upload3,$upload4,$uploaddigital = null) {
        $idnya = urutId('m_produk',"produk_id");

        if ($uploaddigital != null) {
            if ($_FILES['digital']['name']!='') {
                $filedig = $uploaddigital['file']['file_name'];
            }else{
                $filedig = '';
            }
        }else{
            $filedig = '';
        }

        $data = [
            'produk_id'             => $idnya,
            'kode_produk'           => $this->input->post('kode_produk'),
            'nama_produk'           => $this->input->post('nama_produk'),
            'url_produk'            => url_replace($this->input->post('nama_produk')),
            'harga_produk'          => $this->input->post('harga_produk'),
            'berat_produk'          => $this->input->post('berat_produk'),
            'keterangan_produk'     => $this->input->post('keterangan_produk'),
            'potongan_status'       => $this->input->post('potongan_status'),
            'potongan_diskon'       => $this->input->post('potongan_diskon'),
            'potongan_mulai'        => $this->input->post('potongan_mulai'),
            'potongan_akhir'        => $this->input->post('potongan_akhir'),
            'is_new'                => $this->input->post('is_new'),
            'is_digital'            => $this->input->post('is_digital'),
            'status_affiliate'        => $this->input->post('status_affiliate'),
            'komisi_affiliate_produk' => $this->input->post('komisi_affiliate_produk'),
            'meta_title'            => $this->input->post('meta_title'),
            'meta_deskripsi'        => $this->input->post('meta_deskripsi'),
            'is_active'             => 1,
            'file_digital'          => $filedig,
            'created_at'            => date('Y-m-d H:i:s')
        ];
        $res = $this->db->insert('m_produk', $data);

        if ($res==true) {

            /* ----------------------------------- Triple Kategori */

            /* Lv1 */
            $kateg = $this->input->post('kategori_id');
            foreach ($kateg as $key => $value) {
                if($value!=""){
                    $datakg = [
                        'produk_id'             => $idnya,
                        'kategori_id'           => $value
                    ];
                    $this->db->insert('m_produk_kategori', $datakg);
                }
            }

            /* Lv2 */
            $check_ksub = $this->db->query("SELECT * FROM m_produk_kategori WHERE produk_id='$idnya'")->result_array();
            foreach ($check_ksub as $row) {
                $kategSub = $this->input->post('kategori_sub_id');
                if ($kategSub!='') {
                    foreach ($kategSub as $key_k => $value_k) {
                        if($value_k!=""){
                            $expl = explode("__", $value_k);
                            $check_ksub = $this->db->query("SELECT * FROM m_produk_kategori WHERE produk_kategori_id='$row[produk_kategori_id]' AND produk_id='$idnya' AND kategori_id='$expl[0]'")->row_array();
                            if ($check_ksub) {
                                $this->db->set(['kategori_sub_id' => $expl[1]]);
                                $this->db->where('produk_kategori_id', $row['produk_kategori_id']);
                                $res = $this->db->update('m_produk_kategori');
                            }
                        }
                    }
                }
            }

            $kategSub = $this->input->post('kategori_sub_id');
            if ($kategSub!='') {
                foreach ($kategSub as $key_k => $value_k) {
                    if($value_k!=""){
                        $expl = explode("__", $value_k);
                        $check_ksub = $this->db->query("SELECT * FROM m_produk_kategori WHERE produk_id='$idnya' AND kategori_id='$expl[0]' AND kategori_sub_id='$expl[1]'")->row_array();
                        if (!$check_ksub) {
                            $datakg = [
                                'produk_id'             => $idnya,
                                'kategori_id'           => $expl[0],
                                'kategori_sub_id'       => $expl[1]
                            ];
                            $this->db->insert('m_produk_kategori', $datakg);
                        }
                    }
                }
            }

            /* Lv3 */
            $check_ksub2 = $this->db->query("SELECT * FROM m_produk_kategori WHERE produk_id='$idnya'")->result_array();
            foreach ($check_ksub2 as $row) {
                $kategSub2 = $this->input->post('kategori_sub_lv2_id');
                if ($kategSub2!='') {
                    foreach ($kategSub2 as $key_k => $value_k) {
                        if($value_k!=""){
                            $expl = explode("__", $value_k);
                            $check_ksub2 = $this->db->query("SELECT * FROM m_produk_kategori WHERE produk_kategori_id='$row[produk_kategori_id]' AND produk_id='$idnya' AND kategori_id='$expl[0]' AND kategori_sub_id='$expl[1]'")->row_array();
                            if ($check_ksub2) {
                                $this->db->set(['kategori_sub_lv2_id' => $expl[2]]);
                                $this->db->where('produk_kategori_id', $row['produk_kategori_id']);
                                $res = $this->db->update('m_produk_kategori');
                            }
                        }
                    }
                }
            }


            $kategSub2 = $this->input->post('kategori_sub_lv2_id');
            if ($kategSub2!='') {
                foreach ($kategSub2 as $key_k => $value_k) {
                    if($value_k!=""){
                        $expl = explode("__", $value_k);
                        $check_ksub2 = $this->db->query("SELECT * FROM m_produk_kategori WHERE produk_id='$idnya' AND kategori_id='$expl[0]' AND kategori_sub_id='$expl[1]' AND kategori_sub_lv2_id='$expl[2]'")->row_array();
                        if (!$check_ksub2) {
                            $datakg = [
                                'produk_id'             => $idnya,
                                'kategori_id'           => $expl[0],
                                'kategori_sub_id'       => $expl[1],
                                'kategori_sub_lv2_id'   => $expl[2]
                            ];
                            $this->db->insert('m_produk_kategori', $datakg);
                        }
                    }
                }
            }

            /* ----------------------------------- End Triple Kategori */

            $warna = $this->input->post('warna_id');
            if ($warna!='') {
                foreach ($warna as $key => $value) {
                    if($value!=""){
                        $datawarna = [
                            'produk_id' => $idnya,
                            'warna_id' => $value
                        ];
                        $this->db->insert('m_produk_warna', $datawarna);
                    }
                }
            }else{
                $datawarna = [
                    'produk_id' => $idnya,
                    'warna_id' => 1
                ];
                $this->db->insert('m_produk_warna', $datawarna);
            }

            $ht_ukuran = $this->input->post('harga_tambahan_ukuran');
            $ukuran = $this->input->post('ukuran_id');
            if ($ukuran!='') {
                foreach ($ukuran as $key => $value) {
                    if($value!=""){
                        $dataukuran = [
                            'produk_id' => $idnya,
                            'ukuran_id' => $value,
                            'tambahan_harga' => $ht_ukuran[$key]
                        ];
                        $this->db->insert('m_produk_ukuran', $dataukuran);
                    }
                }
            }else{
                $dataukuran = [
                    'produk_id' => $idnya,
                    'ukuran_id' => 1,
                    'tambahan_harga' => 0
                ];
                $this->db->insert('m_produk_ukuran', $dataukuran);
            }

            $dataimg1 = ['produk_id'     => $idnya, 'logo_image'    => $upload['file']['file_name']];
            $this->db->insert('m_produk_img', $dataimg1);
            if ($upload2['result']=='success'){
                $dataimg2 = ['produk_id'     => $idnya, 'logo_image'    => $upload2['file']['file_name']];
                $this->db->insert('m_produk_img', $dataimg2);
            }
            if ($upload3['result']=='success'){
                $dataimg3 = ['produk_id'     => $idnya, 'logo_image'    => $upload3['file']['file_name']];
                $this->db->insert('m_produk_img', $dataimg3);
            }
            if ($upload4['result']=='success'){
                $dataimg4 = ['produk_id'     => $idnya, 'logo_image'    => $upload4['file']['file_name']];
                $this->db->insert('m_produk_img', $dataimg4);
            }
        }

        return $res;
    }

    public function editProduk($primary_id,$uploaddigital,$cekdigital,$old_digital) {

        if ($cekdigital=='') { $fdig = $old_digital; }else{ $fdig = $uploaddigital['file']['file_name']; }

        $this->db->set([
            'kode_produk'           => $this->input->post('kode_produk'),
            'nama_produk'           => $this->input->post('nama_produk'),
            'url_produk'            => url_replace($this->input->post('nama_produk')),
            'harga_produk'          => $this->input->post('harga_produk'),
            'berat_produk'          => $this->input->post('berat_produk'),
            'keterangan_produk'     => $this->input->post('keterangan_produk'),
            'potongan_status'       => $this->input->post('potongan_status'),
            'potongan_diskon'       => $this->input->post('potongan_diskon'),
            'potongan_mulai'        => $this->input->post('potongan_mulai'),
            'potongan_akhir'        => $this->input->post('potongan_akhir'),
            'is_active'             => $this->input->post('is_active'),
            'is_new'                => $this->input->post('is_new'),
            'status_affiliate'        => $this->input->post('status_affiliate'),
            'komisi_affiliate_produk' => $this->input->post('komisi_affiliate_produk'),
            'meta_title'            => $this->input->post('meta_title'),
            'meta_deskripsi'        => $this->input->post('meta_deskripsi'),
            'is_digital'            => $this->input->post('is_digital'),
            'file_digital'          => $fdig
        ]);
        $this->db->where('produk_id', $primary_id);
        $res = $this->db->update('m_produk');

        if ($res==true) {
            
            /* ----------------------------------- Triple Kategori */
            $this->db->delete('m_produk_kategori', ['produk_id' => $primary_id]);

            /* Lv1 */
            $kateg = $this->input->post('kategori_id');
            foreach ($kateg as $key => $value) {
                if($value!=""){
                    $datakg = [
                        'produk_id'             => $primary_id,
                        'kategori_id'           => $value
                    ];
                    $this->db->insert('m_produk_kategori', $datakg);
                }
            }

            /* Lv2 */
            $kategSub = $this->input->post('kategori_sub_id');
            if ($kategSub!='') {
                foreach ($kategSub as $key_k => $value_k) {
                    if($value_k!=""){
                        $expl = explode("__", $value_k);
                        $check_ksub = $this->db->query("SELECT * FROM m_produk_kategori WHERE produk_id='$primary_id' AND kategori_id='$expl[0]' AND kategori_sub_id='$expl[1]'")->row_array();
                        if (!$check_ksub) {
                            $datakg = [
                                'produk_id'             => $primary_id,
                                'kategori_id'           => $expl[0],
                                'kategori_sub_id'       => $expl[1]
                            ];
                            $this->db->insert('m_produk_kategori', $datakg);
                        }
                    }
                }
            }

            /* Lv3 */
            $kategSub2 = $this->input->post('kategori_sub_lv2_id');
            if ($kategSub2!='') {
                foreach ($kategSub2 as $key_k => $value_k) {
                    if($value_k!=""){
                        $expl = explode("__", $value_k);
                        $check_ksub2 = $this->db->query("SELECT * FROM m_produk_kategori WHERE produk_id='$primary_id' AND kategori_id='$expl[0]' AND kategori_sub_id='$expl[1]' AND kategori_sub_lv2_id='$expl[2]'")->row_array();
                        if (!$check_ksub2) {
                            $datakg = [
                                'produk_id'             => $primary_id,
                                'kategori_id'           => $expl[0],
                                'kategori_sub_id'       => $expl[1],
                                'kategori_sub_lv2_id'   => $expl[2]
                            ];
                            $this->db->insert('m_produk_kategori', $datakg);
                        }
                    }
                }
            }

            /* ----------------------------------- End Triple Kategori */

            $this->db->set(['is_status' => 'n']);
            $this->db->where('produk_id', $primary_id);
            $this->db->update('m_produk_warna');
            $warna = $this->input->post('warna_id');
            if ($warna!='') {
                foreach ($warna as $key => $value) {
                    if($value!=""){

                        $q = $this->db->query("SELECT * FROM m_produk_warna WHERE produk_id='$primary_id' AND warna_id='$value'")->row_array();
                        if ($q) {
                            $this->db->set(['is_status' => 'y']);
                            $this->db->where('produk_warna_id', $q['produk_warna_id']);
                            $this->db->update('m_produk_warna');
                        }else{
                            $datawarna = [
                                'produk_id' => $primary_id,
                                'warna_id' => $value
                            ];
                            $this->db->insert('m_produk_warna', $datawarna);                          
                        }
                    }
                }

                if ($value!='1') {
                    $dataupdate = array('is_status' => 'n');
                    $wheres = array('produk_id' => $primary_id, 'warna_id' => '1');
                    $this->db->where($wheres);
                    $this->db->update('m_produk_warna', $dataupdate);
                }
                
            }else{
                $q = $this->db->query("SELECT * FROM m_produk_warna WHERE produk_id='$primary_id' AND warna_id='1'")->row_array();
                if ($q) {
                    $dataupdate = array('is_status' => 'y');
                    $wheres = array('produk_id' => $primary_id, 'warna_id' => '1');
                    $this->db->where($wheres);
                    $this->db->update('m_produk_warna', $dataupdate);
                }else{
                    $datawarna = [
                        'produk_id' => $primary_id,
                        'warna_id' => 1
                    ];
                    $this->db->insert('m_produk_warna', $datawarna);
                }
            }

            $this->db->set(['is_status' => 'n']);
            $this->db->where('produk_id', $primary_id);
            $this->db->update('m_produk_ukuran');
            $ht_ukuran = $this->input->post('harga_tambahan_ukuran');
            $ukuran = $this->input->post('ukuran_id');
            if ($ukuran!='') {
                foreach ($ukuran as $key => $value) {
                    if($value!=""){
                        $q = $this->db->query("SELECT * FROM m_produk_ukuran WHERE produk_id='$primary_id' AND ukuran_id='$value'")->row_array();
                        if ($q) {
                            $this->db->set(['is_status' => 'y', 'tambahan_harga' => $ht_ukuran[$key]]);
                            $this->db->where('produk_ukuran_id', $q['produk_ukuran_id']);
                            $this->db->update('m_produk_ukuran');
                        }else{
                            $dataukuran = [
                                'produk_id' => $primary_id,
                                'ukuran_id' => $value,
                                'tambahan_harga' => $ht_ukuran[$key]
                            ];
                            $this->db->insert('m_produk_ukuran', $dataukuran);                            
                        }
                    }
                }

                if ($value!='1') {
                    $dataupdate = array('is_status' => 'n');
                    $wheres = array('produk_id' => $primary_id, 'ukuran_id' => '1');
                    $this->db->where($wheres);
                    $this->db->update('m_produk_ukuran', $dataupdate);
                }

            }else{
                $q = $this->db->query("SELECT * FROM m_produk_ukuran WHERE produk_id='$primary_id' AND ukuran_id='1'")->row_array();
                if ($q) {
                    $dataupdate = array('is_status' => 'y');
                    $wheres = array('produk_id' => $primary_id, 'ukuran_id' => '1');
                    $this->db->where($wheres);
                    $this->db->update('m_produk_ukuran', $dataupdate);
                }else{
                    $dataukuran = [
                        'produk_id' => $primary_id,
                        'ukuran_id' => 1,
                        'tambahan_harga' => 0
                    ];
                    $this->db->insert('m_produk_ukuran', $dataukuran);
                }
            }

        }

        return $res;
    }

    public function cekStok($id,$p_wid,$p_uid) {
        $query = "SELECT * FROM tx_stok WHERE produk_id='$id' AND produk_warna_id='$p_wid' AND produk_ukuran_id='$p_uid' ORDER BY stok_id DESC LIMIT 1";
        return $this->db->query($query)->row_array();
    }

    public function tambahStok() {

        $bul = date('m'); $tahun = date('Y'); $tgl = date('mY');
        $nores = $this->db->query("SELECT max(substr(kode_stok,17,5))as no FROM tx_stok WHERE substr(kode_stok,5,4)='STOK' AND substr(kode_stok,12,4)='$tahun'")->row_array();
        $has=intval($nores['no'])+1;
        $noJadi="OPN/STOK/".$tgl."/".sprintf("%05d",$has);

        $produk = $this->input->post('produk_id');
        foreach ($produk as $key => $value) {
            if($value!=""){
                $p_warnaid = $this->input->post('produk_warna_id')[$key];
                $stok = $this->input->post('stok'.$p_warnaid);
                foreach ($stok as $keys => $values) {
                    if($values!=""){
                        $p_ukuranid = $this->input->post('produk_ukuran_id'.$p_warnaid)[$keys];

                        $mstok = $this->db->query("SELECT akhir FROM tx_stok WHERE produk_id='$value' AND produk_warna_id='$p_warnaid' AND produk_ukuran_id='$p_ukuranid' ORDER BY stok_id DESC LIMIT 1")->row_array();

                        if (!isset($mstok['akhir'])) {
                            $mstok['akhir'] = 0;
                        }

                        //$mstok = $this->db->query("SELECT max(stok_id) as stok_id,awal,masuk,keluar,akhir FROM tx_stok WHERE stok_id=(SELECT max(stok_id) FROM tx_stok where produk_id='$value' AND produk_warna_id='$p_warnaid' AND produk_ukuran_id='$p_ukuranid')")->row_array();

                        $check = $this->db->query("SELECT * FROM m_produk_warna WHERE produk_id='$value' AND produk_warna_id='$p_warnaid'")->row_array();

                        $check2 = $this->db->query("SELECT * FROM m_produk_ukuran WHERE produk_id='$value' AND produk_ukuran_id='$p_ukuranid'")->row_array();

                        if ($check && $check2) {

                            if ($values>0) {
                                $status = 1; //masuk
                                $masuk = $values;
                                $keluar = 0;
                                $akhir = $mstok['akhir']+$masuk;
                                $lbl = "ADP"; // Admin Plus
                            }else{
                                $status = 2; //keluar
                                $masuk = 0;
                                $keluar = substr($values,1);
                                $akhir = $mstok['akhir']+$values;
                                $lbl = "ADM"; // Admin Min
                            }

                            $data = [
                                'kode_stok'             => $noJadi,
                                'status_stok'           => $status,
                                'produk_id'             => $value,
                                'produk_warna_id'       => $p_warnaid,
                                'produk_ukuran_id'      => $p_ukuranid,
                                'admin_id'              => $this->session->userdata('p_id'),
                                'awal'                  => $mstok['akhir'],
                                'masuk'                 => $masuk,
                                'keluar'                => $keluar,
                                'akhir'                 => $akhir,
                                'label_stok'            => $lbl,
                                'keterangan_stok'       => $this->input->post('keterangan')[$key],
                                'created_at'            => date('Y-m-d H:i:s')
                            ];
                            $res = $this->db->insert('tx_stok', $data);
                        }
                    }
                }
            }
        }
    }

    public function riwayatStok($id,$mulai,$akhir,$warna,$ukuran) {
        $query = "SELECT * FROM tx_stok WHERE produk_id='$id' AND produk_warna_id='$warna' AND produk_ukuran_id='$ukuran' AND date(created_at) BETWEEN '$mulai' AND '$akhir' ORDER BY stok_id DESC";
        return $this->db->query($query)->result_array();
    }

    public function dataVoucher() {

        $items = array();

        $query = $this->db->query("SELECT * FROM m_voucher WHERE is_hapus='n'")->result_array();

        foreach ($query as $row) {

            $dipakai = $this->db->query("SELECT voucher_id FROM m_voucher_det WHERE voucher_id='$row[voucher_id]'")->num_rows();

            $items[] = array(
                'voucher_id'            => $row['voucher_id'],
                'nama_voucher'          => $row['nama_voucher'],
                'kode_voucher'          => $row['kode_voucher'],
                'khusus_cust_baru'      => $row['khusus_cust_baru'],
                'tipe_voucher'          => $row['tipe_voucher'],
                'nominal_voucher'       => $row['nominal_voucher'],
                'jumlah_voucher'        => $row['jumlah_voucher'],
                'minimal_belanja'       => $row['minimal_belanja'],
                'maksimal_diskon'       => $row['maksimal_diskon'],
                'deskripsi_voucher'     => $row['deskripsi_voucher'],
                'status_voucher'        => $row['status_voucher'],
                'tgl_mulai'             => $row['tgl_mulai'],
                'tgl_akhir'             => $row['tgl_akhir'],
                'tgl_dibuat'            => $row['tgl_dibuat'],
                'dipakai'               => $dipakai
            );
        }

        return $items;
    }

    public function tambahVoucher() {
        $data = [
            'nama_voucher'              => $this->input->post('nama_voucher'),
            'kode_voucher'              => $this->input->post('kode_voucher'),
            'khusus_cust_baru'          => 'n',
            'tipe_voucher'              => $this->input->post('tipe_voucher'),
            'nominal_voucher'           => $this->input->post('nominal_voucher'),
            'jumlah_voucher'            => $this->input->post('jumlah_voucher'),
            'minimal_belanja'           => $this->input->post('minimal_belanja'),
            'maksimal_diskon'           => $this->input->post('maksimal_diskon'),
            'deskripsi_voucher'         => $this->input->post('deskripsi_voucher'),
            'tampilkan'                 => $this->input->post('tampilkan'),
            'status_voucher'            => 'y',
            'tgl_mulai'                 => $this->input->post('tgl_mulai'),
            'tgl_akhir'                 => $this->input->post('tgl_akhir'),
            'tgl_dibuat'                => date('Y-m-d H:i:s')
        ];

        $res = $this->db->insert('m_voucher', $data);
        return $res;
    }

    public function editVoucher($primary_id) {
    
        if($this->input->post('tipe_voucher')==1){
           $maksimal_d = 0;
        }else{
           $maksimal_d = $this->input->post('maksimal_diskon');
        }

        if($primary_id==1){
            $this->db->set([
                'nama_voucher'              => $this->input->post('nama_voucher'),
                'tipe_voucher'              => $this->input->post('tipe_voucher'),
                'nominal_voucher'           => $this->input->post('nominal_voucher'),
                'jumlah_voucher'            => $this->input->post('jumlah_voucher'),
                'minimal_belanja'           => $this->input->post('minimal_belanja'),
                'tampilkan'                 => $this->input->post('tampilkan'),
                'maksimal_diskon'           => $maksimal_d,
                'deskripsi_voucher'         => $this->input->post('deskripsi_voucher'),
                'status_voucher'            => $this->input->post('status_voucher')
            ]);

        }else{
            $this->db->set([
                'nama_voucher'              => $this->input->post('nama_voucher'),
                'kode_voucher'              => $this->input->post('kode_voucher'),
                'tipe_voucher'              => $this->input->post('tipe_voucher'),
                'nominal_voucher'           => $this->input->post('nominal_voucher'),
                'jumlah_voucher'            => $this->input->post('jumlah_voucher'),
                'minimal_belanja'           => $this->input->post('minimal_belanja'),
                'tampilkan'                 => $this->input->post('tampilkan'),
                'maksimal_diskon'           => $maksimal_d,
                'deskripsi_voucher'         => $this->input->post('deskripsi_voucher'),
                'status_voucher'            => $this->input->post('status_voucher'),
                'tgl_mulai'                 => $this->input->post('tgl_mulai'),
                'tgl_akhir'                 => $this->input->post('tgl_akhir')
            ]);
        }

        $this->db->where('voucher_id', $primary_id);
        $res = $this->db->update('m_voucher');
        return $res;
    }

    public function editLabelVoucher() {
        $this->db->set(['label_voucher' => str_replace_html(str_replace_kutip($this->input->post('label_voucher')))]);
        $this->db->where('setting_id', '1');
        $res = $this->db->update('_setting');
        if ($res==true) return 'ok'; else return 'no';
    }


}
