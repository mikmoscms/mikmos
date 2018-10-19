<?php
error_reporting(0);
switch($_GET['get']){
default:
?>
<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong><?php _e(__VOUCHERS_STYLE);?></strong>
<span class="tools pull-right"></span>
</header>
<div class="panel-body">
<p class="text-muted">
<a class="btn btn-success" href="./?index=vouchers_style&get=ae"> <i class="fa fa-plus"></i> <?php _e(__ADD);?></a>
<a target="_blank" class="btn btn-info" href="<?php _e("https://mikmos.my.id/?load=voucher");?>"> <i class="fa fa-download"></i> <?php _e(__VOUCHERS_STYLE);?></a>
</p><hr>
<?php //print_r($mikmosLoad));?>
<div class="table-responsive">
<div class="adv-table">
<table class="table table-bordered table-hover" id="mikmos-tbl-noinfo">
<thead>
<tr>
<th width="150px"></th>
<th>Nama Style Voucher</th>
</tr>
</thead>
<tbody>

<?php
$rep=opendir('./vouchers/styles/');
while ($file = readdir($rep)) {
if($file != '..' && $file !='.' && $file !=''){
if ($file !='index.php' && $file !='index.html' && $file !='.htaccess'){
if(!is_dir($file)){ 
if((substr($file, 0, -4)=="DEFAULT") or (substr($file, 0, -4)=="ORANGE")){?>
<tr>
<td class="text-center">
<a href="#" title="Remove" onclick="return confirm('Tidak bisa di Hapus')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
<a href="#" title="Edit" onclick="return confirm('Tidak bisa di Perbaharui')" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
<a onclick="window.open('./vouchers/views.php?id=demo&styles=<?php _e(substr($file, 0, -4));?>&pilihan=up&qrcode=qr', 'newwindow', 'width=300,height=250'); return false;" title="Lihat Voucher" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a>
</td>
<td><?php _e(substr($file, 0, -4));?></td>
</tr>
<?php }else{ ?>
<tr>
<td class="text-center">
<a href="./?index=vouchers_style&get=del&style=<?php _e(substr($file, 0, -4));?>" title="Remove" onclick="return confirm('Hapus: Anda yakin?')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
<a href="./?index=vouchers_style&get=ae&style=<?php _e(substr($file, 0, -4));?>" title="Edit" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
<a onclick="window.open('./vouchers/views.php?id=demo&styles=<?php _e(substr($file, 0, -4));?>&pilihan=up&qrcode=qr', 'newwindow', 'width=300,height=250'); return false;" title="Lihat Voucher" class="btn btn-info btn-xs"><i class="fa fa-eye"></i></a></td>
<td><?php _e(substr($file, 0, -4));?></td>
</tr>
<?php }}}}} ?>
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
if(!empty($_GET['style'])){
$id_net = $_GET['style'];
$styles_vo = "./vouchers/styles/".$_GET['style'].".php";
}else{
$id_net = '';
}
if(isset($_POST['save'])){
 $name1 = strtoupper(ganti_spasi($_POST['name1']));
 $name = strtoupper(ganti_spasi($_POST['name']));
 $editor = $_POST['editor'];
$my_file = './vouchers/styles/'.$name.'.php';
$handle = fopen($my_file, 'w') or die('Cannot open file: '.$my_file);
$data = $editor;
fwrite($handle, $data);
chmod($my_file,0755);
echo Loading('./?index=vouchers_style','1','Loading...');
echo '<style>.panel-body{display:none;}</dstyle>';
}
if(isset($_POST['edit'])){
 $name1 = strtoupper(ganti_spasi($_POST['name1']));
 $name = strtoupper(ganti_spasi($_POST['name']));
 $editor = $_POST['editor'];
$my_file_d = './vouchers/styles/'.$name1.'.php';
unlink($my_file_d);
$my_file = './vouchers/styles/'.$name.'.php';
$handle = fopen($my_file, 'w') or die('Cannot open file: '.$my_file);
$data = $editor;
fwrite($handle, $data);
chmod($my_file,0755);
echo Loading('./?index=vouchers_style','1','Loading...');
echo '<style>.panel-body{display:none;}</dstyle>';
}
?>
<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong><?php _e(__VOUCHERS_STYLE);?></strong></i>
</header>
<div class="panel-body">
<div class="row">
<div class="col-md-8">
<form autocomplete="off" method="post" action="">
<table class="table">
<tr>
<td width="120px">Nama Voucher</td><td><input class="form-control" type="text" size="4" autocomplete="off" name="name" value="<?php _e($id_net);?>" placeholder="VOUCHERKU" required="1">
 <?php if(!empty($id_net)){ ?> <input class="form-control" type="hidden" name="name1" value="<?php _e($id_net);?>"/><?php } ?></td>
<td width="200px">
<div>
<a class="btn btn-warning" href="./?index=vouchers_style"> <i class="fa fa-close btn-mrg"></i> Close</a>
<?php if(!empty($_GET['style'])){?>
<button type="submit" name="edit" class="btn btn-primary btn-mrg" ><i class="fa fa-save btn-mrg"></i> Edit</button>
<?php }else{?>
<button type="submit" name="save" class="btn btn-primary btn-mrg" ><i class="fa fa-save btn-mrg"></i> Save</button>
<?php }?>
</div></td>
</tr>
<tr>
<td colspan="3">
<textarea id="editor" name="editor" style="width:100%" rows=20><?php _e(file_get_contents($styles_vo));?></textarea>
</td>
</tr>
<tr>
<td></td><td>

</td>
</tr>
</table>
</form>
</div>
<div class="col-md-4">
<table class="table">
<tr>
<td>Variable</td>
</tr>
<tr>
<td>
<textarea readonly rows=20 style="width:100%" ><?php _e(file_get_contents ('./vouchers/variable.php'));?></textarea>
</td>
</tr>
</table>
</div>
</div>
</div>
</div>
</div>
<?php
break;
case'del':
$style = $_GET['style'];
$my_file = './vouchers/styles/'.$style.'.php';
unlink($my_file);
echo Loading('./?index=vouchers_style','0');
break;
}
?>
