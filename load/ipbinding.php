<?php
error_reporting(0);
switch($_GET['get']){
default:
@session_start();
if(!isset($_SESSION['connect'])){
 echo "<meta http-equiv='refresh' content='0;url=./?load=settings' />";
}
$mikmosLoad = $API->comm("/ip/hotspot/ip-binding/print");
$mikmosTot = count($mikmosLoad);
?>
<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong><?php echo __BINDING;?></strong></i>
</header>
<div class="panel-body">
<div class="row">
<div class="col-md-12">
<div class="table-responsive">
 <table class="table table-bordered table-hover text-nowrap" id="mikmos-tbl-noinfo">
<thead>
<tr>
<th></th>
<th>Name</th>
<th>Mac Address</th>
<th>Address</th>
<th>To Address</th>
<th>Server</th>
<th style='text-align:center;'>Type</th>
</tr>
</thead>
<tbody>
<?php
for ($i=0; $i<$mikmosTot; $i++){
$mikmosData = $mikmosLoad[$i];
$id = $mikmosData['.id'];
//$server = $mikmosData['server'];
$user = $mikmosData['user'];
$address = $mikmosData['address'];
$toaddress = $mikmosData['to-address'];
$mac = $mikmosData['mac-address'];
$comment = $mikmosData['comment'];


 
if(empty($mikmosData['server'])){$server = "all";}
else{$server = $mikmosData['server'];}
 
if($mikmosData['type']=="bypassed"){$bypass = "<span class='btn btn-warning btn-xs' title='P - bypass'>P</span>";}
elseif($mikmosData['type']=="blocked"){$bypass = "<span class='btn btn-warning btn-xs' title='B - Blocked'>B</span>";}
else{$bypass = "<strong title='R - Regular' style='color:#345333'>R</strong>";}

if($mikmosData['bypassed']=="true"){$address1 = "<a title='Queues Simple ".$address."' href='#'><span class='btn btn-warning btn-xs'><i class='fa fa-retweet'></i></span> ".$address."</a>";}
else{$address1 = "<a title='Make Binding IP ".$address."' href='./?load=host&get=makebinding&mac_binding=". $mac . "&server_binding=". $server . "&address_binding=". $address . "&toaddress_binding=". $toaddress . "'><i class='fa fa-retweet'></i> ".$address."</a>";}

if($mikmosData['disabled']=="true"){$disabled = "style='color:#ccc'";$lockn="<a title='Enable IP Binding ". $address . "' href='./?load=ipbinding&get=disable&id=". $id . "'><span class='btn btn-info btn-xs'><i class='fa fa-lock'></i></span></a>";}
else{$disabled = "style=''";$lockn="<a title='Disable IP Binding ". $address . "' href='./?load=ipbinding&get=enable&id=". $id . "'><span class='btn btn-info btn-xs'><i class='fa fa-unlock'></i></span></a>";}

echo "<tr ".$disabled.">";
echo "<td style='text-align:center;'><a title='Remove ". $user . "' href='./?load=ipbinding&get=del&id=". $id . "&name=". $comment . "'><span class='btn btn-danger btn-xs'><i class='fa fa-trash'></i></span></a> ".$lockn." " . $bypass . "</td>";
echo "<td>" . $comment . "</td>";
echo "<td>" . $mac . "</td>";
echo "<td>" . $address1 . "</td>";
echo "<td>" . $toaddress . "</td>";
echo "<td>" . $server . "</td>";
echo "<td style='text-align:center;'>
<a title='Click to P - Bypass' class='btn btn-success btn-xs' href='./?load=ipbinding&get=type&id=".$id ."&fix=bypassed'> P</a>
<a title='Click to B - Blocked' class='btn btn-danger btn-xs' href='./?load=ipbinding&get=type&id=".$id ."&fix=blocked'> B</a> 
</td>";
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


</div>

<?php

break;
case'type':
@session_start();
error_reporting(0);
$idget = $_GET['id'];
$idtype = $_GET['fix'];
$API->comm("/ip/hotspot/ip-binding/set", array(
".id"=> "$idget",
"type"=> "$idtype"));
_e('<script>window.history.go(-1)</script>');
break;
case'enable':
@session_start();
error_reporting(0);
$idget = $_GET['id'];
$API->comm("/ip/hotspot/ip-binding/set", array(
".id"=> "$idget",
"disabled"=> "true"));
_e('<script>window.history.go(-1)</script>');
break;
case'disable':
@session_start();
error_reporting(0);
$idget = $_GET['id'];
$API->comm("/ip/hotspot/ip-binding/set", array(
".id"=> "$idget",
"disabled"=> "false"));
_e('<script>window.history.go(-1)</script>');
break;
case'del':
@session_start();
error_reporting(0);
$idget = $_GET['id'];
$usget = $_GET['name'];
$API->comm("/ip/hotspot/ip-binding/remove", array(".id"=> "$idget",));
_e('<script>window.history.go(-1)</script>');
break;
}
?>
