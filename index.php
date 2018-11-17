<?php
error_reporting(0);
@session_start();
@ob_start("ob_gzhandler");
@date_default_timezone_set("Asia/Bangkok");
@ini_set('max_execution_time', 300);
require_once('./inc/config.php');
require_once('./lib/routeros_api.class.php');
require_once('./lib/fungsi.php');
$_IPMK_DETEK = install_ipmk('./inc/ip_mk/');
if(empty($_LANG)){
require_once('./inc/lang/id.php');
}else{
require_once('./inc/lang/'.$_LANG.'.php');
}
if(empty($_IPMK_DETEK)){
rename ("./install_mikmos.php", "./install.php");
_e('<script>window.location.replace("./install.php?install");</script>');
}else{
rename ("./install.php", "./install_mikmos.php");
}
if(!empty($_SESSION['username'])) {
require_once('./inc/adm/'.$_SESSION['level'].'.php');
}
if($_SESSION['connect']=='connect') {
require_once('./inc/ip_mk/'.$_ROUTER.'.php');
$API = new RouterosAPI();
$API->debug = false;
$API->connect($_IPMK, $_POMK, $_USMK, _de(ltrim($_PSMK, __CMS)));
}
switch($_GET['index']){
default:
if($_SESSION['connect']=='noconnect') {_e('<script>window.location.replace("./settings.php?index");</script>');}
if(isset($_SESSION['username'])) {
include("load/t_atas.php");
include("load/t_menu.php");
$load=$_GET["load"];
if(!$load){
include("load/home.php");
}else{
if(empty($load)){
include("load/error.php");
}else{
if(file_exists("load/".$load.".php")){
include("load/".$_GET["load"].".php");
}else{
include("load/error.php");
}}}
include("load/t_bawah.php");
} else {
_e('<script>window.location.replace("./?index=login");</script>');
}
break;
case'api':
if(isset($_SESSION['username'])) {
$load=$_GET["load"];
if(empty($load)){
include("load/error.php");
}else{
if(file_exists("api/".$load.".php")){
include("api/".$_GET["load"].".php");
}else{
include("load/error.php");
}}
} else {
_e('<script>window.location.replace("./?index=login");</script>');
}
break;
case'login':
if(isset($_SESSION['username'])){
_e('<script>window.location.replace("./");</script>');
} else {
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['level'])) {
require_once('./inc/adm/'.$_POST['level'].'.php');
if($_POST['username'] == $_USER && $_POST['password'] == _de(ltrim($_PASS, __CMS)) && $_POST['level'] == $_LEVEL) {
$_SESSION['username'] = $_POST['username'];
$_SESSION['password'] = $_POST['password'];
$_SESSION['level']   = $_POST['level'];
_e('<meta http-equiv="refresh" content="0; url=./settings.php?index=connect"/>');
$_ceklog = '<div style="position:absolute;right:10%;top:10%;width:30%;z-index:1111" class="alert alert-warning alert-dismissible" role="alert"><i class="fa fa-warning"></i> Tunggu Sedang Mendeteksi...</div>';
} elseif($_POST['username'] !== $_USER && $_POST['password'] == _de(ltrim($_PASS, __CMS)) && $_POST['level'] == $_LEVEL) {
$_ceklog = '<div style="position:absolute;right:10%;top:10%;width:30%;z-index:1111" class="alert alert-danger alert-dismissible" role="alert"><i class="fa fa-times-circle"></i> Gagal!, username Salah...</div>';
} elseif($_POST['username'] == $_USER && $_POST['password'] !== _de(ltrim($_PASS, __CMS)) && $_POST['level'] == $_LEVEL) {
$_ceklog = '<div style="position:absolute;right:10%;top:10%;width:30%;z-index:1111" class="alert alert-danger alert-dismissible" role="alert"><i class="fa fa-times-circle"></i> Gagal!, Password Salah...</div>';
} elseif($_POST['username'] !== $_USER && $_POST['password'] !== _de(ltrim($_PASS, __CMS)) && $_POST['level'] == $_LEVEL) {
$_ceklog = '<div style="position:absolute;right:10%;top:10%;width:30%;z-index:1111" class="alert alert-danger alert-dismissible" role="alert"><i class="fa fa-times-circle"></i> Gagal!, username & Password Salah...</div>';
}}
include("load/_login.php");
}
break;
case'forgot':
if(isset($_POST['username']) && isset($_POST['level'])) {
require_once('./inc/adm/'.$_POST['level'].'.php');
require_once('./inc/ip_mk/'.$_ROUTER.'.php');
if(($_POST['username'] == $_USER) && ($_POST['hp'] == $_RTEL) && ($_POST['level'] == $_LEVEL)) {
$_ceklog = '<div class="alert alert-success alert-dismissible text-dark" role="alert">Username: '. $_USER.'<br/>Password: '. _de(ltrim($_PASS, __CMS)).'</div><p><a class="btn btn-danger btn-sm" href="./?index=login">LOGIN</a></p>';
} else {
$_ceklog = '<div class="alert alert-danger alert-dismissible" role="alert"><i class="fa fa-times-circle"></i> Gagal!, ada yang Salah...</div><p><a class="btn btn-danger btn-sm" href="./?index=forgot">ULANG</a></p>';
}
}
include("load/_forgot.php");
break;
case'logout':
include("load/t_atas.php");
include("load/t_menu.php");
//if(isset($_SESSION['username'])) {
session_destroy();
_e('<script>window.location.replace("./?index=login");</script>');
//}
include("load/t_bawah.php");
break;
case'lang':
include("load/t_atas.php");
include("load/t_menu.php");
if(isset($_SESSION['username'])) {
$lang = $_GET['get'];
$mconfig = './inc/config.php';
$handleconfig = fopen($mconfig, 'w') or die('Cannot open file:  '.$mconfig);
$dataconfig = '
<?php 
/** 
Yedin Abu Shafa 
Kontak WA: 081802161315
**/
$_ROUTER = "'.$_ROUTER.'";
$_LANG = "'.$lang.'";
$_TIMER= "'.$_TIMER.'";
?>';
fwrite($handleconfig, $dataconfig);
_e('<script>window.location.replace("./");</script>');
}
include("load/t_bawah.php");
break;
case'install_rename':
rename ("./install.php", "./install_mikmos.php");
session_destroy();
_e('<script>window.location.replace("./?index=login");</script>');
break;
case'vouchers_style':
include("load/t_atas.php");
include("load/t_menu_adm.php");
include("load/_voucher_editor.php");
include("load/t_bawah.php");
break;
case'backup':
include("load/t_atas.php");
include("load/t_menu_adm.php");
include("load/_backup.php");
include("load/t_bawah.php");
break;
}
?>