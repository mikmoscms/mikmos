<!DOCTYPE html>
<html lang="<?php _e($_LANG);?>">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?php _e(__WEBDESC);?>">
<meta name="author" content="<?php _e(__CMS);?>">
<link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
<title><?php _e(__WEBTITLLE);?></title>
<link href="assets/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/helper.css" rel="stylesheet">
<?php if(empty($_SESSION['css'])){ ?>
<link href="assets/css/mikmos_style.css" rel="stylesheet">
<?php }else{ ?>
<link href="assets/css/styles/<?php _e($_SESSION['css']);?>/mikmos_style.css" rel="stylesheet">
<?php } ?>
<script>
  function PassUser(){
var x = document.getElementById('passUser');
if (x.type === 'password') {
x.type = 'text';
} else {
x.type = 'password';
}}
</script>
</head>
<body class="fix-header fix-sidebar">
<div class="preloader">
<svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
</div>
<div id="main-wrapper">
<div class="header">
<nav class="navbar top-navbar navbar-expand-md navbar-light">
<div class="navbar-header">
<?php if(empty($_SESSION['css'])){ ?>
<a class="navbar-brand" href="?load=home">
<b><img src="assets/images/logo.png"/></b>
<span><img src="assets/images/logo-text.png"/></span>
</a>
<?php }else{ ?>
<a class="navbar-brand" href="?load=home">
<b><img src="assets/css/styles/<?php _e($_SESSION['css']);?>/logo.png"/></b>
<span><img src="assets/css/styles/<?php _e($_SESSION['css']);?>/logo-text.png"/></span>
</a>
<?php } ?>
</div>
<div class="navbar-collapse">
<ul class="navbar-nav mr-auto mt-md-0">
<li class="nav-item dropdown">
</li>
</ul>
</div>
</nav>
</div>

<?php if(!empty($_ceklog)){ ?>
<?php _e($_ceklog);?>
<?php } ?>
<div class="unix-login ">
<div class="container-fluid">
<div class="row justify-content-center">
<div class="col-lg-4">
<div class="login-content card ">
<div class="login-form">
<h4 style="text-transform:uppercase"><?php _e(__LOGIN_UR_ACCOUNT);?></h4>
<form class="form-signin" method="post" action="?index=login">
<div class="form-group">
<label><?php _e(__USERNAME);?></label>
<input type="text" class="form-control" id="signin-email" name="username" required placeholder="<?php _e(__USERNAME);?>" autocomplete="off" autofocus>
</div>
<div class="form-group">
<label><?php _e(__PASSWORD);?></label>
<div class="input-group input-group-flat">
<input id="passUser" type="password" class="form-control" id="signin-password" data-minlength="5" name="password" required placeholder="&bull;&bull;&bull;&bull;&bull;">
<span class="input-group-btn"><span class="btn btn-danger" onclick="PassUser()"><i class="fa fa-eye"></i></span></span>
</div>
</div>
<div class="checkbox">
<label>
<input type="checkbox" name="level" value="ADMIN" required> Check Me
</label>
<label class="pull-right">
<a href="./?index=forgot">Lupa Password?</a>
</label>
</div>
<button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Sign in</button>
</form>
</div>
</div>
<div class="register-link m-t-15 text-center">
<p>MIKMOS &copy; 2018</p>
</div>
</div>
</div>
</div>
</div>
</div>
<script src="assets/js/lib/jquery/jquery.min.js"></script>
<script src="assets/js/lib/bootstrap/js/bootstrap.min.js"></script>
<script>

 $(function() {
"use strict";
$(function() {
$(".preloader").fadeOut();
})
});
 </script>
</body>
</html>