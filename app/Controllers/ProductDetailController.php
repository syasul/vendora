<?php
class ProductDetailController extends Controller {
    public function index() {
        global $rest_sistem, $main_imgurl, $main_url;
        
 

  if (!$_GET['p_url']) {
    header("Location: ".$main_url); exit();
  }
  
  $get_param = $_GET['p_url'];

  if (isset($_GET['p_url'])) {
    $p_url = $get_param;
    $session_key = 'AFFILIATE_P_' . $p_url;

    // Cek apakah session sudah lebih dari 6 jam
    if (isset($_SESSION[$session_key . '_time']) && (time() - $_SESSION[$session_key . '_time']) > 10800) {
        unset($_SESSION[$session_key]); // Hapus session utama
        unset($_SESSION[$session_key . '_time']); // Hapus session waktu
    }

    // Simpan data baru jika UID tersedia
    if (isset($_GET['uid'])) {
        $_SESSION[$session_key] = ['p_url' => $p_url, 'uid' => $_GET['uid']];
        $_SESSION[$session_key . '_time'] = time(); // Simpan waktu saat session dibuat
    }
  }

  $arr = array('wishlist' => 'n', 'idproduk' => $_GET['p_url'], 'new' => '', 'tipe' => '', 'lang' => 'en');
  $rest_produk = loadData('rest_load/load_produk/', $arr); 

  $res_p = $rest_produk['result'][0];

  $arr = array('idproduk' => $res_p['produk_id'], 'lang' => 'en');
  $rest_v_varian = loadData('rest_load/load_produk_varian/', $arr);


  $uid_affiliate = '';
  if(isset($rest_cust['result']['is_token'])){
    if($rest_cust['result']['is_token']!=''){
      $uid_affiliate = "&uid=".encodeData($rest_cust['result']['is_token']);
    }else{
      $uid_affiliate = '';
    }
  }




        $data = get_defined_vars();
        $this->view('product_detail/index', $data);
    }
}
