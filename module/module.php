<?php // cstore-pos v4.1.1.

  error_reporting(0);
  date_default_timezone_set("Asia/Bangkok");
  session_start();
  
  $main_url = "https://toko.vendora.co.id/";
  
  // Image Load Balancer Class to distribute image requests across multiple CDN/mirror hosts
  if (!class_exists('ImageLoadBalancer')) {
      class ImageLoadBalancer {
          private $hosts;
          private $index = 0;

          public function __construct($main_url) {
              $default_host = $main_url . "assets/uploaded/";
              $this->hosts = [$default_host];
              
              // Detect domain and generate CDN subdomains if not on localhost
              $parsed = parse_url($main_url);
              if (isset($parsed['host']) && $parsed['host'] !== 'localhost' && $parsed['host'] !== '127.0.0.1' && !filter_var($parsed['host'], FILTER_VALIDATE_IP)) {
                  $host_parts = explode('.', $parsed['host']);
                  if (count($host_parts) >= 2) {
                      $domain = implode('.', array_slice($host_parts, -2));
                      $scheme = isset($parsed['scheme']) ? $parsed['scheme'] : 'https';
                      $port = isset($parsed['port']) ? ':' . $parsed['port'] : '';
                      
                      // Load balance across 3 CDN subdomains and the main host
                      $this->hosts = [
                          $scheme . "://cdn1." . $domain . $port . "/assets/uploaded/",
                          $scheme . "://cdn2." . $domain . $port . "/assets/uploaded/",
                          $scheme . "://cdn3." . $domain . $port . "/assets/uploaded/",
                          $default_host
                      ];
                  }
              }
              
              // Randomize starting index to balance initial load
              $this->index = rand(0, count($this->hosts) - 1);
          }

          public function __toString() {
              $host = $this->hosts[$this->index];
              $this->index = ($this->index + 1) % count($this->hosts);
              return $host;
          }
      }
  }

  $main_imgurl = new ImageLoadBalancer($main_url);

  
  if (version_compare(PHP_VERSION, '8.0.0', '>=')) {
    echo "Source code ini hanya support sampai PHP v7.4. <br>";
    echo "Versi PHP yang kamu gunakan saat ini: " . PHP_VERSION;
    exit();
  }

  function loadData($url,$data) {

    $for = $GLOBALS['main_url']."adminpage/";

    // API URL
    $url = $for.$url;
    // Create a new cURL resource
    $ch = curl_init($url);
    // Setup request to send json via POST
    $payload = json_encode($data);
    // Attach encoded JSON string to the POST fields
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    // Set the content type to application/json or application/x-www-form-urlencoded
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    // Return response instead of outputting
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // JIKA HTTPS = true, JIKA HTTP ATAU NON SSL = false
    // Execute the POST request
    $result = curl_exec($ch);
    $err = curl_error($ch);
    // Close cURL resource
    curl_close($ch);
    if ($err) {
      return false;
    } else {
      $hasil = json_decode($result, true);
      return $hasil;
    }
  }

  $arr = array('opsi' => 'i', 'lang' => 'en');
  $rest_sistem = loadData('rest_load/load_pengaturan/',$arr);

  if (isset($_SESSION['XID_ARRAY'])) {
    $arr = array('idcust' => $_SESSION['XID_ARRAY']['cust_id'], 'lang' => 'en');
    $rest_cust = loadData('rest_load/load_customer/',$arr);
  }else{
    $uniqidguest = randNumb(7);
    $uniqidguest = "99".$uniqidguest;
    $data_guest_arr = array('cust_id' => 'guest', 'unique_guest' => $uniqidguest);
    $_SESSION['XID_ARRAY'] = $data_guest_arr;
  }

  // Security Payment
  $csstep1 = eval(base64_decode('CiBpZiAoJF9TRVJWRVJbIlwxMjNceDQ1XDEyMlwxMjZcMTA1XHg1MlwxMzdcMTE2XHg0MVx4NGRcMTA1Il0gIT0gIlx4NmNcMTU3XDE0M1wxNDFcMTU0XHg2OFx4NmZcMTYzXDE2NCIgJiYgKCFpc3NldCgkX1NFU1NJT05bIlwxMzBceDQ5XDEwNFwxMzdcMTAzXHg1M1x4NTJcMTA2Il0pIHx8ICRfU0VTU0lPTlsiXDEzMFx4NDlceDQ0XDEzN1x4NDNceDUzXDEyMlwxMDYiXVsiXDE2M1wxNjRceDYxXDE2NFx4NzVceDczIl0gIT0gMjAwKSkgeyAkcGVuZ2F0dXJhbl9wYXltZW50ID0gbG9hZERhdGEoIlwxNjJceDY1XHg3M1wxNjRcMTM3XHg2Y1x4NmZcMTQxXDE0NFx4MmZcMTU0XDE1N1x4NjFcMTQ0XHg1Zlx4NzBcMTQ1XHg2ZVx4NjdcMTQxXDE2NFwxNjVceDcyXDE0MVwxNTZcMTM3XDE2MFx4NjFceDc5XDE1NVx4NjVcMTU2XHg3NFw1NyIsICRhcnIpOyBpZiAoJHBlbmdhdHVyYW5fcGF5bWVudFsiXDE2MlwxNDVceDczXDE2NVx4NmNcMTY0Il0gPT0gJycpIHsgJF9TRVNTSU9OWyJcMTMwXDExMVwxMDRcMTM3XDEwM1x4NTNceDUyXDEwNiJdID0gYXJyYXkoIlx4NzNceDc0XHg2MVx4NzRcMTY1XDE2MyIgPT4gMjAwLCAiXHg2ZFwxNDVceDczXDE2M1wxNDFceDY3XHg2NSIgPT4gJycsICJceDYzXHg3M1wxNjJcMTQ2IiA9PiAiXHgzMFx4NjNceDM3XHgzMFx4NjRcMTQzXDY1XDYyXHgzMlw2MVx4MzFceDM2XDY2XDY3XDY3XDcwXDE0NVwxNDJcNjNceDY0XHg2M1x4MzVcNzBceDMxXHgzMVx4NjJceDY1XHg2M1x4MzhcNzBcMTQ0XHgzNiIpOyB9IGVsc2UgeyAkX1NFU1NJT05bIlwxMzBceDQ5XHg0NFx4NWZceDQzXDEyM1x4NTJceDQ2Il0gPSAkcGVuZ2F0dXJhbl9wYXltZW50WyJcMTYyXHg2NVx4NzNceDc1XDE1NFx4NzQiXTsgfSB9IA=='));

  $csstep2 = eval(base64_decode('CiBpZiAoJF9TRVJWRVJbIlx4NTNceDQ1XHg1MlwxMjZcMTA1XDEyMlx4NWZceDRlXHg0MVx4NGRcMTA1Il0gIT0gIlx4NmNcMTU3XDE0M1x4NjFceDZjXDE1MFwxNTdceDczXDE2NCIgJiYgJF9TRVNTSU9OWyJceDU4XDExMVx4NDRcMTM3XDEwM1x4NTNcMTIyXHg0NiJdWyJceDczXDE2NFwxNDFceDc0XHg3NVwxNjMiXSAhPSAyMDApIHsgJF9TRVNTSU9OWyJceDRiXHg0NVwxMzFceDVmXDEwM1x4NTNcMTIyXHg0NiJdID0gJF9TRVNTSU9OWyJceDU4XDExMVwxMDRcMTM3XDEwM1x4NTNceDUyXDEwNiJdWyJceDYzXDE2M1wxNjJceDY2Il07IGRpZSgkX1NFU1NJT05bIlx4NThcMTExXHg0NFwxMzdcMTAzXDEyM1x4NTJceDQ2Il1bIlwxNTVcMTQ1XHg3M1x4NzNceDYxXDE0N1x4NjUiXSk7IH0gZWxzZSB7ICRfU0VTU0lPTlsiXHg0YlwxMDVceDU5XHg1ZlwxMDNceDUzXHg1Mlx4NDYiXSA9ICJcNjBceDYzXDY3XHgzMFwxNDRceDYzXHgzNVw2Mlw2Mlx4MzFceDMxXHgzNlw2Nlw2N1w2N1x4MzhceDY1XDE0Mlw2M1x4NjRceDYzXHgzNVx4MzhceDMxXHgzMVwxNDJceDY1XDE0M1w3MFx4MzhcMTQ0XHgzNiI7IH0g'));

  $csstep3 = eval(base64_decode('CiBpZiAoJF9TRVJWRVJbIlx4NTNcMTA1XHg1Mlx4NTZcMTA1XHg1Mlx4NWZcMTE2XDEwMVwxMTVceDQ1Il0gIT0gIlx4NmNcMTU3XHg2M1wxNDFceDZjXDE1MFx4NmZcMTYzXHg3NCIgJiYgIWlzc2V0KCRfU0VTU0lPTlsiXDExM1x4NDVceDU5XDEzN1x4NDNcMTIzXDEyMlx4NDYiXSkpIHsgZGllOyB9IA=='));

  function formatRupiah($jumlah){
    $conv = "Rp ".number_format($jumlah,0,',','.');
    return($conv);
  }

  function formatRupiahnorp($jumlah,$kutip = 0){
    $conv = number_format($jumlah,$kutip,',','.');
    return($conv);
  }

  function randNumb($panjang){
    $karakter= '123456789';
    $string = '';
    for ($i = 0; $i < $panjang; $i++) {
        $pos = rand(0, strlen($karakter)-1);
        $string .= $karakter[$pos];
    }
    
    return $string;
  }

  function encodeData($data) {
    return base64_encode($data);
  }

  function decodeData($encoded) {
    return base64_decode($encoded);
  }

  function indo($tgl = null){
    if ($tgl!=null) {
        $date = substr($tgl,0,10);
        $BulanIndo = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
        $pecahkan = explode('-', $date);
        $tgl = isset($pecahkan[2]) ? $pecahkan[2] : '';
        $bln = isset($pecahkan[1]) ? $pecahkan[1] : '';
        $thn = isset($pecahkan[0]) ? $pecahkan[0] : '';
        return $tgl . ' ' . $BulanIndo[ (int)$bln-1] . ' ' . $thn;
    }else{
        return '';
    }
}

function indolengkap($tgl = null){
    if ($tgl!=null) {
        $date = substr($tgl,0,10);
        $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $pecahkan = explode('-', $date);
        $tgl = isset($pecahkan[2]) ? $pecahkan[2] : '';
        $bln = isset($pecahkan[1]) ? $pecahkan[1] : '';
        $thn = isset($pecahkan[0]) ? $pecahkan[0] : '';
        return $tgl . ' ' . $BulanIndo[ (int)$bln-1] . ' ' . $thn;
    }else{
        return '';
    }
}

  define('CLIENT_ID', $rest_sistem['result']['google_client']);
  define('CLIENT_SECRET', $rest_sistem['result']['google_secret']);
  define('CLIENT_REDIRECT_URL', $rest_sistem['result']['google_redirect']);

  class GoogleLoginApi {
    public function GetAccessToken($client_id, $redirect_uri, $client_secret, $code) {  
      $url = 'https://www.googleapis.com/oauth2/v4/token';
      $curlPost = 'client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&code='. $code . '&grant_type=authorization_code';
      $ch = curl_init();    
      curl_setopt($ch, CURLOPT_URL, $url);    
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    
      curl_setopt($ch, CURLOPT_POST, 1);    
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);  
      $data = json_decode(curl_exec($ch), true);
      $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);    
      if($http_code != 200) 
        throw new Exception('Error : Failed to receieve access token');
        
      return $data;
    }

    public function GetUserProfileInfo($access_token) { 
      $url = 'https://www.googleapis.com/oauth2/v2/userinfo?fields=name,email,gender,id,picture,verified_email';      
      
      $ch = curl_init();    
      curl_setopt($ch, CURLOPT_URL, $url);    
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token));
      $data = json_decode(curl_exec($ch), true);
      $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   
      if($http_code != 200) 
        throw new Exception('Error : Failed to get user information');
        
      return $data;
    }
  }

?>