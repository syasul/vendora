	
    <meta name="author" content="https://carvellonic.com">
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=$main_url;?>assets/fonts/icomoon/style.css">
    <link rel="stylesheet" href="<?=$main_url;?>assets/css/owl.carousel.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=$main_url;?>assets/css/bootstrap-app.min.css">
    <!-- Style -->
    <link rel="stylesheet" href="<?=$main_url;?>assets/css/stylesmain.css">
    <link rel="stylesheet" href="<?=$main_url;?>assets/vendor/bootstrap-select.min.css">
    <link href="<?=$main_url;?>assets/vendor/jquery-confirm.min.css" rel="stylesheet">

    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="<?=$main_url;?>assets/vendor/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=$main_url;?>assets/vendor/owlcarousel/assets/owl.theme.default.min.css">

    <link href="<?=$main_imgurl;?>logo/<?=$rest_sistem['result']['favicon_image'];?>" rel="icon">
    <link href="<?=$main_imgurl;?>logo/<?=$rest_sistem['result']['favicon_image'];?>" rel="apple-touch-icon">

    <script src="<?=$main_url;?>assets/vendor/main/jquery-3.3.1.min.js"></script>
    <script src="<?=$main_url;?>assets/vendor/owlcarousel/owl.carousel.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <style>
        :root { /* 0e6ae8 0248a7 */
          --primarycolor: <?=$rest_sistem['result']['primary_color'];?> !important;
          --primaryhover: <?=$rest_sistem['result']['primary_hovercolor'];?> !important;
        }
    </style>

    <style type="text/css">

      /*#floating-button{  left: auto !important;  right: 30px !important;}
      #container-floating{  left: auto !important;  right: 30px !important;}
      .nd1{  left: auto !important;  right: 35px !important;}
      .nd3{  left: auto !important;  right: 35px !important;}
      .nd4{  left: auto !important;  right: 35px !important;}*/

      .bootstrap-select button {
        background: #FFF !important;
        border: 1px solid #ced4da !important;
      }

      .site-navbar .site-navigation .site-menu .has-children.account-div-signin > a:before {
        display: none !important;
      }

      .site-navbar .site-navigation .site-menu .has-children.account-div-signin .dropdown.arrow-top {
        right: 0px;
      }

      .navmvsec .has-children.account-div-signin > a:before {
        display: none !important;
      }

      .navmvsec .has-children.account-div-signin .dropdown.arrow-top {
        right: 0px;
      }

      .account-div-signin ul li {
        min-width: 160px !important;
      }

      .account-div-signin_img {
        background-position: center !important;
        background-size: cover !important;
        background-color: #FFF;
        width: 35px;
        height: 35px;
        position: absolute;
        top: 4px;
      }

      .account-div-signin_imgsec {
        background-position: center !important;
        background-size: cover !important;
        background-color: #FFF;
        width: 45px;
        height: 45px;
      }

      .account-div-ulasan_img {
        background-position: center !important;
        background-size: cover !important;
        background-color: #FFF;
        width: 45px;
        height: 45px;
      }

      #popalert-fixed {
        position: fixed;
        top: 100px;
        z-index: 1003;
        width: auto;
        right: 15px;
      }

      .popup_floating_download_apps {
        position: fixed;
        z-index: 100;
        bottom: 15px;
        right: 15px;
        background: #fff;
        padding: 15px;
        box-shadow: 0 1px 8px 0 #c2c2c2;
        border-radius: 5px;
        text-align: center;
      }

      .logo_pfda {
        margin-top: -60px;
        padding-bottom: 10px;
      }

      .logo_pfda img {
        width: 90px;
        border-radius: 5px;
        box-shadow: 0 1px 8px 0 #c2c2c2;
      }

      .txt_pfda {
        font-size: 18px;
        font-weight: 600;
      }

      .market_pfda img {
        width: 105px !important;
      }

      .close_pfda {
        cursor: pointer;
        font-size: 20px;
        position: absolute;
        right: 18px;
        color: #777;
      }

      .border-e4 {
        border:1px solid #e4e4e4;
      }

      .p-mob-30 {
          padding: 30px;
      }

      #carouselCategoryColumn_id .owl-stage,
      #carouselCategorySubColumn_id .owl-stage {
          left: -35px !important;
      }

      .navbar-bottom-fix {
        position:fixed;
        bottom: 0;
        width: 100%;
        background: #FFF;
        border-top: 1px solid transparent;
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
        z-index: 1019;
        padding: 7px 15px 7px 15px;
        font-size: 18px;
      }

      .nd4 {
        bottom: 220px;
      }

      @media (max-width: 991px) {
        .account-div-signin_img {
          width: 35px;
          position: unset;
          top: '';
        }
        .p-mob-30 {
          padding: 15px;
        }            
      }

      @media (max-width: 767.5px) {
        .footer-pb-mob {
          padding-bottom: 70px !important;
        }

        #floating-button {
          bottom: 80px;
        }
        .nd1 {
          bottom: 150px;
        }
        .nd3 {
          bottom: 210px;
        }
        .nd4 {
          bottom: 270px;
        }
      }
      
      .pay-box{
        background: #fff;
        border-radius: 12px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        transition: 0.2s;
      }
    
      .pay-box:hover{
        transform: translateY(-3px);
        box-shadow: 0 5px 12px rgba(0,0,0,0.08);
      }
    
      .pay-logo{
        max-height: 28px;
        max-width: 80%;
        object-fit: contain;
      }
      
      
      @media (max-width: 991px) {
          .pay-box{
            height: 45px;
          }
      }
      
      @media (max-width: 645px) {
        .footer__nav > * {
          flex: 1 40%;
          margin-right: 1.25em;
        }
      }
    </style>

