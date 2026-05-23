<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller {
    public function __construct() {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('auth_model', 'auth');
        $this->load->model('menu_model', 'menu');
        $this->load->model('master_model', 'master');
        $this->load->model('rest_proses_model', 'rp');
    }

    public function index($tgl = null) {
        $data['nmenu'] = 'Dashboard';
        $data['title'] = 'Dashboard';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));

        $data['t_cust'] = $this->auth->countRow('m_customer','is_active="1"','cust_id');
        $data['t_produk'] = $this->auth->countRow('m_produk','is_hapus="n"','produk_id');
        $data['t_t_baru'] = $this->auth->countRow('tx_transaksi','is_read="n" AND is_status="p"','transaksi_id');
        $data['t_t_proses'] = $this->auth->countRow('tx_transaksi','is_status="p" OR is_status="y" OR is_status="k"','transaksi_id');
        $data['t_t_selesai'] = $this->auth->countRow('tx_transaksi','is_status="s"','transaksi_id');
        $data['t_t_batal'] = $this->auth->countRow('tx_transaksi','is_status="b"','transaksi_id');

        $data['t_topup_baru'] = $this->auth->countRow('tx_topup','is_status="p"','topup_id');

        $data['set_sistem'] = pengaturanSistem();

        $today = date('Y-m-d');
        $bulanini = date('Y-m-01');

        $bulanlaluawal = convertedTime('-1 month',date('Y-m-01'));
        $bulanlaluakhir = convertedTime('-1 month',date('Y-m-t'));

        $data['pendapatan'] = $this->auth->pendapatan_bulan_ini($bulanini,$today);
        $data['pendapatan_lalu'] = $this->auth->pendapatan_bulan_ini($bulanlaluawal,$bulanlaluakhir);
        $data['pendapatan_all'] = $this->auth->pendapatan_bulan_ini("2022-04-01",$today);

        $data['bestseller'] = $this->auth->produkTerlaris();
        $data['stokhabis'] = $this->auth->produkStokHabis();

        $postjson = array();
        $data['statistic_visitors'] = json_decode($this->rp->get_statistic_visitors($postjson), true);

        if($tgl==null){
            $data['tglstatistik'] = date('Y-m-d', strtotime("-1 days"));
        }else{
            $data['tglstatistik'] = $tgl;
        }

        $postjson = array('tgl'=>$data['tglstatistik']);
        $data['statistic_visitors_filter'] = json_decode($this->rp->get_statistic_visitors($postjson), true);

        $this->load->view('templates/in_header', $data);
        $this->load->view('templates/in_topbar', $data);
        $this->load->view('module/master/index', $data);
        $this->load->view('templates/in_footer');
    }

    public function none() {
        $data['nmenu'] = '404';
        $data['title'] = '404';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));

        $this->load->view('templates/in_header', $data);
        $this->load->view('templates/in_topbar', $data);
        $this->load->view('module/auth/auth_none', $data);
        $this->load->view('templates/in_footer');
    }

    public function chat() {
        $data['nmenu'] = 'Live Chat';
        $data['title'] = 'Live Chat';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));

        $data['user_chat'] = $this->master->user_chat();

        $this->load->view('templates/in_header', $data);
        $this->load->view('templates/in_topbar', $data);
        $this->load->view('module/master/chat', $data);
        $this->load->view('templates/in_footer');
    }

    public function chat_get($id) {
        $data['idcust'] = $id;
        $data['get_chat'] = $this->master->get_chat($id);
        $this->load->view('module/master/chat_get', $data);
    }

    public function chat_proses() {
        $data = $this->master->add_chat();
        echo $data;
    }

    public function akses($nb = null) {
        cek_menu_access();
        $data['nmenu'] = 'Master';
        $data['title'] = 'Akses Jabatan';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_role'] = $this->auth->resultData('m_role','is_hide=0','*','role_id ASC');

        $this->form_validation->set_rules('nama_akses', 'Nama Akses', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('is_active', 'Status', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('hak[]', 'Hak Role', 'trim|xss_clean|htmlspecialchars');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/master/akses/index', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $urole = $this->input->post('nama_akses');
            $query = $this->db->query("SELECT * FROM m_role WHERE nama_role='$urole'")->num_rows();
            if ($query < 1) {
                $this->master->tambahAkses();
                echo 'closemodalreload~Data baru berhasil dibuat.';
            } else {
                echo 'no~Nama Akses <b>"'.$this->input->post('nama_akses').'"</b> ini sudah terdaftar.';
            }
        }
    }

    public function editAkses($primary_id, $nb = null) {
        $data['nmenu'] = 'Master';
        $data['title'] = 'Akses Jabatan';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['role'] = $this->auth->getById('m_role','role_id',$primary_id);

        $this->form_validation->set_rules('nama_akses', 'Nama Akses', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('is_active', 'Status', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('hak[]', 'Hak Role', 'trim|xss_clean|htmlspecialchars');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Proses gagal, lengkapi kolom dan coba lagi.</div>');
                echo 'reload';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/master/akses/edit', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            if ($primary_id==1) {
                echo 'no~Super admin tidak bisa di edit.';
            }else{
                $urole = $this->input->post('nama_akses');
                $query = $this->db->query("SELECT * FROM m_role WHERE nama_role='$urole' AND role_id!='$primary_id'")->num_rows();
                if ($query < 1) {
                    $this->master->editAkses($primary_id);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diperbarui.</div>');
                    echo 'url~'.base_url('master/akses/');
                }else{
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Proses gagal, nama akses <b>"'.$urole.'"</b> sudah terdaftar.</div>');
                    echo 'reload';
                }
            }
        }
    }

    public function bank($nb = null) {
        cek_menu_access();
        $data['nmenu'] = 'Master';
        $data['title'] = 'Bank';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_data'] = $this->auth->resultData('m_bank','is_hapus="n"','*','nama_bank ASC');

        $this->form_validation->set_rules('nama_bank', 'Nama Bank', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('nama_rekening', 'Nama Rekening', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('nomor_rekening', 'Nomor Rekening', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('gambar', 'Gambar', 'xss_clean|htmlspecialchars');
        
        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/master/bank/index', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $upload = $this->auth->uploadGambar('','new','komponen','bank_');
            if($upload['result'] == "success"){
                $this->master->tambahBank($upload);
                echo 'closemodalreload~Data baru berhasil di buat.';
            }else{
                echo 'no~'.$upload['error'];
            }
        }

    }

    public function editBank($primary_id, $nb = null) {
        $data['nmenu'] = 'Master';
        $data['title'] = 'Bank';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['edit'] = $this->auth->getById('m_bank','bank_id',$primary_id);

        $this->form_validation->set_rules('nama_bank', 'Nama Bank', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('nama_rekening', 'Nama Rekening', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('nomor_rekening', 'Nomor Rekening', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('is_active', 'Status', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('gambar', 'Gambar', 'xss_clean|htmlspecialchars');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Proses gagal, lengkapi kolom data.</div>');
                echo 'reload';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/master/bank/edit', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $old_gambar = $this->input->post('old_gambar');
            $cekimg = $_FILES['gambar']['name'];
            $upload = $this->auth->uploadGambar('',$old_gambar,'komponen','bank_');
            if($upload['result'] == "success" || $cekimg==''){
                $this->master->editBank($primary_id,$upload,$cekimg,$old_gambar);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diperbarui.</div>');
                echo 'url~'.base_url('master/bank/');
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$upload['error'].'</div>');
                echo 'reload';
            }
        }
    }

    public function hapusBank($primary_id){
        $this->auth->hapusiFlag('m_bank','bank_id',$primary_id);
        echo 'ok~default';
    }

    public function bankpenarikan($nb = null) {
        cek_menu_access();
        $data['nmenu'] = 'Master';
        $data['title'] = 'Bank Penarikan';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_data'] = $this->auth->resultData('m_bank_tarik','is_hapus="n"','*','nama_bank ASC');

        $this->form_validation->set_rules('nama_bank', 'Nama Bank', 'trim|required|xss_clean|htmlspecialchars');
        
        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/master/bankpenarikan/index', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $this->master->tambahBankp();
            echo 'closemodalreload~Data baru berhasil di buat.';
        }

    }

    public function editBankp($primary_id, $nb = null) {
        $data['nmenu'] = 'Master';
        $data['title'] = 'Bank Penarikan';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['edit'] = $this->auth->getById('m_bank_tarik','bank_tarik_id',$primary_id);

        $this->form_validation->set_rules('nama_bank', 'Nama Bank', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('is_active', 'Status', 'trim|required|xss_clean|htmlspecialchars');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Proses gagal, lengkapi kolom data.</div>');
                echo 'reload';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/master/bankpenarikan/edit', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $this->master->editBankp($primary_id);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diperbarui.</div>');
            echo 'url~'.base_url('master/bankpenarikan/');
        }
    }

    public function hapusBankp($primary_id){
        $this->auth->hapusiFlag('m_bank_tarik','bank_tarik_id',$primary_id);
        echo 'ok~default';
    }

    public function slider() {
        cek_menu_access();
        $data['nmenu'] = 'Master';
        $data['title'] = 'Slider';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_data'] = $this->auth->resultData('m_slider','is_hapus="n"','*','slider_id DESC');

        $this->load->view('templates/in_header', $data);
        $this->load->view('templates/in_topbar', $data);
        $this->load->view('module/master/slider/index', $data);
        $this->load->view('templates/in_footer');
    }

    public function tambahSlider($nb = null) {
        $data['nmenu'] = 'Master';
        $data['title'] = 'Slider';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));

        $this->form_validation->set_rules('tipe_slider', 'Tipe', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('gambar', 'Gambar', 'xss_clean|htmlspecialchars');
        
        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/master/slider/tambah', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $upload = $this->auth->uploadGambar('','new','komponen','slider_');
            if($upload['result'] == "success"){
                $this->master->tambahSlider($upload);
                echo 'url~'.base_url('master/slider/');
            }else{
                echo 'no~'.$upload['error'];
            }
        }

    }

    public function editSlider($primary_id, $nb = null) {
        $data['nmenu'] = 'Master';
        $data['title'] = 'Slider';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['edit'] = $this->auth->getById('m_slider','slider_id',$primary_id);

        $this->form_validation->set_rules('tipe_slider', 'Tipe', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('is_active', 'Status', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('gambar', 'Gambar', 'xss_clean|htmlspecialchars');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/master/slider/edit', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $old_gambar = $this->input->post('old_gambar');
            $cekimg = $_FILES['gambar']['name'];
            $upload = $this->auth->uploadGambar('',$old_gambar,'komponen','slider_');
            if($upload['result'] == "success" || $cekimg==''){
                $this->master->editSlider($primary_id,$upload,$cekimg,$old_gambar);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diperbarui.</div>');
                echo 'url~'.base_url('master/slider/');
            }else{
                echo 'no~'.$upload['error'];
            }
        }
    }

    public function hapusSlider($primary_id){
        $this->auth->hapusiFlag('m_slider','slider_id',$primary_id);
        echo 'ok~default';
    }

    public function partner($nb = null) {
        cek_menu_access();
        $data['nmenu'] = 'Master';
        $data['title'] = 'Partner / Brand';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_data'] = $this->auth->resultData('m_partner','','*','');

        $this->form_validation->set_rules('is_active', 'Status', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('gambar', 'Gambar', 'xss_clean|htmlspecialchars');
        
        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/master/partner/index', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $upload = $this->auth->uploadGambar('','new','komponen','partner_');
            if($upload['result'] == "success"){
                $this->master->tambahPartner($upload);
                echo 'closemodalreload~Data baru berhasil di buat.';
            }else{
                echo 'no~'.$upload['error'];
            }
        }

    }

    public function editPartner($primary_id, $nb = null) {
        $data['nmenu'] = 'Master';
        $data['title'] = 'Partner / Brand';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['edit'] = $this->auth->getById('m_partner','partner_id',$primary_id);

        $this->form_validation->set_rules('is_active', 'Status', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('gambar', 'Gambar', 'xss_clean|htmlspecialchars');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Proses gagal, lengkapi kolom data.</div>');
                echo 'reload';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/master/partner/edit', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $old_gambar = $this->input->post('old_gambar');
            $cekimg = $_FILES['gambar']['name'];
            $upload = $this->auth->uploadGambar('',$old_gambar,'komponen','partner_');
            if($upload['result'] == "success" || $cekimg==''){
                $this->master->editPartner($primary_id,$upload,$cekimg,$old_gambar);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diperbarui.</div>');
                echo 'url~'.base_url('master/partner/');
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$upload['error'].'</div>');
                echo 'reload';
            }
        }
    }

    public function hapusPartner($primary_id,$gbr){
        $this->db->delete('m_partner', ['partner_id' => $primary_id]);
        unlink(FCPATH . './../assets/uploaded/komponen/' . $gbr);
        echo 'ok~default';
    }

}
