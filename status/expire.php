<?php
error_reporting(0);
require_once('../inc/config.php');
require_once('../lib/fungsi.php');
require_once('../lib/routeros_api.class.php');
if(empty($_LANG)){
include('../inc/lang/id.php');
}else{
include('../inc/lang/'.$_LANG.'.php');
}
if(empty($_GET['router'])){
include('../inc/ip_mk/'.$_ROUTER.'.php');
}else{
include('../inc/ip_mk/'.$_GET['router'].'.php');
}
$API = new RouterosAPI();
$API->debug = false;
$API->connect($_IPMK, $_USMK, _de(ltrim($_PSMK, __CMS)));

$uname = $_GET['user'];
if($uname != ""){
$mikmosLoad = $API->comm("/sys/sch/print", array("?name" => "$uname"));
$expx = $mikmosLoad[0]['next-run'];
}
if(empty($expx)){
$exp = 'Unlimited';
}else{
$exp = $expx;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Status Expire</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="pragma" content="no-cache" />
<style>
body {font-family: arial;font-size: 13px;margin:0px;color:#555;}
</style>
</head>
<body>
<div style="padding:5px;" id="exp" ><?php echo $exp;?></div>
</body>
</html>