<?php
class CategoriesDetailC2Controller extends Controller {
    public function index() {
        global $rest_sistem, $main_imgurl, $main_url;
        
 

  if (!$_GET['p_url'] || !$_GET['s_url'] || !$_GET['t_url']) {
    header("Location: ".$main_url); exit();
  }
  
  $get_param = $_GET['p_url'];
  $get_param2 = $_GET['s_url'];
  $get_param3 = $_GET['t_url'];

  $arr = array('tipeid' => 'url', 'tipeid_v2' => 'url', 'idkategori' => $get_param, 'idsubkategori' => $get_param2, 'idsubkategorilv2' => $get_param3, 'lang' => 'en');
  $rest_kategori = loadData('rest_load/load_sub_kategori_det/', $arr);

  if ($rest_kategori==null) {
    $title_web = $rest_sistem['result']['meta_title'];
  }else{
    $title_web = $rest_kategori['nama_kategori'].' - '.$rest_kategori['nama_kategori2'].' - '.$rest_kategori['nama_kategori3'];
  }

  $arr = array('tipeid' => 'url', 'idkategori' => $get_param, 'lang' => 'en');
  $rest_kategori_f = loadData('rest_load/load_kategori_det/', $arr);




        $data = get_defined_vars();
        $this->view('categories_detail_c2/index', $data);
    }
}
