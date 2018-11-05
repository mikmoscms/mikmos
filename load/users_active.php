<?php
switch($_GET['get']) {
default:
$gethotspotactive = $API->comm("/ip/hotspot/active/print");
$TotalReg = count($gethotspotactive);
$counthotspotactive = $API->comm("/ip/hotspot/active/print", array("count-only" => "",));
?>
<div id="reloadActivex">
<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong><?php echo __USERS_ACTIVE;?></strong> | aktif <span class="text-danger"><?php if($counthotspotactive < 2 ){echo "$counthotspotactive";}elseif($counthotspotactive > 1){ echo "$counthotspotactive";}?></span> users

<span class="tools pull-right">
 </span>
</header>
<div class="panel-body">
<?php //print_r($mikmosLoad);?>
<div class="table-responsive">
<div class="adv-table">
 <table class="table table-bordered table-hover text-nowrap" id="mikmos-tbl-noinfo">
 <thead>
  <tr>
<th class="text-left align-middle"></th>
<th class="text-left align-middle">Server</th>
<th class="text-left align-middle">User</th>
<th class="text-center align-middle">Address</th>
<th class="text-center align-middle">Mac Address</th>
<th class="text-center align-middle">Uptime</th>
<th class="text-center align-middle">Total<br/>Pemakaian</th>
<th class="text-center align-middle">Login By</th>
<th class="text-center align-middle">Comment</th>
  </tr>
  </thead>
  <tbody>
<?php
for ($i=0; $i<$TotalReg; $i++){
$hotspotactive = $gethotspotactive[$i];
$id = $hotspotactive['.id'];
$server = $hotspotactive['server'];
$user = $hotspotactive['user'];
$address = $hotspotactive['address'];
$mac = $hotspotactive['mac-address'];
$uptime = formatDTM($hotspotactive['uptime']);
//$byteso = formatBytes($hotspotactive['bytes-out'], 2);

$utotdata = $hotspotactive['bytes-out'] + $hotspotactive['bytes-in'];
$utotdatax = formatBytes($utotdata,2);
if($utotdatax == 0){$utotdata1 = "";}else{$utotdata1 = $utotdatax;}

$loginby = $hotspotactive['login-by'];
$comment = $hotspotactive['comment'];

echo "<tr>";
echo "<td style='text-align:center;'><a title='".__DEL." ". $user . "' href='./?load=users_active&get=del&id=". $id . "'><span class='btn btn-danger btn-xs'><i class='fa fa-trash'></i></span></a></td>";
echo "<td>" . $server . "</td>";
echo "<td><a title='Open User " .$user. "' href=./?load=users_active&get=view&id=". $id . "><i class='fa fa-search'></i> " .$user."</a></td>";
echo "<td class='text-center'>" . $address . "</td>";
echo "<td class='text-center'>" . $mac . "</td>";
echo "<td class='text-center'>" . $uptime . "</td>";
echo "<td class='text-center'>" . $utotdata1 . "</td>";
echo "<td class='text-center'>" . $loginby . "</td>";
echo '<td>' . $comment . '';
echo "</tr>";
}
?>
  </tbody>
</table>
</div>
</div>
</div>
</section>
</div>
</div>
</div>

<!-- Trigger the modal with a button -->


<script type="text/javascript">
setTimeout(function(){
   window.location.reload(1);
}, 80000);
</script>
<?php
break;
case'view':
$id_get = $_GET['id'];

$mikmosLoadP = $API->comm("/ip/hotspot/user/profile/print");
$mikmosLoadS = $API->comm("/ip/hotspot/print");

if(substr($id_get,0,1) == "*"){
$id_get = $id_get;
}elseif(substr($id_get,0,1) != ""){
$getuser = $API->comm("/ip/hotspot/active/print", array("?name"=> "$id_get",));
$id_get =$getuser[0]['.id'];
//if($id_get == ""){echo "<b>Hotspot User not found</b>";}
}
$getuser = $API->comm("/ip/hotspot/active/print", array("?.id"=> "$id_get",));
$userdetails =$getuser[0];
$uid = $userdetails['.id'];
$userver = $userdetails['server'];
$uname = $userdetails['user'];
$uaddress = $userdetails['address'];
$uloginby = $userdetails['login-by'];
$umac = $userdetails['mac-address'];
$usessiontimeleft = formatDTM($userdetails['session-time-left']);
$uuptime = formatDTM($userdetails['uptime']);
$ukeepalivetimeout = $userdetails['keepalive-timeout'];
$uidletime = $userdetails['idle-time'];
$ubytesout = $userdetails['bytes-out'];
$ubytesin = $userdetails['bytes-in'];
$upacketsout = $userdetails['packets-out'];
$upacketsin = $userdetails['packets-in'];
$ucomment = $userdetails['comment'];
$uradius = $userdetails['radius'];


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
<strong>Status <?php echo __USERS_ACTIVE;?></strong> |  <?php echo $uname;?>
<span class="tools pull-right">
 </span>
</header>
<div class="panel-body"><hr>
<?php// print_r($getuser);?>
<div class="row">
<div class="col-md-7">
<p class="text-muted">
<a class="btn btn-danger" href="./?load=users_active"> <i class="fa fa-arrow-left"></i> <?php echo __BACK;?></a>


</p>

<table class="table">
<tr>
<td class="align-middle">Server</td><td><?php _e($userver);?></td>
</tr>
<tr>
<td class="align-middle">IP Address</td><td><?php echo $uaddress;?></td>
</tr>
<tr>
<td class="align-middle">Mac Address</td><td><?php if(empty($umac)){echo'-';}else{echo $umac;}?></td>
</tr>
<tr>
<td class="align-middle">Name</td><td><?php echo $uname;?></td>
</tr>
<tr>
<td class="align-middle">Login by</td><td><?php echo $uloginby;?></td>
</tr>
<tr>
<td class="align-middle">Uptime</td><td><?php echo $uuptime;?></td>
</tr>
<tr>
<td class="align-middle">Session Time Left</td><td><?php echo $usessiontimeleft;?></td>
</tr>
<tr>
<td class="align-middle">Idle Time</td><td><?php echo $uidletime;?></td>
</tr>
<tr>
<td class="align-middle">Keepalive Timeout</td><td><?php echo $ukeepalivetimeout;?></td>
</tr>
<tr>
<td class="align-middle">Bytes Out/In</td><td><?php if($ubytesout == 0){echo'0';}else{echo formatBytes($ubytesout,2);}?> / <?php if($ubytesin == 0){echo'0';}else{echo formatBytes($ubytesin,2);}?></td>
</tr>
<tr>
<td class="align-middle">Packet Out/In</td><td><?php if($upacketsout == 0){echo'0';}else{echo formatBytes($upacketsout,2);}?> / <?php if($upacketsin == 0){echo'0';}else{echo formatBytes($upacketsin,2);}?></td>
</tr>
<tr>
<td class="align-middle">Radius</td><td><?php echo $uradius;?></td>
</tr>
<tr>
<td class="align-middle">Comment</td><td><?php echo $ucomment;?></td>
</tr>
</table>
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
case'del':
@session_start();
error_reporting(0);
$id=$_GET['id'];
$getuser = $API->comm("/ip/hotspot/active/print", array("?.id"=> "$id",));
$user =$getuser[0]['user'];
$getcookie = $API->comm("/ip/hotspot/cookie/print", array("?user"=> "$user",));
$ck_id =$getcookie[0]['.id'];
$API->comm("/ip/hotspot/cookie/remove", array(".id"=> "$ck_id",));
$API->comm("/ip/hotspot/active/remove", array(".id"=> "$id",));
_e('<script>window.history.go(-1)</script>');
break;

}
?>
