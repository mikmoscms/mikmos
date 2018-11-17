<?php 
error_reporting(0);
@session_start();
@ob_start("ob_gzhandler");
@date_default_timezone_set("Asia/Bangkok");
@ini_set("max_execution_time", 300);
require_once('./inc/config.php');
require_once('./lib/fungsi.php');
$_IPMK_DETEK = install_ipmk('./inc/ip_mk/');
$_ADMK_DETEK = install_ipmk('./inc/adm/');
if(empty($_LANG)){
require_once('./inc/lang/id.php');
}else{
require_once('./inc/lang/'.$_LANG.'.php');
}
?>
<!DOCTYPE html>
<html lang="<?php echo $_LANG;?>">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?php echo __WEBDESC;?>">
<meta name="author" content="<?php echo __CMS;?>">
<link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
<title><?php echo __WEBTITLLE;?></title>
<link href="assets/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/helper.css" rel="stylesheet">
<link href="assets/css/mikmos_style.css" rel="stylesheet">
</head>

<body class="fix-header fix-sidebar">
<div class="preloader">
<svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
</div>
<div id="main-wrapper" class="container">
<div class="header">
<nav class="navbar top-navbar navbar-expand-md navbar-light">
<div class="navbar-header">
<a class="navbar-brand" href="?load=home">
<b><img src="assets/images/logo.png" alt="homepage" class="dark-logo" /></b>
<span><img src="assets/images/logo-text.png" alt="homepage" class="dark-logo" /></span>
</a>
</div>
<div class="navbar-collapse">
<ul class="navbar-nav mr-auto mt-md-0">
<li class="nav-item"> <a title="<?php echo __MENU;?>" class="nav-link nav-toggler hidden-md-up text-muted" href="javascript:void(0)"><i class="fa fa-list"></i></a> </li>
<li class="nav-item m-l-10"> <a title="<?php echo __MENU;?>" class="nav-link sidebartoggler hidden-sm-down text-muted" href="javascript:void(0)"><i class="fa fa-list"></i></a> </li>
</ul>

</div>
</nav>
</div>
<?php
switch($_GET['install']){
default:
?>
<div class="left-sidebar">
<div class="scroll-sidebar">
<nav class="sidebar-nav">
<ul id="sidebarnav">
<li class="nav-devider"></li>
<li class="nav-label">Install MIKMOS</li>
<li><a href="./install.php?install" class=""><i class="fa fa-dashboard"></i><span class="hide-menu">Wellcome</span></a></li>
<li><a href="#" class=""><i class="fa fa-dashboard"></i><span class="hide-menu">Step 1</span></a></li>
<li><a href="#" class=""><i class="fa fa-dashboard"></i><span class="hide-menu">Step 2</span></a></li>
<li><a href="#" class=""><i class="fa fa-dashboard"></i><span class="hide-menu">Finish</span></a></li>
</ul>
</nav>
</div>
</div>
<div class="page-wrapper">
<div class="container-fluid">
<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong><?php echo __CMS;?></strong>
<span class="tools pull-right">
 </span>
</header>
<div class="panel-body">
<p>Selamat datang, selamat menggunakan MIKMOS cms.</p>
<p>MIKMOS cms ini sepenuhnya FREE</p>
<span class="input-group-btn text-center"><a href="./install.php?install=step_1" class="btn btn-primary"><?php echo __NEXT;?> <i class="fa fa-arrow-right"></i></a></span>
 </div> 
 </div> 
 </div>
 </div>
</div>
</div>
<?php
break;
case'step_1':

?>
<?php
if(isset($_POST['submit'])) 
{
$level = strtoupper(ganti_spasi($_POST['level']));
$ip = $_POST['ip'];
$user = $_POST['user'];
$pass = _en($_POST['pass']);
$_SESSION['level'] = $level;
$my_file = 'inc/adm/'.$level.'.php';
$handle = fopen($my_file, 'w') or die('Cannot open file:'.$my_file);
$data = '
<?php
/** 
Yedin Abu Shafa 
Kontak WA: 081802161315
**/
$_LEVEL = "'.$level.'";
$_USER = "'.$user.'";
$_PASS = "'.__CMS.'_'.$pass.'";
?>';
fwrite($handle, $data);
echo '<script>window.location.replace("./install.php?install=step_2");</script>';
}
?>
<script>
 function PassUser(){
 var x = document.getElementById('passUser');
 if (x.type === 'password') {
 x.type = 'text';
 } else {
 x.type = 'password';
 }}
</script>
<div class="left-sidebar">
<div class="scroll-sidebar">
<nav class="sidebar-nav">
<ul id="sidebarnav">
<li class="nav-devider"></li>
<li class="nav-label">Install MIKMOS</li>
<li><a href="#" class=""><i class="fa fa-dashboard"></i><span class="hide-menu">Wellcome</span></a></li>
<li><a href="./install.php?install=step_1" class=""><i class="fa fa-dashboard"></i><span class="hide-menu">Step 1</span></a></li>
<li><a href="#" class=""><i class="fa fa-dashboard"></i><span class="hide-menu">Step 2</span></a></li>
<li><a href="#" class=""><i class="fa fa-dashboard"></i><span class="hide-menu">Finish</span></a></li>
</ul>
</nav>
</div>
</div>
<div class="page-wrapper">
<div class="container-fluid">
<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong><?php echo __CMS;?> &rarr; Step 1</strong>
<span class="tools pull-right">
 </span>
</header>
<div class="panel-body">
<p class="text-muted">
Step 1 - Membuat Akun Administrator untuk login ke MIKMOS
</p>
<form action="" method="post">
<table class="table">
 <tr>
 <td class="align-middle">Username</td><td><input class="form-control" type="text" name="user" placeholder="Username" required autocomplete="off" />
 <input class="form-control" type="hidden" name="level" value="ADMIN" placeholder="Nickname" required autocomplete="off" /></td>
 </tr>
 <tr>
 <td class="align-middle">Password</td><td>
 <div class="input-group input-group-flat">
 <input class="form-control" id="passUser" type="password" name="pass" placeholder="&bull;&bull;&bull;&bull;&bull;" required autocomplete="off" />
 <span class="input-group-btn btn btn-danger" title="Show/Hide Password" onclick="PassUser()"><i class="fa fa-eye"></i></span>
 </div>
 </td>
 </tr>
 <tr>
 <td></td><td>
 <div>
 </div>
 </td>
 </tr>
</table>
<span class="input-group-btn text-center"> <button type="submit" name="submit" class="btn btn-primary btn-mrg" ><?php echo __NEXT;?> <i class="fa fa-arrow-right"></i></button></span>
</form>
 </div> 
 </div> 
 </div>
 </div>
</div>
</div>
<?php
break;
case'step_2':
if(!empty($_IPMK_DETEK)){
echo '<script>window.location.replace("./install.php?install=finish");</script>';
}
?>
<?php
 if(isset($_POST['cek'])) 
 {
$router1 = strtoupper(ganti_spasi($_POST['router']));
$ip1 = $_POST['ip'];
$port1 = $_POST['port'];
$user1 = $_POST['user'];
$pass1 = $_POST['pass'];
require_once('./lib/routeros_api.class.php');
$API = new RouterosAPI();
$API->debug = false;
$API->connect($ip1, $port1, $user1, $pass1);
if($API->connect($ip1, $port1, $user1, $pass1)){
$konek = __CONNECT;$konek1 = '&rarr; <span class="text-danger mk_blink">'.__CONNECT.'</span>';
}else{
$konek = __NO_CONNECT;$konek1 = '&rarr; <span class="text-danger mk_blink">'.__NO_CONNECT.'</span>';
}
 }
 if(isset($_POST['submit'])) 
 {
 $router = strtoupper(ganti_spasi($_POST['router']));
 $ip = $_POST['ip'];
 $port = $_POST['port'];
 $user = $_POST['user'];
 $pass = _en($_POST['pass']);
 $per = $_POST['per'];
 $kot = $_POST['kot'];
 $tel = $_POST['tel'];
 $dns = $_POST['dns'];
 $etr = $_POST['etr'];
 $_SESSION['router'] = $router;


$namafolder="./vouchers/images/"; 
$jenis_gambar=$_FILES['Filegambar']['type'];
if($jenis_gambar!=="image/jpeg" || $jenis_gambar!=="image/jpg" || $jenis_gambar!=="image/gif" || $jenis_gambar!=="image/png")
{echo "Jenis gambar yang anda kirim salah. Harus .jpg .gif .png";} 

$gambar = $namafolder . basename($router."_".$_FILES['Filegambar']['name']); 
if (move_uploaded_file($_FILES['Filegambar']['tmp_name'], $gambar)) {

$gambar1 = basename($router."_".$_FILES['Filegambar']['name']); 
$my_file = './inc/ip_mk/'.$router.'.php';
$handle = fopen($my_file, 'w') or die('Cannot open file: '.$my_file);
$data = '<?php
/** 
Yedin Abu Shafa 
Kontak WA: 081802161315
**/
$_ROUTER = "'.$router.'";
$_IPMK = "'.$ip.'";
$_POMK = "'.$port.'";
$_USMK = "'.$user.'";
$_PSMK = "'.__CMS.'_'.$pass.'";
$_RPER = "'.$per.'";
$_RKOT = "'.$kot.'";
$_RTEL = "'.$tel.'";
$_RDNS = "'.$dns.'";
$_RETR = "'.$etr.'";
$_RLOG = "'.$gambar1.'";
?>';
fwrite($handle, $data);
$my_file1 = 'inc/config.php';
$handle1 = fopen($my_file1, 'w') or die('Cannot open file:'.$my_file1);
$data1 = '<?php
/** 
Yedin Abu Shafa 
Kontak WA: 081802161315
**/
$_ROUTER 	= "'.$router.'";
$_LANG 		= "id";
$_TIMER		= "1200";
$_THEMES	= "white";
?>';
fwrite($handle1, $data1);
echo '<script>window.location.replace("./install.php?install=finish");</script>';
 }
 }
?>
<script>
 function PassUser(){
 var x = document.getElementById('passUser');
 if (x.type === 'password') {
 x.type = 'text';
 } else {
 x.type = 'password';
 }}
</script>
<div class="left-sidebar">
<div class="scroll-sidebar">
<nav class="sidebar-nav">
<ul id="sidebarnav">
<li class="nav-devider"></li>
<li class="nav-label">Install MIKMOS</li>
<li><a href="#" class=""><i class="fa fa-dashboard"></i><span class="hide-menu">Wellcome</span></a></li>
<li><a href="#" class=""><i class="fa fa-dashboard"></i><span class="hide-menu">Step 1</span></a></li>
<li><a href="./install.php?install=step_2" class=""><i class="fa fa-dashboard"></i><span class="hide-menu">Step 2</span></a></li>
<li><a href="#" class=""><i class="fa fa-dashboard"></i><span class="hide-menu">Finish</span></a></li>
</ul>
</nav>
</div>
</div>
<div class="page-wrapper">
<div class="container-fluid">
<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong><?php echo __CMS;?> &rarr; Step 2 <?php echo $konek1;?></strong>
<span class="tools pull-right"></span>
</header>
<div class="panel-body">
<p class="text-muted">
Step 2 - Membuat Akses Router
</p>
<form action="" method="post" enctype="multipart/form-data">
<div class="row">
<div class="col-md-6">
<table class="table">
<tr>
<td class="align-middle">Nama Router</td><td><input class="form-control" autocomplete="off" type="text" name="router" value="<?php echo $router1;?>" placeholder="ROUTER" required /></td>
</tr>
<tr>
<td class="align-middle">IP</td><td><input class="form-control" autocomplete="off" type="text" name="ip" value="<?php echo $ip1;?>" placeholder="Ip/Host Mikrotik" required /></td>
</tr>
<tr>
<td class="align-middle">Port</td><td><input class="form-control" autocomplete="off" type="text" name="port" value="<?php echo $port1;?>" placeholder="Port (default : 8728)" required /></td>
</tr>
<tr>
<td class="align-middle">Username</td><td><input class="form-control" autocomplete="off" type="text" name="user" value="<?php echo $user1;?>" placeholder="Username" required /></td>
</tr>
<tr>
<td class="align-middle">Password</td><td>
<div class="input-group input-group-flat">
<input class="form-control" id="passUser" autocomplete="off" type="password" name="pass" value="<?php echo $pass1;?>" placeholder="Password" required />
<span class="input-group-btn btn btn-danger" title="Show/Hide Password" onclick="PassUser()"><i class="fa fa-eye"></i></span>
</div>
</td>
</tr>
<?php if($konek!==__CONNECT){?> <tr>
<td class="align-middle"></td><td>
<button type="submit" name="cek" class="btn btn-danger btn-mrg" ><?php echo __CONNECT_IT;?> <i class="fa fa-arrow-right"></i></button>
</td>
</tr>
<?php } ?>
</table>

</div>
<div class="col-md-6">
<?php if($konek==__CONNECT){?>
<table class="table">
<tr>
<td style="width:120px;">Perusahaan</td><td><input placeholder="Perusahaan Hotspot" class="form-control" type="text" autocomplete="off" name="per" required="1"></td>
</tr>
<tr>
<td>Kota</td><td><input placeholder="Banten" class="form-control" type="text" autocomplete="off" name="kot" required="1"></td>
</tr>
<tr>
<td>Kontak</td><td><input placeholder="No Telp/Hp" class="form-control" type="text" autocomplete="off" name="tel" required="1"></td>
</tr>
<tr>
<td>Domain Login</td><td><input placeholder="hotspot.net" class="form-control" type="text" autocomplete="off" name="dns" required="1"></td>
</tr>
<tr>
<td>Interface</td><td>
<select class="form-control" name="etr">
<option style="text-transform:uppercase" value="0">Non Aktif</option>
<option style="text-transform:uppercase" value="1">Ether 1</option>
<option style="text-transform:uppercase" value="2">Ether 2</option>
<option style="text-transform:uppercase" value="3">Ether 3</option>
<option style="text-transform:uppercase" value="4">Ether 4</option>
<option style="text-transform:uppercase" value="5">Ether 5</option>
</select>
</td>
</tr>
<tr>
<td>Logo Voucher</td><td><input type="file" name="Filegambar" id="Filegambar" required="1"></td>
</tr>
<tr>
<td></td><td>
</td>
</tr>
</table>
<div>
<button type="submit" name="submit" class="btn btn-primary btn-mrg" ><?php echo __NEXT;?> <i class="fa fa-arrow-right"></i></button>
</div>
<?php } ?>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
<?php
break;
case'finish':
if(empty($_ADMK_DETEK)){
echo '<script>window.location.replace("./install.php?install=step_1");</script>';
}
include_once('./inc/adm/'.$_SESSION['level'].'.php');
include_once('./inc/ip_mk/'.$_SESSION['router'].'.php');
?>
<div class="left-sidebar">
<div class="scroll-sidebar">
<nav class="sidebar-nav">
<ul id="sidebarnav">
<li class="nav-devider"></li>
<li class="nav-label">Install MIKMOS</li>
<li><a href="#" class=""><i class="fa fa-dashboard"></i><span class="hide-menu">Wellcome</span></a></li>
<li><a href="#" class=""><i class="fa fa-dashboard"></i><span class="hide-menu">Step 1</span></a></li>
<li><a href="#" class=""><i class="fa fa-dashboard"></i><span class="hide-menu">Step 2</span></a></li>
<li><a href="./install.php?install=finish" class=""><i class="fa fa-dashboard"></i><span class="hide-menu">Finish</span></a></li>
</ul>
</nav>
</div>
</div>
<div class="page-wrapper">
<div class="container-fluid">
<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong><?php echo __CMS;?> &rarr; <?php echo __FINISH;?> Installasi</strong>
<span class="tools pull-right">
 </span>
</header>
<div class="panel-body">
<p class="text-muted">
Data anda sudah selesai dibuat, silahkan untuk menggunakan MIKMOS cms :D
</p>
<div style="">

<table class="table">
 <tr>
 <td class="align-middle" colspan="2"><b>DATA MIKROTIK</b></td>
 </tr>
 <tr>
 <td class="align-middle" style="width:30%;">Nama Router</td><td><?php echo $_ROUTER;?></td>
 </tr>
 <tr>
 <td class="align-middle">IP</td><td><?php echo $_IPMK;?></td>
 </tr>
 <tr>
 <td class="align-middle">Username</td><td><?php echo $_USMK;?></td>
 </tr>
 <tr>
 <td class="align-middle">Password</td><td><?php echo _de(ltrim($_PSMK, __CMS));?></td>
 </tr>
</table>
<p></p>
<table class="table">
 <tr>
 <td class="align-middle" colspan="2"><b>DATA ADMIN</b></td>
 </tr>
 <tr>
 <td class="align-middle" style="width:30%;">Nickname</td><td><?php echo $_LEVEL;?></td>
 </tr>
 <tr>
 <td class="align-middle">Username</td><td><?php echo $_USER;?></td>
 </tr>
 <tr>
 <td class="align-middle">Password</td><td><?php echo _de(ltrim($_PASS, __CMS));?></td>
 </tr>
</table>
<p></p>
<table class="table">
 <tr>
 <td class="align-middle" colspan="2"><b>DATA LAINNYA</b></td>
 </tr>
 <tr>
 <td class="align-middle" style="width:30%;">Perusahaan</td><td><?php echo $_RPER;?></td>
 </tr>
 <tr>
 <td class="align-middle">Kota</td><td><?php echo $_RKOT;?></td>
 </tr>
 <tr>
 <td class="align-middle">Kontak</td><td><?php echo $_RTEL;?></td>
 </tr>
 <tr>
 <td class="align-middle">Login Hotspot</td><td><?php echo $_RDNS;?></td>
 </tr>
 <tr>
 <td class="align-middle">Ether</td><td><?php echo $_RETR;?></td>
 </tr>
 <tr>
 <td class="align-middle">Logo Voucher</td><td><img height="50" src="./vouchers/images/<?php echo $_RLOG;?>"/></td>
 </tr>
</table>
<div class="alert alert-warning">
<p>Dengan menekan tombol <?php echo __FINISH;?> berarti anda sudah siap. Langsung di gass poll </p>
</div>
<p></p>
<p>Salam,</p>
<p>MIKMOS cms</p>
</div> 
<span class="input-group-btn text-center"><a href="./index.php?index=install_rename" class="btn btn-primary"><?php echo __FINISH;?> <i class="fa fa-arrow-right"></i></a></span>
 </div>
 </div>
</div>
</div>
</div>
</div>
<?php
break;
}
?>
</div>
</div>
</div>
<script src="assets/js/lib/jquery/jquery.min.js"></script>
<script src="assets/js/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/sidebarmenu.js"></script>
<script src="assets/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="assets/js/lib/datatables/datatables.min.js"></script>
<script src="assets/js/lib/datatables/datatables-init.js"></script>
<script src="assets/js/mikmos_script.js"></script>
<script>
var url = "./?index=logout";
var count = <?php echo $_TIMER;?>;
function countDown() {
if (count > 0) {
count--;
var waktu = count + 1;
$('#pesan').html('Idle: ' + waktu + ' detik');
setTimeout("countDown()", 1000);
} else {
window.location.href = url;
}
}
countDown();
</script>
</body>
</html>