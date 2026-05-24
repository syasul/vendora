<?php
class CategoriesDetailController extends Controller {
    public function index() {
        global $rest_sistem, $main_imgurl, $main_url;
        
 

  if (!$_GET['p_url']) {
    header("Location: ".$main_url); exit();
  }
  
  $get_param = $_GET['p_url'];

  $arr = array('tipeid' => 'url', 'idkategori' => $get_param, 'lang' => 'en');
  $rest_kategori = loadData('rest_load/load_kategori_det/', $arr);

  if ($rest_kategori==null) {
    $title_web = '...';
  }else{
    $title_web = $rest_kategori['nama_kategori'];
  }




        $data = get_defined_vars();
        $this->view('categories_detail/index', $data);
    }
}
