<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller {
    public function __construct() {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('auth_model', 'auth');
        $this->load->model('menu_model', 'menu');
        $this->load->model('kategori_model', 'kategori');
    }

    public function kategori($nb = null) {
        cek_menu_access();
        $data['nmenu'] = 'Kategori';
        $data['title'] = 'Kategori';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_data'] = $this->auth->resultData('m_kategori','is_hapus="n"','*','nama_kategori ASC');
        $data['all_sub'] = $this->auth->resultData('m_kategori_sub','is_hapus="n" AND is_active=1','*');

        $this->form_validation->set_rules('nama_kategori', 'Kategori', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('gambar', 'Gambar', 'xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('subrole[]', 'Gambar', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('is_color', 'Warna Text', 'trim|required|xss_clean|htmlspecialchars');
        
        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/kategori/kategori/index', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $checkdata = $this->db->get_where('m_kategori', ['nama_kategori' => $this->input->post('nama_kategori')]);
            if ($checkdata->num_rows() < 1) {
                $upload = $this->auth->uploadGambar('','new','komponen','kategori_');
                if($upload['result'] == "success"){
                    $this->kategori->tambahKategori($upload);
                    echo 'closemodalreload~Data baru berhasil di buat.';
                }else{
                    echo 'no~'.$upload['error'];
                }
            }else{
                echo 'no~Kategori dengan nama <b>"'.$this->input->post('nama_kategori').'"</b> ini sudah terdaftar.';
            }
        }

    }

    public function editKategori($primary_id, $nb = null) {
        $data['edit'] = $this->auth->getById('m_kategori','kategori_id',$primary_id);
        $data['all_sub'] = $this->auth->resultData('m_kategori_sub','is_hapus="n" AND is_active=1','*');

        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('is_active', 'Status', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('gambar', 'Gambar', 'xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('subrole[]', 'Gambar', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('is_color', 'Warna Text', 'trim|required|xss_clean|htmlspecialchars');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('module/kategori/kategori/edit', $data);
            }
        } else {
            $unama = $this->input->post('nama_kategori');
            $query = $this->db->query("SELECT * FROM m_kategori WHERE nama_kategori='$unama' AND kategori_id!='$primary_id'");
             if ($query->num_rows() < 1) {
                $old_gambar = $this->input->post('old_gambar');
                $cekimg = $_FILES['gambar']['name'];
                $upload = $this->auth->uploadGambar('',$old_gambar,'komponen','kategori_');
                if($upload['result'] == "success" || $cekimg==''){
                    $this->kategori->editKategori($primary_id,$upload,$cekimg,$old_gambar);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diperbarui.</div>');
                    echo 'closemodalreload~Data berhasil diperbarui.';
                }else{
                    echo 'no~'.$upload['error'];
                }
            }else{
                echo 'no~Edit data gagal, kategori dengan nama <b>"'.$unama.'"</b> sudah di gunakan.';
            }
        }
    }

    public function pilihanKategori() {
        $this->kategori->pilihanKategori();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diperbarui.</div>');
        echo 'closemodalreload~Data berhasil diperbarui.';
    }

    public function hapusKategori($primary_id){
        $this->auth->hapusiFlag('m_kategori','kategori_id',$primary_id);
        echo 'ok~default';
    }

    public function hapusWarna($primary_id){
        if ($primary_id!=1) {
            $this->kategori->hapusWarna($primary_id);
            echo 'ok~default';
        }else{
            echo 'no~Default tidak bisa dihapus.';
        }
    }

    public function hapusUkuran($primary_id){
        if ($primary_id!=1) {
            $this->kategori->hapusUkuran($primary_id);
            echo 'ok~default';
        }else{
            echo 'no~Default tidak bisa dihapus.';
        }
    }

    public function sub($nb = null) {
        cek_menu_access();
        $data['nmenu'] = 'Kategori';
        $data['title'] = 'Kategori Sub';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_data'] = $this->auth->resultData('m_kategori_sub','is_hapus="n"','*','nama_kategori ASC');
        $data['all_sub'] = $this->auth->resultData('m_kategori_sub_lv2','is_hapus="n" AND is_active=1','*');

        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('gambar', 'Gambar', 'xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('subrole[]', 'Gambar', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('is_color', 'Warna Text', 'trim|required|xss_clean|htmlspecialchars');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/kategori/sub/index', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $checkdata = $this->db->get_where('m_kategori_sub', ['nama_kategori' => $this->input->post('nama_kategori')]);
            if ($checkdata->num_rows() < 1) {
                $upload = $this->auth->uploadGambar('','new','komponen','kategori_sub_');
                if($upload['result'] == "success"){
                    $this->kategori->tambahSub($upload);
                    echo 'closemodalreload~Data baru berhasil di buat.';
                }else{
                    echo 'no~'.$upload['error'];
                }
            }else{
                echo 'no~Sub kategori dengan nama <b>"'.$this->input->post('nama_kategori').'"</b> ini sudah terdaftar.';
            }
        }

    }

    public function editSub($primary_id, $nb = null) {
        $data['edit'] = $this->auth->getById('m_kategori_sub','kategori_sub_id',$primary_id);
        $data['all_sub'] = $this->auth->resultData('m_kategori_sub_lv2','is_hapus="n" AND is_active=1','*');

        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('is_active', 'Status', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('gambar', 'Gambar', 'xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('subrole[]', 'Gambar', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('is_color', 'Warna Text', 'trim|required|xss_clean|htmlspecialchars');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('module/kategori/sub/edit', $data);
            }
        } else {
            $unama = $this->input->post('nama_kategori');
            $query = $this->db->query("SELECT * FROM m_kategori_sub WHERE nama_kategori='$unama' AND kategori_sub_id!='$primary_id'");
             if ($query->num_rows() < 1) {
                $old_gambar = $this->input->post('old_gambar');
                $cekimg = $_FILES['gambar']['name'];
                $upload = $this->auth->uploadGambar('',$old_gambar,'komponen','kategori_sub_');
                if($upload['result'] == "success" || $cekimg==''){
                    $this->kategori->editSub($primary_id,$upload,$cekimg,$old_gambar);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diperbarui.</div>');
                    echo 'closemodalreload~Data berhasil diperbarui.';
                }else{
                    echo 'no~'.$upload['error'];
                }
            }else{
                echo 'no~Edit data gagal, sub kategori dengan nama <b>"'.$unama.'"</b> sudah di gunakan.';
            }
        }
    }

    public function pilihanSubkategori() {
        $this->form_validation->set_rules('kategori_sub_id[]', 'Gambar', 'trim|xss_clean|htmlspecialchars');
        if ($this->form_validation->run() == false) {
            echo 'no~Proses gagal, reload halaman dan silahkan coba lagi.';
        }else{
            $this->kategori->pilihanSubkategori();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diperbarui.</div>');
            echo 'closemodalreload~Data berhasil diperbarui.';
        }
    }

    public function hapusSub($primary_id){
        $this->auth->hapusiFlag('m_kategori_sub','kategori_sub_id',$primary_id);
        echo 'ok~default';
    }

    public function sublv2($nb = null) {
        cek_menu_access();
        $data['nmenu'] = 'Kategori';
        $data['title'] = 'Kategori Sub Lv2';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_data'] = $this->auth->resultData('m_kategori_sub_lv2','is_hapus="n"','*','nama_kategori ASC');

        $this->form_validation->set_rules('nama_kategori', 'Kategori', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('gambar', 'Gambar', 'xss_clean|htmlspecialchars');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/kategori/sub-lv2/index', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $checkdata = $this->db->get_where('m_kategori_sub_lv2', ['nama_kategori' => $this->input->post('nama_kategori')]);
            if ($checkdata->num_rows() < 1) {
                $upload = $this->auth->uploadGambar('','new','komponen','kategori_sub2_');
                if($upload['result'] == "success"){
                    $this->kategori->tambahSubLv2($upload);
                    echo 'closemodalreload~Data baru berhasil di buat.';
                }else{
                    echo 'no~'.$upload['error'];
                }
            }else{
                echo 'no~kategori dengan nama <b>"'.$this->input->post('nama_kategori').'"</b> ini sudah terdaftar.';
            }
        }

    }

    public function editSubLv2($primary_id, $nb = null) {
        $data['edit'] = $this->auth->getById('m_kategori_sub_lv2','kategori_sub_lv2_id',$primary_id);

        $this->form_validation->set_rules('nama_kategori', 'Kategori', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('gambar', 'Gambar', 'xss_clean|htmlspecialchars');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('module/kategori/sub-lv2/edit', $data);
            }
        } else {
            $unama = $this->input->post('nama_kategori');
            $query = $this->db->query("SELECT * FROM m_kategori_sub_lv2 WHERE nama_kategori='$unama' AND kategori_sub_lv2_id!='$primary_id'");
             if ($query->num_rows() < 1) {
                $old_gambar = $this->input->post('old_gambar');
                $cekimg = $_FILES['gambar']['name'];
                $upload = $this->auth->uploadGambar('',$old_gambar,'komponen','kategori_sub2_');
                if($upload['result'] == "success" || $cekimg==''){
                    $this->kategori->editSubLv2($primary_id,$upload,$cekimg,$old_gambar);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diperbarui.</div>');
                    echo 'closemodalreload~Data baru berhasil di buat.';
                }else{
                    echo 'no~'.$upload['error'];
                }
            }else{
                echo 'no~Edit data gagal, sub kategori dengan nama <b>"'.$unama.'"</b> sudah di gunakan.';
            }
        }
    }

    public function pilihanSubkategoriLv2() {

        $this->form_validation->set_rules('kategori_sub_lv2_id[]', 'Gambar', 'trim|xss_clean|htmlspecialchars');
        if ($this->form_validation->run() == false) {
            echo 'no~Proses gagal, reload halaman dan silahkan coba lagi.';
        }else{
            $this->kategori->pilihanSubkategoriLv2();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diperbarui.</div>');
            echo 'closemodalreload~Data berhasil diperbarui.';
        }
    }

    public function hapusSubLv2($primary_id){
        $this->auth->hapusiFlag('m_kategori_sub_lv2','kategori_sub_lv2_id',$primary_id);
        echo 'ok~default';
    }

    public function warna($nb = null) {
        cek_menu_access();
        $data['nmenu'] = 'Kategori';
        $data['title'] = 'Warna';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_data'] = $this->auth->resultData('m_warna','is_hapus="n"','*');

        $this->form_validation->set_rules('nama_warna', 'Warna', 'trim|required|xss_clean|htmlspecialchars');
        
        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/kategori/warna/index', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $checkdata = $this->db->get_where('m_warna', ['nama_warna' => $this->input->post('nama_warna')]);
            if ($checkdata->num_rows() < 1) {
                $this->kategori->tambahWarna();
                echo 'closemodalreload~Data baru berhasil di buat.';
            }else{
                echo 'no~Warna <b>"'.$this->input->post('nama_kategori').'"</b> ini sudah terdaftar.';
            }
        }

    }

    public function editWarna($primary_id, $nb = null) {
        $data['edit'] = $this->auth->getById('m_warna','warna_id',$primary_id);

        $this->form_validation->set_rules('nama_warna', 'Warna', 'trim|required|xss_clean|htmlspecialchars');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('module/kategori/warna/edit', $data);
            }
        } else {
            if ($primary_id==1) {
                echo 'no~Data Default tidak bisa diubah.';
            }else{
                $unama = $this->input->post('nama_warna');
                $query = $this->db->query("SELECT * FROM m_warna WHERE nama_warna='$unama' AND warna_id!='$primary_id'");
                 if ($query->num_rows() < 1) {
                    $this->kategori->editWarna($primary_id);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diperbarui.</div>');
                    echo 'closemodalreload~Data baru berhasil di buat.';
                }else{
                    echo 'no~Edit data gagal, warna <b>"'.$unama.'"</b> sudah di gunakan.';
                }
            }
        }
    }

    public function ukuran($nb = null) {
        cek_menu_access();
        $data['nmenu'] = 'Kategori';
        $data['title'] = 'Ukuran / Spesifikasi';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_data'] = $this->auth->resultData('m_ukuran','is_hapus="n"','*');

        $this->form_validation->set_rules('ukuran_size', 'Ukuran', 'trim|required|xss_clean|htmlspecialchars');
        
        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/kategori/ukuran/index', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $checkdata = $this->db->get_where('m_ukuran', ['ukuran_size' => $this->input->post('ukuran_size')]);
            if ($checkdata->num_rows() < 1) {
                $this->kategori->tambahUkuran();
                echo 'closemodalreload~Data baru berhasil di buat.';
            }else{
                echo 'no~<b>"'.$this->input->post('ukuran_size').'"</b> ini sudah terdaftar.';
            }
        }

    }

    public function editUkuran($primary_id, $nb = null) {
        $data['edit'] = $this->auth->getById('m_ukuran','ukuran_id',$primary_id);

        $this->form_validation->set_rules('ukuran_size', 'Warna', 'trim|required|xss_clean|htmlspecialchars');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('module/kategori/ukuran/edit', $data);
            }
        } else {
            if ($primary_id==1) {
                echo 'no~Data Default tidak bisa diubah.';
            }else{
                $unama = $this->input->post('ukuran_size');
                $query = $this->db->query("SELECT * FROM m_ukuran WHERE ukuran_size='$unama' AND ukuran_id!='$primary_id'");
                 if ($query->num_rows() < 1) {
                    $this->kategori->editUkuran($primary_id);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diperbarui.</div>');
                    echo 'closemodalreload~Data baru berhasil di buat.';
                }else{
                    echo 'no~Edit data gagal, <b>"'.$unama.'"</b> sudah di gunakan.';
                }
            }
        }
    }

}
