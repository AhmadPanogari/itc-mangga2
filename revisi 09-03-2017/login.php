<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | Inventory Management System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/login.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-3.3.5/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/font-awesome/css/font-awesome.min.css') ?>">
    <script src="<?= base_url('assets/jquery-2.1.4.min.js') ?>"></script>
    <style type="text/css">
    .alert {
        margin-bottom:0px;
    }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="google-header-bar  centered">
            <div class="header content clearfix">
                <div class="logo logo-w"></div>
            </div>
        </div>
        <div class="banner">
            <h2>Inventory Management System</h2>
        </div>
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="row">                   
            <?php if($data=='First'){
                  echo'<h1 class="text-center login-title">Sign in to Inventory Management System</h1>' ;         
                    }
                  if($data=='Success'){
                    echo'
                    <h1 class="text-center login-title">Sign in to Inventory Management System</h1>
                    <div class="alert alert-success" role="alert">Login Successfuly.</div>';
                  }if($data=='Failed'){
                    echo'
                    <h1 class="text-center login-title">Sign in to Inventory Management System</h1>
                    <div class="alert alert-danger" role="alert">Login Failed.</div>';
                  }
            ?>
            </div>
            <div class="account-wall">
                <img class="profile-img" src="<?= base_url('assets/img/avatar.png') ?>"
                    alt="">
                <form class="form-signin" action="<?php echo base_url('login/aksi_login'); ?>" method="post">
                <input name="username" type="text" class="form-control" placeholder="Email" required autofocus>
                <input name= "password" type="password" class="form-control" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    Sign in</button>
                <label class="checkbox pull-left">
                    <span><h5>Don't forget for your account</h5></span>
                </label>
                <!-- <a href="#" class="pull-right need-help">Need help? </a> --><span class="clearfix"></span>
                </form>
            </div>
            <!-- <a href="#" class="text-center new-account">Create an account </a> -->
        </div>
    </div>
</div>
<script type="text/javascript">
<?php 
if($data=='Success'){
echo "$(document).ready(function() {
    setTimeout(function(){
                location.href='".base_url()."'}, 1000);
})";
}
?>
</script>
</body>
</html>