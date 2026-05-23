<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Transaksi extends CI_Controller {
    public function __construct() {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('auth_model', 'auth');
        $this->load->model('menu_model', 'menu');
        $this->load->model('transaksi_model', 'transaksi');
        $this->load->model('produk_model', 'produk');

        require APPPATH.'libraries/phpmailer/src/Exception.php';
        require APPPATH.'libraries/phpmailer/src/PHPMailer.php';
        require APPPATH.'libraries/phpmailer/src/SMTP.php';
    }

    public function transaksi() {
        cek_menu_access();
        $data['nmenu'] = 'Laporan & Transaksi';
        $data['title'] = 'Transaksi';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));

        // khusus point of sale
        if ($data['auth']['role_id']==9) {
            $data['all_data'] = $this->auth->resultData('tx_transaksi a JOIN m_toko b ON a.pos_toko_id=b.toko_id','a.is_status!="s" AND a.is_status!="b" AND a.pos_toko_id='.$data['auth']['toko_id'],'a.*,b.nama_toko','a.transaksi_id DESC');
        }else{
            $data['all_data'] = $this->auth->resultData('tx_transaksi a LEFT JOIN m_toko b ON a.pos_toko_id=b.toko_id','a.is_status!="s" AND a.is_status!="b"','a.*,b.nama_toko','a.transaksi_id DESC');
        }

        $this->load->view('templates/in_header', $data);
        $this->load->view('templates/in_topbar', $data);
        $this->load->view('module/transaksi/transaksi/index', $data);
        $this->load->view('templates/in_footer');
    }

    public function transaksiDetail($zindex,$id) {
        $this->auth->hapusiFlag('tx_transaksi','transaksi_id',$id,'is_read');
        $data['all_data'] = $this->transaksi->transaksiDetail($id);
        $this->load->view('module/transaksi/transaksi/detail', $data);
    }

    public function transaksi_action($id,$flag) {
        $mail = new PHPMailer();
        $res = 'no';
        if ($flag=='b') {
            $res = $this->transaksi->transaksiDel($mail,$id);
            if ($res=='yes') {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Transaksi dibatalkan, cek "Riwayat Transaksi" untuk melihat riwayat transaksi.</div>');
            }
        }else if ($flag=='y') {
            $res = $this->transaksi->transaksiProses($mail,$id);
        }else if ($flag=='k') {
            $res = $this->transaksi->transaksiKirim($mail,$id);
        }else if ($flag=='s') {
            $res = $this->transaksi->transaksiSelesai($mail,$id);
            if ($res=='yes') {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Transaksi selesai, cek "Riwayat Transaksi" untuk melihat riwayat transaksi.</div>');
            }
        }
        echo $res;
    }

    public function transaksi_x_digital($id) {
        $old_digital = $this->input->post('old_digital');
        $cekdigital = $_FILES['digital']['name'];
        $uploaddigital = $this->auth->uploadDigital('',$old_digital,'products','file_digital_');
        if($uploaddigital['result'] == "success" || $cekdigital==''){
            $res = $this->transaksi->transaksiXdigital($id,$uploaddigital,$cekdigital,$old_digital);
            if ($res==true) {
                echo 'closemodalreload~default';
            }else{
                echo 'no~Terjadi kesalahan, silahkan cobalagi.';
            }
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$uploaddigital['error'].'</div>');
            echo 'no~'.$uploaddigital['error'];
        }
    }

    public function transaksi_resi($id,$resi) {
        $res = $this->transaksi->transaksiResi($id,$resi);
        echo $res;
    }

    public function transaksi_ulasan($id) {
        $res = $this->transaksi->transaksiUlasan($id);
        echo $res;
    }

    public function riwayat() {
        cek_menu_access();
        $data['nmenu'] = 'Laporan & Transaksi';
        $data['title'] = 'Riwayat Transaksi';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));

        if ($this->input->get('tgl_awal')=="") {
            $data['tgl_awal'] = date('Y-m-01');
        }else{
            $data['tgl_awal'] = $this->input->get('tgl_awal');
        }
        if ($this->input->get('tgl_akhir')=="") {
            $data['tgl_akhir'] = date('Y-m-d');
        }else{
            $data['tgl_akhir'] = $this->input->get('tgl_akhir');
        }     

        $keyvalue = $this->input->get('keyvalue');
        $data['total_trx'] = $this->transaksi->totalTransaksi($keyvalue,$data['tgl_awal'],$data['tgl_akhir']);;   

        $config = array();
        if ($this->input->get('keyvalue') || $this->input->get('tgl_awal') || $this->input->get('tgl_akhir')){ 
            $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $data['reset'] = 'yes';
        }else{
            $data['reset'] = 'no';
        }
        $config["base_url"] = site_url().'transaksi/riwayat/';
        $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
        $config["total_rows"] = $data['total_trx'];
        $config["per_page"] = 10;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 4;

        // Bootstrap 4, work very fine.
        $config['full_tag_open'] = '<ul class="pagination float-right">';
        $config['full_tag_close'] = '</ul>';
        $config['attributes'] = ['class' => 'page-link'];
        // $config['first_link'] = false;
        // $config['last_link'] = false;
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        if($this->uri->segment(3)){
            $pages = ($this->uri->segment(3));
        }else{
            $pages = 1;
        }

        $data['all_data'] = $this->transaksi->riwayatTransaksi($keyvalue,$config["per_page"],$pages,$data['tgl_awal'],$data['tgl_akhir']);
        $data['all_pendapatan'] = $this->transaksi->totalPendapatan($keyvalue,$data['tgl_awal'],$data['tgl_akhir']);

        $this->load->view('templates/in_header', $data);
        $this->load->view('templates/in_topbar', $data);
        $this->load->view('module/transaksi/transaksi/riwayat', $data);
        $this->load->view('templates/in_footer');
    }

    public function download_riwayat_transaksi($mulai,$akhir) {
        $data['tgl_awal'] = $mulai;
        $data['tgl_akhir'] = $akhir;
        $data['all_data'] = json_decode($this->transaksi->downloadriwayatTransaksi($mulai,$akhir), true);
        $this->load->view('module/transaksi/transaksi/download_riwayat', $data);
    }

    public function pembayaran() {
        cek_menu_access();
        $data['nmenu'] = 'Laporan & Transaksi';
        $data['title'] = 'Bukti Pembayaran';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_data'] = $this->auth->resultData('tx_transaksi','bukti_pembayaran!="n"','*','transaksi_id DESC');

        $this->load->view('templates/in_header', $data);
        $this->load->view('templates/in_topbar', $data);
        $this->load->view('module/transaksi/transaksi/pembayaran', $data);
        $this->load->view('templates/in_footer');
    }

    public function ulasan() {
        cek_menu_access();
        $data['nmenu'] = 'Laporan & Transaksi';
        $data['title'] = 'Ulasan & Rating';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_data'] = $this->transaksi->loadUlasanRatPending();

        $this->load->view('templates/in_header', $data);
        $this->load->view('templates/in_topbar', $data);
        $this->load->view('module/transaksi/transaksi/ulasan', $data);
        $this->load->view('templates/in_footer');
    }

    public function topup() {
        cek_menu_access();
        $data['nmenu'] = 'Laporan & Transaksi';
        $data['title'] = 'Topup Saldo';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_data'] = $this->auth->resultData('tx_topup','is_status="p"','*','topup_id DESC');

        $this->load->view('templates/in_header', $data);
        $this->load->view('templates/in_topbar', $data);
        $this->load->view('module/transaksi/topup/index', $data);
        $this->load->view('templates/in_footer');
    }

    public function topupDetail($zindex,$id) {
        $data['all_data'] = $this->auth->getById('tx_topup','topup_id',$id);
        $this->load->view('module/transaksi/topup/detail', $data);
    }

    public function topup_action($id,$flag) {
        $res = 'no';
        if ($flag=='b') {
            $res = $this->transaksi->topupDel($id);
            if ($res=='yes') {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Transaksi dibatalkan, cek "Riwayat Topup" untuk melihat riwayat transaksi.</div>');
            }
        }else if ($flag=='y') {
            $res = $this->transaksi->topupSelesai($id);
            if ($res=='yes') {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Transaksi selesai, cek "Riwayat Topup" untuk melihat riwayat transaksi.</div>');
            }
        }
        echo $res;
    }

    public function riwayatopup() {
        cek_menu_access();
        $data['nmenu'] = 'Laporan & Transaksi';
        $data['title'] = 'Riwayat Topup';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_data'] = $this->auth->resultData('tx_topup','is_status!="p"','*','topup_id DESC');

        $this->load->view('templates/in_header', $data);
        $this->load->view('templates/in_topbar', $data);
        $this->load->view('module/transaksi/topup/riwayat', $data);
        $this->load->view('templates/in_footer');
    }

    public function tariksaldo() {
        cek_menu_access();
        $data['nmenu'] = 'Laporan & Transaksi';
        $data['title'] = 'Penarikan Saldo';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_data'] = $this->auth->resultData('tx_saldo_tarik','is_status="p"','*','saldo_tarik_id DESC');

        $this->load->view('templates/in_header', $data);
        $this->load->view('templates/in_topbar', $data);
        $this->load->view('module/transaksi/tariksaldo/index', $data);
        $this->load->view('templates/in_footer');
    }

    public function tariksaldoDetail($zindex,$id) {
        $data['all_data'] = $this->auth->getById('tx_saldo_tarik','saldo_tarik_id',$id);
        $this->load->view('module/transaksi/tariksaldo/detail', $data);
    }

    public function tariksaldo_action($id,$flag) {
        $res = 'no';
        if ($flag=='b') {
            $res = $this->transaksi->tariksaldoDel($id);
            if ($res=='yes') {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Tarik saldo ditolak, cek "Riwayat Penarikan" untuk melihat riwayat penarikan.</div>');
            }
        }else if ($flag=='y') {
            $res = $this->transaksi->tariksaldoSelesai($id);
            if ($res=='yes') {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Tarik saldo diterima, pastikan nonimal dan tujuan penarikan sudah sesuai! cek "Riwayat Penarikan" untuk melihat riwayat penarikan.</div>');
            }
        }
        echo $res;
    }

    public function riwayattarik() {
        cek_menu_access();
        $data['nmenu'] = 'Laporan & Transaksi';
        $data['title'] = 'Riwayat Penarikan';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_data'] = $this->auth->resultData('tx_saldo_tarik','is_status!="p"','*','saldo_tarik_id DESC');

        $this->load->view('templates/in_header', $data);
        $this->load->view('templates/in_topbar', $data);
        $this->load->view('module/transaksi/tariksaldo/riwayat', $data);
        $this->load->view('templates/in_footer');
    }

}
