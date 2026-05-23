<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data extends CI_Controller {
    public function __construct() {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('auth_model', 'auth');
        $this->load->model('menu_model', 'menu');
        $this->load->model('data_model', 'data');
    }

    public function admin($nb = null) {
        cek_menu_access();
        $data['nmenu'] = 'Data';
        $data['title'] = 'Admin';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_peng'] = $this->data->dataAdmin();
        $data['all_role'] = $this->auth->resultData('m_role','is_active=1 AND is_hide=0','*','role_id ASC');

        $this->form_validation->set_rules('role_id', 'Akses', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('nama', 'Nama Pengelola', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('name', 'Username', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|htmlspecialchars');
        
        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~Kolom tidak boleh dikosongkan.';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/data/admin/index', $data);
                $this->load->view('templates/in_footer');
            }
        }else{
            $checkdata = $this->db->get_where('m_pengelola', ['username' => $this->input->post('name')]);
            if ($checkdata->num_rows() < 1) {
                $this->data->tambahAdmin();
                echo 'closemodalreload~Data baru berhasil di buat.';
            }else{
                echo 'no~Username dengan nama <b>"'.$this->input->post('name').'"</b> ini sudah terdaftar.';
            }
        }

    }

    public function editAdmin($primary_id,$nb = null) {
        $data['nmenu'] = 'Data';
        $data['title'] = 'Admin';
        $data['pengelola'] = $this->auth->getById('m_pengelola','pengelola_id',$primary_id);
        $data['all_role'] = $this->auth->resultData('m_role','is_active=1 AND is_hide=0','*','role_id ASC');

        $this->form_validation->set_rules('nama', 'Nama Pengelola', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('name', 'Username', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|htmlspecialchars');

        if ($nb!='prosesi') {
            $this->form_validation->set_rules('role_id', 'Akses', 'trim|required|xss_clean|htmlspecialchars');
            $this->form_validation->set_rules('is_active', 'Status', 'trim|required|xss_clean|htmlspecialchars');
        }
        
        if ($primary_id == 1 && $nb=='proses') {
          echo 'no~Edit Admin utama silahkan dimenu profil.';
        }

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~Kolom tidak boleh dikosongkan.';
            }else if ($nb=='prosesi') {
                echo 'no~Kolom tidak boleh dikosongkan.';
            }else{
                $this->load->view('module/data/admin/edit', $data);
            }
        }else{
            $passwordlama = $data['pengelola']['password'];
            $uname = $this->input->post('name');
            $query = $this->db->query("SELECT * FROM m_pengelola WHERE username='$uname' AND pengelola_id!='$primary_id'");
            if ($query->num_rows() < 1) {
                $this->data->editAdmin($primary_id,$passwordlama,$nb);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diperbarui.</div>');
                echo 'closemodalreload~default';
            }else{
                echo 'no~Proses gagal, username dengan nama <b>"'.$uname.'"</b> sudah di gunakan.';
            }
        }
    }

    public function hapusAdmin($primary_id){
    // Proteksi admin utama
    if ($primary_id == 1) {
        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-warning" role="alert">Admin utama tidak bisa dihapus.</div>'
        );
        echo 'no';
        return;
    }

    $this->auth->hapusiFlag('m_pengelola', 'pengelola_id', $primary_id);

    $this->session->set_flashdata(
        'message',
        '<div class="alert alert-danger" role="alert">Data berhasil dihapus.</div>'
    );

    echo 'ok';
    }

    public function user($nb = null) {
        cek_menu_access();
        $data['nmenu'] = 'Data';
        $data['title'] = 'User';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_data'] = $this->data->dataUser();

        $this->load->view('templates/in_header', $data);
        $this->load->view('templates/in_topbar', $data);
        $this->load->view('module/data/user/index', $data);
        $this->load->view('templates/in_footer');
    }

    public function rincianUser($zindex,$primary_id){
        $data['zindex'] = $zindex+1;
        $data['datas'] = $this->auth->getById('m_customer','cust_id',$primary_id);
        $data['saldo_user'] = cek_saldo($primary_id);
        $this->load->view('module/data/user/detail', $data);
    }

}
