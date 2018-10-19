<?php
error_reporting(0);
$bg_array = array("#CEED9D","#ECED9D","#EDCF9D","#EC9CA7","#fdd752","#a48ad4","#aec785","#1fb5ac","#fa8564");
switch($_GET['get']){
default:
$mikmosLoad = $API->comm("/ip/hotspot/user/profile/print");
$mikmosTot = count($mikmosLoad);
$mikmosCount = $API->comm("/ip/hotspot/user/profile/print", array("count-only" => "",));
?>
<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong><?php echo __PROFILE;?></strong> | Profile <span class="text-danger"><?php if($mikmosCount < 2 ){echo "$mikmosCount"; }elseif($mikmosCount > 1){echo "$mikmosCount";}?></span> items

<span class="tools pull-right">
 </span>
</header>
<div class="panel-body">
<p class="text-muted">
<a class="btn btn-success" href="./?load=profile&get=add"> <i class="fa fa-plus"></i> <?php echo __ADD;?></a>
</p><hr>
<div class="table-responsive">
<table class="table table-bordered table-hover text-nowrap" id="mikmos-tbl-noinfo">
<thead>
<tr> 
<th class="align-middle"></th>
<th class="align-middle">Nama Profil</th>
<th class="align-middle text-center">Shared<br/>Users</th>
<th class="align-middle text-center">Rate<br/>Limit</th>
<th class="align-middle text-center">Mode Expired</th>
<th class="align-middle text-center">Masa<br/>Aktif</th>
<th class="align-middle text-center">Masa<br/>Tenggang</th>
<th class="align-middle text-center">Masa<br/>Hapus</th>
<th class="align-middle">Harga <?php echo $curency;?></th>
<th class="align-middle text-center">Total<br/>User</th>
</tr>
</thead>

  <tbody>
<?php

for ($i=0; $i<$mikmosTot; $i++){
$mikmosData = $mikmosLoad[$i];
$pid = $mikmosData['.id'];
$pname = $mikmosData['name'];
$psharedu = $mikmosData['shared-users'];
$pratelimit = $mikmosData['rate-limit'];
$ponlogin = $mikmosData['on-login'];
?>
<tr>
<td style='text-align:center;'>
<a  href="./?load=users&prof=<?php echo $pname;?>" title="Lihat User Profile <?php echo $pname;?>" class='btn btn-primary btn-xs'><i class="fa fa-eye"></i></a>
<a  href="./?load=vouchers&get=view&id=<?php echo $pname;?>" title="Cetak Voucher Profile <?php echo $pname;?>" class='btn btn-success btn-xs'><i class="fa fa-ticket"></i></a>
<a onclick="return confirm('Anda yakin untuk menghapusnya?')" href="./?load=profile&get=del&id=<?php echo $pid;?>" title="Remove User Profile <?php echo $pname;?>" class='btn btn-danger btn-xs'><i class="fa fa-trash"></i></a>
</td>

<td><a title='Perbaharui User Profile <?php echo $pname;?><' href='./?load=profile&get=edit&id=<?php echo $pid;?>'><span class='btn btn-info btn-xs'><i class='fa fa-edit'></i></span> <?php echo $pname;?></a></td>


<?php
echo "<td class='text-center'>" . $psharedu;echo "</td>";
echo "<td class='text-center'>" . $pratelimit;echo "</td>";

echo "<td class='text-center'>";
$getexpmode = explode(",",$ponlogin);
$expmode = $getexpmode[1];
if($expmode == "rem"){
echo "Remove";
}elseif($expmode == "ntf"){
echo "Notice";
}elseif($expmode == "remc"){
echo "Remove & Record";
}elseif($expmode == "ntfc"){
echo "Notice & Record";
}else{

}
echo "</td>";
echo "<td class='text-center'>";
$getvalid = explode(",",$ponlogin);
echo $getvalid[5];

echo "</td>";
echo "<td class='text-center'>";

$getgracep= explode(",",$ponlogin);
echo $getgracep[3];
echo "</td>";
echo "<td class='text-center'>";

$getgracep= explode(",",$ponlogin);
echo $getgracep[4];
echo "</td>";

echo "<td style='text-align:right;'>";
$getprice = explode(",",$ponlogin);
$price = trim($getprice[2]);
if($price == "" || $price == "0" ){
echo "";
}else{
if($curency == "Rp" || $curency == "rp" || $curency == "IDR" || $curency == "idr"){
echo number_format($price,0,",",".");
}else{ 
echo number_format($price); 
}
}

echo "</td>";
echo "<td class='text-center'>";

$countuser = $API->comm("/ip/hotspot/user/print", array(
"count-only" => "",
"?profile" => "$pname",
));
if($countuser < 2 ){echo "$countuser";
  }elseif($countuser > 1){
  echo "$countuser";}
echo  "</td>";
echo "</tr>";
}
?>
  </tbody>
</table>
</div>

</div>
</div>
</div>
</div>



<?php

break;
case'add':
if(isset($_POST['save'])){
$name = ganti_spasi($_POST['name']);
$sharedusers = ($_POST['sharedusers']);
$ratelimit = ($_POST['ratelimit']);
$expmode = ($_POST['expmode']);
$validity = ($_POST['validity']);
$timelimit = ($_POST['timelimit']);
$graceperiod = ($_POST['graceperiod']);
$getprice = ($_POST['price']);
if($getprice == ""){$price = "0";}else{$price = $getprice;}
$getlock = ($_POST['lockunlock']);
if($getlock == Enable){$lock = ';[:local mac $"mac-address"; /ip hotspot user set mac-address=$mac [find where name=$user]]';}else{$lock = "";}

  $onlogin1 = ':put (",rem,'.$price.','.$validity.','.$graceperiod.','.$timelimit.','.$getlock.',"); {:local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$validity.');[/system scheduler add disabled=no interval=$uptime name=$user on-event="[/ip hotspot active remove [find where user=$user]];[/ip hotspot user set limit-uptime=1s [find where name=$user]];[/sys sch re [find where name=$user]];[/sys script run [find where name=$user]];[/sys script re [find where name=$user]]" start-date=$date start-time=$time];[/system script add name=$user source=":local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$graceperiod.');[/system scheduler add disabled=no interval=\$uptime name=$user on-event= \"[/ip hotspot user remove [find where name=$user]];[/ip hotspot active remove [find where user=$user]];[/sys sch re [find where name=$user]]\"]"]'; 
$onlogin2 = ':put (",ntf,'.$price.','.$validity.',,'.$timelimit.','.$getlock.',"); {:local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$validity.');[/system scheduler add disabled=no interval=$uptime name=$user on-event= "[/ip hotspot user set limit-uptime=1s [find where name=$user]];[/ip hotspot active remove [find where user=$user]];[/sys sch re [find where name=$user]]" start-date=$date start-time=$time]';
$onlogin3 = ':put (",remc,'.$price.','.$validity.','.$graceperiod.','.$timelimit.','.$getlock.',"); {:local price ('.$price.');:local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$validity.');[/system scheduler add disabled=no interval=$uptime name=$user on-event="[/ip hotspot active remove [find where user=$user]];[/ip hotspot user set limit-uptime=1s [find where name=$user]];[/sys sch re [find where name=$user]];[/sys script run [find where name=$user]];[/sys script re [find where name=$user]]" start-date=$date start-time=$time];[/system script add name=$user source=":local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$graceperiod.');[/system scheduler add disabled=no interval=\$uptime name=$user on-event= \"[/ip hotspot user remove [find where name=$user]];[/ip hotspot active remove [find where user=$user]];[/sys sch re [find where name=$user]]\"]"];:local bln [:pick $date 0 3]; :local thn [:pick $date 7 11];[:local mac $"mac-address"; /system script add name="$date-|-$time-|-$user-|-$price-|-$address-|-$mac-|-'.$validity.'" owner="$bln$thn" source=$date comment=MIKMOScms]';
$onlogin4 = ':put (",ntfc,'.$price.','.$validity.',,'.$timelimit.','.$getlock.',"); {:local price ('.$price.');:local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$validity.');[/system scheduler add disabled=no interval=$uptime name=$user on-event= "[/ip hotspot user set limit-uptime=1s [find where name=$user]];[/ip hotspot active remove [find where user=$user]];[/sys sch re [find where name=$user]]" start-date=$date start-time=$time];:local bln [:pick $date 0 3]; :local thn [:pick $date 7 11];[:local mac $"mac-address"; /system script add name="$date-|-$time-|-$user-|-$price-|-$address-|-$mac-|-'.$validity.'" owner="$bln$thn" source=$date comment=MIKMOScms]';

if($expmode == "rem"){
  $onlogin = $onlogin1.$lock."}}";
}elseif($expmode == "ntf"){
  $onlogin = $onlogin2.$lock."}}";
}elseif($expmode == "remc"){
  $onlogin = $onlogin3.$lock."}}";
}elseif($expmode == "ntfc"){
  $onlogin = $onlogin4.$lock."}}";
}elseif($expmode == "0" && $price != "" ){
$onlogin = ':put (",,'.$price.',,,,'.$getlock.',")'.$lock;
}else{
$onlogin = "";
}

$API->comm("/ip/hotspot/user/profile/add", array(
  "name" => "$name",
  "rate-limit" => "$ratelimit",
  "shared-users" => "$sharedusers",
  "status-autorefresh" => "1m",
  "transparent-proxy" => "yes",
  "on-login" => "$onlogin",
));

$mikmosLoad = $API->comm("/ip/hotspot/user/profile/print", array(
"?name"=> "$name",
));
$pid =$mikmosLoad[0]['.id'];
echo "<script>window.location='./?load=profile'</script>";
  }
?>
<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong><?php echo __ADD." ".__PROFILE;?></strong></i>

<span class="tools pull-right">
 </span>
</header>
<form action="./?load=profile&get=add" method="post">
<div class="panel-body">

<hr>

<div class="row">
<div class="col-md-7">
  
<p class="text-muted">
<a class="btn btn-danger" href="./?load=profile"> <i class="fa fa-close"></i> <?php echo __CANCEL;?></a>
<button type="submit" class="btn bg-primary" name="save"><i class="fa fa-save"></i> <?php echo __SAVE;?></button>
</p>

<table class="table">
  <tr>
<td class="align-middle">Name</td><td><input class="form-control" type="text" autocomplete="off" name="name" value="" required="1" autofocus></td>
  </tr>
  <tr>
<td class="align-middle">Shared Users</td><td><input class="form-control" type="text" size="4" autocomplete="off" name="sharedusers" value="1" required="1"></td>
  </tr>
  <tr>
<td class="align-middle">Rate limit [up/down]</td><td><input class="form-control" type="text" name="ratelimit" autocomplete="off" value="" placeholder="Example : 512k/1M" ></td>
  </tr>
  <tr>
<td class="align-middle">Mode Expired</td><td>
  <select class="form-control" onchange="RequiredV();" id="expmode" name="expmode" required="1">
<option value="">=== Pilih Mode Expired ===</option>
<option value="0">None</option>
<option value="rem">Remove</option>
<option value="ntf">Notice</option>
<option value="remc">Remove & Record</option>
<option value="ntfc">Notice & Record</option>
  </select>
</td>
  </tr>
  <tr id="timelimit" style="display:none;">
<td class="align-middle">Masa Aktif</td><td><input class="form-control" type="text" id="timelimi" size="4" name="timelimit" value=""></td>
  </tr>
  <tr id="validity" style="display:none;">
<td class="align-middle">Masa Tenggang</td><td><input class="form-control" type="text" id="validi" size="4" name="validity" value=""></td>
  </tr>
  <tr id="graceperiod" style="display:none;">
<td class="align-middle">Masa Hapus</td><td><input class="form-control" type="text" id="gracepi" size="4" name="graceperiod" placeholder="5m" value="5m"></td>
  </tr>
  <tr>
<td class="align-middle">Harga <?php echo $curency;?></td><td><input class="form-control" type="number" size="10" min="0" name="price" value="" ></td>
  </tr>
  <tr>
<td>Kunci User</td><td>
  <select class="form-control" id="lockunlock" name="lockunlock">
<option value="">=== Pilih Kunci User ===</option>
<option value="Enable">Enable</option>
<option value="Disable">Disable</option>
  </select>
</td>
  </tr>
  <tr>
<td></td><td>
</td>
  </tr>
</table>

</div>
<div class="col-md-5">

<header class="panel-heading">
<strong><?php echo __INFO;?></strong>

<span class="tools pull-right">
 </span>
</header>

<div class="panel-body">

<table class="table">
<tr>
<td colspan="2">
  <?php if($_LANG == "id"){?>
  <p>
Mode Expired adalah kontrol untuk user hotspot
  </p>
  <table>
  <tr><td>Mode Expired</td><td>Remove, Notice, Remove & Record,Notice & Record.</td></tr>
  <tr><td>Remove</td><td>User akan dihapus ketika sudah Masa Hapus habis.</td></tr>
  <tr><td>Notice</td><td>User tidak dihapus dan akan mendapatkan notifikasi setelah user expired.</td></tr>
  <tr><td>Record</td><td>Menyimpan data harga tiap user yang login. Untuk menghitung total penjualan user hotspot.</td></tr>
  <tr><td>Masa Aktif</td><td>Masa Aktif User/Voucher, disarankan kurang dari Masa Tenggang.</td></tr>
  <tr><td>Masa Tenggang</td><td>Tenggang waktu sebelum user dihapus.</td></tr>
  <tr><td>Masa Hapus</td><td>User akan dihapus setelah masa tenggang</td></tr>
  <tr><td>Kunci User</td><td>Username/Kode voucher hanya bisa digunakan pada 1 perangkat saja.</td></tr>
  <tr><td>Format</td><td>[wdhm] Contoh : 30d = 30hari, 12h = 12jam, 4w3d = 31hari.</td></tr>
  </table>
  <?php }else{?>
  <p>
  Mode Expired is the control for the hotspot user.
  </p>
  <table>
  <tr><td>Options Expired</td><td>Options : Remove, Notice, Remove & Record, Notice & Record.</td></tr>
  <tr><td>Remove</td><td>User will be deleted when the grace period expires.</td></tr>
  <tr><td>Notice</td><td>User will not deleted and get notification after user expiration.</td></tr>
  <tr><td>Record</td><td>Save the price of each user login. To calculate total sales of hotspot users.</td></tr>
  <tr><td>Masa Aktif</td><td>Masa Aktif User/Voucher, disarankan kurang dari Masa Tenggang.</td></tr>
  <tr><td>Masa Tenggang</td><td>Tenggang waktu sebelum user dihapus.</td></tr>
  <tr><td>Masa Hapus</td><td>Grace period before user deleted.</td></tr>
  <tr><td>Kunci User</td><td>Username can only be used on 1 device only.</td></tr>
  <tr><td>Format</td><td>[wdhm] Contoh : 30d = 30hari, 12h = 12jam, 4w3d = 31hari.</td></tr>
  </table>
  
  <?php }?>
</td>
  </tr>
</table>
</div>
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
$userprofile = $_GET['id'];
if(substr($userprofile,0,1) == "*"){
$userprofile = $userprofile;
  }elseif(substr($userprofile,0,1) != ""){
$mikmosLoad = $API->comm("/ip/hotspot/user/profile/print", array(
"?name"=> "$userprofile",
));
$userprofile =$mikmosLoad[0]['.id'];
if($userprofile == ""){echo "<b>User Profile not found</b>";}
  }
  
  $mikmosLoad = $API->comm("/ip/hotspot/user/profile/print", array(
"?.id" => "$userprofile"));
$mikmosData = $mikmosLoad[0];
  $pid = $mikmosData['.id'];
  $pname = $mikmosData['name'];
  $psharedu = $mikmosData['shared-users'];
  $pratelimit = $mikmosData['rate-limit'];
  $ponlogin = $mikmosData['on-login'];
  
  $getexpmode = explode(",",$ponlogin)[1];
  
if($getexpmode == "rem"){
$getexpmodet = "Remove";
}elseif($getexpmode == "ntf"){
$getexpmodet = "Notice";
}elseif($getexpmode== "remc"){
$getexpmodet = "Remove & Record";
}elseif($getexpmode == "ntfc"){
$getexpmodet = "Notice & Record";
}else{
$getexpmode = "0";
$getexpmodet = "None";
}

$getprice = explode(",",$ponlogin)[2];
if($getprice == "0"){$getprice = "";}else{$getprice = $getprice;}
$getvalid = explode(",",$ponlogin)[3];
$getgracep = explode(",",$ponlogin)[4];
$gettimelimit = explode(",",$ponlogin)[5];
$getlocku = explode(",",$ponlogin)[6];
if($getlocku == ""){$getlocku = "Disable";}else{$getlocku = $getlocku;}

  if(isset($_POST['edit'])){
$name = ganti_spasi($_POST['name']);
$sharedusers = ($_POST['sharedusers']);
$ratelimit = ($_POST['ratelimit']);
$expmode = ($_POST['expmode']);
$timelimit = ($_POST['timelimit']);
$validity = ($_POST['validity']);
$graceperiod = ($_POST['graceperiod']);
$getprice = ($_POST['price']);
if($getprice == ""){$price = "0";}else{$price = $getprice;}
$getlock = ($_POST['lockunlock']);
if($getlock == Enable){$lock = ';[:local mac $"mac-address"; /ip hotspot user set mac-address=$mac [find where name=$user]]';}else{$lock = "";}
   
$onlogin1 = ':put (",rem,'.$price.','.$validity.','.$graceperiod.','.$timelimit.','.$getlock.',"); {:local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$validity.');[/system scheduler add disabled=no interval=$uptime name=$user on-event="[/ip hotspot active remove [find where user=$user]];[/ip hotspot user set limit-uptime=1s [find where name=$user]];[/sys sch re [find where name=$user]];[/sys script run [find where name=$user]];[/sys script re [find where name=$user]]" start-date=$date start-time=$time];[/system script add name=$user source=":local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$graceperiod.');[/system scheduler add disabled=no interval=\$uptime name=$user on-event= \"[/ip hotspot user remove [find where name=$user]];[/ip hotspot active remove [find where user=$user]];[/sys sch re [find where name=$user]]\"]"]'; 
$onlogin2 = ':put (",ntf,'.$price.','.$validity.',,'.$timelimit.','.$getlock.',"); {:local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$validity.');[/system scheduler add disabled=no interval=$uptime name=$user on-event= "[/ip hotspot user set limit-uptime=1s [find where name=$user]];[/ip hotspot active remove [find where user=$user]];[/sys sch re [find where name=$user]]" start-date=$date start-time=$time]';
$onlogin3 = ':put (",remc,'.$price.','.$validity.','.$graceperiod.','.$timelimit.','.$getlock.',"); {:local price ('.$price.');:local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$validity.');[/system scheduler add disabled=no interval=$uptime name=$user on-event="[/ip hotspot active remove [find where user=$user]];[/ip hotspot user set limit-uptime=1s [find where name=$user]];[/sys sch re [find where name=$user]];[/sys script run [find where name=$user]];[/sys script re [find where name=$user]]" start-date=$date start-time=$time];[/system script add name=$user source=":local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$graceperiod.');[/system scheduler add disabled=no interval=\$uptime name=$user on-event= \"[/ip hotspot user remove [find where name=$user]];[/ip hotspot active remove [find where user=$user]];[/sys sch re [find where name=$user]]\"]"];:local bln [:pick $date 0 3]; :local thn [:pick $date 7 11];[:local mac $"mac-address"; /system script add name="$date-|-$time-|-$user-|-$price-|-$address-|-$mac-|-'.$validity.'" owner="$bln$thn" source=$date comment=MIKMOScms]';
$onlogin4 = ':put (",ntfc,'.$price.','.$validity.',,'.$timelimit.','.$getlock.',"); {:local price ('.$price.');:local date [/system clock get date ];:local time [/system clock get time ];:local uptime ('.$validity.');[/system scheduler add disabled=no interval=$uptime name=$user on-event= "[/ip hotspot user set limit-uptime=1s [find where name=$user]];[/ip hotspot active remove [find where user=$user]];[/sys sch re [find where name=$user]]" start-date=$date start-time=$time];:local bln [:pick $date 0 3]; :local thn [:pick $date 7 11];[:local mac $"mac-address"; /system script add name="$date-|-$time-|-$user-|-$price-|-$address-|-$mac-|-'.$validity.'" owner="$bln$thn" source=$date comment=MIKMOScms]';

if($expmode == "rem"){
  $onlogin = $onlogin1.$lock."}}";
}elseif($expmode == "ntf"){
  $onlogin = $onlogin2.$lock."}}";
}elseif($expmode == "remc"){
  $onlogin = $onlogin3.$lock."}}";
}elseif($expmode == "ntfc"){
  $onlogin = $onlogin4.$lock."}}";
}elseif($expmode == "0" && $price != "" ){
$onlogin = ':put (",,'.$price.',,,,'.$getlock.',")'.$lock;
}else{
$onlogin = "";
}

$API->comm("/ip/hotspot/user/profile/set", array(
/*"add-mac-cookie" => "yes",*/
".id" => "$pid",
  "name" => "$name",
  "rate-limit" => "$ratelimit",
  "shared-users" => "$sharedusers",
  "status-autorefresh" => "1m",
  "transparent-proxy" => "yes",
  "on-login" => "$onlogin",
));
echo "<script>window.location='./?load=profile'</script>";
  }

//print_r($mikmosLoad);
?>

<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong><?php echo __EDIT." ".__PROFILE;?></strong></i>

<span class="tools pull-right">
 </span>
</header>
<form action="" method="post">
<div class="panel-body">

<hr>

<div class="row">
<div class="col-md-7">
  
<p class="text-muted">
<a class="btn btn-danger" href="./?load=profile"> <i class="fa fa-close"></i> <?php echo __CANCEL;?></a>
<button type="submit" class="btn bg-primary" name="edit"><i class="fa fa-save"></i> <?php echo __SAVE;?></button>
</p>


<table class="table">
  <tr>
<td>Nama Profil</td><td><input class="form-control" type="text" autocomplete="off" name="name" value="<?php echo $pname;?>" required="1" autofocus></td>
  </tr>
  <tr>
<td>Shared Users</td><td><input class="form-control" type="text" size="4" autocomplete="off" name="sharedusers" value="<?php echo $psharedu;?>" required="1"></td>
  </tr>
  <tr>
<td>Rate limit [up/down]</td><td><input class="form-control" type="text" name="ratelimit" autocomplete="off" value="<?php echo $pratelimit;?>" placeholder="Example : 512k/1M" ></td>
  <tr>
<td>Mode Expired</td>
<td>
<select class="form-control" onchange="RequiredV();" id="expmode" name="expmode" required="1">
<option value="">=== Pilih Mode Expired ===</option>
<option <?php if($getexpmode=='0'){echo 'selected';}?> value="0">None</option>
<option <?php if($getexpmode=='rem'){echo 'selected';}?> value="rem">Remove</option>
<option <?php if($getexpmode=='ntf'){echo 'selected';}?> value="ntf">Notice</option>
<option <?php if($getexpmode=='remc'){echo 'selected';}?> value="remc">Remove & Record</option>
<option <?php if($getexpmode=='ntfc'){echo 'selected';}?> value="ntfc">Notice & Record</option>
</select>
</td>
</tr>
  <tr id="timelimit" <?php if(($getexpmode=='rem')or($getexpmode=='ntf')or($getexpmode=='remc')or($getexpmode=='ntfc')){echo 'style="display: table-row;"';}else{echo 'style="display:none;"';}?>>
<td>Masa Aktif</td><td><input class="form-control" type="text" id="timelimi" size="4" autocomplete="off" name="timelimit" value="<?php echo $gettimelimit;?>"></td>
  </tr>
  <tr id="validity" <?php if(($getexpmode=='rem')or($getexpmode=='ntf')or($getexpmode=='remc')or($getexpmode=='ntfc')){echo 'style="display: table-row;"';}else{echo 'style="display:none;"';}?>>
<td>Masa Tenggang</td><td><input class="form-control" type="text" id="validi" size="4" autocomplete="off" name="validity" value="<?php echo $getvalid;?>"></td>
  </tr>
  <tr id="graceperiod" <?php if(($getexpmode=='rem')or($getexpmode=='remc')){echo 'style="display: table-row;"';}else{echo 'style="display:none;"';}?>>
<td>Masa Hapus</td><td><input class="form-control" type="text" id="gracepi" size="4" autocomplete="off" name="graceperiod" value="<?php echo $getgracep;?>"></td>
  </tr>
  <tr>
<td>Harga</td><td><input class="form-control" type="number" min="0" name="price" value="<?php echo $getprice;?>" ></td>
  </tr>
  <tr>
<td>Kunci User</td><td>
<select class="form-control" id="lockunlock" name="lockunlock" >
<option value="">=== Pilih Kunci User ===</option>
<option <?php if($getlocku=="Enable"){echo 'selected';}?> value="Enable"><?php echo __ENABLE;?></option>
<option <?php if($getlocku=="Disable"){echo 'selected';}?> value="Disable"><?php echo __DISABLE;?></option>
  </select>
</td>
  </tr>
  <tr>
<td></td><td>
</td>
  </tr>
</table>

</div>
<div class="col-md-5">

<header class="panel-heading">
<strong><?php echo __INFO;?></strong>

<span class="tools pull-right">
 </span>
</header>

<div class="panel-body">
<table class="table">
<tr>
<td colspan="2">
  <?php if($_LANG == "id"){?>
  <p>
Mode Expired adalah kontrol untuk user hotspot
  </p>
  <table>
  <tr><td>Mode Expired</td><td>Remove, Notice, Remove & Record,Notice & Record.</td></tr>
  <tr><td>Remove</td><td>User akan dihapus ketika sudah grace period habis.</td></tr>
  <tr><td>Notice</td><td>User tidak dihapus dan akan mendapatkan notifikasi setelah user expired.</td></tr>
  <tr><td>Record</td><td>Menyimpan data harga tiap user yang login. Untuk menghitung total penjualan user hotspot.</td></tr>
  <tr><td>Masa Tenggang</td><td>Tenggang waktu sebelum user dihapus.</td></tr>
  <tr><td>Masa Hapus</td><td>User akan dihapus setelah masa tenggang</td></tr>
  <tr><td>Kunci User</td><td>Username/Kode voucher hanya bisa digunakan pada 1 perangkat saja.</td></tr>
  <tr><td>Format</td><td>[wdhm] Contoh : 30d = 30hari, 12h = 12jam, 4w3d = 31hari.</td></tr>
  </table>
  <?php }else{?>
  <p>
  Expired Mode is the control for the hotspot user.
  </p>
  <table>
  <tr><td>Options Expired</td><td>Options : Remove, Notice, Remove & Record, Notice & Record.</td></tr>
  <tr><td>Remove</td><td>User will be deleted when the grace period expires.</td></tr>
  <tr><td>Notice</td><td>User will not deleted and get notification after user expiration.</td></tr>
  <tr><td>Record</td><td>Save the price of each user login. To calculate total sales of hotspot users.</td></tr>
  <tr><td>Masa Tenggang</td><td>Tenggang waktu sebelum user dihapus.</td></tr>
  <tr><td>Masa Hapus</td><td>Grace period before user deleted.</td></tr>
  <tr><td>Kunci User</td><td>Username can only be used on 1 device only.</td></tr>
  <tr><td>Format</td><td>[wdhm] Contoh : 30d = 30hari, 12h = 12jam, 4w3d = 31hari.</td></tr>
  </table>
  
  <?php }?>
</td>
  </tr>
</table>
</div>
</div>
</div>
</div>
</form>

</div>
</div>
</div>





<?php
break;
case'del':
$removeuserprofile = $_GET['id'];
$API->comm("/ip/hotspot/user/profile/remove", array(
".id"=> "$removeuserprofile",));
echo Loading('./?load=profile','0');
break;
}
?>
