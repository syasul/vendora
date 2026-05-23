<?php 

defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('auth_model', 'auth');
        $this->load->model('produk_model', 'produk');

        require APPPATH.'libraries/phpmailer/src/Exception.php';
        require APPPATH.'libraries/phpmailer/src/PHPMailer.php';
        require APPPATH.'libraries/phpmailer/src/SMTP.php';
        // require APPPATH.'libraries/PHPMailer/PHPMailerAutoload.php';
    }

    public function index() {
        if ($this->session->userdata('p_id')){
            redirect('master');
        }
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|htmlspecialchars');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $data['setting'] = $this->auth->getById('_setting','setting_id','1');
            c_get_file_contents();
            $this->load->view('module/auth/auth_login', $data);
        } else {
            $this->_login();
        }
    }

    private function _login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $user = $this->auth->prosesLogin($username);

        if ($user != null) {
            if ($user['is_active'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'p_id'          => $user['pengelola_id'],
                        'role_id'       => $user['role_id'],
                        'nama_lengkap'  => $user['nama_lengkap'],
                        'username'      => $user['username']
                    ];
                    $this->session->set_userdata($data);
                        redirect('auth');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Kata sandi salah.</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akun ini tidak aktif.</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akun tidak terdaftar.</div>');
            redirect('auth');
        }
    }

    public function cek_transaksi_baru() {
        echo $this->auth->countRow('tx_transaksi','is_read="n" AND is_status="p"','transaksi_id');
    }

    public function cek_transaksi_pending_udah_bayar() {
        echo $this->auth->countRow('tx_transaksi','is_status="p" AND bukti_pembayaran!="n"','transaksi_id');
    }

    public function cek_transaksi_ulasan_rat_baru() {
        echo $this->auth->countRow('tx_transaksi_det','publikasi_rating="n" AND rating_produk>0','transaksi_det_id');
    }

    public function cek_wd_baru() {
        echo $this->auth->countRow('tx_saldo_tarik','is_status="p"','saldo_tarik_id');
    }

    public function cek_transaksi_auto_batal() {
        $this->auth->cek_transaksi_auto_batal();
    }

    public function cek_transaksi_topup_auto_batal() {
        $this->auth->cek_transaksi_topup_auto_batal();
    }

    public function logout() {
        $this->session->unset_userdata('p_id');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('nama_lengkap');
        $this->session->unset_userdata('username');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Akun anda telah keluar dari dashboard.</div>');
        redirect('auth');
    }
    
    public function emailTestSmtp() {
        $mail = new PHPMailer();
        $res = $this->auth->emailTestSmtp('hokidigital.id@gmail.com',$mail);
        echo $res;
    }

    public function blocked() {
        $this->load->view('module/auth/auth_blocked');
    }

    public function cronjob() {
        $data = $this->auth->cronjob();
        echo $data;
    }

    public function clearallCache() {
        delete_files(APPPATH.'cache/', TRUE);
        redirect('master');
    }
}

?>