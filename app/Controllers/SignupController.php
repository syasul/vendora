<?php
class SignupController extends Controller {
    public function index() {
        global $rest_sistem, $main_imgurl, $main_url;
        
 
  
   

  if ($_SESSION['XID_ARRAY'] && $_SESSION['XID_ARRAY']['cust_id']!='guest') {
    header("Location: ".$main_url); exit();
  }

  $arr = array('idunique' => $_GET['p_url'], 'lang' => 'en');
  $reset_check = loadData('rest_load/reset_password/', $arr); 




        $data = get_defined_vars();
        $this->view('signup/index', $data);
    }
}
