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
$konek = $API->connect($_IPMK, $_USMK, _de(ltrim($_PSMK, __CMS)));
if($_LANG=="id"){
$s = "";
}else{$s = "s";}
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
<style>
*,html,body{padding:0;margin:0;color:#111;font-family: arial;font-size: 15px;margin:0px;}
.main{margin:10px 5px;padding:0;background:rgba(255,255,255,0.5);border: 1px solid #666;}
.hasil{text-align:center;padding:10px 0;line-height:150%;}
.atas{font-weight:bold;text-align:center;padding:10px 0;line-height:150%;text-transform:uppercase;}
table {border-collapse: collapse;width: 100%;}
th, td {text-align: left;padding:5px;}
tr:nth-child(even){background-color: #fafafa}
th {background-color: #efefef;color: #333;text-transform:uppercase;}
</style>
</head>

<body>
<div class="main">
<?php if(!empty($_ceklog)){ ?>
<?php echo $_ceklog;?>
<?php } ?>
<div class="kolom">
<div class="atas">
<h3 class="text-center"><?php _e(__S_title);?></h3>
<p class="text-center" id="date1"><?php _e(date("d-m-Y"));?></p>
</div>
<div class="hasil">
<?php
$name = $_GET['user'];
if ($konek) {
$API->write('/system/scheduler/print', false);
$API->write('?=name='.$name.'');
$ARRAY1 = $API->read();
$regtable = $ARRAY1[0];
$exp = $regtable['next-run'];
$strd = $regtable['start-date'];
$strt = $regtable['start-time'];
$cek = $regtable['interval'];
$ceklen = strlen(substr($cek,0));
$cekw = substr($cek, 0,2);
$cekw1 = substr($cekw, 0,1)*7;
$cekd = substr($cek, 2,2);
$cekd1 = substr($cek, 2,1);
if ($ceklen > 3){
if($_LANG=="id"){
$cekall = $cekw1 + $cekd1 .__S_title13;
}else{
$cekall = $cekw1 + $cekd1;
if($cekall > 1){$cekall = $cekw1 + $cekd1 .__S_title13.$s;}else{$cekall = $cekw1 + $cekd1 .__S_title13;}
}
}elseif (substr($cek, -1) == "h"){
$cek1 = substr($cek, 0,-1);
$cekall = $cek1.__S_title14;
}elseif (substr($cek, -1) == "d"){
$cek1 = substr($cek, 0,-1);
$cekall = $cek1 .__S_title13;
}elseif (substr($cek, -1) == "w"){
$cek1 = substr($cek, 0,-1);
$cekall = ($cek1*7);
if($cekall > 1){$cekall = $cekw1 + $cekd1 .__S_title13.$s;}else{$cekall = $cekw1 + $cekd1 .__S_title13;}
}elseif($cekall == ""){
}
 $cekall;


$getuser = $API->comm("/ip/hotspot/user/print", array("?name"=> "$name"));
$user = $getuser[0]['name'];
$profile = $getuser[0]['profile'];
$uptime = formatDTM($getuser[0]['uptime']);
$getbyteo = $getuser[0]['bytes-out'];
$byteo = formatBytes2($getbyteo, 2);
$limitup = $getuser[0]['limit-uptime'];
$limitbyte = $getuser[0]['limit-bytes-out'];
if($limitbyte == ""){$dataleft = "Unlimited";}else{$dataleft = formatBytes2($limitbyte-$getbyteo,2);}
}
if($user == "" || $exp == ""){
echo "<h3 class='text-center'>User <i style='color:#008CCA;'>$name</i> ".__S_title9."</h3>";
}elseif($limitup == "1s" || $uptime == $limitup || $getbyteo == $limitbyte){
echo "<h3 class='text-center'>User <i style='color:#008CCA;'>$name</i> ".__S_title10."</h3>";
}
if($user == "" || $exp == ""){}else{
?>

<div style='margin-top:0px;overflow-x:auto;'>
<table width="100%">
<tr>
<th colspan="2"> User Details <?php echo  $user;?></th>
</tr>
  <?php
echo "";
echo "";
echo "<tr>";
echo "<td >".__S_title1."</td>";
echo "<td > $user</td>";
echo "</tr>";
echo "<tr>";
echo "<td >".__S_title2."</td>";
echo "<td > $profile</td>";
echo "</tr>";
echo "<tr>";
echo "<td >".__S_title3."</td>";
echo "<td > $uptime</td>";
echo "</tr>";
echo "<tr>";
echo "<td >".__S_title4."</td>";
echo "<td > $byteo</td>";
echo "</tr>";
if($limitup == "1s"  || $uptime == $limitup || $getbyteo == $limitbyte){
echo "<tr>";
echo "<td >Status</td>";
echo "<td >".__S_title16."</td>";
echo "</tr>";
}else{
echo "<tr>";
echo "<td >".__S_title5."</td>";
echo "<td > $dataleft</td>";
echo "</tr>";
echo "<tr>";
echo "<td >".__S_title6."</td>";
echo "<td >$cekall</td>";
echo "</tr>";
echo "<tr>";
echo "<td >".__S_title7."</td>";
echo "<td >$strd $strt</td>";
echo "</tr>";
echo "<tr>";
echo "<td >".__S_title8."</td>";
echo "<td >$exp</td>";
echo "</tr>";
echo "<tr>";
echo "<td >Status</td>";
echo "<td >".__S_title15."</td>";
echo "</tr>";
echo "";
}
}
?>
</table>
</div>
</div>
</div>
</div>

</body>



</html>


