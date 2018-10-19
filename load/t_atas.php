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
<link href="assets/css/mikmos_style<?php _e($_SESSION['css']);?>.css" rel="stylesheet">
<script src="assets/js/lib/jquery/jquery.min.js"></script>
<script src="assets/js/lib/bootstrap/js/bootstrap.min.js"></script>
</head>
<body class="fix-header fix-sidebar">
<?php
echo cek_update();
?>
<div class="preloader">
<svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
</div>
<div id="main-wrapper" class="containerx">
<div class="header">
<nav class="navbar top-navbar navbar-expand-md navbar-light">
<div class="navbar-header">
<a class="navbar-brand" href="?load=home">
<b><img src="assets/images/logo<?php _e($_SESSION['css']);?>.png" class="dark-logo" /></b>
<span><img src="assets/images/logo-text<?php _e($_SESSION['css']);?>.png" class="dark-logo" /></span>
</a>
</div>
<div class="navbar-collapse">
<ul class="navbar-nav mr-auto mt-md-0">
<li class="nav-item"> <a title="Hide/Show" class="nav-link nav-toggler hidden-md-up text-muted  " href="javascript:void(0)"><i class="fa fa-list"></i></a> </li>
<li class="nav-item m-l-10"> <a title="Hide/Show" class="nav-link sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0)"><i class="fa fa-list"></i></a> </li>
<li class="nav-item dropdown">
<a title="<?php _e(__ROUTER);?>" class="nav-link dropdown-toggle text-muted text-muted  " href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-server"></i>
<div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
</a>
<div class="dropdown-menu dropdown-menu-left mailbox animated zoomIn">
<ul>
<li>
<div class="drop-title"><?php _e(__ROUTER);?></div>
</li>
<li>
<div class="message-center1">
<?php
$rep=opendir('./inc/ip_mk/');
while ($file = readdir($rep)) {
if($file != '..' && $file !='.' && $file !=''){
if ($file !='index.php' && $file !='index.html' && $file !='.htaccess'){
if(!is_dir($file)){
?>
<?php if($_ROUTER==substr($file, 0, -4)){ ?> 
<a title="Status Aktif" class="alert alert-success clearfix" href="./settings.php?index=change&get=<?php _e(substr($file, 0, -4));?>">
<div class="btn btn-info btn-circle m-r-10"><i class="fa fa-check"></i></div>
<div class="mail-contnet">
<h5><?php _e(substr($file, 0, -4));?></h5> 
</div>
</a>
<?php } ?>
<?php if($_ROUTER!==substr($file, 0, -4)){ ?> 

<a title="Aktifkan" class="alert alert-warning clearfix" href="./settings.php?index=change&get=<?php _e(substr($file, 0, -4));?>">
<div class="btn btn-danger btn-circle m-r-10"><i class="fa fa-minus"></i></div>
<div class="mail-contnet">
<h5><?php _e(substr($file, 0, -4));?></h5> 
</div>
</a>
<?php } ?>
<?php }}}} ?>
</div>
</li>
<li>
<a class="nav-link text-center" href="./settings.php?index=mikrotik_ae"> <strong><?php _e(__ADD);?> <?php _e(__ROUTER);?></strong> <i class="fa fa-angle-right"></i> </a>
</li>
</ul>
</div>
</li>
</ul>
<ul class="navbar-nav my-lg-0">
<li class="nav-item search-box box"><?php _e(update_system());?></li>
<li class="nav-item hidden-sm-down search-box"> <a class="nav-link hidden-sm-down text-muted  " href="javascript:void(0)"><div class="form-control" id="pesan"></div></a>
</li>
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/images/user<?php _e($_SESSION['css']);?>.png" alt="<?php _e($_SESSION['username']);?>" title="<?php _e($_SESSION['username']);?>" class="profile-pic" /></a>
<div class="dropdown-menu dropdown-menu-right animated zoomIn">
<ul class="dropdown-user">
<li><a href="./?index=logout"><i class="fa fa-power-off"></i> <?php _e(__LOGOUT);?></a></li>
</ul>
</div>
</li>
</ul>
</div>
</nav>
</div>