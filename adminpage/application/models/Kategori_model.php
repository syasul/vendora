<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori_model extends CI_Model {

    public function tambahKategori($upload) {
        $idnya = urutId('m_kategori',"kategori_id");

        $return_field =  str_replace_html($this->input->post('nama_kategori'));

        $data = [
            'kategori_id'      => $idnya,
            'nama_kategori'    => $return_field,
            'url_kategori'     => url_replace($return_field),
            'logo_image'       => $upload['file']['file_name'],
            'is_active'        => 1,
            'is_color'         => $this->input->post('is_color'),
            'created_at'       => date('Y-m-d H:i:s')
        ];
        $res = $this->db->insert('m_kategori', $data);

        if ($res==true) {
            $subrole = $this->input->post('subrole');
            if ($subrole!='') {
                foreach ($subrole as $key => $value) {
                    if($value!=""){
                        $datasub = [
                            'kategori_id'       => $idnya,
                            'kategori_sub_id'   => $value
                        ];
                        $this->db->insert('m_kategori_det', $datasub);
                    }
                }
            }
        }
    }

    public function editKategori($primary_id,$upload,$cekimg,$old_gambar) {

        if ($cekimg=='') { $imgnya = $old_gambar; }else{ $imgnya = $upload['file']['file_name']; }

        $return_field =  str_replace_html($this->input->post('nama_kategori'));

        $this->db->set([
            'nama_kategori'    => $return_field,
            'url_kategori'     => url_replace($return_field),
            'logo_image'       => $imgnya,
            'is_active'        => $this->input->post('is_active'),
            'is_color'         => $this->input->post('is_color')
        ]);
        $this->db->where('kategori_id', $primary_id);
        $res = $this->db->update('m_kategori');

        if ($res==true) {
            $this->db->delete('m_kategori_det', ['kategori_id' => $primary_id]);
            $subrole = $this->input->post('subrole');
            if ($subrole!='') {
                foreach ($subrole as $key => $value) {
                    if($value!=""){
                        $datasub = [
                            'kategori_id'       => $primary_id,
                            'kategori_sub_id'   => $value
                        ];
                        $this->db->insert('m_kategori_det', $datasub);
                    }
                }
            }
        }
    }

    public function pilihanKategori() {
        $this->db->truncate('ui_kategori');
        $k = $this->input->post('kategori_id');
        if ($k!='') {
            foreach ($k as $key => $value) {
                if($value!=""){
                    $idnya = urutId('ui_kategori',"kategori_ui_id");
                    $datak = [
                        'kategori_ui_id'    => $idnya,
                        'kategori_id'       => $value
                    ];
                    $this->db->insert('ui_kategori', $datak);
                }
            }
        }
    }

    public function tambahSub($upload) {
        $idnya = urutId('m_kategori_sub',"kategori_sub_id");

        $return_field =  str_replace_html($this->input->post('nama_kategori'));

        $data = [
            'kategori_sub_id'  => $idnya,
            'nama_kategori'    => $return_field,
            'url_kategori'     => url_replace($return_field),
            'logo_image'       => $upload['file']['file_name'],
            'is_active'        => 1,
            'is_color'         => $this->input->post('is_color'),
            'created_at'       => date('Y-m-d H:i:s')
        ];
        $res = $this->db->insert('m_kategori_sub', $data);

        if ($res==true) {
            $subrole = $this->input->post('subrole');
            if ($subrole!='') {
                foreach ($subrole as $key => $value) {
                    if($value!=""){
                        $datasub = [
                            'kategori_sub_id'       => $idnya,
                            'kategori_sub_lv2_id'   => $value
                        ];
                        $this->db->insert('m_kategori_sub_det', $datasub);
                    }
                }
            }
        }
    }

    public function editSub($primary_id,$upload,$cekimg,$old_gambar) {

        if ($cekimg=='') { $imgnya = $old_gambar; }else{ $imgnya = $upload['file']['file_name']; }

        $return_field =  str_replace_html($this->input->post('nama_kategori'));

        $this->db->set([
            'nama_kategori'    => $return_field,
            'url_kategori'     => url_replace($return_field),
            'logo_image'       => $imgnya,
            'is_active'        => $this->input->post('is_active'),
            'is_color'         => $this->input->post('is_color')
        ]);
        $this->db->where('kategori_sub_id', $primary_id);
        $res = $this->db->update('m_kategori_sub');

        if ($res==true) {
            $this->db->delete('m_kategori_sub_det', ['kategori_sub_id' => $primary_id]);
            $subrole = $this->input->post('subrole');
            if ($subrole!='') {
                foreach ($subrole as $key => $value) {
                    if($value!=""){
                        $datasub = [
                            'kategori_sub_id'       => $primary_id,
                            'kategori_sub_lv2_id'   => $value
                        ];
                        $this->db->insert('m_kategori_sub_det', $datasub);
                    }
                }
            }
        }
    }

    public function pilihanSubkategori() {
        $this->db->truncate('ui_kategori_sub');
        $k = $this->input->post('kategori_sub_id');
        if ($k!='') {
            foreach ($k as $key => $value) {
                if($value!=""){
                    $idnya = urutId('ui_kategori_sub',"kategori_sub_ui_id");
                    $datak = [
                        'kategori_sub_ui_id' => $idnya,
                        'kategori_sub_id' => $value
                    ];
                    $this->db->insert('ui_kategori_sub', $datak);
                }
            }
        }
    }

    public function tambahSubLv2($upload) {
        $return_field =  str_replace_html($this->input->post('nama_kategori'));
        $data = [
            'nama_kategori'         => $return_field,
            'url_kategori'          => url_replace($return_field),
            'logo_image'            => $upload['file']['file_name'],
            'is_active'             => 1,
            'created_at'            => date('Y-m-d H:i:s')
        ];
        $this->db->insert('m_kategori_sub_lv2', $data);
    }

    public function editSubLv2($primary_id,$upload,$cekimg,$old_gambar) {

        if ($cekimg=='') { $imgnya = $old_gambar; }else{ $imgnya = $upload['file']['file_name']; }

        $return_field =  str_replace_html($this->input->post('nama_kategori'));

        $this->db->set([
            'nama_kategori'     => $return_field,
            'url_kategori'      => url_replace($return_field),
            'logo_image'        => $imgnya,
            'is_active'         => $this->input->post('is_active')
        ]);
        $this->db->where('kategori_sub_lv2_id', $primary_id);
        $this->db->update('m_kategori_sub_lv2');
    }

    public function pilihanSubkategoriLv2() {
        $this->db->truncate('ui_kategori_sub_lv2');
        $k = $this->input->post('kategori_sub_lv2_id');
        if ($k!='') {
            foreach ($k as $key => $value) {
                if($value!=""){
                    $idnya = urutId('ui_kategori_sub_lv2',"kategori_sub_lv2_ui_id");
                    $datak = [
                        'kategori_sub_lv2_ui_id' => $idnya,
                        'kategori_sub_lv2_id' => $value
                    ];
                    $this->db->insert('ui_kategori_sub_lv2', $datak);
                }
            }
        }
    }

    public function tambahWarna() {

        $return_field =  str_replace_html($this->input->post('nama_warna'));

        $data = [
            'nama_warna'     => $return_field,
            'created_at'     => date('Y-m-d H:i:s')
        ];
        $this->db->insert('m_warna', $data);
    }

    public function editWarna($primary_id) {

        $return_field =  str_replace_html($this->input->post('nama_warna'));

        $this->db->set([
            'nama_warna'  => $return_field
        ]);
        $this->db->where('warna_id', $primary_id);
        $this->db->update('m_warna');
    }

    public function tambahUkuran() {

        $return_field =  str_replace_html($this->input->post('ukuran_size'));

        $data = [
            'ukuran_size'    => $return_field,
            'created_at'     => date('Y-m-d H:i:s')
        ];
        $this->db->insert('m_ukuran', $data);
    }

    public function editUkuran($primary_id) {

        $return_field =  str_replace_html($this->input->post('ukuran_size'));

        $this->db->set([
            'ukuran_size'  => $return_field
        ]);
        $this->db->where('ukuran_id', $primary_id);
        $this->db->update('m_ukuran');
    }

    public function hapusWarna($primary_id) {
        $this->db->set([
            'is_hapus'     => 'y'
        ]);

        $this->db->where('warna_id', $primary_id);
        $this->db->update('m_warna');

        $cek_produk = $this->db->query("SELECT * FROM m_produk")->result_array();
        foreach ($cek_produk as $row) {
            // update pengaturan stok karna warna id telah dihapus
            $update_cart = array('is_status' => 'n');
            $wh = array('warna_id' => $primary_id, 'produk_id' => $row['produk_id']);
            $this->db->where($wh);
            $this->db->update('m_produk_warna', $update_cart);

            $count_warna = $this->db->query("SELECT produk_id FROM m_produk_warna WHERE produk_id='$row[produk_id]' AND is_status='y'")->num_rows();

            if ($count_warna==0) {
                $cek_warna_default = $this->db->query("SELECT produk_id FROM m_produk_warna WHERE produk_id='$row[produk_id]' AND warna_id=1")->num_rows();

                if ($cek_warna_default==0) {
                    $datawarna = [
                        'produk_id' => $row['produk_id'],
                        'warna_id' => 1
                    ];
                    $this->db->insert('m_produk_warna', $datawarna);
                }else{
                    $dataupdate = array('is_status' => 'y');
                    $wheres = array('produk_id' => $row['produk_id'], 'warna_id' => '1');
                    $this->db->where($wheres);
                    $this->db->update('m_produk_warna', $dataupdate);
                }

            }
        }

    }

    public function hapusUkuran($primary_id) {
        $this->db->set([
            'is_hapus'     => 'y'
        ]);

        $this->db->where('ukuran_id', $primary_id);
        $this->db->update('m_ukuran');

        $cek_produk = $this->db->query("SELECT * FROM m_produk")->result_array();
        foreach ($cek_produk as $row) {
            // update pengaturan stok karna ukuran id telah dihapus
            $update_cart = array('is_status' => 'n');
            $wh = array('ukuran_id' => $primary_id, 'produk_id' => $row['produk_id']);
            $this->db->where($wh);
            $this->db->update('m_produk_ukuran', $update_cart);

            $count_warna = $this->db->query("SELECT produk_id FROM m_produk_ukuran WHERE produk_id='$row[produk_id]' AND is_status='y'")->num_rows();

            if ($count_warna==0) {
                $cek_warna_default = $this->db->query("SELECT produk_id FROM m_produk_ukuran WHERE produk_id='$row[produk_id]' AND ukuran_id=1")->num_rows();

                if ($cek_warna_default==0) {
                    $datawarna = [
                        'produk_id' => $row['produk_id'],
                        'ukuran_id' => 1
                    ];
                    $this->db->insert('m_produk_ukuran', $datawarna);
                }else{
                    $dataupdate = array('is_status' => 'y');
                    $wheres = array('produk_id' => $row['produk_id'], 'ukuran_id' => '1');
                    $this->db->where($wheres);
                    $this->db->update('m_produk_ukuran', $dataupdate);
                }

            }
        }
    }


}
