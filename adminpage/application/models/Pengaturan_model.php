<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan_model extends CI_Model {

    public function editPengaturan($menu,$upload=null,$cekimg=null,$old_gambar=null,$upload2=null,$cekimg2=null,$old_gambar2=null,$upload3=null,$cekimg3=null,$old_gambar3=null,$upload4=null,$cekimg4=null,$old_gambar4=null) {
        $proses = 'y';

        if ($menu=='sistem') {

            if ($this->input->post('metode_ulasan')!='konfirmasi' && $this->input->post('metode_ulasan')!='auto' && $this->input->post('metode_ulasan')!='off') {
                $metode_ulsn = 'konfirmasi';
            }else{
                $metode_ulsn = $this->input->post('metode_ulasan');
            }

            if ($this->input->post('metode_rating')!='konfirmasi' && $this->input->post('metode_rating')!='auto' && $this->input->post('metode_rating')!='off') {
                $metode_rat = 'konfirmasi';
            }else{
                $metode_rat = $this->input->post('metode_rating');
            }

            if($this->input->post('origin_store')==''){
                $originstore = '151*Jakarta Barat';
            }else{
                $originstore = $this->input->post('origin_store');
            }

            $this->db->set([
                'global_diskon'             => $this->input->post('global_diskon'),
                'google_client'             => $this->input->post('google_client'),
                'google_secret'             => $this->input->post('google_secret'),
                'google_redirect'           => $this->input->post('google_redirect'),
                'midtrans_tipekey'          => $this->input->post('midtrans_tipekey'),
                'midtrans_clientkey'        => $this->input->post('midtrans_clientkey'),
                'midtrans_serverkey'        => $this->input->post('midtrans_serverkey'),
                'tripay_merchant'           => $this->input->post('tripay_merchant'),
                'tripay_tipekey'            => $this->input->post('tripay_tipekey'),
                'tripay_apikey'             => $this->input->post('tripay_apikey'),
                'tripay_privatekey'         => $this->input->post('tripay_privatekey'),
                'xendit_tipekey'            => $this->input->post('xendit_tipekey'),
                'xendit_publickey'          => $this->input->post('xendit_publickey'),
                'xendit_secretkey'          => $this->input->post('xendit_secretkey'),
                'xendit_callbank_token'     => $this->input->post('xendit_callbank_token'),
                'metode_pembayaran'         => $this->input->post('metode_pembayaran'),
                'metode_ulasan'             => $metode_ulsn,
                'metode_rating'             => $metode_rat,
                'fitur_chat'                => $this->input->post('fitur_chat'),
                'status_wablas'             => $this->input->post('status_wablas'),
                'api_token_wablas'          => $this->input->post('api_token_wablas'),
                'server_wablas'             => $this->input->post('server_wablas'),
                'kirim_transaksi_email'     => $this->input->post('kirim_transaksi_email'),
                'smtp_host'                 => $this->input->post('smtp_host'),
                'smtp_username'             => $this->input->post('smtp_username'),
                'smtp_password'             => $this->input->post('smtp_password'),
                'smtp_secure'               => $this->input->post('smtp_secure'),
                'smtp_port'                 => $this->input->post('smtp_port'),
                'smtp_setnama'              => $this->input->post('smtp_setnama'),
                'smtp_cc_email'             => $this->input->post('smtp_cc_email'),
                'smtp_bcc_email'            => $this->input->post('smtp_bcc_email'),
                'origin_store'              => $originstore,
                'fitur_saldo'               => $this->input->post('fitur_saldo'),
                'komisi_affiliate_produk'   => $this->input->post('komisi_affiliate_produk'),
                'min_tarik_saldo'           => $this->input->post('min_tarik_saldo'),
                'status_watsap'             => $this->input->post('status_watsap'),
                'apikey_watsap'             => $this->input->post('apikey_watsap'),
                'iddevice_watsap'           => $this->input->post('iddevice_watsap'),
                'server_watsap'             => $this->input->post('server_watsap'),
                'login_whatsapp'            => $this->input->post('login_whatsapp'),
                'tipe_login'                => $this->input->post('tipe_login'),
                'api_ro1'                   => $this->input->post('api_ro1'),
                'api_ro2'                   => $this->input->post('api_ro2'),
                'api_ro3'                   => $this->input->post('api_ro3'),
                'api_ro4'                   => $this->input->post('api_ro4'),
                'api_ro5'                   => $this->input->post('api_ro5'),
                'api_ro6'                   => $this->input->post('api_ro6'),
                'is_hide_menu_digital'      => $this->input->post('is_hide_menu_digital'),
                'lbl_info_global'           => $this->input->post('lbl_info_global'),
                'lbl_info_transaksi'        => $this->input->post('lbl_info_transaksi'),
                'label_produk_lainnya_home' => $this->input->post('label_produk_lainnya_home')
                // 'maintance'              => $this->input->post('maintance')
            ]);
        }else if ($menu=='seo-ui') {

            if ($cekimg=='') { $imgnya = $old_gambar; }else{ $imgnya = $upload['file']['file_name']; }
            if ($cekimg2=='') { $imgnya2 = $old_gambar2; }else{ $imgnya2 = $upload2['file']['file_name']; }
            if ($cekimg3=='') { $imgnya3 = $old_gambar3; }else{ $imgnya3 = $upload3['file']['file_name']; }
            if ($cekimg4=='') { $imgnya4 = $old_gambar4; }else{ $imgnya4 = $upload4['file']['file_name']; }

            $this->db->set([
                'meta_title'                => $this->input->post('meta_title'),
                'meta_description'          => $this->input->post('meta_description'),
                'meta_keywords'             => $this->input->post('meta_keywords'),
                'ui_navbar'                 => $this->input->post('ui_navbar'),
                'ui_kategori'               => $this->input->post('ui_kategori'),
                'ui_footer'                 => $this->input->post('ui_footer'),
                'label_footer'              => $this->input->post('label_footer'),
                'footer'                    => $this->input->post('footer'),
                'primary_color'             => $this->input->post('primary_color'),
                'primary_hovercolor'        => $this->input->post('primary_hovercolor'),
                'logo_image'                => $imgnya,
                'favicon_image'             => $imgnya2,
                'empty_cart_image'          => $imgnya3,
                'logo_toko_image'           => $imgnya4
            ]);
        }else if ($menu=='tentang-kami') {
            $this->db->set([
                'tentang_kami'              => $this->input->post('tentang_kami')
            ]);
        }else if ($menu=='kontak-kami') {
            $this->db->set([
                'google_maps'               => $this->input->post('google_maps'),
                'kontak_kami'               => $this->input->post('kontak_kami'),
                'email_address'             => $this->input->post('email_address'),
                'call_center'               => $this->input->post('call_center'),
                'call_center2'              => $this->input->post('call_center2'),
                'whatsapp'                  => $this->input->post('whatsapp'),
                'whatsapp2'                 => $this->input->post('whatsapp2'),
                'instagram'                 => $this->input->post('instagram'),
                'facebook'                  => $this->input->post('facebook')
            ]);
        }else if ($menu=='faq') {
            $this->db->set([
                'faq_asked'                 => $this->input->post('faq_asked')
            ]);
        }else if ($menu=='privacy-policy') {
            $this->db->set([
                'privacy_policy'            => $this->input->post('privacy_policy')
            ]);
        }else if ($menu=='terms') {
            $this->db->set([
                'terms_conditions'          => $this->input->post('terms_conditions')
            ]);
        }else{
            $proses = 'n';
        }

        if ($proses=='y') {
            $this->db->where('setting_id', '1');
            $res = $this->db->update('_setting');
            // tambahan kurir lokal
            if ($menu=='sistem') {
                $check = $this->auth->countRow('m_kurir_lokal','kurir_lokal_id=1');
                if ($check==0) {
                    $datak = [
                        'kurir_lokal_id'    => 1,
                        'kurir_kode'        => 'klokal1',
                        'kurir_nama'        => 'Kurir Lokal Toko',
                        'kurir_harga'       => 0,
                        'is_status'         => 'y',
                        'is_hapus'          => 'n',
                        'created_at'        => date('Y-m-d H:i:s')
                    ];
                    $this->db->insert('m_kurir_lokal', $datak);
                }else{
                    $this->db->set([
                        'kurir_nama'    => $this->input->post('kurir_nama'),
                        'kurir_harga'   => $this->input->post('kurir_harga'),
                        'is_status'     => $this->input->post('is_status_k')
                    ]);
                    $this->db->where('kurir_lokal_id', '1');
                    $this->db->update('m_kurir_lokal');
                }

            }
            // end tambahan kurir lokal
        }else{
            $res = 'no';
        }


        if ($res==true) return 'ok'; else return 'no';
    }

}
