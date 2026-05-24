<?php
class SearchController extends Controller {
    public function index() {
        global $rest_sistem, $main_imgurl, $main_url;
        
 

  if (!$_GET['p_url']) {
    header("Location: ".$main_url); exit();
  }
  
  $get_param = $_GET['p_url'];
  $get_param = str_replace('-', ' ', $get_param);

  $arr = array('lang' => 'en');
  $rest_kategori_p_o = loadData('rest_load/load_kategori_pilihan_only/', $arr);




        $data = get_defined_vars();
        $this->view('search/index', $data);
    }
}
