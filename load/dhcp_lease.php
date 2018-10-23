<?php
switch($_GET['get']){
default:
$mikmosLoad = $API->comm("/ip/dhcp-server/lease/print");
$mikmosTot = count($mikmosLoad);
?>
<div id="reloadmikmosLoadx">
<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong><?php _e(__DHCPLEASE);?></strong> | <span class="text-danger"><?php if($mikmosTot < 2 ){_e($mikmosTot); }elseif($mikmosTot > 1){_e($mikmosTot);}?></span> items
<span class="tools pull-right"></span>
</header>
<div class="panel-body">
<div class="table-responsive">
<div class="adv-table">
<table class="table table-bordered table-hover text-nowrap" id="mikmos-tbl-noinfo">
<thead>
<tr> 
<th class="text-center" style="width:85px;"></th>
<th class="align-middle">Address</th>
<th class="align-middle text-center">MAC Address</th>
<th class="align-middle text-center">Server</th>
<th class="align-middle text-center">Active Address</th>
<th class="align-middle text-center">Active MAC</th>
<th class="align-middle">Active Host Name</th>
</tr>
</thead>
<tbody>
<?php
for ($i=0; $i<$mikmosTot; $i++){
echo "<tr>";
$mikmosData = $mikmosLoad[$i];
if($mikmosData['dynamic'] == "true"){$dinamic = "<b class='btn btn-info btn-xs' title='D - dynamic'>D</b>";}else{$dinamic = "<b class='btn btn-warning btn-xs' title='S - static'>S</b>";}
?>
<td style='text-align:center;'><a class='btn btn-danger btn-xs' href='./?load=dhcp_lease&get=del&id=<?php _e($mikmosData['.id']);?>' title='Remove'><i class='fa fa-trash'></i></a> <?php _e($dinamic);?>
</td>
<td><?php _e($mikmosData['address']);?></td>
<td class='text-center'><?php _e($mikmosData['mac-address']);?></td>
<td class='text-center'><?php _e($mikmosData['server']);?></td>
<td class='text-center'><?php _e($mikmosData['active-address']);?></td>
<td class='text-center'><?php _e($mikmosData['active-mac-address']);?></td>
<td class='text-left'><?php _e($mikmosData['host-name']);?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
</section>
</div>
</div>
</div>
<?php
break;
case'del':
$removeget = $_GET['id'];
$API->comm("/ip/dhcp-server/lease/remove", array(".id"=> "$removeget",));
_e('<script>window.history.go(-1)</script>');
break;
}
?>
