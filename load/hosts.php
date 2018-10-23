<?php
error_reporting(0);
switch($_GET['get']){
default:
@session_start();
if(!isset($_SESSION['connect'])){
 echo "<meta http-equiv='refresh' content='0;url=./?load=settings' />";
}
$mikmosLoad = $API->comm("/ip/hotspot/host/print");
$mikmosTot = count($mikmosLoad);


?>
<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong><?php echo __HOSTS;?></strong></i>
</header>
<div class="panel-body">
<?php //print_r($mikmosLoad);?>
<div class="table-responsive">
<div class="adv-table">
<table id="mikmos-tbl-noinfo" class="table table-sm table-bordered table-hover text-nowrap">
<thead>
<tr>
<th></th>
<th>Mac Address</th>
<th>Address</th>
<th>To Address</th>
<th>Server</th>
<th>Comment</th>
</tr>
</thead>
<tbody>
<?php
for ($i=0; $i<$mikmosTot; $i++){
$mikmosData = $mikmosLoad[$i];
$id = $mikmosData['.id'];
$server = $mikmosData['server'];
$user = $mikmosData['user'];
$address = $mikmosData['address'];
$toaddress = $mikmosData['to-address'];
$mac = $mikmosData['mac-address'];
$uptime = formatDTM($mikmosData['uptime']);
$byteso = formatBytes($mikmosData['bytes-out'], 2);
$keepalivetimeout = $mikmosData['keepalive-timeout'];
$foundby = $mikmosData['found-by'];
$loginby = $mikmosData['login-by'];
$comment = $mikmosData['comment'];

if (empty($comment)){$comment1 = $mac;}else{$comment1 = $comment;}
if ($mikmosData['authorized']=="true"){$authorized = "<span class='btn btn-success btn-xs' title='A - authorized'>A</span>&nbsp";}
elseif ($mikmosData['authorized']=="false"){$authorized = "<strong title='' style='color:#04B404'></strong>";}
else{$authorized = "";}

if ($mikmosData['DHCP']=="true"){$dhcp = "<span class='btn btn-info btn-xs' title='H - DHCP'>H</span>&nbsp";}
elseif($mikmosData['DHCP']=="false"){$dhcp = "<span class='btn btn-info btn-xs'>D</span>&nbsp";}
else{$dhcp = "";}


if($mikmosData['bypassed']=="true"){$bypass = "<span class='btn btn-warning btn-xs' title='P - bypass'>P</span>";}
elseif($mikmosData['bypassed']=="false"){$bypass = "<strong style='color:#FF0000'></strong>";}
else{$bypass = "";}
if($mikmosData['bypassed']=="true"){$address1 = "<atitle='Cek Binding IP ".$address."' href='./?load=ipbinding'><span class='btn btn-warning btn-xs'><i class='fa fa-retweet'></i></span> ".$address."</a>";}
else{$address1 = "<atitle='Make Binding IP ".$address."' href='./?load=hosts&get=makebinding&mac_binding=". $mac . "&server_binding=all&address_binding=". $address . "&toaddress_binding=". $toaddress . "&comment=".$comment1."'><span class='btn btn-info btn-xs'><i class='fa fa-retweet'></i></span> ".$address."</a>";}

echo "<tr>";
echo "<td><atitle='".__DEL." ". $user . "' href='./?load=hosts&del=". $id . "'><span class='btn btn-danger btn-xs'><i class='fa fa-trash'></i></span></a>";
echo "&nbsp";
echo "" . $authorized . "" . $dhcp . "" . $bypass . "</td>";
echo "<td>" . $mac . "</td>";
echo "<td>" . $address1 . "</td>";
echo "<td>" . $toaddress . "</td>";
echo "<td>" . $server . "</td>";
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



<?php

break;
case'makebinding':
@session_start();
error_reporting(0);
$mac_binding = $_GET['mac_binding'];
$server_binding = $_GET['server_binding'];
$address_binding = $_GET['address_binding'];
$toaddress_binding = $_GET['toaddress_binding'];
$comment = $_GET['comment'];
$API->comm("/ip/hotspot/ip-binding/add", array(
"mac-address"=> "$mac_binding",
"server"=> "$server_binding",
"address"=> "$address_binding",
"to-address"=> "$toaddress_binding",
"comment"=> "$comment",
"type"=> "bypassed",
"disabled" => "no",
));
_e("<script>window.location='./?load=ipbinding'</script>");
break;
case'del':
@session_start();
error_reporting(0);
$removeget = $_GET['id'];
$API->comm("/ip/hotspot/host/remove", array(
".id"=> "$removeget",));
_e('<script>window.history.go(-1)</script>');
break;
}
?>
