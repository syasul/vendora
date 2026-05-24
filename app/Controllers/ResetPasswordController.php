<?php
class ResetPasswordController extends Controller {
    public function index() {
        global $rest_sistem, $main_imgurl, $main_url;
        
 
  
   

  if (!$_GET['p_url']) {
    header("Location: ".$main_url); exit();
  }
  if ($_SESSION['XID_ARRAY'] && $_SESSION['XID_ARRAY']['cust_id']!='guest') {
    $_SESSION['trxrpass_msgpass'] = 'Logout dari akun untuk melanjutkan.';
    header("Location: ".$main_url); exit();
  }

  $arr = array('idunique' => $_GET['p_url'], 'lang' => 'en');
  $reset_check = loadData('rest_load/reset_password/', $arr); 




        $data = get_defined_vars();
        $this->view('reset-password/index', $data);
    }
}
