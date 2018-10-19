<!DOCTYPE html>
<html>
<head>
<title>Voucher</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="pragma" content="no-cache" />
<link rel="icon" href="../img/favicon.png" />
<style>
body {color: #000000;background-color: #FFFFFF;font-size: 14px;font-family: 'Helvetica', arial, sans-serif;margin: 0px;}
table.voucher {display: inline-block;border: 2px solid black;margin: 2px;}
@page{size: auto;margin-left: 7mm;margin-right: 3mm;margin-top: 9mm;margin-bottom: 3mm;}
@media print{table { page-break-after:auto }tr { page-break-inside:avoid; page-break-after:auto }td { page-break-inside:avoid; page-break-after:auto }thead { display:table-header-group }tfoot { display:table-footer-group }}
#num {float:right;display:inline-block;}
.qrc {width:30px;height:30px;margin-top:1px;}
</style>
</head>
<?php
error_reporting(0);
@session_start();
if(!isset($_SESSION['connect'])){
 echo "<meta http-equiv='refresh' content='0;url=./?index=login' />";
}
$id = $_GET['id'];
$vouchers = $_GET['vouchers'];
$styles = $_GET['styles'];
$v_opsi = $_GET['pilihan'];
$v_qrc = $_GET['qrcode'];
include('../inc/config.php');
include('../lib/routeros_api.class.php');
include('../lib/fungsi.php');
include('../inc/ip_mk/'.$_ROUTER.'.php');
include('../inc/lang/'.$_LANG.'.php');
$API = new RouterosAPI();
$API->debug = false;
$API->connect($_IPMK, $_USMK, _de(ltrim($_PSMK, __CMS)));
$getprofile = $API->comm("/ip/hotspot/user/profile/print", array("?.id" => "$id"));
$profiledetalis = $getprofile[0];
$pid = $profiledetalis['.id'];
$gpname = $profiledetalis['name'];
$vuser = $API->comm("/ip/hotspot/user/print", array("?.id" => "$id"));
$Totuser = count($vuser);
$usermode = explode('-',$vouchers)[0];
$user = explode('-',$vouchers)[1];
$usermode = explode('-',$id)[0];
$v_profile = $vuser[0]['profile'];
$getprofile = $API->comm("/ip/hotspot/user/profile/print", array("?name" => "$v_profile"));
$ponlogin = $getprofile[0]['on-login'];
$v_valid = explode(",",$ponlogin)[3];
$getprice = explode(",",$ponlogin)[2];
if($getprice == 0){
$v_harga = "0";
}else{
$v_harga = number_format($getprice,0,",",".");
}
$v_logo = "../vouchers/images/".$_RLOG."";
?>
<body onload="window.print()">
<?php 
$v_dns = $_RDNS;
$v_spot = $_RPER;
$v_hp = $_RTEL;
for ($i=0; $i<$Totuser; $i++){ 
$regtable = $vuser[$i];
$v_user = $regtable['name'];
$v_pass = $regtable['password'];
$v_tlimit = $regtable['limit-uptime'];
$getdatalimit = $regtable['limit-bytes-out'];
if($getdatalimit == 0){$v_dlimit = "";}else{$v_dlimit = formatBytes2($getdatalimit,2);}
$chs = "80x80";
$chl = urlencode("http://$v_dns/login?username=$v_user&password=$v_pass");
$v_qrcode = 'https://chart.googleapis.com/chart?cht=qr&chs=' . $chs . '&chld=L|0&chl=' . $chl . '&choe=utf-8';
$v_num = $i+1;
if(empty($styles)){
include("styles/DEFAULT.php");
}else{
include "styles/".$styles.".php";
}
}
?>
</body>
</html>