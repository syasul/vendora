<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="https://carvellonic.com">
  <link href="<?=$this->config->item("nhub_url");?>assets/uploaded/logo/<?=$setting["favicon_image"];?>" rel="icon">
  <title> <?=$title;?> </title>
  <link href="<?=base_url('assets/temp/');?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?=base_url('assets/temp/');?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="<?=base_url('assets/temp/');?>css/ruang-admin.min.css" rel="stylesheet">

  <style type="text/css">

    .bg-g-app-primary {
      background: <?=$setting["primary_color"];?> !important;
    }

    .bg-g-app-primary:hover {
      background: <?=$setting["primary_hovercolor"];?> !important;
    }

    .border-none {
      border: 0px !important;
    }

    .logo {
      width: 200px;
      height: 100px;
      margin-top: 20px;
      margin-left: 35px
    }

    .b-bottom-l {
      width: 100%; 
      height: 4px; 
      background: <?=$setting["primary_color"];?>;
    }

    .image {
      width: 360px;
      height: 280px
    }

    @media (max-width: 1199px){
      .container-login {
        margin-left: 10rem;
        margin-right: 10rem;
      }
    }

    @media (max-width: 678px){
      .container-login {
        margin-left: 0rem;
        margin-right: 0rem;
      }
    }

    @media screen and (max-width: 991px) {
      .logo {
          margin-left: 0px
      }

      .image {
          width: 300px;
          height: 220px
      }
    }

  </style>

</head>

<body class="bg-gradient-login">

  <div class="p-3">
    <div class="row d-flex justify-content-center">
      <div class="col-lg-5 col-md-6 col-sm-10">
        <div class="card border-none py-4" style="height: calc(100vh - 30px);">
          <div class="px-4 mb-4">
            <div class="row">
              <div class="col-xl-12 col-lg-12">
                <img src="<?=$this->config->item("nhub_url");?>assets/uploaded/logo/<?=$setting["logo_image"];?>" width="140">
              </div>
            </div>
          </div>
          <div class="b-bottom-l"></div>
          <div class="px-4 mt-4">
            <?=$this->session->flashdata('message');?>
            <form class="user" action="<?=base_url('auth');?>" method="post">
              <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" autocomplete="off" name="username" placeholder="" autocomplete="off" value="<?= set_value('username'); ?>">
                <?=form_error('username','<small class="text-danger">','</small>');?>
              </div>

              <div class="form-group mb-3">
                <div class="input-group">
                  <input type="password" class="form-control" id="myInput" autocomplete="off" name="password" placeholder="*****************">
                  <div class="input-group-append" onclick="myFunction()">
                    <span class="input-group-text bg-g-app-primary border-none" id="basic-addon2" style="cursor: pointer;">
                      <i id="matanyaganti" class="fas fa-eye-slash"></i>
                    </span>
                  </div>
                </div>
                <?=form_error('password','<small class="text-danger">','</small>');?> 
              </div>
 
              <div class="form-group">
                <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                  <input type="checkbox" class="custom-control-input" id="customCheck">
                  <label class="custom-control-label" for="customCheck">Remember me</label>
                </div>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block bg-g-app-primary border-none">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Login Content -->
  <script src="<?=base_url('assets/temp/');?>vendor/jquery/jquery.min.js"></script>
  <script src="<?=base_url('assets/temp/');?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?=base_url('assets/temp/');?>vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?=base_url('assets/temp/');?>js/ruang-admin.min.js"></script>

  <script type="text/javascript">
    function myFunction() {
      var x = document.getElementById("myInput");
      if (x.type === "password") {
        x.type = "text";
        $('#matanyaganti').addClass('fa-eye');
        $('#matanyaganti').removeClass('fa-eye-slash');
      } else {
        $('#matanyaganti').addClass('fa-eye-slash');
        $('#matanyaganti').removeClass('fa-eye');
        x.type = "password";
      }
    }
  </script>
</body>

</html>