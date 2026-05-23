    
    <?php
        if(isset($_GET['code']) && isset($_GET['scope'])) {
            try {
                $gapi = new GoogleLoginApi();
                // Get the access token 
                $data = $gapi->GetAccessToken(CLIENT_ID, CLIENT_REDIRECT_URL, CLIENT_SECRET, $_GET['code']);
                // Get user information
                $user_info = $gapi->GetUserProfileInfo($data['access_token']);

                $arr = array('tipe' => 'web', 'email' => $user_info['email'], 'nama' => $user_info['name'], 'kode_aktivasi' => 'google', 'onesignalid' => '', 'lang' => 'en', 'sessid' => $_SESSION['XID_ARRAY']['unique_guest']);
                $rest_val = loadData('rest_proses/proses_aktivasi/', $arr);

                if ($rest_val['success']==true) {
                  $_SESSION['XID_ARRAY'] = $rest_val['result'];
                  echo '<div class="alert alert-success" id="popalert-fixed">'.$rest_val['msg'].'</div>';
                }else{
                  echo '<div class="alert alert-danger" id="popalert-fixed">'.$rest_val['msg'].'</div>';
                }
            }
            catch(Exception $e) {
              if (!isset($_SESSION['XID_ARRAY'])) {
                echo '<div class="alert alert-danger" id="popalert-fixed">'.$e->getMessage().', please try again.</div>';
              }
            }
        }

        if ($_SERVER['SERVER_NAME']!='localhost' && !isset($_SESSION['KEY_CSRF'])) { exit(); }
        $google_login_url = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email') . '&redirect_uri=' . urlencode(CLIENT_REDIRECT_URL) . '&response_type=code&client_id=' . CLIENT_ID . '&access_type=online';
    ?>

    <?php if ($rest_sistem['result']['label_voucher']!='') { ?>
    <div class="top-bar border-bottom1">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <a><?=$rest_sistem['result']['label_voucher'];?></a>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
    
    <?php if ($rest_sistem['result']['lbl_info_global']!='') { ?>
    <div class="p-3">
      <div class="alert alert-warning">
        <?=$rest_sistem['result']['lbl_info_global'];?>
      </div>
    </div>
    <?php } ?>

    <?php 
      if ($rest_sistem['result']['ui_navbar']==2) {
        include 'h_lv2.php';
      }else{ 
        include 'h_lv1.php'; 
      } 
    ?>