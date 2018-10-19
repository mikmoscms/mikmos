<?php 
$bg_array = array("#CEED9D","#ECED9D","#EDCF9D","#EC9CA7","#fdd752","#a48ad4","#aec785","#1fb5ac","#fa8564");
switch($_GET['get']){
default:
 $mikmosLoad = $API->comm("/ip/hotspot/user/profile/print");
 $mikmosTot = count($mikmosLoad);
 $countprofile = $API->comm("/ip/hotspot/user/profile/print", array(
 "count-only" => "",));
?>

<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong><?php echo __VOUCHERS;?></strong> | Profile <span class="text-danger"><?php if($countprofile < 2 ){echo "$countprofile"; }elseif($countprofile > 1){echo "$countprofile";}?></span> items
					
<span class="tools pull-right">
 </span>
</header>
<div class="panel-body">
<div class="row">

<?php
for ($i=0; $i<$mikmosTot; $i++){
$mikmosView = $mikmosLoad[$i];
$pid = $mikmosView['.id'];
$pname = $mikmosView['name'];
$psharedu = $mikmosView['shared-users'];
$pratelimit = $mikmosView['rate-limit'];
$ponlogin = $mikmosView['on-login'];
$countuser = $API->comm("/ip/hotspot/user/print", array( "count-only" => "", "?profile" => "$pname" ));
 ?>
 
<div class="col-md-3">
<a title='Vouchers Profile <?php echo $pname;?>' href='./?load=vouchers&get=view&id=<?php echo $pname;?>'>
<div class="card p-20" style="background-color:<?php echo $bg_array[rand(0,8)];?>">
<div class="media widget-ten">
<div class="media-left meida media-middle">
<span  class="color-white"><i class="fa fa-money f-s-40"></i></span>
</div>
<div class="media-body media-text-right">
<h2 class="color-white"><?php echo "$countuser";?></h2>
<p class="m-b-0 color-white"><?php echo $pname;?></p>
</div>
</div>
</div>
</a>
</div>
 <?php
}
?>
</div>
</div>
</section> 
</div>
</div>

<?php

break;
case'view':
$gpname = $_GET['id'];
$vuser = $API->comm("/ip/hotspot/user/print", array("?profile" => "$gpname"));
$Totuser = count($vuser);


 $mikmosLoad = $API->comm("/ip/hotspot/user/profile/print", array(
 "?name" => "$gpname"));
 $mikmosView = $mikmosLoad[0];
 $pid = $mikmosView['.id'];
 
 $ponlogin = $mikmosView['on-login'];
 
 
 $getvalid = explode(",",$ponlogin)[3];
 $gettimelimi = explode(",",$ponlogin)[5];
 
 $getgracep = explode(",",$ponlogin)[4];
 
 $getlocku = explode(",",$ponlogin)[6];
 $getprice = explode(",",$ponlogin)[2];
 if($getprice == "0"){$getprice1 = "0";}else{$getprice1 = $getprice;}
 if(empty($getvalid)){$getvalid1 = "-";}else{$getvalid1 = $getvalid;}
 if(empty($gettimelimi)){$gettimelimi1 = "-";}else{$gettimelimi1 = $gettimelimi;}
 
?>

<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong><?php echo __VOUCHERS;?> <?php echo $mikmosView['name'];?></strong>
					
<span class="tools pull-right">
 </span>
</header>
<div class="panel-body">

<div class="row">
<div class="col-md-7">
<header class="panel-heading">
<strong><?php echo __INFO;?> <?php echo __VOUCHERS;?> <?php echo $mikmosView['name'];?></strong>
					
<span class="tools pull-right">
 </span>
</header>
				
<div class="panel-body">
<table class="table">
 <tr>
 <td>Total Semua Voucher</td><td><?php echo $Totuser;?></td>
 </tr>
 <tr><td>Nama Paket</td><td><?php echo $mikmosView['name'];?></td></tr>
 <tr><td>Harga Paket</td><td><?php echo $getprice1;?></td></tr>
 <tr><td>Masa Aktif</td><td><?php echo $gettimelimi1;?></td></tr>
 <tr><td>Masa Tenggang</td><td><?php echo $getvalid1;?></td></tr>
</table>

</div>
				
<div style="margin-top:50px;">
<header class="panel-heading">
<strong><?php echo __VOUCHERS_STYLE;?></strong>
					
<span class="tools pull-right">
 </span>
</header>
<div class="panel-body">
<div class="row">
<?php
$rep=opendir('./vouchers/styles/');
while ($file = readdir($rep)) {
if($file != '..' && $file !='.' && $file !=''){
if ($file !='index.php' && $file !='index.html' && $file !='.htaccess'){
if(!is_dir($file)){ 
?>

<div class="col-md-3"><a style="cursor:pointer" onclick="window.open('./vouchers/views.php?id=demo&styles=<?php echo substr($file, 0, -4);?>&pilihan=up&qrcode=qr', 'newwindow', 'width=300,height=250'); return false;" title="Lihat Voucher">
<div class="p-10" style="background-color:<?php echo $bg_array[rand(0,8)];?>">
<div class="media widget-ten">
<div class="media-left meida media-middle">
<span  class="color-white"><i class="fa fa-money f-s-20"></i></span>
</div>
<div class="media-body media-text-right">
<strong class="m-b-0 color-white"><?php echo substr($file, 0, -4);?></strong>
</div>
</div>
</div>
						</a>
</div>

<?php }}}} ?>

</div>

</div>
</div>
</div>

<div class="col-md-5">

<header class="panel-heading">
<strong><?php echo __GENERATE;?></strong>
					
<span class="tools pull-right">
 </span>
</header>
				
<div class="panel-body">
<form target="_blank" action="./vouchers/vouchers.php" method="get">

<table class="table">
 <tr>
 <td class="align-middle">Pilih</td><td>
 
 <input class="form-control" name="id" value="<?php echo $mikmosView['.id'];?>" type="hidden">
 <select class="form-control" id="comment" name="vouchers" required="1">
<option style="text-transform:uppercase" value="all">Semua Voucher <?php echo $mikmosView['name'];?></option> 

 <?php 
for ($i=0; $i<$Totuser; $i++){
 $userdetails = $vuser[$i];
 $ucomment = $userdetails['comment'];
$counts = count($ucomment);
if($counts==1){
if($ucomment !== $vuser[$i-1]['comment']){echo '<option style="text-transform:uppercase" value="'.$ucomment.'">Voucher => '.$ucomment.'</option>';}
 }
}
?>

 </select>
 </td>
 </tr>
 <tr>
 <td class="align-middle">Voucher</td><td>
 <select class="form-control" name="styles" required="1">
 <?php
$rep=opendir('./vouchers/styles/');
while ($file = readdir($rep)) {
if($file != '..' && $file !='.' && $file !=''){
if ($file !='index.php' && $file !='index.html' && $file !='.htaccess'){
if(!is_dir($file)){?>
<option style="text-transform:uppercase" value="<?php echo substr($file,0, -4);?>">Voucher <?php echo substr($file, 0, -4);?></option>
<?php }}}}
?>
 </select>
 </td>
 </tr>
 <tr>
 <td class="align-middle">Pilihan</td><td>
 <select class="form-control" name="pilihan" required="1">
<option style="text-transform:uppercase" value="up">Username & Password</option>
<option style="text-transform:uppercase" value="vc">Username = Password</option>
 </select>
 </td>
 </tr>
 <tr>
 <td class="align-middle">QRcode</td><td>
 <select class="form-control" name="qrcode" required="1">
<option style="text-transform:uppercase" value="qr">Tampil</option>
<option style="text-transform:uppercase" value="noqr">Tidak</option>
 </select>
 </td>
 </tr>
 <tr>
 <td></td><td>
 <div>
 <a class="btn btn-warning" href="./?load=vouchers"> <i class="fa fa-close btn-mrg"></i> Batal</a>
 <button type="submit" class="btn btn-primary btn-mrg" ><i class="fa fa-print btn-mrg"></i> Cetak</button>
 </div>
 </td>
 </tr>
</table>
</form>
</div>
</div>

</div>


 </div>
 
 
 </div>
 </div>
 
 
 <!-- END OVERVIEW -->
 </div>
 </div>
 </div> 
<?php 
break;
}
?>
