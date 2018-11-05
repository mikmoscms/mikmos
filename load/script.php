<?php
switch($_GET['get']){
default:

$mikmosLoad = $API->comm("/system/script/print");
$mikmosTot = count($mikmosLoad);
?>
<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong><?php echo __SCHEDULER;?></strong>| <span class="text-danger"><?php if($mikmosTot < 2 ){echo "$mikmosTot"; }elseif($mikmosTot > 1){echo "$mikmosTot";}?></span> items

</header>
<div class="panel-body">

<?php //print_r($mikmosLoad);?>
<div class="table-responsive">
<div class="adv-table">
<table class="table table-bordered table-hover" id="mikmos-tbl-noinfo">
<thead>
<tr>
<th style="width:30px"></th>
<th>Name</th>
<th>Owner</th>
<th>Last Time</th>
<th>Run Count</th>
<th>Next Run</th>
</tr>
</thead>
<tbody>
<?php
for ($i=0; $i<$mikmosTot; $i++){
$mikmosData = $mikmosLoad[$i];
if($mikmosData['disabled']=='true'){$disabled = "<a title='Enable' href='./?load=scheduler&get=dis&id=".$mikmosData['.id']."&d=false'><span class='label label-danger'><i class='fa fa-lock'></i></span></a>";}else{$disabled = "<a title='Disable' href='./?load=scheduler&get=dis&id=".$mikmosData['.id']."&d=true'><span class='label label-success'><i class='fa fa-unlock'></i></span></a>";}
if($mikmosData['action']=='allow'){$actions = "<a title='Deny' href='./?load=scheduler&get=actions&id=".$mikmosData['.id']."&action=deny'><span class='btn btn-success btn-xs'>" . $mikmosData['action']. "</span></a>";}else{$actions = "<a title='Allow' href='./?load=scheduler&get=actions&id=".$mikmosData['.id']."&action=allow'><span class='btn btn-danger btn-xs'>" . $mikmosData['action']. "</span></a>";}
if(empty($mikmosData['server'])){$server = "All";}else{$server = $mikmosData['server'];}

echo "<tr>";
echo "<td class='text-center'><a title='Remove' href='./?load=scheduler&get=del&id=".$mikmosData['.id']."' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i></a></td>";
echo "<td>" . $mikmosData['name']. "</td>";
echo "<td>" . $mikmosData['owner']. "</td>";
echo "<td>" . $mikmosData['last-time']. "</td>";
echo "<td>" . $mikmosData['run-count']. "</td>";
echo "<td>" . $mikmosData['next-run']. "</td>";
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
case'dis':
$idget = $_GET['id'];
$dget = $_GET['d'];
$API->comm("/system/scheduler/set", array(
".id"=> "$idget",
"disabled"=> "$dget"));
_e('<script>window.history.go(-1)</script>');
break;
case'del':
$idget = $_GET['id'];
$API->comm("/system/scheduler/remove", array(
".id"=> "$idget",));
_e('<script>window.history.go(-1)</script>');
break;
}
?>
