<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('auth_model', 'auth');
        $this->load->model('menu_model', 'menu');
        $this->load->model('pengaturan_model', 'pengaturan');
    }

    public function sistem($nb = null) {
        cek_menu_access();
        $data['nmenu'] = 'Pengaturan';
        $data['title'] = 'Sistem';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['sistem'] = $this->auth->rowData('_setting');

        if($nb!='proses'){
            if ($data['sistem']['tripay_apikey']!='-') {
                $data['tripay'] = $this->auth->load_metode_tripay();
            }
            $data['city'] = $this->auth->load_kabupaten();
        }

        // tambahan kurir lokal
        $data['xkurir'] = $this->auth->getById('m_kurir_lokal','kurir_lokal_id',1);
        // end tambahan kurir lokal

        $this->form_validation->set_rules('global_diskon', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('metode_pembayaran', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('metode_ulasan', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('metode_rating', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('google_client', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('google_secret', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('google_redirect', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('midtrans_tipekey', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('midtrans_clientkey', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('midtrans_serverkey', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('fitur_chat', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('status_wablas', '', 'trim|required|xss_clean|htmlspecialchars');

        $this->form_validation->set_rules('kirim_transaksi_email', '', 'trim|required|xss_clean|htmlspecialchars');
        
        $this->form_validation->set_rules('smtp_host', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('smtp_username', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('smtp_password', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('smtp_secure', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('smtp_port', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('smtp_setnama', '', 'trim|required|xss_clean|htmlspecialchars');

        $this->form_validation->set_rules('tripay_merchant', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('tripay_tipekey', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('tripay_apikey', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('tripay_privatekey', '', 'trim|required|xss_clean|htmlspecialchars');

        $this->form_validation->set_rules('xendit_publickey', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('xendit_secretkey', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('xendit_callbank_token', '', 'trim|required|xss_clean|htmlspecialchars');

        $this->form_validation->set_rules('origin_store', '', 'trim|required|xss_clean|htmlspecialchars');

        $this->form_validation->set_rules('fitur_saldo', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('komisi_affiliate_produk', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('min_tarik_saldo', '', 'trim|required|xss_clean|htmlspecialchars');

        $this->form_validation->set_rules('status_watsap', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('apikey_watsap', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('iddevice_watsap', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('server_watsap', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('login_whatsapp', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('tipe_login', '', 'trim|required|xss_clean|htmlspecialchars');
        
        $this->form_validation->set_rules('api_ro1', 'Rajaongkir Api 1', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('api_ro2', '', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('api_ro3', '', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('api_ro4', '', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('api_ro5', '', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('api_ro6', '', 'trim|xss_clean|htmlspecialchars');
        
        $this->form_validation->set_rules('is_hide_menu_digital', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('lbl_info_global', '', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('lbl_info_transaksi', '', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('label_produk_lainnya_home', '', 'trim|required|xss_clean|htmlspecialchars');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/pengaturan/sistem', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $res = $this->pengaturan->editPengaturan('sistem');
            if ($res=='ok') {
                echo 'closemodalreload~Perubahan data berhasil.';
            }else{
                echo 'no~Perubahan gagal disimpan, pastikan kolom sudah terisi silahkan coba lagi.';
            }
        }
    }

    public function seoui($nb = null) {
        cek_menu_access();
        $data['nmenu'] = 'Pengaturan';
        $data['title'] = 'SEO & UI';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['sistem'] = $this->auth->rowData('_setting');

        $this->form_validation->set_rules('meta_title', 'Meta Title', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('meta_description', 'Meta Description', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('ui_navbar', 'UI Navbar', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('ui_kategori', 'UI Kategori', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('ui_footer', 'UI Footer', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('label_footer', 'Label Footer', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('footer', 'Footer', 'trim|required|xss_clean|htmlspecialchars');
        
        $this->form_validation->set_rules('primary_color', 'Primary Color', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('primary_hovercolor', 'Sub Color', 'trim|required|xss_clean|htmlspecialchars');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/pengaturan/seo-ui', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $old_gambar = $this->input->post('gambar_old');
            $cekimg = $_FILES['gambar']['name'];
            $old_gambar2 = $this->input->post('gambar_old2');
            $cekimg2 = $_FILES['gambar2']['name'];
            $old_gambar3 = $this->input->post('gambar_old3');
            $cekimg3 = $_FILES['gambar3']['name'];
            $old_gambar4 = $this->input->post('gambar_old4');
            $cekimg4 = $_FILES['gambar4']['name'];

            $upload = $this->auth->uploadGambar('gambar',$old_gambar,'logo','logo_admin_');
            if($upload['result'] == "success" || $cekimg==''){
                $upload2 = $this->auth->uploadGambar('gambar2',$old_gambar2,'logo','favicon_');
                if($upload2['result'] == "success" || $cekimg2==''){
                    $upload3 = $this->auth->uploadGambar('gambar3',$old_gambar3,'logo','empty_cart_');
                    if($upload3['result'] == "success" || $cekimg3==''){
                        $upload4 = $this->auth->uploadGambar('gambar4',$old_gambar4,'logo','logo_');
                        if($upload4['result'] == "success" || $cekimg4==''){
                            $res = $this->pengaturan->editPengaturan('seo-ui',$upload,$cekimg,$old_gambar,$upload2,$cekimg2,$old_gambar2,$upload3,$cekimg3,$old_gambar3,$upload4,$cekimg4,$old_gambar4);
                            if ($res=='ok') {
                                echo 'closemodalreload~Perubahan data berhasil.';
                            }else{
                                echo 'no~Perubahan gagal disimpan, pastikan kolom sudah terisi silahkan coba lagi.';
                                if ($cekimg!='') {
                                    unlink(FCPATH . './../assets/uploaded/logo/' . $upload['file']['file_name']);
                                }
                                if ($cekimg2!='') {
                                    unlink(FCPATH . './../assets/uploaded/logo/' . $upload2['file']['file_name']);
                                }
                                if ($cekimg3!='') {
                                    unlink(FCPATH . './../assets/uploaded/logo/' . $upload3['file']['file_name']);
                                }
                                if ($cekimg4!='') {
                                    unlink(FCPATH . './../assets/uploaded/logo/' . $upload4['file']['file_name']);
                                }
                            }
                        }else{
                            unlink(FCPATH . './../assets/uploaded/logo/' . $upload3['file']['file_name']);
                            echo 'no~Logo Toko : '.$upload4['error'];
                        }
                    }else{
                        unlink(FCPATH . './../assets/uploaded/logo/' . $upload2['file']['file_name']);
                        echo 'no~Empty Cart : '.$upload3['error'];
                    }
                }else{
                    unlink(FCPATH . './../assets/uploaded/logo/' . $upload['file']['file_name']);
                    echo 'no~Favicon : '.$upload2['error'];
                }
            }else{
                echo 'no~Logo Admin : '.$upload['error'];
            }
        }
    }

    public function tentang($nb = null) {
        cek_menu_access();
        $data['nmenu'] = 'Pengaturan';
        $data['title'] = 'Tentang Kami';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['sistem'] = $this->auth->rowData('_setting');

        $this->form_validation->set_rules('tentang_kami', 'Tentang Kami', 'required');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/pengaturan/tentang-kami', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $res = $this->pengaturan->editPengaturan('tentang-kami');
            if ($res=='ok') {
                echo 'closemodalreload~Perubahan data berhasil.';
            }else{
                echo 'no~Perubahan gagal disimpan, pastikan kolom sudah terisi silahkan coba lagi.';
            }
        }
    }

    public function kontak($nb = null) {
        cek_menu_access();
        $data['nmenu'] = 'Pengaturan';
        $data['title'] = 'Kontak Kami';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['sistem'] = $this->auth->rowData('_setting');

        $this->form_validation->set_rules('kontak_kami', 'Kontak Kami', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('email_address', 'Email', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('call_center', 'Call', 'trim|required|xss_clean|htmlspecialchars');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/pengaturan/kontak-kami', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $res = $this->pengaturan->editPengaturan('kontak-kami');
            if ($res=='ok') {
                echo 'closemodalreload~Perubahan data berhasil.';
            }else{
                echo 'no~Perubahan gagal disimpan, pastikan kolom sudah terisi silahkan coba lagi.';
            }
        }
    }

    public function faq($nb = null) {
        cek_menu_access();
        $data['nmenu'] = 'Pengaturan';
        $data['title'] = 'FAQ';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['sistem'] = $this->auth->rowData('_setting');

        $this->form_validation->set_rules('faq_asked', '', 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/pengaturan/faq', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $res = $this->pengaturan->editPengaturan('faq');
            if ($res=='ok') {
                echo 'closemodalreload~Perubahan data berhasil.';
            }else{
                echo 'no~Perubahan gagal disimpan, pastikan kolom sudah terisi silahkan coba lagi.';
            }
        }
    }

    public function privacy($nb = null) {
        cek_menu_access();
        $data['nmenu'] = 'Pengaturan';
        $data['title'] = 'Privacy Policy';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['sistem'] = $this->auth->rowData('_setting');

        $this->form_validation->set_rules('privacy_policy', 'Privacy', 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/pengaturan/privacy-policy', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $res = $this->pengaturan->editPengaturan('privacy-policy');
            if ($res=='ok') {
                echo 'closemodalreload~Perubahan data berhasil.';
            }else{
                echo 'no~Perubahan gagal disimpan, pastikan kolom sudah terisi silahkan coba lagi.';
            }
        }
    }

    public function terms($nb = null) {
        cek_menu_access();
        $data['nmenu'] = 'Pengaturan';
        $data['title'] = 'Terms & Conditions';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['sistem'] = $this->auth->rowData('_setting');

        $this->form_validation->set_rules('terms_conditions', '', 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/pengaturan/terms', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $res = $this->pengaturan->editPengaturan('terms');
            if ($res=='ok') {
                echo 'closemodalreload~Perubahan data berhasil.';
            }else{
                echo 'no~Perubahan gagal disimpan, pastikan kolom sudah terisi silahkan coba lagi.';
            }
        }
    }



}
