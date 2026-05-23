<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller {
    public function __construct() {
        parent::__construct();
        is_logged_in();
        $this->load->library('form_validation');
        $this->load->model('auth_model', 'auth');
        $this->load->model('menu_model', 'menu');
        $this->load->model('produk_model', 'produk');
    }

    public function produk() {
        cek_menu_access();
        $data['nmenu'] = 'Produk';
        $data['title'] = 'Produk';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_data'] = $this->auth->resultData('m_produk','is_hapus="n"','*','kode_produk ASC');

        $this->load->view('templates/in_header', $data);
        $this->load->view('templates/in_topbar', $data);
        $this->load->view('module/produk/produk/index', $data);
        $this->load->view('templates/in_footer');
    }

    public function tambahProduk($nb = null) {
        $data['nmenu'] = 'Produk';
        $data['title'] = 'Produk';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_kateg'] = $this->auth->resultData('m_kategori','is_hapus="n" AND is_active=1','*','nama_kategori ASC');
        $data['all_warna'] = $this->auth->resultData('m_warna','is_hapus="n"');
        $data['all_ukuran'] = $this->auth->resultData('m_ukuran','is_hapus="n"');

        $this->form_validation->set_rules('kategori_id[]', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('kode_produk', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('nama_produk', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('harga_produk', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('potongan_status', '', 'trim|required|xss_clean|htmlspecialchars');

        if ($this->input->post('potongan_status')=='y') {
            $this->form_validation->set_rules('potongan_diskon', '', 'trim|required|xss_clean|htmlspecialchars');
            $this->form_validation->set_rules('potongan_mulai', '', 'trim|required|xss_clean|htmlspecialchars');
            $this->form_validation->set_rules('potongan_akhir', '', 'trim|required|xss_clean|htmlspecialchars');
        }

        $this->form_validation->set_rules('is_digital', '', 'trim|required|xss_clean|htmlspecialchars');
        if ($this->input->post('is_digital')=='n') {
            $this->form_validation->set_rules('berat_produk', '', 'trim|required|xss_clean|htmlspecialchars');
            $this->form_validation->set_rules('is_new', '', 'trim|required|xss_clean|htmlspecialchars');
        }
        
        $this->form_validation->set_rules('kategori_sub_id[]', '', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('kategori_sub_lv2_id[]', '', 'trim|xss_clean|htmlspecialchars');
        
        //$this->form_validation->set_rules('keterangan_produk', '', 'trim|xss_clean');
        $this->form_validation->set_rules('gambar', '', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('gambar2', '', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('gambar3', '', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('gambar4', '', 'trim|xss_clean|htmlspecialchars');

        $this->form_validation->set_rules('status_affiliate', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('komisi_affiliate_produk', '', 'trim|xss_clean|htmlspecialchars');
        
        $this->form_validation->set_rules('meta_title', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('meta_deskripsi', '', 'trim|required|xss_clean|htmlspecialchars');
        
        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/produk/produk/tambah', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $cekimg2 = $_FILES['gambar2']['name'];
            $cekimg3 = $_FILES['gambar3']['name'];
            $cekimg4 = $_FILES['gambar4']['name'];
            $upload = $this->auth->uploadGambar('gambar','new','products','produk_');
            if($upload['result'] == "success"){
                $upload2 = $this->auth->uploadGambar('gambar2','new','products','produk_');
                if($upload2['result'] == "success" || $cekimg2==''){
                    $upload3 = $this->auth->uploadGambar('gambar3','new','products','produk_');
                    if($upload3['result'] == "success" || $cekimg3==''){
                        $upload4 = $this->auth->uploadGambar('gambar4','new','products','produk_');
                        if($upload4['result'] == "success" || $cekimg4==''){
                            if ($this->input->post('is_digital')=='y') {
                                $cekdigital = $_FILES['digital']['name'];
                                $uploaddigital = $this->auth->uploadDigital('digital','new','products','file_digital_');
                                if ($uploaddigital['result'] == "success" || $cekdigital=='') {
                                    $res = $this->produk->tambahProduk($upload,$upload2,$upload3,$upload4,$uploaddigital);
                                    if ($res==true) {
                                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data baru berhasil di buat.</div>');
                                        echo 'url~'.base_url('produk/produk/');
                                    }else{
                                        echo 'no~ Proses gagal, silahkan coba lagi';
                                        unlink(FCPATH . './../assets/uploaded/products/' . $uploaddigital['file']['file_name']);
                                        unlink(FCPATH . './../assets/uploaded/products/' . $upload['file']['file_name']);
                                        if ($cekimg2!='') {
                                            unlink(FCPATH . './../assets/uploaded/products/' . $upload2['file']['file_name']);
                                        }
                                        if ($cekimg3!='') {
                                            unlink(FCPATH . './../assets/uploaded/products/' . $upload3['file']['file_name']);
                                        }
                                        if ($cekimg4!='') {
                                            unlink(FCPATH . './../assets/uploaded/products/' . $upload4['file']['file_name']);
                                        }
                                    }
                                }else{
                                    echo 'no~ File Digital : '.$uploaddigital['error'];
                                    unlink(FCPATH . './../assets/uploaded/products/' . $upload['file']['file_name']);
                                    if ($cekimg2!='') {
                                        unlink(FCPATH . './../assets/uploaded/products/' . $upload2['file']['file_name']);
                                    }
                                    if ($cekimg3!='') {
                                        unlink(FCPATH . './../assets/uploaded/products/' . $upload3['file']['file_name']);
                                    }
                                    if ($cekimg4!='') {
                                        unlink(FCPATH . './../assets/uploaded/products/' . $upload4['file']['file_name']);
                                    }
                                }
                            }else{
                                $res = $this->produk->tambahProduk($upload,$upload2,$upload3,$upload4);
                                if ($res==true) {
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data baru berhasil di buat.</div>');
                                    echo 'url~'.base_url('produk/produk/');
                                }else{
                                    echo 'no~ Proses gagal, silahkan coba lagi';
                                    unlink(FCPATH . './../assets/uploaded/products/' . $upload['file']['file_name']);
                                    if ($cekimg2!='') {
                                        unlink(FCPATH . './../assets/uploaded/products/' . $upload2['file']['file_name']);
                                    }
                                    if ($cekimg3!='') {
                                        unlink(FCPATH . './../assets/uploaded/products/' . $upload3['file']['file_name']);
                                    }
                                    if ($cekimg4!='') {
                                        unlink(FCPATH . './../assets/uploaded/products/' . $upload4['file']['file_name']);
                                    }
                                }
                            }
                        }else{
                            unlink(FCPATH . './../assets/uploaded/products/' . $upload3['file']['file_name']);
                            echo 'no~ Gambar 4 : '.$upload4['error'];
                        }
                    }else{
                        unlink(FCPATH . './../assets/uploaded/products/' . $upload2['file']['file_name']);
                        echo 'no~ Gambar 3 : '.$upload3['error'];
                    }
                }else{
                    unlink(FCPATH . './../assets/uploaded/products/' . $upload['file']['file_name']);
                    echo 'no~ Gambar 2 : '.$upload2['error'];
                }
            }else{
                echo 'no~ Gambar 1 : '.$upload['error'];
            }
        }

    }

    public function editProduk($primary_id, $nb = null) {
        $data['nmenu'] = 'Produk';
        $data['title'] = 'Produk';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['edit'] = $this->auth->getById('m_produk','produk_id',$primary_id);
        $data['all_kateg'] = $this->auth->resultData('m_kategori','is_hapus="n" AND is_active=1','*','nama_kategori ASC');
        $kateg_selected = $this->produk->dataprodKategori($primary_id);
        $data['all_sub'] = $this->produk->selectSub($kateg_selected['datatextid']);
        $data['all_warna'] = $this->auth->resultData('m_warna','is_hapus="n"');
        $data['all_ukuran'] = $this->auth->resultData('m_ukuran','is_hapus="n"');
        $data['all_img'] = $this->auth->resultData('m_produk_img','produk_id='.$primary_id);

        $this->form_validation->set_rules('kategori_id[]', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('kode_produk', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('nama_produk', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('harga_produk', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('is_active', 'Status', 'trim|required|xss_clean|htmlspecialchars');

        $this->form_validation->set_rules('potongan_status', '', 'trim|required|xss_clean|htmlspecialchars');

        $this->form_validation->set_rules('is_digital', '', 'trim|required|xss_clean|htmlspecialchars');
        if ($this->input->post('is_digital')=='n') {
            $this->form_validation->set_rules('berat_produk', '', 'trim|required|xss_clean|htmlspecialchars');
            $this->form_validation->set_rules('is_new', '', 'trim|required|xss_clean|htmlspecialchars');
        }

        if ($this->input->post('potongan_status')=='y') {
            $this->form_validation->set_rules('potongan_diskon', '', 'trim|required|xss_clean|htmlspecialchars');
            $this->form_validation->set_rules('potongan_mulai', '', 'trim|required|xss_clean|htmlspecialchars');
            $this->form_validation->set_rules('potongan_akhir', '', 'trim|required|xss_clean|htmlspecialchars');
        }

        $this->form_validation->set_rules('kategori_sub_id[]', '', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('kategori_sub_lv2_id[]', '', 'trim|xss_clean|htmlspecialchars');
        //$this->form_validation->set_rules('keterangan_produk', '', 'trim|xss_clean');

        $this->form_validation->set_rules('status_affiliate', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('komisi_affiliate_produk', '', 'trim|xss_clean|htmlspecialchars');
        
        $this->form_validation->set_rules('meta_title', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('meta_deskripsi', '', 'trim|required|xss_clean|htmlspecialchars');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/produk/produk/edit', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $old_digital = $this->input->post('old_digital');
            $cekdigital = $_FILES['digital']['name'];
            $uploaddigital = $this->auth->uploadDigital('',$old_digital,'products','file_digital_');
            if($uploaddigital['result'] == "success" || $cekdigital==''){
                $res = $this->produk->editProduk($primary_id,$uploaddigital,$cekdigital,$old_digital);
                if ($res==true) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diperbarui.</div>');
                    echo 'url~'.base_url('produk/produk/');
                }else{
                    echo 'no~ Proses gagal, silahkan coba lagi.';
                }
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$uploaddigital['error'].'</div>');
                echo 'reload';
            }
        }
    }

    public function editProdukImg($primary_id) {
        $old_gambar = $this->input->post('old_gambar');
        $cekimg = $_FILES['gambar']['name'];

        if ($cekimg!='') {
            $upload = $this->auth->uploadGambar('gambar',$old_gambar,'products','produk_');
            if($upload['result'] == "success"){
                $this->produk->editProdukImg($primary_id,$upload,$cekimg,$old_gambar);
                echo 'closemodalreload~Data berhasil diperbarui.';
            }else{
                echo 'no~'.$upload['error'];
            }
        }else{
            echo 'no~Tidak ada perubahan gambar.';
        }
    }

    public function tambahProdukImg($id) {
        $cekimg = $_FILES['gambar']['name'];
        if ($cekimg!='') {
            $upload = $this->auth->uploadGambar('gambar','new','products','produk_');
            if($upload['result'] == "success"){
                $this->produk->tambahProdukImg($id,$upload);
                echo 'closemodalreload~Gambar baru berhasil di simpan.';
            }else{
                echo 'no~'.$upload['error'];
            }
        }else{
             echo 'no~Tidak ada perubahan gambar.';
        }
    }

    public function hapusProdukImg($primary_id){
        $res = $this->produk->hapusProdukImg($primary_id);
        if ($res=='y') {
            echo 'ok~Gambar berhasil dihapus.';
        }else{
            echo 'no~Proses gagal, silahkan coba lagi.';
        }
    }

    public function hapusProduk($primary_id){
        $this->auth->hapusiFlag('m_produk','produk_id',$primary_id);
        echo 'ok~default';
    }

    public function selectSub($id = null, $produk_id = null) {
        $data['tipe'] = 'sub';
        $data['produk_id'] = $produk_id;
        $data['all_sub'] = $this->produk->selectSub($id);
        $this->load->view('module/produk/produk/option', $data);
    }

    public function selectSub2($id = null, $produk_id = null) {
        $data['tipe'] = 'sub_lv2';
        $data['produk_id'] = $produk_id;
        $data['all_sub'] = $this->produk->selectSub2($id);
        $this->load->view('module/produk/produk/option', $data);
    }

    public function produkDetail($zindex,$primary_id) {
        $data['zindex'] = $zindex+1;
        $data['detail'] = $this->auth->getById('m_produk','produk_id',$primary_id);
        $data['gambar'] = $this->auth->resultData('m_produk_img','produk_id='.$primary_id);
        $data['kategori'] = $this->produk->dataprodKategori($primary_id);
        $data['subkategori'] = $this->produk->dataprodsubKategori($primary_id);
        $data['subkategorilv2'] = $this->produk->dataprodsubLv2Kategori($primary_id);
        $data['warna'] = $this->produk->dataprodWarna($primary_id,'y');
        $data['ukuran'] = $this->produk->dataprodUkuran($primary_id,'y');
        $this->load->view('module/produk/produk/detail', $data);
    }

    public function stok($nb = null) {
        cek_menu_access();
        $data['nmenu'] = 'Produk';
        $data['title'] = 'Stok Produk';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_data'] = $this->auth->resultData('m_produk a JOIN m_produk_warna b ON a.produk_id=b.produk_id JOIN m_warna c ON b.warna_id=c.warna_id','a.is_hapus="n"','a.*,b.produk_warna_id,b.is_status,c.nama_warna','a.kode_produk ASC');

        $this->form_validation->set_rules('produk_id[]', '', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('produk_warna_id[]', '', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('keterangan[]', '', 'trim|xss_clean|htmlspecialchars');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/produk/stok/index', $data);
                $this->load->view('templates/in_footer');
            }
        }else{
            $this->produk->tambahStok();
            echo 'closemodalreload~Perubahan data stok berhasil.';
        }
    }

    public function riwayat() {
        cek_menu_access();
        $data['nmenu'] = 'Produk';
        $data['title'] = 'Riwayat Stok';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_data'] = $this->auth->resultData('m_produk','is_hapus="n"','*','kode_produk ASC');

        $this->load->view('templates/in_header', $data);
        $this->load->view('templates/in_topbar', $data);
        $this->load->view('module/produk/riwayat/index', $data);
        $this->load->view('templates/in_footer');
    }

    public function riwayat_stok($id,$mulai,$akhir) {
        $data['produk_id'] = $id;
        $data['tgl_mulai'] = $mulai;
        $data['tgl_akhir'] = $akhir;
        $data['jen'] = 'lv1';

        $data['all_data'] = $this->auth->resultData('m_produk a JOIN m_produk_warna b ON a.produk_id=b.produk_id JOIN m_warna c ON b.warna_id=c.warna_id','a.is_hapus="n" AND a.produk_id='.$id,'a.*,b.produk_warna_id,b.is_status,c.nama_warna','a.kode_produk ASC');

        $data['ukuranstok'] = $this->produk->dataprodUkuran($id);
        $this->load->view('module/produk/riwayat/riwayat_stok', $data);
    }

    public function riwayat_stok_res($id,$mulai,$akhir,$warna,$ukuran,$no) {
        $data['no_tabs'] = $no;
        $data['produk_id'] = $id;
        $data['tgl_mulai'] = $mulai;
        $data['tgl_akhir'] = $akhir;
        $data['jen'] = 'lv2';

        $data['all_data'] = $this->produk->riwayatStok($id,$mulai,$akhir,$warna,$ukuran);

        $data['ukuranstok'] = $this->produk->dataprodUkuran($id);
        $this->load->view('module/produk/riwayat/riwayat_stok', $data);
    }

    public function voucher() {
        cek_menu_access();
        $data['nmenu'] = 'Produk';
        $data['title'] = 'Voucher';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['all_data'] = $this->produk->dataVoucher();
        $data['sistem'] = $this->auth->rowData('_setting');

        $this->load->view('templates/in_header', $data);
        $this->load->view('templates/in_topbar', $data);
        $this->load->view('module/produk/voucher/index', $data);
        $this->load->view('templates/in_footer');
    }

    public function editLabelVoucher() {
        $res = $this->produk->editLabelVoucher();
        if ($res=='ok') {
            echo 'closemodalreload~Perubahan data berhasil.';
        }else{
            echo 'no~Perubahan gagal disimpan, pastikan kolom sudah terisi silahkan coba lagi.';
        }
    }

    public function tambahVoucher($nb = null) {
        $data['nmenu'] = 'Produk';
        $data['title'] = 'Voucher';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));

        $this->form_validation->set_rules('nama_voucher', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('kode_voucher', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('tipe_voucher', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('nominal_voucher', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('jumlah_voucher', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('tgl_mulai', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('tgl_akhir', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('minimal_belanja', '', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('maksimal_diskon', '', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('deskripsi_voucher', '', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('tampilkan', '', 'trim|required|xss_clean|htmlspecialchars');
        
        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/produk/voucher/tambah', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $checkdata = $this->db->get_where('m_voucher', ['kode_voucher' => $this->input->post('kode_voucher')]);
            if ($checkdata->num_rows() < 1) {
            $res = $this->produk->tambahVoucher();
                if ($res==true) {
                   $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data baru berhasil di buat.</div>');
                   echo 'url~'.base_url('produk/voucher/');
                }else{
                   echo 'no~ Proses gagal, silahkan coba lagi.';                            
                }
            }else{
                echo 'no~Voucher dengan kode <b>"'.$this->input->post('kode_voucher').'"</b> ini sudah terdaftar.';
            }
        }
    }

    public function editVoucher($primary_id, $nb = null) {
        $data['nmenu'] = 'Produk';
        $data['title'] = 'Produk';
        $data['auth'] = $this->auth->getById('m_pengelola','pengelola_id',$this->session->userdata('p_id'));
        $data['edit'] = $this->auth->getById('m_voucher','voucher_id',$primary_id);
    
        $this->form_validation->set_rules('nama_voucher', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('kode_voucher', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('tipe_voucher', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('nominal_voucher', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('jumlah_voucher', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('tgl_mulai', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('tgl_akhir', '', 'trim|required|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('minimal_belanja', '', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('maksimal_diskon', '', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('deskripsi_voucher', '', 'trim|xss_clean|htmlspecialchars');
        $this->form_validation->set_rules('tampilkan', '', 'trim|required|xss_clean|htmlspecialchars');

        if ($this->form_validation->run() == false) {
            if ($nb=='proses') {
                echo 'no~default';
            }else{
                $this->load->view('templates/in_header', $data);
                $this->load->view('templates/in_topbar', $data);
                $this->load->view('module/produk/voucher/edit', $data);
                $this->load->view('templates/in_footer');
            }
        } else {
            $unama = $this->input->post('kode_voucher');
            $query = $this->db->query("SELECT * FROM m_voucher WHERE kode_voucher='$unama' AND voucher_id!='$primary_id'");
            if ($query->num_rows() < 1) {
             $res = $this->produk->editVoucher($primary_id);
             if ($res==true) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diperbarui.</div>');
                echo 'url~'.base_url('produk/voucher/');
             }else{
                echo 'no~ Proses gagal, silahkan coba lagi.';
             }
            }else{
              echo 'no~Edit data gagal, voucher dengan kode <b>"'.$unama.'"</b> sudah di gunakan.';
            }
        }
    }

}
