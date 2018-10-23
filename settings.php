<?php
eval("?>".base64_decode("PD9waHAgaW5jbHVkZSJsaWIvZnVsbC5waHAiOz8+"));
error_reporting(0);
@session_start();
@ob_start("ob_gzhandler");
@date_default_timezone_set("Asia/Bangkok");
@ini_set("max_execution_time", 300);
require_once('./inc/config.php');
require_once('./lib/routeros_api.class.php');
require_once('./lib/fungsi.php');
require_once('./inc/ip_mk/'.$_ROUTER.'.php');
$bg_array = array("#CEED9D","#ECED9D","#EDCF9D","#EC9CA7","#fdd752","#a48ad4","#aec785","#1fb5ac","#fa8564");
if(empty($_LANG)){
require_once('./inc/lang/id.php');
}else{
require_once('./inc/lang/'.$_LANG.'.php');
}
if(!empty($_SESSION['username'])) {
require_once('./inc/adm/'.$_SESSION['level'].'.php');
}
if(empty($_SESSION['username'])) {
_e('<script>window.location.replace("./?index=login");</script>');
}
switch($_GET['index']){
default:
//echo cek_update();
include("load/t_atas.php");
include("load/t_menu_adm.php");
?>
<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong><?php echo __WELLCOME;?>, <?php echo $_SESSION['username'];?></strong>
<span class="tools pull-right">
</span>
</header>
<div class="panel-body">
<p class="text-muted">
<?php if($_SESSION['connect']=='connect'){ ?> 
<a class="btn btn-danger" href="./?load=home"> <i class="fa fa-dashboard"></i> <?php echo __DASHBOARD;?></a>
<a class="btn btn-primary" href="./settings.php?index=mikrotik"> <i class="fa fa-wifi"></i> <?php echo __ROUTER;?></a>
<a class="btn btn-warning" href="./settings.php?index=administrator"> <i class="fa fa-key"></i> <?php echo __ADM;?></a>
<?php }else{ ?>
<a class="btn btn-danger" href="./settings.php?index=mikrotik"> <i class="fa fa-close"></i> Ganti Router</a>
<?php } ?>
</p><hr>
<div class="row">
<div class="col-md-6">


<?php load_router($_ROUTER, "./inc/ip_mk/", "on"); ?>
<?php load_adm("./inc/adm/"); ?>
</div>
<div class="col-md-6">

<table class="table table-striped" style="font-weight:600">
<tr><td>MIKMOS Versi</td><td> <?php echo versi_off('versi');?></td></tr>
<tr><td>Update</td><td><?php echo versi_off('tanggal');?></td></tr>
<tr><td>Seri</td><td><?php echo versi_off('seri');?></td></tr>
</table>
<hr>
<?php echo masaaktif();?>
</div>
</div>
</div>
</section>
</div>
</div>
<?php 
include("load/t_bawah.php");
break;
case'administrator':
include("load/t_atas.php");
include("load/t_menu_adm.php");
?>
<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong><?php echo __ADM;?></strong>
<span class="tools pull-right"></span>
</header>
<div class="panel-body">
<p class="text-muted">
Ruang administrator
</p><hr>
<div class="row">
<div class="col-md-6">
<?php load_adm("./inc/adm/"); ?>
</div>
<div class="col-md-6">
<table class="table table-striped">
<tr><td>Level</td><td><?php echo $_LEVEL;?></td></tr>
<tr><td>Username</td><td><?php echo $_USER;?></td></tr>
<tr><td>Password</td><td>&bull;&bull;&bull;&bull;&bull;&bull;</td></tr>
</table>
</div>
</div></div></div></div>
<?php
include("load/t_bawah.php");
break;
case'administrator_ae':
include("load/t_atas.php");
include("load/t_menu_adm.php");
$adm1 = $_GET['id'];
include './inc/adm/'.$adm1.'.php';
if(isset($_POST['edit'])) 
{
$level = strtoupper(ganti_spasi($_POST['level']));
$user = $_POST['user'];
$pass = _en($_POST['pass']);
$my_file_d = './inc/adm/'.$level.'.php';
unlink($my_file_d);
$my_file = './inc/adm/'.$level.'.php';
$handle = fopen($my_file, 'w') or die('Cannot open file: '.$my_file);
$data = '<?php
/** 
Yedin Abu Shafa 
Kontak WA: 081802161315
**/
$_LEVEL 	= "'.$level.'";
$_USER 		= "'.$user.'";
$_PASS 		= "'.__CMS.'_'.$pass.'";
?>';
fwrite($handle, $data);
chmod($my_file,0644);
_e('<script>window.location.replace("./settings.php?index=administrator");</script>');
echo '<style>.panel-body{display:none;}</dstyle>';
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
<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong><?php echo __ADM;?></strong>
<span class="tools pull-right"></span>
</header>
<div class="panel-body">
<p class="text-muted">
</p><hr>
<div class="row">
<div class="col-md-6">
<form action="" method="post">
<table class="table">
<tr>
<td class="align-middle">Username</td><td>
<input class="form-control" type="text" name="user" value="<?php echo $_USER;?>"/>
<input class="form-control" type="hidden" name="level" value="ADMIN"/>
</td>
</tr>
<tr>
<td class="align-middle">Password</td><td>
<div class="input-group input-group-flat">
<input class="form-control" id="passUser" type="password" name="pass" value="<?php echo _de(ltrim($_PASS, __CMS));?>"/>
<span class="input-group-btn btn btn-danger" title="Show/Hide Password" onclick="PassUser()"><i class="fa fa-eye"></i></span>
</div> 
</td>
</tr>
<tr>
<td></td><td>
<div>
<a class="btn btn-warning" href="./settings.php?index=mikrotik"> <i class="fa fa-close btn-mrg"></i> Close</a>
<button type="submit" name="edit" class="btn btn-primary btn-mrg" ><i class="fa fa-save btn-mrg"></i> Edit</button>
</div>
</td>
</tr>
</table>
</form>
</div>
<div class="col-md-6">
<table class="table table-striped">
<tr><td>Level</td><td><?php echo $_LEVEL;?></td></tr>
<tr><td>Username</td><td><?php echo $_USER;?></td></tr>
<tr><td>Password</td><td>&bull;&bull;&bull;&bull;&bull;&bull;</td></tr>
</table>
 </div>
 </div> </div> </div></div>
<?php
include("load/t_bawah.php");
break;
case'change':
include("load/t_atas.php");
include("load/t_menu_adm.php");
if(isset($_SESSION['username'])) {
$url = $_SERVER['REQUEST_URI'];
$_ipmk = $_GET['get'];
$mconfig = './inc/config.php';
$handleconfig = fopen($mconfig, 'w') or die('Cannot open file:  '.$mconfig);
$dataconfig = '<?php 
/** 
Yedin Abu Shafa 
Kontak WA: 081802161315
**/
$_ROUTER 	= "'.$_ipmk.'";
$_LANG 		= "'.$_LANG.'";
$_TIMER		= "'.$_TIMER.'";
?>';
fwrite($handleconfig, $dataconfig);
chmod($mconfig,0644);

$_SESSION['router'] = $_ipmk;
$_SESSION['urlasal'] = $_SERVER['REQUEST_URI'];
_e('<script>window.location.replace("./settings.php?index=connect");</script>');
}
include("load/t_bawah.php");
break;
case'connect':
include("load/t_atas.php");
include("load/t_menu_adm.php");
$API = new RouterosAPI();
$API->debug = false;
if ($API->connect($_IPMK, $_USMK, _de(ltrim($_PSMK, __CMS)))) {
$_SESSION['connect'] = 'connect';
_e('<script>window.location.replace("./?load=home");</script>');
$API->disconnect();
}else{
$_SESSION['connect'] = 'noconnect';
_e('<script>window.location.replace("./settings.php?index");</script>');
}
include("load/t_bawah.php");
break;
case'gagal':
include("load/t_atas.php");
include("load/t_menu_adm.php");
?>
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-body"> Status tidak terhubung ke Router, silahkan setting kembali Router yang akan digunakan <?php echo $_SESSION['connect'] ;
;?></div>
</div>
</div>
</div>
<?php 
include("load/t_bawah.php");
break;
case'mikrotik':
include("load/t_atas.php");
include("load/t_menu_adm.php");
?>
<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong><?php echo __ROUTER;?></strong>
<span class="tools pull-right">
 </span>
</header>
<div class="panel-body">
<p class="text-muted">
<a class="btn btn-danger" href="./settings.php?index=mikrotik_ae"> <i class="fa fa-plus"></i> <?php echo __ADD;?></a>
</p><hr>
<div class="row">
<div class="col-md-6">
<?php
load_router($_ROUTER, "./inc/ip_mk/", "on");
load_router($_ROUTER, "./inc/ip_mk/", "off");
?>
</div>
<div class="col-md-6">
<table class="table table-striped">
<tr><td>Status Router</td><td style="color:#fa8564"> <?php if($_SESSION['connect']=='connect'){ ?>Terhubung<?php }else{ ?>Tidak Terhubung<?php } ?></td></tr>
<tr><td>Router</td><td><?php echo $_ROUTER;?></td></tr>
<tr><td>IP/URL</td><td><?php echo $_IPMK;?></td></tr>
<tr><td>Username</td><td><?php echo $_USMK;?></td></tr>
<tr><td>Password</td><td>&bull;&bull;&bull;&bull;&bull;&bull;</td></tr>
<tr><td>Nama Perusahaan</td><td><?php echo $_RPER;?></td></tr>
<tr><td>Kota</td><td><?php echo $_RKOT;?></td></tr>
<tr><td>Kontak</td><td><?php echo $_RTEL;?></td></tr>
<tr><td>Logo Voucher</td><td><img height="50" src="./vouchers/images/<?php echo $_RLOG;?>"/></td></tr>
</table>
 </div>
 </div> </div> </div></div>
<?php
include("load/t_bawah.php");
break;
case'mikrotik_ae':
include("load/t_atas.php");
include("load/t_menu_adm.php");
if(!empty($_GET['id'])){
$router1 = $_GET['id'];
include('./inc/ip_mk/'.$router1.'.php');
$_ROUTER1 = $_ROUTER;
$_IPMK1 = $_IPMK;
$_USMK1 = $_USMK;
$_PSMK1 = $_PSMK;
$_RPER1 = $_RPER;
$_RKOT1 = $_RKOT;
$_RTEL1 = $_RTEL;
$_RDNS1 = $_RDNS;
$_RLOG1 = $_RLOG;
$_RETR1 = $_RETR;
}else{
$router1 = '';
}
if(isset($_POST['cek'])) 
{
$router1 = strtoupper(ganti_spasi($_POST['router']));
$ip1 = $_POST['ip'];
$user1 = $_POST['user'];
$pass1 = $_POST['pass'];
require_once('./lib/routeros_api.class.php');  
$API = new RouterosAPI();
$API->debug = false;
$API->connect($ip1, $user1, $pass1);
if($API->connect($ip1, $user1, $pass1)){
$konek = __CONNECT;$konek1 = '&rarr; <span class="text-danger mk_blink">'.__CONNECT.'</span>';
}else{
$konek = __NO_CONNECT;$konek1 = '&rarr; <span class="text-danger mk_blink">'.__NO_CONNECT.'</span>';
}
}
if(isset($_POST['save'])) 
{
$router = strtoupper(ganti_spasi($_POST['router']));
$ip = $_POST['ip'];
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
{  echo "Jenis gambar yang anda kirim salah. Harus .jpg .gif .png";} 
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
$_ROUTER 	= "'.$router.'";
$_IPMK 		= "'.$ip.'";
$_USMK 		= "'.$user.'";
$_PSMK 		= "'.__CMS.'_'.$pass.'";
$_RPER 		= "'.$per.'";
$_RKOT 		= "'.$kot.'";
$_RTEL 		= "'.$tel.'";
$_RDNS 		= "'.$dns.'";
$_RETR 		= "'.$etr.'";
$_RLOG 		= "'.$gambar1.'";
?>';
fwrite($handle, $data);
$my_file1 = 'inc/config.php';
$handle1 = fopen($my_file1, 'w') or die('Cannot open file:  '.$my_file1);
$data1 = '<?php
/** 
Yedin Abu Shafa 
Kontak WA: 081802161315
**/
$_ROUTER 	= "'.$router.'";
$_LANG 		= "id";
$_TIMER		= "1200";
?>';
fwrite($handle1, $data1);
chmod($my_file1,0644);
echo '<script>window.location.replace("./settings.php?index=mikrotik");</script>';
}
}
if(isset($_POST['edit'])) 
{
$router1 = $_ROUTER;
$router = strtoupper(ganti_spasi($router1));
$ip = $_POST['ip'];
$user = $_POST['user'];
$pass = _en($_POST['pass']);
$per = $_POST['per'];
$kot = $_POST['kot'];
$tel = $_POST['tel'];
$dns = $_POST['dns'];
$etr = $_POST['etr'];
$log1 = $_POST['log1'];
$log = $_FILES["Filegambar"]["tmp_name"];
if(empty($log)){
$logo = $log1;
}else{
$namafolder="./vouchers/images/"; 
$jenis_gambar=$_FILES['Filegambar']['type'];
if($jenis_gambar!=="image/jpeg" || $jenis_gambar!=="image/jpg" || $jenis_gambar!=="image/gif" || $jenis_gambar!=="image/png")
{  echo "Jenis gambar yang anda kirim salah. Harus .jpg .gif .png";} 
$gambar = $namafolder . basename($router."_".$_FILES['Filegambar']['name']);   
if (move_uploaded_file($_FILES['Filegambar']['tmp_name'], $gambar)) {
$gambar1 = basename($router."_".$_FILES['Filegambar']['name']); 
}
$logo = $gambar1; 
unlink('./vouchers/images/'.$log1.'');
}
$my_file_d = './inc/ip_mk/'.$router1.'.php';
unlink($my_file_d);
$namafolder="./vouchers/images/";  
$my_file = './inc/ip_mk/'.$router.'.php';
$handle = fopen($my_file, 'w') or die('Cannot open file: '.$my_file);
$data = '<?php
/** 
Yedin Abu Shafa 
Kontak WA: 081802161315
**/
$_ROUTER 	= "'.$router.'";
$_IPMK 		= "'.$ip.'";
$_USMK 		= "'.$user.'";
$_PSMK 		= "'.__CMS.'_'.$pass.'";
$_RPER 		= "'.$per.'";
$_RKOT 		= "'.$kot.'";
$_RTEL 		= "'.$tel.'";
$_RDNS 		= "'.$dns.'";
$_RETR 		= "'.$etr.'";
$_RLOG 		= "'.$logo.'";
?>';
fwrite($handle, $data);
chmod($my_file,0644);
_e('<script>window.location.replace("./settings.php?index=mikrotik");</script>');
echo '<style>.panel-body{display:none;}</dstyle>';
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
<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong><?php echo __ROUTERS;?></strong> <?php echo $konek1;?>
</header>
<form action="" method="post" enctype="multipart/form-data">
<div class="panel-body">
<div class="row">
<div class="col-md-6">
<table class="table table-striped">
<tr>
<td class="align-middle">Router</td><td>
<?php if(empty($_GET['id'])){ ?>
<input autocomplete="off" placeholder="Router" class="form-control" type="text" name="router" value="<?php echo $router1;?>" required="1"/>
<?php }else{ ?>
<?php echo $_ROUTER1;?>
<?php } ?>
</td>
</tr>
<tr>
<td class="align-middle">IP</td><td><input placeholder="IP / Domain" autocomplete="off" class="form-control" type="text" name="ip" value="<?php if(isset($_POST['cek'])) { echo $ip1;}else{ ?><?php echo $_IPMK1;?><?php } ?>" required="1"/></td>
</tr>
<tr>
<td class="align-middle">Username</td><td><input placeholder="Username Mikrotik" autocomplete="off" class="form-control" type="text" name="user" value="<?php if(isset($_POST['cek'])) { echo $user1;}else{ ?><?php echo $_USMK1;?><?php } ?>" required="1"/></td>
</tr>
<tr>
<td class="align-middle">Password<?php echo $user1;?></td><td>
<input placeholder="Password Mikrotik" autocomplete="off" class="form-control" id="passUser" type="password" name="pass" value="<?php if(isset($_POST['cek'])) { echo $pass1;}else{ ?><?php echo _de(ltrim($_PSMK1, __CMS));?><?php } ?>" required="1"/>
</td>
</tr>
<tr>
<td class="align-middle"></td><td>
<?php if($konek!==__CONNECT){?>
<button type="submit" name="cek" class="btn btn-danger btn-mrg" ><?php echo __CONNECT_IT;?> <i class="fa fa-arrow-right"></i></button>
<?php } ?>
<?php if($konek==__CONNECT){?>
<?php
if(!empty($_GET['id'])){ ?>
<button type="submit" name="edit" class="btn btn-primary btn-mrg" ><i class="fa fa-save btn-mrg"></i> Edit</button>
<?php }else{ ?>
<button type="submit" name="save" class="btn btn-primary btn-mrg" ><i class="fa fa-save btn-mrg"></i> Save</button>
<?php } ?>
<?php } ?>
<a class="btn btn-warning" href="./settings.php?index=mikrotik"> <i class="fa fa-close btn-mrg"></i> Close</a>
</td>
</tr>
</table>
</div>
<div class="col-md-6">
<?php if($konek==__CONNECT){?>
<table class="table table-striped">
<tr>
<td style="width:120px;">Perusahaan</td><td><input placeholder="Perusahaan Hotspot" class="form-control" type="text" autocomplete="off" name="per" value="<?php echo $_RPER1;?>" required="1"></td>
</tr>
<tr>
<td>Kota</td><td><input placeholder="Banten" class="form-control" type="text" autocomplete="off" name="kot" value="<?php echo $_RKOT1;?>" required="1"></td>
</tr>
<tr>
<td>Kontak</td><td><input placeholder="No Telp/Hp" class="form-control" type="text" autocomplete="off" name="tel" value="<?php echo $_RTEL1;?>" required="1"></td>
</tr>
<tr>
<td>Domain Login</td><td><input placeholder="hotspot.net" class="form-control" type="text" autocomplete="off" name="dns" value="<?php echo $_RDNS1;?>" required="1"></td>
</tr>
<tr>
<td>Interface</td><td>
<select class="form-control" name="etr">
<option <?php if($_RETR1==0){ echo 'selected';} ?> style="text-transform:uppercase" value="0">Non Aktif</option>
<option <?php if($_RETR1==1){ echo 'selected';} ?> style="text-transform:uppercase" value="1">Ether 1</option>
<option <?php if($_RETR1==2){ echo 'selected';} ?> style="text-transform:uppercase" value="2">Ether 2</option>
<option <?php if($_RETR1==3){ echo 'selected';} ?> style="text-transform:uppercase" value="3">Ether 3</option>
<option <?php if($_RETR1==4){ echo 'selected';} ?> style="text-transform:uppercase" value="4">Ether 4</option>
<option <?php if($_RETR1==5){ echo 'selected';} ?> style="text-transform:uppercase" value="5">Ether 5</option>
</select>
</td>
</tr>
<tr>
<td>Logo Voucher</td><td>
<?php if(!empty($_GET['id'])){ ?><input class="form-control" type="hidden" autocomplete="off" name="log1" value="<?php echo $_RLOG1;?>"><img height="50" src="./vouchers/images/<?php echo $_RLOG1;?>"/><?php } ?>  
<input type="file" name="Filegambar" id="Filegambar">
</td>
</tr>
</table>
<?php } ?>
</div>
</div> 
</div>
</form>
</div>
</div>
</div>
<?php
include("load/t_bawah.php");
break;
case'mikrotik_del':
include("load/t_atas.php");
include("load/t_menu_adm.php");
$router1 = $_GET['id'];
$my_file = './inc/ip_mk/'.$router1.'.php';
unlink($my_file);
_e('<script>window.location.replace("./settings.php?index=mikrotik");</script>');
include("load/t_bawah.php");
break;
case'update':
include("load/t_atas.php");
include("load/t_menu_adm.php");
if($_FILES["zip_file"]["name"]) {
$filename = $_FILES["zip_file"]["name"];
$source = $_FILES["zip_file"]["tmp_name"];
$type = $_FILES["zip_file"]["type"];
$name = explode(".", $filename);
$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip');
foreach($accepted_types as $mime_type) {
if($mime_type == $type) {
$okay = true;
break;
} 
}
$continue = strtolower($name[1]) == 'zip' ? true : false;
if(!$continue) {
$message = '<div class="alert alert-danger alert-dismissible" role="alert"><i class="fa fa-info"></i> '.__UPDATE1.'</div>';
}
$target_path = "./".$filename;
if(move_uploaded_file($source, $target_path)) {
$zip = new ZipArchive();
$x = $zip->open($target_path);
if ($x === true) {
$zip->extractTo("./"); 
$zip->close();
unlink($target_path);
}
$message = '<div class="alert alert-success" role="alert"><i class="fa fa-info"></i> '.__UPDATE2.'</div>';
} else {
$message = '<div class="alert alert-warning" role="alert"><i class="fa fa-info"></i> '.__UPDATE3.'</div>';
}
_e('<script>window.location.replace("./settings.php?index=update");</script>');
}
?>
<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong><?php echo __UPDATE;?></strong>
</header>
<h2>Upload File Update.zip</h2>
<form enctype="multipart/form-data" method="post" action="">
<p>Silahkan update : <input type="file" name="zip_file">  <button type="submit" name="submit" class="btn btn-primary btn-mrg" ><i class="fa fa-upload btn-mrg"></i><?php echo __UPDATE;?></button>
</form>
<?php if($message) echo "<p>$message</p>"; ?>
</div>
</div>
</div>
<?php
include("load/t_bawah.php");
break;
case'update_online':
include("load/t_atas.php");
include("load/t_menu_adm.php");
if(!empty($_GET['url'])){
$ch = curl_init();
$source = $_GET['url'];
curl_setopt($ch, CURLOPT_URL, $source);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec ($ch);
curl_close ($ch);
$destination = "mikmos_update.zip";
$file = fopen($destination, "w+");
fputs($file, $data);
fclose($file);
$zip = new ZipArchive;
$res = $zip->open('mikmos_update.zip');
if ($res === TRUE) {
$zip->extractTo('.');
$zip->close();
unlink('mikmos_update.zip');
} else {
}
_e('<script>window.location.replace("./settings.php?index");</script>');
}
?>
<?php
include("load/t_bawah.php");
break;
case'changebill':
include("load/t_atas.php");
include("load/t_menu_adm.php");
if(isset($_POST['changebill'])) 
{
$API = new RouterosAPI();
$API->debug = false;
$API->connect($_IPMK, $_USMK, _de(ltrim($_PSMK, __CMS)));
$mikmosLoad = $API->comm("/system/script/print", array("?comment" => "mikhmon"));
$mikmosTot = count($mikmosLoad);
for ($i=0; $i<$mikmosTot; $i++){
$mikmosView = $mikmosLoad[$i];
$idget = $mikmosView['.id'];
$MIKMOSCMS = 'MIKMOScms';
$API->comm("/system/script/set", array(".id" => "$idget", "comment" => "$MIKMOSCMS"));
}
}
?>
<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong><?php echo __UPDATE;?></strong>
</header>
<h2>Upload File Update.zip</h2>
<form enctype="multipart/form-data" method="post" action="">
<button type="submit" name="changebill" class="btn btn-primary btn-mrg" ><i class="fa fa-upload btn-mrg"></i><?php echo __UPDATE;?></button>
</form>
</div>
</div>
</div>
<?php
include("load/t_bawah.php");
break;
case'dis':
include("load/t_atas.php");
include("load/t_menu_adm.php");
$API = new RouterosAPI();
$API->debug = false;
$API->connect($_IPMK, $_USMK, _de(ltrim($_PSMK, __CMS)));
$idget = $_GET['id'];
$dget = $_GET['d'];
$API->comm("/ip/hotspot/user/set", array(".id"=> "$idget","disabled"=> "$dget"));
_e('<script>window.location.replace("./?load=users");</script>');
include("load/t_bawah.php");
break;
case'reboot':
include("load/t_atas.php");
include("load/t_menu_adm.php");
if(isset($_POST['reboot'])){
$API = new RouterosAPI();
$API->debug = false;
if ($API->connect($_IPMK, $_USMK, _de(ltrim($_PSMK, __CMS)))) {
	$API->write('/system/reboot');
	$API->read();
}
session_destroy();
echo "<script>window.location='./?index=login'</script>";
}
?>
<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong><?php echo __REBOOT;?></strong>
</header>
<div class="card-body">
					
<div class="table-responsive">
<div class="adv-table">
<form action="" method="post" enctype="multipart/form-data">
        <div>
          <h3>Anda yakin untuk me-Reboot Mikrotik <?php echo $_ROUTER;?>?</h3>
        </div>
  	  <button onclick="return confirm('Anda yakin untuk me-Reboot Mikrotik <?php echo $_ROUTER;?>?')" class="btn bg-danger" type="submit" title="Reboot" name="reboot"><i class="fa fa-power-off"></i> Reboot</button>
    </form>
</div>
</div>
</div>
</div>
</div>
</div>
<?php
include("load/t_bawah.php");
break;
case'themecss':
$_SESSION['css'] = $_GET['css'];
_e('<script>window.history.go(-1)</script>');
?>
<?php
break;
}
?>