<?php
switch($_GET['get']){
default:
$mikmosLoad = $API->comm("/ip/hotspot/cookie/print");
$mikmosTot = count($mikmosLoad);
?>
<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong><?php _e(__COOKIES);?></strong></i>
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
<th>Domain</th>
<th>Mac Address</th>
<th>Expires In</th>
</tr>
</thead>
<tbody>
<?php
for ($i=0; $i<$mikmosTot; $i++){
$mikmosData = $mikmosLoad[$i];
$id = $mikmosData['.id'];
$user = $mikmosData['user'];
$expiresin = $mikmosData['expires-in'];
$mac = $mikmosData['mac-address'];
$domain = $mikmosData['domain'];
?>
<tr>
<td style='text-align:center;'><a title='Remove <?php _e($user);?>' href='./?load=cookies&get=del&id=<?php _e($id);?>'><span class='btn btn-danger btn-xs'><i class='fa fa-trash'></i></span></a></td>
<td><?php _e($user);?></td>
<td><?php _e($domain);?></td>
<td><?php _e($mac);?></td>
<td><?php _e(formatDTM($expiresin));?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php
break;
case'del':
$idget = $_GET['id'];
$API->comm("/ip/hotspot/cookie/remove", array(
".id"=> "$idget",));
_e('<script>window.history.go(-1)</script>');
break;
}
?>
