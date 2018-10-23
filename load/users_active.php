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
<th></th>
<th>Server</th>
<th>User</th>
<th>Address</th>
<th>Mac Address</th>
<th>Uptime</th>
<th>Bytes Out</th>
<th>Login By</th>
<th>Comment</th>
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
$byteso = formatBytes($hotspotactive['bytes-out'], 2);
$loginby = $hotspotactive['login-by'];
$comment = $hotspotactive['comment'];

echo "<tr>";
echo "<td style='text-align:center;'><a title='".__DEL." ". $user . "' href='./?load=users_active&get=del&id=". $id . "'><span class='btn btn-danger btn-xs'><i class='fa fa-trash'></i></span></a></td>";
echo "<td>" . $server . "</td>";
echo "<td><a title='Open User " .$user. "' href=#" .$user. "><i class='fa fa-edit'></i> " .$user."</a></td>";
echo "<td>" . $address . "</td>";
echo "<td>" . $mac . "</td>";
echo "<td style='text-align:right;'>" . $uptime . "</td>";
echo "<td style='text-align:right;'>" . $byteso . "</td>";
echo "<td>" . $loginby . "</td>";
echo "<td>" . $comment . "</td>";
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
<script type="text/javascript">
setTimeout(function(){
   window.location.reload(1);
}, 80000);
</script>
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
