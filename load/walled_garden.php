<?php
switch($_GET['get']){
default:
$mikmosLoad = $API->comm("/ip/hotspot/walled-garden/print");
$mikmosTot = count($mikmosLoad);
?>
<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong><?php echo __WALLED_GARDEN;?></strong>| <span class="text-danger"><?php if($mikmosTot < 2 ){echo "$mikmosTot"; }elseif($mikmosTot > 1){echo "$mikmosTot";}?></span> items
</header>
<div class="panel-body">
<?php //print_r($mikmosLoad);?>
<p class="text-muted">
<a class="btn btn-success" href="./?load=walled_garden&get=ae"> <i class="fa fa-plus"></i> <?php echo __ADD;?></a>
</p><hr>
<div class="table-responsive">
<div class="adv-table">
<table class="table table-bordered table-hover text-nowrap" id="mikmos-tbl-noinfo">
<thead>
<tr>
<th style="width:120px"></th>
<th>Actions</th>
<th>Server</th>
<th>Dst. Host</th>
<th>Dst. Port</th>
<th>Hits</th>
</tr>
</thead>
<tbody>
<?php
for ($i=0; $i<$mikmosTot; $i++){
$mikmosData = $mikmosLoad[$i];
if($mikmosData['disabled']=='true'){$disabled = "<a  title='Enable' href='./?load=walled_garden&get=dis&id=".$mikmosData['.id']."&d=false' class='btn btn-danger btn-xs'><i class='fa fa-lock'></i></a>";}else{$disabled = "<a  title='Disable' href='./?load=walled_garden&get=dis&id=".$mikmosData['.id']."&d=true' class='btn btn-success btn-xs'><i class='fa fa-unlock'></i></a>";}
if($mikmosData['action']=='allow'){$actions = "<a  title='Deny' href='./?load=walled_garden&get=actions&id=".$mikmosData['.id']."&action=deny'><span class='btn btn-success btn-xs'>" . $mikmosData['action']. "</span></a>";}else{$actions = "<a  title='Allow' href='./?load=walled_garden&get=actions&id=".$mikmosData['.id']."&action=allow'><span class='btn btn-danger btn-xs'>" . $mikmosData['action']. "</span></a>";}
if(empty($mikmosData['server'])){$server = "All";}else{$server = $mikmosData['server'];}
echo "<tr>";
echo "<td class='text-center'><a  title='Remove' href='./?load=walled_garden&get=del&id=".$mikmosData['.id']."' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i></a> <a  title='Edit' href='./?load=walled_garden&get=ae&id=".$mikmosData['.id']."' class='btn btn-info btn-xs'><i class='fa fa-edit'></i></a> " . $disabled. "</td>";
echo "<td>" . $actions. "</td>";
echo "<td>" . $server. "</td>";
echo "<td>" . $mikmosData['dst-host']. "</td>";
echo "<td>" . $mikmosData['dst-port']. "</td>";
echo "<td>" . $mikmosData['hits']. "</td>";
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
case'ae':
if(!empty($_GET['id'])){
$id_net = $_GET['id'];
$API = new RouterosAPI();
$API->debug = false;
$API->connect($_IPMK, $_USMK, _de(ltrim($_PSMK, __CMS)));
$mikmosLoad =  $API->comm("/ip/hotspot/walled-garden/print", array("?.id" => "$id_net"));
$mikmosLoads = $mikmosLoad[0];
}else{
$id_net = '';
}
if(isset($_POST['save'])){
$action = ($_POST['action']);
$dsthost = ($_POST['dsthost']);
$dstport = ($_POST['dstport']);
$disabled = ($_POST['disabled']);
$API->comm("/ip/hotspot/walled-garden/add", array(
"action" => "$action",
"dst-host" => "$dsthost",
"dst-port" => "$dstport",
"disabled" => "$disabled",
));
echo "<script>window.location='./?load=walled_garden'</script>";
}
if(isset($_POST['edit'])){
$action = ($_POST['action']);
$dsthost = ($_POST['dsthost']);
$dstport = ($_POST['dstport']);
$disabled = ($_POST['disabled']);
$API->comm("/ip/hotspot/walled-garden/set", array(
".id" => "$id_net",
"action" => "$action",
"dst-host" => "$dsthost",
"dst-port" => "$dstport",
"disabled" => "$disabled",
));
echo "<script>window.location='./?load=walled_garden'</script>";
}
$srvlist = $API->comm("/ip/hotspot/print");
?>
<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong><?php echo __WALLED_GARDEN;?></strong><?php if(!empty($id_net)){ echo " | ".__EDIT." id => ".$id_net;};?>
<span class="tools pull-right">
</span>
</header>
<div class="panel-body">
<div class="row">
<div class="col-md-7">
<form autocomplete="off" method="post" action="">
<table class="table">
<tr>
<td>Actions</td><td>
<div class="radio">
<label>
<input required value="allow" name="action" <?php if($mikmosLoads['action']=='allow'){echo'checked';}?> type="radio">
Allow
</label>&nbsp&nbsp&nbsp&nbsp&nbsp
<label>
<input required value="deny" name="action" <?php if($mikmosLoads['action']=='deny'){echo'checked';}?> type="radio">
Deny
</label>
</div>
</td>
</tr>
<tr>
<td>Dst. Host</td><td><input class="form-control" type="text" size="4" autocomplete="off" name="dsthost" value="<?php echo $mikmosLoads['dst-host'];?>" autofocus></td>
</tr>
<tr>
<td>Dst. Port</td><td><input class="form-control" type="text" name="dstport" autocomplete="off" value="<?php echo $mikmosLoads['dst-port'];?>" placeholder="0"></td>
</tr>
<tr>
<td>Enabled</td><td>
<select class="form-control" name="disabled">
<option <?php if($mikmosLoads['disabled']=='false'){echo'selected';}?> value="false"><?php echo __ENABLE;?></option>
<option <?php if($mikmosLoads['disabled']=='true'){echo'selected';}?> value="trus"><?php echo __DISABLE;?></option>
</select>
</td>
</tr>
<tr>
<td></td><td>
<div>
<a class="btn btn-warning" href="./?load=walled_garden"> <i class="fa fa-close btn-mrg"></i> Close</a>
<?php 
if(empty($_GET['id'])){ ?>
<button type="submit" name="save" class="btn btn-primary btn-mrg" ><i class="fa fa-save btn-mrg"></i> Save</button>
<?php }else{ ?>
<button type="submit" name="edit" class="btn btn-primary btn-mrg" ><i class="fa fa-edit btn-mrg"></i> Edit</button>
<?php } ?>
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
<?php
break;
case'dis':
$idget = $_GET['id'];
$dget = $_GET['d'];
$API->comm("/ip/hotspot/walled-garden/set", array(
".id"=> "$idget",
"disabled"=> "$dget"));
_e('<script>window.history.go(-1)</script>');
break;
case'actions':
$idget = $_GET['id'];
$actionget = $_GET['action'];
$API->comm("/ip/hotspot/walled-garden/set", array(
".id"=> "$idget",
"action"=> "$actionget"));
_e('<script>window.history.go(-1)</script>');
break;
case'del':
$idget = $_GET['id'];
$API->comm("/ip/hotspot/walled-garden/remove", array(
".id"=> "$idget",));
_e('<script>window.history.go(-1)</script>');
break;
}
?>