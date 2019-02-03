<?php
switch($_GET['get']) {
default:
@session_start();
error_reporting(0);
ini_set('max_execution_time', 300);
include './lib/PHPExcel/IOFactory.php';
$mikmosLoadS = $API->comm("/ip/hotspot/print");
$mikmosLoadP = $API->comm("/ip/hotspot/user/profile/print");
if(isset($_POST['import'])){	
foreach($_FILES['data_import']['name'] as $key => $val){
$inputFileName = basename($_FILES['data_import']['name'][$key]) ;
move_uploaded_file($_FILES['data_import']['tmp_name'][$key], $inputFileName);
try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}
$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true ,true);
$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet
$server = ($_POST['server']);
$profile = ($_POST['profile']);
$timelimit = ($_POST['timelimit']);
$datalimit = ($_POST['datalimit']);
$adcomment = ($_POST['adcomment']);
$mbgb = ($_POST['mbgb']);
if($timelimit == ""){$timelimit = "0";}else{$timelimit = $timelimit;}
if($datalimit == ""){$datalimit = "0";}else{$datalimit = $datalimit*$mbgb;}
if($adcomment == ""){$adcomment = "";}else{$adcomment = "-".$adcomment;}

$commt = "up-import-" . date("d.m.y") . "" .$adcomment;
  
	$numrow = 1;
      foreach($allDataInSheet as $row){
        $aa = $row['A']; 
        $bb = $row['B']; 
        
        if(empty($aa) && empty($bb))
          continue; 
        
        if($numrow > 1){
		$API->comm("/ip/hotspot/user/add", array(
		"server" => "$server",
		"name" => "$aa",
		"password" => "$bb",
		"profile" => "$profile",
		"limit-uptime" => "$timelimit",
		"limit-bytes-total" => "$datalimit",
		"comment" => "$commt",
		));
        }
        
    $numrow++; 
      }
	unlink($inputFileName);
}
_e('<script>window.location="./?load=users_import&import='.$commt.'&prof='.$profile.'"</script>');
}
?>
<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong><?php echo __IMPORT;?> Excel</strong>
<span class="tools pull-right">
 </span>
</header>
<?php if(!empty($_GET['import'])){ 
 $gpname = $_GET['prof'];
 $mikmosLoad = $API->comm("/ip/hotspot/user/profile/print", array(
 "?name" => "$gpname"));
 $mikmosView = $mikmosLoad[0];
 ?>
<div class="panel-body">
<strong>Berhasil <?php echo __IMPORT;?> Excel Vouchers: <span style="color:red"><?php echo $_GET['import'];?></span></strong>
<form target="_blank" action="./vouchers/vouchers.php" method="get">
<input class="form-control" name="id" value="<?php echo $mikmosView['.id'];?>" type="hidden">
<input class="form-control" name="vouchers" value="<?php echo $_GET['import'];?>" type="hidden">
<hr>
<div class="row">
<div class="col-md-7">
<p class="text-muted">
<a class="btn btn-danger" href="./?load=users"> <i class="fa fa-arrow-left"></i> <?php echo __BACK;?></a>
<a class="btn btn-primary" href="./?load=users_import"> <i class="fa fa-ticket"></i> <?php echo __IMPORT;?> Excel Lagi</a>
</p>
<table class="table">
 <tr>
 <td class="align-middle">Style Voucher</td><td>
 <select class="form-control" name="styles" required="1">
 <?php
$rep=opendir('./vouchers/styles/');
while ($file = readdir($rep)) {
if($file != '..' && $file !='.' && $file !=''){
if ($file !='index.php' && $file !='index.html' && $file !='.htaccess'){
if(!is_dir($file)){?>
<option style="text-transform:uppercase" value="<?php echo substr($file,0, -4);?>"><?php echo substr($file, 0, -4);?></option>
<?php }}}} ?>
 </select>
 </td>
 </tr>
 <tr>
 <td class="align-middle">Pilihan</td><td>
 <select class="form-control" name="pilihan" required="1">
<option style="text-transform:uppercase" value="up">Username & Password</option>
<option style="text-transform:uppercase" value="vc">Username = Password</option>
 </select>
 <input class="form-control" name="qrcode" value="qr" type="hidden">
 </td>
 </tr>
 <tr>
 <td></td><td>
 <div>
 <button type="submit" name="submit" class="btn btn-primary btn-mrg" ><i class="fa fa-print btn-mrg"></i> Cetak Hasil Import Excel</button>
 </div>
 </td>
 </tr>
 <tr>
 <td></td><td>
 <div>
<a class="btn btn-success" href="./?load=users&comment=<?php echo $_GET['import'];?>&prof=<?php echo $_GET['prof'];?>"> <i class="fa fa-check"></i> Lihat Hasil Import Excel</a>
 </div>
 </td>
 </tr>
</table>
</div>

<div class="col-md-5">

</div>
</div>

</form>
</div>

<?php }else { ?>

<div class="panel-body">
<form name="myForm" id="myForm" onSubmit="return validateForm()" action="" method="post" enctype="multipart/form-data">
<hr>
<div class="row">
<div class="col-md-7">
<p class="text-muted">
<a class="btn btn-danger" href="./?load=users"> <i class="fa fa-close"></i> Batal</a>
<button type="submit" class="btn bg-primary" name="import"><i class="fa fa-file-excel-o"></i> Import Excel</button>

</p>
<table class="table">
<tr>
<td class="align-middle">Server</td>
<td>
<select class="form-control " name="server" required="1">
<option>all</option>
<?php $mikmosTot = count($mikmosLoadS);
for ($i=0; $i<$mikmosTot; $i++){
echo "<option>" . $mikmosLoadS[$i]['name'] . "</option>";
}
?>
</select>
</td>
</tr>
<tr>
<td class="align-middle">Import Excel</td><td><input class="form-control " type="file" id="data_import" name="data_import[]" multiple required >
</td>
</tr>

<tr>
<td class="align-top">Profil Users</td><td>
<select class="form-control" onchange="GetVP();" id="uprof" name="profile">
<option value="">=== Pilih Profil Users ===</option>
<?php 
$mikmosTot = count($mikmosLoadP);
for ($i=0; $i<$mikmosTot; $i++){
  $ponlogin = $mikmosLoadP[$i]['on-login'];
  $gettime = explode(",",$ponlogin)[5];
  if(empty($gettime)){
	  $gettime1 = explode(",",$ponlogin)[3];
	  }else{
	  $gettime1 = $gettime;
	  }
?>
<option onClick="form.timelimit.value='<?php echo $gettime1;?>'" value="<?php echo $mikmosLoadP[$i]['name'];?>"><?php echo $mikmosLoadP[$i]['name'];?></option>
<?php } ?>
</select>
<div id="GetValidPrice"></div>
</td>
</tr>

<tr>
<td class="align-middle">Total Data Limit</td><td>

<div class="row">
<div class="col-md-9">
<input class="form-control" type="number" min="0" max="9999" name="datalimit" value="">
</div>
<div class="col-md-3">
<select class="form-control" name="mbgb" required="1">
<option value=1000000>MB</option>
<option value=1000000000>GB</option>
</select>
</div>
</div>


</td>
</tr>
<tr>
<td class="align-middle">Comment</td><td><input class="form-control " type="text" title="No special characters" id="comment" autocomplete="off" name="adcomment" value=""></td>
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

  <p>Import Excel ini  adalah untuk mengupload data username/password kostum, ini bisa digunakan oleh sekolah atau lainnya sesuai kebutuhan</p>
  <p>Hanya file .XLSX (Excel 2007 Up) yang diijinkan.</p>
  <p><a target="_blank" class="btn btn-warning" href="https://drive.google.com/file/d/15dapzXs7qhuYn0ijhTsSPcMnrmMnrxOb/view?usp=sharing"> <i class="fa fa-file-excel-o"></i> Download Contoh Files Excel</a></p>
<p>DEMO YOUTUBE</p>
<a class="btn btn-danger" href="https://www.youtube.com/watch?v=ygIf2hDPZvk"> <i class="fa fa-youtube"></i> Demo Excel</a>
<a class="btn btn-danger" href="https://www.youtube.com/watch?v=6eaeZQ11WVs"> <i class="fa fa-youtube"></i> Demo Dari Userman</a>


</div>
</div>
</div>
</form>
</div>
<script type="text/javascript">
    function validateForm()
    {
        function hasExtension(inputID, exts) {
            var fileName = document.getElementById(inputID).value;
            return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
        }

        if(!hasExtension('data_import', ['.xlsx'])){
            alert("Hanya file .XLSX (Excel 2007 Up) yang diijinkan.");
            return false;
        }
    }
</script>
<?php } ?>
</div>
</div>
<?php
break;
}
?>
