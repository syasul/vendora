<?php 
	
	include "module/module.php";

  if ($_GET['jen']=='index') {

  	$arr = array('wishlist' => 'n', 'idproduk' => 'n', 'new' => 'all', 'tipe' => 'limit', 'start' => $_GET['start'], 'limit' => $_GET['limit'], 'lang' => 'en');
    $rest_produk = loadData('rest_load/load_produk/', $arr); 

    $result_produk = $rest_produk['result'];
    $cols_data_infinity = 'col-xl-2 col-lg-3 col-md-3 col-sm-4 col-xs-6';

    if ($result_produk) {
  	  $json = include "product_data.php";
    }else{
    	$json = 'last';
    }
   	
   	return $json;

  }

  if ($_GET['jen']=='new_arrivals') {

    $arr = array('wishlist' => 'n', 'idproduk' => 'n', 'new' => 'y', 'tipe' => 'limit', 'start' => $_GET['start'], 'limit' => $_GET['limit'], 'lang' => 'en');
    $rest_produk = loadData('rest_load/load_produk/', $arr); 

    $result_produk = $rest_produk['result'];
    $cols_data_infinity = 'col-xl-2 col-lg-3 col-md-3 col-sm-4 col-xs-6';

    if ($result_produk) {
      $json = include "product_data.php";
    }else{
      $json = 'last';
    }
    
    return $json;

  }

  if ($_GET['jen']=='new_products') {

    $arr = array('wishlist' => 'n', 'idproduk' => 'n', 'new' => 'n', 'tipe' => 'limit', 'start' => $_GET['start'], 'limit' => $_GET['limit'], 'lang' => 'en');
    $rest_produk = loadData('rest_load/load_produk/', $arr); 

    $result_produk = $rest_produk['result'];
    $cols_data_infinity = 'col-xl-2 col-lg-3 col-md-3 col-sm-4 col-xs-6';

    if ($result_produk) {
      $json = include "product_data.php";
    }else{
      $json = 'last';
    }
    
    return $json;

  }

  if ($_GET['jen']=='product_digitals') {

    $arr = array('wishlist' => 'n', 'idproduk' => 'n', 'new' => 'd', 'tipe' => 'limit', 'start' => $_GET['start'], 'limit' => $_GET['limit'], 'lang' => 'en');
    $rest_produk = loadData('rest_load/load_produk/', $arr); 

    $result_produk = $rest_produk['result'];
    $cols_data_infinity = 'col-xl-2 col-lg-3 col-md-3 col-sm-4 col-xs-6';

    if ($result_produk) {
      $json = include "product_data.php";
    }else{
      $json = 'last';
    }
    
    return $json;

  }

  if ($_GET['jen']=='wishlist') {

    $arr = array('wishlist' => 'y', 'idproduk' => 'n', 'new' => 'n', 'tipe' => 'limit', 'start' => $_GET['start'], 'limit' => $_GET['limit'], 'lang' => 'en', 'idcust' => $_SESSION['XID_ARRAY']['cust_id']);
    $rest_produk = loadData('rest_load/load_produk/', $arr); 

    $result_produk = $rest_produk['result'];
    $cols_data_infinity = 'col-xl-2 col-lg-3 col-md-3 col-sm-4 col-xs-6';

    if ($result_produk) {
      $json = include "product_data.php";
    }else{
      $json = 'last';
    }
    
    return $json;

  }

  if ($_GET['jen']=='kategori_c0') {

    $arr = array('tipe' => 'limit', 'price' => $_GET['price'], 'sortby' => $_GET['sortby'], 'search' => $_GET['search'], 'start' => $_GET['start'], 'limit' => $_GET['limit'], 'idkategori' => $_GET['k_id'], 'lang' => 'en');
    $rest_kategori_p = loadData('rest_load/load_sub_kategori_pilihan_zero/',$arr);

    $result_produk = $rest_kategori_p['result'][0]['items'];
    $cols_data_infinity = 'col-xl-3 col-lg-4 col-md-6 col-sm-4 col-xs-6';

    if ($result_produk) {
      $json = include "product_data.php";
      $json = "______irow_".$rest_kategori_p['result'][0]['items_count'];
    }else{
      $json = 'last______irow_'.$rest_kategori_p['result'][0]['items_count'];
    }
    
    echo $json;

  }

  if ($_GET['jen']=='kategori_c1') {

    $arr = array('is' => 'n', 'tipe' => 'limit', 'price' => $_GET['price'], 'sortby' => $_GET['sortby'], 'search' => $_GET['search'], 'start' => $_GET['start'], 'limit' => $_GET['limit'], 'idsubkategori' => $_GET['k_subid'], 'lang' => 'en');
    $rest_kategori_p = loadData('rest_load/load_sub_kategori_pilihan_dua/',$arr);

    $result_produk = $rest_kategori_p['result'][0]['items'];
    $cols_data_infinity = 'col-xl-3 col-lg-4 col-md-6 col-sm-4 col-xs-6';

    if ($result_produk) {
      $json = include "product_data.php";
      $json = "______irow_".$rest_kategori_p['result'][0]['items_count'];
    }else{
      $json = 'last______irow_'.$rest_kategori_p['result'][0]['items_count'];
    }
    
    echo $json;

  }

  if ($_GET['jen']=='kategori_c2') {

    $arr = array('tipe' => 'limit', 'price' => $_GET['price'], 'sortby' => $_GET['sortby'], 'search' => $_GET['search'], 'start' => $_GET['start'], 'limit' => $_GET['limit'], 'idsubkategori' => $_GET['k_subid'], 'idsubkategorilv2' => $_GET['k_sub2id'], 'lang' => 'en');
    $rest_kategori_p = loadData('rest_load/load_sub_kategori_pilihan_tiga/',$arr);

    $result_produk = $rest_kategori_p['result'];
    $cols_data_infinity = 'col-xl-3 col-lg-4 col-md-6 col-sm-4 col-xs-6';

    if ($result_produk) {
      $json = include "product_data.php";
      $json = "______irow_".$rest_kategori_p['items_count'];
    }else{
      $json = 'last______irow_'.$rest_kategori_p['items_count'];
    }
    
    echo $json;

  }

  if ($_GET['jen']=='search_cari') {

    $arr = array('tipe' => 'limit', 'price' => $_GET['price'], 'sortby' => $_GET['sortby'], 'search' => $_GET['search'], 'start' => $_GET['start'], 'limit' => $_GET['limit'], 'lang' => 'en');
    $rest_kategori_p = loadData('rest_load/load_produk_search/',$arr);

    $result_produk = $rest_kategori_p['result'];
    $cols_data_infinity = 'col-xl-3 col-lg-4 col-md-6 col-sm-4 col-xs-6';

    if ($result_produk) {
      $json = include "product_data.php";
      $json = "______irow_".$rest_kategori_p['items_count'];
    }else{
      $json = 'last______irow_'.$rest_kategori_p['items_count'];
    }
    
    echo $json;

  }



?>