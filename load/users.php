<?php
switch($_GET['get']) {
default:
$mikmosProf = $_GET['prof'];
$mikmosComm = $_GET['comment'];
$mikmosLupt = $_GET['limit-uptime'];
if(empty($mikmosProf)){
$mikmosLoad = $API->comm("/ip/hotspot/user/print");
$mikmosTot = count($mikmosLoad);
}
if($mikmosProf){
$mikmosLoad = $API->comm("/ip/hotspot/user/print", array("?profile" => "$mikmosProf"));
$mikmosTot = count($mikmosLoad);
}
if($mikmosComm){
$mikmosLoad = $API->comm("/ip/hotspot/user/print", array("?comment" => "$mikmosComm"));
$mikmosTot = count($mikmosLoad);
}
if($mikmosLupt=='expired'){
$mikmosLoad = $API->comm("/ip/hotspot/user/print", array("?limit-uptime" => "1s"));
$mikmosTot = count($mikmosLoad);
}
$mikmosLoadP = $API->comm("/ip/hotspot/user/profile/print");
$mikmosTotP = count($mikmosLoadP);
?>
<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong><?php echo __USERS;?></strong> | <span class="text-danger"><?php if($mikmosTot < 2 ){echo "$mikmosTot"; }elseif($mikmosTot > 1){echo "$mikmosTot";}?></span> items
<span class="tools pull-right"></span>
</header>
<div class="panel-body">
<p class="text-muted">
<a title="Tambahkan Users" class="btn btn-success" href="./?load=users&get=add"> <i class="fa fa-plus"></i> <?php echo __ADD;?></a>
<a title="Tambahkan Generate Users" class="btn btn-info" href="./?load=users&get=generate"> <i class="fa fa-plus"></i> <?php echo __ADD;?> <?php echo __GENERATE;?></a>
<?php if(($mikmosProf)&&($mikmosComm)){?>
<a onclick="return confirm('Yakin untuk mneghapusnya semua users Comment <?php echo $mikmosComm;?>?')" title="Menghapus Semua Users di Comment <?php echo $mikmosComm;?>" class="btn btn-danger" href="./?load=users&get=delprofcom&id=<?php echo $mikmosProf;?>&comment=<?php echo $mikmosComm;?>"> <i class="fa fa-trash-o"></i> Hapus Users</a>
<?php }elseif($mikmosLupt=='expired'){ ?>
<!--<a onclick="return confirm('Yakin untuk mneghapusnya semua users Expire?')" title="Hapus Users Expired" class="btn btn-danger" href="./?load=users&get=delexp"> <i class="fa fa-trash-o"></i> Hapus Users Expired</a>-->
<?php }elseif($mikmosProf){ ?>
<a onclick="return confirm('Yakin untuk mneghapusnya semua users di Profile <?php echo $mikmosProf;?>?')" title="Menghapus Semua Users di Profile <?php echo $mikmosProf;?>" class="btn btn-danger" href="./?load=users&get=delprof&id=<?php echo $mikmosProf;?>"> <i class="fa fa-trash-o"></i> Hapus Users Profil</a>
<?php } ?>
<span class="pull-right">
<select class="form-control" onchange="if (this.value) window.location.href=this.value">
<option <?php if(empty($mikmosProf)){ echo 'selected';} ?> style="text-transform:uppercase" value="./?load=users"><?php _e(__ALL);?></option>
<?php
for ($i=0; $i<$mikmosTotP; $i++){
$mikmosDataP =$mikmosLoadP[$i];?>
<option <?php if($mikmosProf==$mikmosDataP['name']){ echo 'selected';} ?> style="text-transform:uppercase" value="./?load=users&prof=<?php echo $mikmosDataP['name'];?>"><?php echo $mikmosDataP['name'];?></option>
<?php }
?></select>
</span>
</p><hr>
<div class="table-responsive">
<div class="adv-table">
<table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered text-nowrap" id="mikmos-tbl-noinfo">
<thead>
<tr>
<th class="align-middle" style="width:110px"></th>
<th class="align-middle">Server</th>
<th class="align-middle">Name</th>
<th class="align-middle">Profile</th>
<th class="text-center align-middle">Uptime</th>
<th class="text-center align-middle">Total<br/>Pemakaian</th>
<th class="text-center align-middle">Total<br/>Data Limit</th>
<th class="align-middle">Comment</th>
</tr>
</thead>
<tbody>
<?php 
for ($i=0; $i<$mikmosTot; $i++){
$mikmosData =$mikmosLoad[$i];
$uname =$mikmosData['name'];

$utotdata = $mikmosData['bytes-out'] + $mikmosData['bytes-in'];
$utotdatax = formatBytes($utotdata,2);
if($utotdatax == 0){$utotdata1 = "";}else{$utotdata1 = $utotdatax;}

$totdatalimit1 = formatBytes($mikmosData['limit-bytes-total'],2);
if($totdatalimit1 == 0){$totdatalimit = "";}else{$totdatalimit = $totdatalimit1;}

if($mikmosData['.id'] == "*0"){$commentnya = "";}else{$commentnya = '<a title="Lihat '.$mikmosData['comment'].'" class="btn btn-xs btn-success" href="./?load=users&comment='.$mikmosData['comment'].'&prof='.$mikmosData['profile'].'">'.$mikmosData['comment'].'</a>';}

if($mikmosData['disabled']=='true'){$disabled = "<a title='Enable' href='./?load=users&get=dis&id=".$mikmosData['.id']."&d=false'><span class='label label-danger'><i class='fa fa-lock'></i></span></a> ";}else{$disabled = "<a title='Disable' href='./?load=users&get=dis&id=".$mikmosData['.id']."&d=true'><span class='label label-success'><i class='fa fa-unlock'></i></span></a> ";}


$mikmosLoadSc = $API->comm("/system/scheduler/print", array("?name"=> "$uname",));
$mikmosListSc = $mikmosLoadSc[0];
$start = $mikmosListSc['start-date'] ." ". $mikmosListSc['start-time'];
$end = $mikmosListSc['next-run'];

?>
<tr class=" odd">
<td>
<a href="./?load=users&get=del&id=<?php echo $mikmosData['.id'];?>" title="Remove" onclick="return confirm('Yakin untuk mneghapusnya ?...')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
<?php echo $disabled;?>
<a class="btn btn-info btn-xs"title="Print Voucher Username & Password" style="cursor:pointer;color:#fff;" onclick="window.open('./vouchers/prints.php?id=<?php echo $mikmosData['.id'];?>&styles=DEFAULT&pilihan=up&qrcode=qr', 'newwindow', 'width=300,height=250'); return false;"> <i class="fa fa-print"></i></a>
</td>
<td class="text-center"><?php if(empty($mikmosData['server'])){echo "All";}else{echo $mikmosData['server'];}?></td>
<td>
<a href="./?load=users&get=edit&id=<?php echo $mikmosData['.id'];?>" title="Edit">
<span class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></span> <?php echo $mikmosData['name'];?>
</a>
</td>
<td><?php echo $mikmosData['profile'];?></td>
<td class="text-center"><?php echo formatDTM($mikmosData['uptime'])?></td>
<td class="text-center"><?php echo $utotdata1;?></td>
<td class="text-center"><?php echo $totdatalimit;?></td>
<td>
<?php if(empty($mikmosData['comment'])){echo '';}else{echo $commentnya;}?> 
<?php if($mikmosData['limit-uptime'] == '1s'){ echo '<a title="Lihat yang Expired" class="btn btn-xs btn-danger" href="./?load=users&limit-uptime=expired">expired</a>';}else{
	  if(empty($mikmosData['limit-uptime'])){ echo '';}else{echo '<span class="btn btn-xs btn-info">'.$mikmosData['limit-uptime'].'</span>';}
}?>
<?php if($userdetails['limit-bytes-total'] == ''){echo '';}else{echo ' '.formatBytes2($udatalimit,2);}?></td>
</tr>
<?php 
$API->disconnect();
} ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
<?php
break;
case'add':
$mikmosLoadP = $API->comm("/ip/hotspot/user/profile/print");
$mikmosLoadS = $API->comm("/ip/hotspot/print");
if(isset($_POST['save'])){
$server = ($_POST['server']);
$name = ($_POST['name']);
$password = ($_POST['pass']);
$profile = ($_POST['profile']);
$disabled = ($_POST['disabled']);
$timelimit = ($_POST['timelimit']);
$datalimit = ($_POST['datalimit']);
$comment = ($_POST['comment']);
$mbgb = ($_POST['mbgb']);
if($timelimit == ""){$timelimit = "0";}else{$timelimit = $timelimit;}
if($datalimit == ""){$datalimit = "0";}else{$datalimit = $datalimit*$mbgb;}
$API->comm("/ip/hotspot/user/add", array(
"server" => "$server",
"name" => "$name",
"password" => "$password",
"profile" => "$profile",
"disabled" => "no",
"limit-uptime" => "$timelimit",
"limit-bytes-total" => "$datalimit",
"comment" => "$comment",
));
$getuser = $API->comm("/ip/hotspot/user/print", array(
"?name"=> "$name",
));
$uid =$getuser[0]['.id'];
echo Loading('./?load=users&get=edit&id='.$uid.'','0');
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
<strong><?php echo __ADD;?> <?php echo __USERS;?></strong>

<span class="tools pull-right">
 </span>
</header>
<form name="form" autocomplete="off" method="post" action="">
<div class="panel-body"><hr>
<?php //print_r($mikmosLoad);?>
<div class="row">
<div class="col-md-7">
<p class="text-muted">
<a class="btn btn-danger" href="./?load=users"> <i class="fa fa-close"></i> <?php echo __CANCEL;?></a>
<button type="submit" class="btn bg-primary" name="save"><i class="fa fa-save"></i> <?php echo __SAVE;?></button>
</p>
<table class="table">
<tr>
<td class="align-middle" >Server</td>
<td>
<select class="form-control" name="server" required="1">
<option>all</option>
<?php $mikmosTot = count($mikmosLoadS);
for ($i=0; $i<$mikmosTot; $i++){
?>
<?php echo "<option>" . $mikmosLoadS[$i]['name'] . "</option>";?>
<?php } ?>
</select>
</td>
</tr>
<tr>
<td class="align-middle">Name</td><td><input class="form-control" type="text" autocomplete="off" name="name" value="" required="1" autofocus></td>
</tr>
<tr>
<td class="align-middle">Password</td><td>
<div class="input-group input-group-flat">
<input class="form-control" id="passUser" type="password" name="pass" autocomplete="new-password" value="">
 <span class="input-group-btn btn btn-danger" title="Show/Hide Password" onclick="PassUser()"><i class="fa fa-eye"></i></span>
 </div> 

</td>
</tr>
<tr>
<td class="align-top">Profil Users</td><td>
<select class="form-control" onchange="GetVP();" id="uprof" name="profile" required="1">
<option onClick='form.timelimit.value=""' value="">=== Pilih Profil Users ===</option>
<?php $mikmosTot = count($mikmosLoadP);
for ($i=0; $i<$mikmosTot; $i++){
  $ponlogin = $mikmosLoadP[$i]['on-login'];
  $gettime = explode(",",$ponlogin)[5];
  if(empty($gettime)){
	  $gettime1 = explode(",",$ponlogin)[3];
	  }else{
	  $gettime1 = $gettime;
	  }
?>
<option onClick='form.timelimit.value="<?php echo $gettime1;?>"' value="<?php echo $mikmosLoadP[$i]['name'];?>"><?php echo $mikmosLoadP[$i]['name'];?></option>
<?php } ?>
</select>
<div id="GetValidPrice"></div>
</td>
</tr>
<tr>
<td class="align-middle">Total Data Limit</td><td>
<div class="row">
<div class="col-md-9">
<input class="form-control" type="number" min="0" max="9999" name="datalimit" value="">
</div>
<div class="col-md-3">
<select class="form-control" name="mbgb" required="1">
<option value=1000000>MB</option>
<option value=1000000000>GB</option>
</select>
</div>
</div>
</td>
</tr>
<tr>
<td class="align-middle">Comment</td><td><input class="form-control" type="text" title="No special characters" id="comment" autocomplete="off" name="comment" value=""></td>
</tr>
</table>
</div>
<div class="col-md-5">

</div>
</div>
</div>
</form>
</div>
</div>
</div>

<?php
break;
case'edit':
$id_get = $_GET['id'];

$mikmosLoadP = $API->comm("/ip/hotspot/user/profile/print");
$mikmosLoadS = $API->comm("/ip/hotspot/print");

if(substr($id_get,0,1) == "*"){
$id_get = $id_get;
}elseif(substr($id_get,0,1) != ""){
$getuser = $API->comm("/ip/hotspot/user/print", array("?name"=> "$id_get",));
$id_get =$getuser[0]['.id'];
//if($id_get == ""){echo "<b>Hotspot User not found</b>";}
}
$getuser = $API->comm("/ip/hotspot/user/print", array("?.id"=> "$id_get",));
$userdetails =$getuser[0];
$uid = $userdetails['.id'];
$userver = $userdetails['server'];
$uname = $userdetails['name'];
$upass = $userdetails['password'];
$umac = $userdetails['mac-address'];
$uprofile = $userdetails['profile'];
$uuptime = formatDTM($userdetails['uptime']);
$ueduser = $userdetails['disabled'];
$utimelimit = $userdetails['limit-uptime'];
$udatalimit = $userdetails['limit-bytes-total'];
$ubytesout = $userdetails['bytes-out'];
$ubytesin = $userdetails['bytes-in'];
$ucomment = $userdetails['comment'];

if(substr(formatBytes2($udatalimit,2),-2) == "MB"){
$udatalimitx = $udatalimit/1000000;
$MG = "MB";
}elseif(substr(formatBytes2($udatalimit,2),-2) == "GB"){
$udatalimitx = $udatalimit/1000000000;
$MG = "GB";
}elseif($udatalimit == ""){
$udatalimitx = "";
$MG = "MB";
}

if($uname == $upass){$usermode = "vc";}else{$usermode = "up";}

if($uname == ""){ echo "<b>User not found redirect to user list...</b>"; echo "<script>window.location='./?load=users'</script>";}

$mikmosLoadPU = $API->comm("/ip/hotspot/user/profile/print", array(
"?name" => "$uprofile"));
$profiledetalis = $mikmosLoadPU[0];
$ponlogin = $profiledetalis['on-login'];
$getvalid = explode(",",$ponlogin)[3];
$getprice = explode(",",$ponlogin)[2];

$mikmosLoadSc = $API->comm("/system/scheduler/print", array(
"?name"=> "$uname",
));
$mikmosListSc = $mikmosLoadSc[0];
$start = $mikmosListSc['start-date'] ." ". $mikmosListSc['start-time'];
$end = $mikmosListSc['next-run'];
//$valy = $mikmosListSc['interval'];
// share WhatsApp
if($getvalid != ""){
$WA_valid = "Validity : *".$getvalid."* %0A";
}else{
$WA_valid = "";
}
if ($utimelimit != "") {
$WA_tlimit = "TimeLimit : *".$utimelimit."* %0A";
}else{
$WA_tlimit = "";
}
if ($udatalimit != "") {
$WA_dlimit = "DataLimit : *".$udatalimitx."".$MG."* %0A";
}else{
$WA_dlimit = "";
}
if($getprice == 0){echo "";}else{
if($_LANG == "id"){
$WA_price = "Harga : *".number_format($getprice,0,",",".")."* %0A";
}else{
$WA_price = "Price : *".number_format($getprice)."* %0A";
}
}

$shareWAUP = "
%0A---------%0A
*".$_RPER."*
%0A%0A
Username : *" .$uname."* %0A
Password : *".$upass."* %0A
".$WA_valid."
".$WA_tlimit."
".$WA_dlimit."
".$WA_price." %0A
Login : *http://".$_RDNS."* %0A
--------- 
"; 
$shareWAVC = "
%0A---------%0A
*".$_RPER."*
%0A%0A
Voucher : *" .$uname."* %0A
".$WA_valid."
".$WA_tlimit."
".$WA_dlimit."
".$WA_price." %0A
Login : *http://".$_RDNS."* %0A
---------
"; 
if($uname == $upass){$shareWA = $shareWAVC;}else{$shareWA = $shareWAUP;}

if(isset($_POST['save'])){
$server = ($_POST['server']);
$name = ($_POST['name']);
$password = ($_POST['pass']);
$profile = ($_POST['profile']);
$disabled = ($_POST['disabled']);
$timelimit = ($_POST['timelimit']);
$datalimit = ($_POST['datalimit']);
$comment = ($_POST['comment']);
$mbgb = ($_POST['mbgb']);
if($timelimit == ""){$timelimit = "0";}else{$timelimit = $timelimit;}
if($datalimit == ""){$datalimit = "0";}else{$datalimit = $datalimit*$mbgb;}
$API->comm("/ip/hotspot/user/set", array(
".id"=> "$uid",
"server" => "$server",
"name" => "$name",
"password" => "$password",
"profile" => "$profile",
"disabled" => "$disabled",
"limit-uptime" => "$timelimit",
"limit-bytes-total" => "$datalimit",
"comment" => "$comment",
));
echo "<script>window.location='./?load=users&get=edit&id=".$uid."'</script>";
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
<strong><?php echo __USERS;?></strong> | <?php echo __EDIT;?>
<span class="tools pull-right">
 </span>
</header>
<form autocomplete="new-password" method="post" action="">
<div class="panel-body"><hr>

<div class="row">
<div class="col-md-7">
<p class="text-muted">
<a class="btn btn-danger" href="./?load=users"> <i class="fa fa-close"></i> <?php echo __CANCEL;?></a>
<button type="submit" class="btn bg-primary" name="save"><i class="fa fa-edit"></i> <?php echo __EDIT;?></button>

<a id="shareWA" class="btn bg-success" title="Share WhatsApp" href="whatsapp://send?text=<?php echo $shareWA;?>"> <i class="fa fa-whatsapp"></i> Share</a>


<?php if($userdetails['limit-uptime'] == "1s"){ ?>
<a title="Expired Aktifkan Kembali" class="btn btn-danger" href="#"> <i class="fa fa-warning"></i> Expired</a>

<?php } ?>

</p>

<table class="table">
<tr>
<td class="align-middle">Enabled</td>
<td>
<select class="form-control" name="disabled" required="1">
<option value="<?php echo $ueduser;?>"><?php if($ueduser == "true"){echo "No";}else{echo "Yes";}?></option>
<option value="no">Yes</option>
<option value="yes">No</option>
</select>
</td>
</tr>
<tr>
<td class="align-middle">Server</td>
<td>
<select class="form-control" name="server" required="1">
<option><?php if($userver == ""){echo "all";}else{echo $userver;}?></option>
<option>all</option>
<?php $TotalReg = count($mikmosLoadS);
for ($i=0; $i<$TotalReg; $i++){
?>
<?php echo "<option>" . $mikmosLoadS[$i]['name'] . "</option>";?>
<?php } ?>
</select>
</td>
</tr>
<tr>
<td class="align-middle">Name</td><td><input class="form-control" type="text" autocomplete="off" name="name" value="<?php echo $uname;?>"></td>
</tr>
<tr>
<td class="align-middle">Password</td><td>

<div class="input-group input-group-flat">
<input class="form-control" id="passUser" type="password" name="pass" autocomplete="new-password" value="<?php echo $upass;?>">
 <span class="input-group-btn btn btn-danger" title="Show/Hide Password" onclick="PassUser()"><i class="fa fa-eye"></i></span>
 </div> 
 

</td>
</tr>

<tr>
<td class="align-middle">Profil Users</td><td>
<select class="form-control" name="profile">
<option value="">=== Pilih Profil Users ===</option>
<?php $TotalReg = count($mikmosLoadP);
for ($i=0; $i<$TotalReg; $i++){
?>
<option <?php if($mikmosLoadP[$i]['name']==$uprofile){echo'selected';};?>><?php echo $mikmosLoadP[$i]['name'];?></option>

<?php } ?>
</select>
</td>
</tr>
<tr>
<td class="align-middle">Total Data Limit</td><td>

<div class="row">
<div class="col-md-9">
<input class="form-control" type="number" min="0" max="9999" name="datalimit" value="<?php echo $udatalimitx;?>">
</div>
<div class="col-md-3">
<select class="form-control" name="mbgb" required="1">
<option value="<?php if($MG == "MB"){echo "1000000";}elseif($MG == "GB"){echo "1000000000";}?>"><?php echo $MG;?></option>
<option value=1000000>MB</option>
<option value=1000000000>GB</option>
</select>
</div>
</div>

</td>
</tr>
<tr>
<td class="align-middle">Comment</td><td><input class="form-control" type="text" id="comment" autocomplete="off" name="comment" title="No special characters" value="<?php echo $ucomment;?>"></td>
</tr>
<tr>
<td class="align-middle">Mac Address</td><td><input class="form-control" type="text" value="<?php if(empty($umac)){echo'-';}else{echo $umac;}?>" disabled></td>
</tr>
<tr>
<td class="align-middle">Uptime</td><td><input class="form-control" type="text" value="<?php echo $uuptime;?>" disabled></td>
</tr>
<tr>
<td class="align-middle">Bytes Out/In</td><td><input class="form-control" type="text" value="<?php if($ubytesout == 0){echo'0';}else{echo formatBytes($ubytesout,2);}?> / <?php if($ubytesin == 0){echo'0';}else{echo formatBytes($ubytesin,2);}?>" disabled></td>
</tr>
<tr>
<td class="align-middle">Price</td><td><input class="form-control" type="text" value="<?php if($getprice == 0){}else{if($_LANG == "id"){echo number_format($getprice,0,",",".");}else{ echo number_format($getprice); }}?>" disabled></td>
</tr>
<tr>
<td class="align-middle">Masa Aktif</td><td><input class="form-control" type="text" size="4" autocomplete="off" name="timelimit" value="<?php if($utimelimit == "1s"){echo "";}else{ echo $utimelimit;}?>" disabled></td>
</tr>
<?php if($getvalid != ""){?>
<tr>
<td class="align-middle">Masa Tenggang</td><td><input class="form-control" type="text" value="<?php echo $getvalid;?>" disabled></td>
</tr>
<tr>
<td class="align-middle">Start</td><td><input class="form-control" type="text" value="<?php if(empty($start)){echo'-';}else{echo $start;}?>" disabled></td>
</tr>
<tr>



<?php if($userdetails['limit-uptime'] == "1s"){ ?>

<td class="align-middle">
<?php echo "Expired";?>
</td>
<td>
<a title="Lihat yang Expired" class="btn btn-xs btn-danger" href="#">Aktifkan Kembali</a>
</td>

<?php }else{ ?>
<td class="align-middle">
<?php echo "End";?>
</td>
<td>
<input class="form-control" type="text" value="<?php echo $end;?>" disabled> 
</td>
<?php } ?>


</tr>
<?php }else{}?>
</table>
</form>
</div>

<div class="col-md-5">

</div>


</div>
</div>
</div>
</div>
</div>
<?php
break;
case'generate':
@session_start();
error_reporting(0);
ini_set('max_execution_time', 300);


$mikmosLoadS = $API->comm("/ip/hotspot/print");

if(isset($_POST['generate'])){
$qty = ($_POST['qty']);
$server = ($_POST['server']);
$user = ($_POST['user']);
$userl = ($_POST['userl']);
$prefix = ($_POST['prefix']);
$char = ($_POST['char']);
$profile = ($_POST['profile']);
$timelimit = ($_POST['timelimit']);
$datalimit = ($_POST['datalimit']);
$adcomment = ($_POST['adcomment']);
$mbgb = ($_POST['mbgb']);
if($timelimit == ""){$timelimit = "0";}else{$timelimit = $timelimit;}
if($datalimit == ""){$datalimit = "0";}else{$datalimit = $datalimit*$mbgb;}
if($adcomment == ""){$adcomment = "";}else{$adcomment = "-".$adcomment;}
$mikmosLoadP = $API->comm("/ip/hotspot/user/profile/print", array("?name" => "$profile"));
$ponlogin = $mikmosLoadP[0]['on-login'];
$getvalid = explode(",",$ponlogin)[3];
$getprice = explode(",",$ponlogin)[2];
$getlock = explode(",",$ponlogin)[6];

$commt = $user . "-" . date("d.m.y") . "" .$adcomment;



$a = array ("1"=>"","",1,2,2,3,3,4);

if($user=="up"){
for($i=1;$i<=$qty;$i++){
if($char == "lower"){
$u[$i]= substr(str_shuffle("abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz"), -$userl);
}elseif($char == "upper"){
$u[$i]= substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ"), -$userl);
}elseif($char == "upplow"){
$u[$i]= substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), -$userl);
}elseif($char == "mix"){
$u[$i]= substr(str_shuffle("123456789123456789123456789abcdefghijklmnopqrstuvwxyz"), -$userl);
}elseif($char == "mix1"){
$u[$i]= substr(str_shuffle("123456789123456789123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), -$userl);
}elseif($char == "mix2"){
$u[$i]= substr(str_shuffle("123456789123456789123456789AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz"), -$userl);
}
if($userl == 3){
$p[$i]= rand(100,999);
}elseif($userl == 4){
$p[$i]= rand(1000,9999);
}elseif($userl == 5){
$p[$i]= rand(10000,99999);
}elseif($userl == 6){
$p[$i]= rand(100000,999999);
}elseif($userl == 7){
$p[$i]= rand(1000000,9999999);
}elseif($userl == 8){
$p[$i]= rand(10000000,99999999);
}

$u[$i] = "$prefix$u[$i]";
}

for($i=1;$i<=$qty;$i++){
$API->comm("/ip/hotspot/user/add", array(
"server" => "$server",
"name" => "$u[$i]",
"password" => "$p[$i]",
"profile" => "$profile",
"limit-uptime" => "$timelimit",
"limit-bytes-total" => "$datalimit",
"comment" => "$commt",
));
}}

if($user=="vc"){
$shuf = ($userl-$a[$userl]);
for($i=1;$i<=$qty;$i++){
if($char == "lower"){
$u[$i]= substr(str_shuffle("abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz"), -$shuf);
}elseif($char == "upper"){
$u[$i]= substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ"), -$shuf);
}elseif($char == "upplow"){
$u[$i]= substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), -$shuf);
}
if($userl == 3){
$p[$i]= rand(1,9);
}elseif($userl == 4 || $userl == 5){
$p[$i]= rand(10,99);
}elseif($userl == 6 || $userl == 7){
$p[$i]= rand(100,999);
}elseif($userl == 8){
$p[$i]= rand(1000,9999);
}

$u[$i] = "$prefix$u[$i]$p[$i]";

if($char == "num"){
if($userl == 3){
$p[$i]= rand(100,999);
}elseif($userl == 4){
$p[$i]= rand(1000,9999);
}elseif($userl == 5){
$p[$i]= rand(10000,99999);
}elseif($userl == 6){
$p[$i]= rand(100000,999999);
}elseif($userl == 7){
$p[$i]= rand(1000000,9999999);
}elseif($userl == 8){
$p[$i]= rand(10000000,99999999);
}

$u[$i] = "$prefix$p[$i]";
}
if($char == "mix"){
$p[$i]= substr(str_shuffle("123456789123456789123456789abcdefghijklmnopqrstuvwxyz"), -$userl);


$u[$i] = "$prefix$p[$i]";
}
if($char == "mix1"){
$p[$i]= substr(str_shuffle("123456789123456789123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), -$userl);


$u[$i] = "$prefix$p[$i]";
}
if($char == "mix2"){
$p[$i]= substr(str_shuffle("123456789123456789123456789AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz"), -$userl);


$u[$i] = "$prefix$p[$i]";
}

}
for($i=1;$i<=$qty;$i++){
$API->comm("/ip/hotspot/user/add", array(
"server" => "$server",
"name" => "$u[$i]",
"password" => "$u[$i]",
"profile" => "$profile",
"limit-uptime" => "$timelimit",
"limit-bytes-total" => "$datalimit",
"comment" => "$commt",
));

$my_file_d = './vouchers/generate.php';
unlink($my_file_d);
$my_file = './vouchers/generate.php';
$handle = fopen($my_file, 'w') or die('Cannot open file: '.$my_file);
$data = "$commt";
fwrite($handle, $data);
chmod($my_file,0644);

}}



if($qty < 2){
echo Loading('./?load=users&get=generate&generate='.$commt.'','0');
}else{
echo Loading('./?load=users&get=generate&generate='.$commt.'','0');
}
}
$mikmosLoadP = $API->comm("/ip/hotspot/user/profile/print");

if($_LANG == "id"){
$uprice = number_format($uprice,0,",",".");
}else{
 $uprice = number_format($uprice);
}

?>

<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong><?php echo __GENERATE;?></strong>

<span class="tools pull-right">
 </span>
</header>

<form name="form" autocomplete="off" method="post" action="">
<div class="panel-body">
<hr>
<div class="row">
<div class="col-md-7">
<p class="text-muted">
<a class="btn btn-danger" href="./?load=users"> <i class="fa fa-close"></i> <?php echo __CANCEL;?></a>
<button type="submit" class="btn bg-primary" name="generate"><i class="fa fa-save"></i> <?php echo __GENERATE;?></button>
<?php
if(!empty($_GET['generate'])){?>
<a class="btn btn-success" href="./?load=users&comment=<?php echo $_GET['generate'];?>"> <i class="fa fa-check"></i> Lihat Hasil Generate Voucher</a>
<?php } ?>
</p>
<table class="table">
<tr>
<td class="align-middle">Jumlah</td><td><div><input class="form-control " type="number" name="qty" min="1" max="500" value="1" required="1"></div></td>
</tr>
<tr>
<td class="align-middle">Server</td>
<td>
<select class="form-control " name="server" required="1">
<option>all</option>
<?php $mikmosTot = count($mikmosLoadS);
for ($i=0; $i<$mikmosTot; $i++){
echo "<option>" . $mikmosLoadS[$i]['name'] . "</option>";
}
?>
</select>
</td>
</tr>
<tr>
<td class="align-middle">Pilihan User/Voucher</td><td>
<select class="form-control " onchange="defUserl();" id="user" name="user" required="1">
<option value="up">Username & Pasword</option>
<option value="vc">Username = Pasword</option>
</select>
</td>
</tr>
<tr>
<td class="align-middle">Panjang User/Voucher</td><td>
<select class="form-control " id="userl" name="userl" required="1">
<option>4</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
<option>8</option>
</select>
<input class="form-control " type="text" size="4" maxlength="4" autocomplete="off" name="prefix" value="" hidden />
</td>
</tr>
<!--
<tr>
<td class="align-middle">Prefix</td><td><input class="form-control " type="text" size="4" maxlength="4" autocomplete="off" name="prefix" value=""></td>
</tr>
-->
<tr>
<td class="align-middle">Karakter</td><td>
<select class="form-control " name="char" required="1">
<option id="lower" style="display:block;" value="lower">abcd</option>
<option id="upper" style="display:block;" value="upper">ABCD</option>
<option id="upplow" style="display:block;" value="upplow">aBcD</option>
<option id="lower1" style="display:none;" value="lower">abcd1234</option>
<option id="upper1" style="display:none;" value="upper">ABCD1234</option>
<option id="upplow1" style="display:none;" value="upplow">aBcD1234</option>
<option id="mix" style="display:block;" value="mix">1ab2c34d</option>
<option id="mix1" style="display:block;" value="mix1">1AB2C34D</option>
<option id="mix2" style="display:block;" value="mix2">1aB2c34D</option>
<option id="num" style="display:none;" value="num">1234</option>
</select>
</td>
</tr>


<tr>
<td class="align-top">Profil Users</td><td>
<select class="form-control" onchange="GetVP();" id="uprof" name="profile" required="1">
<option value="">=== Pilih Profil Users ===</option>
<?php 
$mikmosTot = count($mikmosLoadP);
for ($i=0; $i<$mikmosTot; $i++){
  $ponlogin = $mikmosLoadP[$i]['on-login'];
  $gettime = explode(",",$ponlogin)[5];
  if(empty($gettime)){
	  $gettime1 = explode(",",$ponlogin)[3];
	  }else{
	  $gettime1 = $gettime;
	  }
?>
<option onClick="form.timelimit.value='<?php echo $gettime1;?>'" value="<?php echo $mikmosLoadP[$i]['name'];?>"><?php echo $mikmosLoadP[$i]['name'];?></option>
<?php } ?>
</select>
<div id="GetValidPrice"></div>
</td>
</tr>

<tr>
<td class="align-middle">Total Data Limit</td><td>

<div class="row">
<div class="col-md-9">
<input class="form-control" type="number" min="0" max="9999" name="datalimit" value="">
</div>
<div class="col-md-3">
<select class="form-control" name="mbgb" required="1">
<option value=1000000>MB</option>
<option value=1000000000>GB</option>
</select>
</div>
</div>


</td>
</tr>
<tr>
<td class="align-middle">Comment</td><td><input class="form-control " type="text" title="No special characters" id="comment" autocomplete="off" name="adcomment" value=""></td>
</tr>
</table>
</div>

<div class="col-md-5">

</div>
</div>

</div>
</form>
</div>
</div>




<?php
break;
case'dis':
$idget = $_GET['id'];
$dget = $_GET['d'];
$API->comm("/ip/hotspot/user/set", array(".id"=> "$idget", "disabled"=> "$dget"));
echo Loading('./?load=users','0');
break;
case'del':
$idget = $_GET['id'];
$API->comm("/ip/hotspot/user/remove", array(".id"=> "$idget",));
echo Loading('./?load=users','0');
break;
case'delprof':
$prof = $_GET['id'];
$mikmosLoad = $API->comm("/ip/hotspot/user/print", array("?profile" => "$prof"));
$mikmosTot = count($mikmosLoad);
for ($i=0; $i<$mikmosTot; $i++){
$mikmosView = $mikmosLoad[$i];
$idget = $mikmosView['.id'];
$API->comm("/ip/hotspot/user/remove", array(".id"=> "$idget"));
}
echo Loading('./?load=users','0');
break;
case'delprofcom':
$prof = $_GET['id'];
$commget = $_GET['comment'];
$mikmosLoad = $API->comm("/ip/hotspot/user/print", array("?comment" => "$commget"));
$mikmosTot = count($mikmosLoad);
for ($i=0; $i<$mikmosTot; $i++){
$mikmosView = $mikmosLoad[$i];
$idget = $mikmosView['.id'];
$API->comm("/ip/hotspot/user/remove", array(".id"=> "$idget"));
}
echo Loading('./?load=users','0');
break;
case'delexp':
$mikmosLoad = $API->comm("/ip/hotspot/user/print", array("?limit-uptime" => "1s"));
$mikmosTot = count($mikmosLoad);
for ($i=0; $i<$mikmosTot; $i++){
$mikmosView = $mikmosLoad[$i];
$idget = $mikmosView['.id'];
$API->comm("/ip/hotspot/user/remove", array(".id"=> "$idget"));
}
echo Loading('./?load=users','0');
break;
}
?>
