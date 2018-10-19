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
<body>
<?php
error_reporting(0);
@session_start();
if(!isset($_SESSION['connect'])){
 echo "<meta http-equiv='refresh' content='0;url=./?index=login' />";
}
include('../inc/config.php');
include('../inc/ip_mk/'.$_ROUTER.'.php');
include('../inc/lang/'.$_LANG.'.php');
$id = $_GET['id'];
$vouchers = $_GET['vouchers'];
$styles = $_GET['styles'];
$v_opsi = $_GET['pilihan'];
$v_qrc = $_GET['qrcode'];
$v_profile = 'Paket Goceng';
$v_valid = '7d';
$v_harga = number_format('5000',0,",",".");
$v_logo = "../vouchers/images/".$_RLOG."";
$v_dns = $_RDNS;
$v_spot = $_RPER;
$v_hp = $_RTEL;
$v_user = 'Demo';
$v_pass ='Demo';
$v_tlimit = '3d';
$v_dlimit = "1gb";
// CHart Size
$chs = "80x80";
// CHart Link
$chl = urlencode("http://$v_dns/login?username=$v_user&password=$v_pass");
$v_qrcode = 'https://chart.googleapis.com/chart?cht=qr&chs=' . $chs . '&chld=L|0&chl=' . $chl . '&choe=utf-8';
$v_num = 1;
include "styles/".$styles.".php";
?>
</body>
</html>
