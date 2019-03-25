<?php
$_MBS='Mikmos_Blok_Situs';
switch($_GET['get']){
default:
$mikmosLoadS = $API->comm("/ip/firewall/filter/print", array("?comment"=> "$_MBS"));
$mikmosS = $mikmosLoadS[0];
$mikmosLoadL = $API->comm("/ip/firewall/layer7-protocol/print", array("?comment" => "$_MBS"));
$mikmosL = $mikmosLoadL[0];
?>

<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong>Mikmos Blok Situs</strong>
</header>

<div class="panel-body">
<?php //print_r($mikmosS);?>
<p class="text-muted">
<?php if(($mikmosS['disabled']=='false') or ($mikmosS['comment']==$_MBS)){ ?>
<a onclick="return confirm('Anda yakin untuk menghapus?')" title="[BEM] Hapus" class="btn btn-danger" href="./?load=blok&get=del&id1=<?php echo $mikmosS['.id'];?>&id2=<?php echo $mikmosL['.id'];?>"> <i class="fa fa-trash"></i> [MBS] HAPUS</a>
<a title="List Situs/Website yang di Blok" class="btn btn-primary" href="./?load=blok&get=list"> <i class="fa fa-edit"></i> LIST DOMAIN</a>
<?php }else{ ?> 
<a title="[MBS] Tambahkan" class="btn btn-primary" href="./?load=blok&get=ae"> <i class="fa fa-edit"></i> [MBS] TAMBAHKAN</a>
<?php  } ?> 
</p><hr>
<div class="row">
<div class="col-md-6">

<div class="card p-20" style="background-color:<?php if(!empty($mikmosS['disabled']=='false')){ ?>#ef5350<?php }else{ ?>#34a853<?php } ?>"><div class="media widget-ten"><div class="media-left meida media-middle"><span class="color-white"><i class="fa fa-ban f-s-50"></i></span></div>
<div class="media-body media-text-right">
<h2 class="color-white">Status MBS</h2>
<?php if(!empty($mikmosS['disabled']=='false')){ ?>
<a class="btn btn-info btn-sm" title="Klik untuk meNon-Aktifkan" href="./?load=blok&get=disabled&id=<?php echo $mikmosS['.id'];?>"><p class="m-b-0 color-white"><i class="fa fa-check"></i> AKTIF</p></a>
<?php }else{ ?>
<a class="btn btn-warning btn-sm" title="Klik untuk mengAktifkan" href="./?load=blok&get=enabled&id=<?php echo $mikmosS['.id'];?>"><p class="m-b-0 color-white"><i class="fa fa-strip"></i> TIDAK AKTIF</p></a>
<?php }?>
</div>
</div>
</div>
<div class="card p-20" style="background-color:#EDCF9D"><div class="media widget-ten"><div class="media-left meida media-middle"><span class="color-white"><i class="fa fa-exclamation-triangle f-s-40"></i></span></div>
<div class="media-body media-text-right">
<h2 class="color-white">List Situs Terblok</h2>
<?php if(($mikmosL['comment']==$_MBS)){ ?>
<p class="m-b-0 color-white"><?php echo MBS_gapunyaideya1($_SESSION['router'],$_MBS);?></p>
<?php }else{ ?>
<span class="btn btn-warning btn-sm"><p class="m-b-0 color-white"><i class="fa fa-strip"></i> Belum ada</p></span>
<?php }?>
</div>
</div>
</div>
</div>
<div class="col-md-6">
<p>
<strong>[MBS] Mikmos Blok Situs</strong> ini adalah paket Blok situs menggunakan Layer 7 Protocols (L7P) & Firewall Filter.
</p>
<p><strong>INFO</strong></p>
<p>
<strong>Status Blok Situs</strong> warna merah menunjukkan status Aktif, jika warna hijau maka Tidak Aktif, status ini bekerja di IP - Firewall - Filter
</p>
<p>
<strong>List Situs Terblok</strong> List situs yang di Blok, list tersebut menyesuaikan dengan Status [MBS] Mikmos Blok Situs (sesuai dengan statusnya)
</p>
</div>
</div>
</div>

</div>
</div>
</div>
<?php
break;
case'list':
$mikmosLoad = $API->comm("/ip/firewall/layer7-protocol/getall", array("?comment" => "$_MBS"));
$mikmosTot = count($mikmosLoad);

$loadLyr7 = $mikmosLoad[0];
$getRegExp = $loadLyr7['regexp'];
$getRtypes = substr($getRegExp,4,-4);
$getReg = explode("|",$getRtypes);
$mikmosTotx = count($getReg);
?>
<div id="reloadNetwacthx">

<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong>LIST <?php echo __BLOK;?></strong> | <span class="text-danger"><?php if($mikmosTotx < 2 ){echo "$mikmosTotx"; }elseif($mikmosTotx > 1){echo "$mikmosTotx";}?></span> items
<span class="tools pull-right"> </span>
</header>
<div class="panel-body">
<p class="text-muted">
<a class="btn btn-success" href="./?load=blok&get=list&get=ae&id=<?php echo $loadLyr7['.id'];?>"> <i class="fa fa-plus"></i> <?php echo __ADD;?> / <?php echo __EDIT;?> List Domain</a>
</p><hr>
<?php //print_r($mikmosLoad);?>
<div class="table-responsive">
<div class="adv-table">
<div class="table-responsive">
 <table class="table table-bordered table-hover text-nowrap" id="mikmos-tbl-noinfo">
 <thead>
<tr> 
<th class="text-center" style="width:70px;"></th>
<th>Host</th>
<th>Lihat</th>
</tr>
</thead>

<tbody>
<?php
for ($i=0; $i<$mikmosTotx; $i++){
	$mikmosData = $mikmosLoad[$i];
	
?>
<tr>
<td class="align-middle">
<?php if($mikmosData['disabled']=='false'){?>
<a onclick="return confirm('Yakin untuk menonaktifkan?')" title="Non Aktifkan" href="./?load=blok&get=disabled&id=<?php echo $mikmosData['.id'];?>" class="btn btn-info btn-xs"><i class='fa fa-unlock '></i></a> <?php }else{ ?><a title="BLOK" href="./?load=blok&get=enabled&id=<?php echo $mikmosData['.id'];?>" class="btn btn-danger btn-xs"><i class='fa fa-ban '></i></a> <?php } ?> </td>
<td><?php echo $getReg[$i];?></td>
<td><a href="http://<?php echo $getReg[$i];?>" target="_blank">Lihat >></a></td>
</tr>
<?php
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
</div>
<script type="text/javascript">
setTimeout(function(){
 window.location.reload(1);
}, 50000);
</script>
<?php
break;
case'ae':
if(empty($_GET['id'])){
$id_net = '';
$submitnm = 'save';
$submitnmx = __SAVE;
}else{
$id_net = $_GET['id'];
$mikmosLoad =$API->comm("/ip/firewall/layer7-protocol/print", array("?.id" => "$id_net"));
$mikmosLoads = $mikmosLoad[0];
$submitnm = 'edit';
$submitnmx = __EDIT;
}
if(isset($_POST['save'])){
$situsx = ($_POST['situsblok']);$situsy=@implode('|',$situsx);
$situs= "^.+(".$situsy.").*$";
$API->comm("/ip/firewall/layer7-protocol/add", array(
"name" => "$_MBS",
"comment" => "$_MBS",
"regexp" => "$situs",
));
$API->comm("/ip/firewall/filter/add", array(
"chain" => "forward ",
"action" => "drop",
"layer7-protocol" => $_MBS,
"disabled" => "false",
"comment" => $_MBS,
));
echo "<script>window.location='./?load=blok'</script>";
}


if(isset($_POST['edit'])){
$situsx = ($_POST['situsblok']);$situsy=@implode('|',$situsx);
$situs= "^.+(".$situsy.").*$";
$API->comm("/ip/firewall/layer7-protocol/set", array(
".id"=> "$id_net",
"regexp" => "$situs",
));
echo "<script>window.location='./?load=blok'</script>";
}

?>
<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong><?php echo __BLOK;?></strong></i>
</header>
<div class="panel-body">

<form name="form" autocomplete="off" method="post" action="">
<p class="text-muted">
<a class="btn btn-warning" href="./?load=blok"> <i class="fa fa-close btn-mrg"></i> <?php echo __CANCEL;?></a>
<button type="submit" name="<?php echo $submitnm;?>" class="btn btn-primary btn-mrg" ><i class="fa fa-save btn-mrg"></i> <?php echo $submitnmx;?></button>
</p><hr>
<div class="row">
<div class="col-md-7">
<table class="table">
<tr>
<td width="30%">Situs/Website </td><td>
<select style="overflow:hidden;height:100px;width:100%;" data-placeholder="domain.com" name="situsblok[]" id="chosen-tags" multiple/>
<?php
if(empty($_GET['id'])){
echo MBS_gapunyaideya2($_SESSION['router']);
}else{ 
echo MBS_gapunyaideya3($_SESSION['router'],$id_net);
echo MBS_gapunyaideya2($_SESSION['router']);
}
?>
</select>
<i>Ketik nama domain yang akan di Blok</i>
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
  <p><b>Blok Situs/Website</b> - Isikan nama domain situs yang akan di blok</p>
</td>
  </tr>
</table>
</div>
</div>
</div>
</form>
</div>
</div>
</div>
<?php
break;
case'disabled':
@session_start();
error_reporting(0);
$idget = $_GET['id'];
$API->comm("/ip/firewall/filter/set", array(
".id"=> $idget,
"disabled"=> "true",));
_e('<script>window.history.go(-1)</script>');
break;
case'enabled':
@session_start();
error_reporting(0);
$idget = $_GET['id'];
if(empty($idget)){
echo "<script>alert('MBS Belum ditambahkan');</script>";
echo "<script>window.location='./?load=blok'</script>";
}
$API->comm("/ip/firewall/filter/set", array(
".id"=> $idget,
"disabled"=> "false",));
_e('<script>window.history.go(-1)</script>');
break;
case'del':
@session_start();
error_reporting(0);
$id1 = $_GET['id1'];
$id2 = $_GET['id2'];
$API->comm("/ip/firewall/filter/remove", array(".id"=> "$id1",));
$API->comm("/ip/firewall/layer7-protocol/remove", array(".id"=> "$id2",));
_e('<script>window.history.go(-1)</script>');
break;
}
?>
