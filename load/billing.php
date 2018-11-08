<?php
switch($_GET['get']){
default:
$idhr = $_GET['idhr'];
$idbl = $_GET['idbl'];
$remdata = ($_POST['remdata']);
if(isset($remdata)){
if(strlen($idhr) > "0"){
if($_SESSION['connect']=='connect') {
$API->write('/system/script/print', false);
$API->write('?source='.$idhr.'', false);
$API->write('=.proplist=.id');
$ARREMD = $API->read();
for ($i=0;$i<count($ARREMD);$i++) {
$API->write('/system/script/remove', false);
$API->write('=.id=' . $ARREMD[$i]['.id']);
$READ = $API->read();
}}
}elseif(strlen($idbl) > "0"){
if($_SESSION['connect']=='connect') {
$API->write('/system/script/print', false);
$API->write('?owner='.$idbl.'', false);
$API->write('=.proplist=.id');
$ARREMD = $API->read();
for ($i=0;$i<count($ARREMD);$i++) {
$API->write('/system/script/remove', false);
$API->write('=.id=' . $ARREMD[$i]['.id']);
$READ = $API->read();
}}}
echo Loading('./?load=billing','0');
}
if(strlen($idhr) > "0"){
if($_SESSION['connect']=='connect') {
$API->write('/system/script/print', false);
$API->write('?=source='.$idhr.'');
$ARRAY = $API->read();
$API->disconnect();
}
$filedownload = $idhr;
$shf = "hidden";
$shd = "inline-block";
}elseif(strlen($idbl) > "0"){
if($_SESSION['connect']=='connect') {
$API->write('/system/script/print', false);
$API->write('?=owner='.$idbl.'');
$ARRAY = $API->read();
$API->disconnect();
}
$filedownload = $idbl;
$shf = "hidden";
$shd = "inline-block";
}elseif($idhr == "" || $idbl == ""){
if($_SESSION['connect']=='connect') {
$API->write('/system/script/print', false);
$API->write('?=comment=MIKMOScms');
$ARRAY = $API->read();
$API->disconnect();
}
$filedownload = "all";
$shf = "text";
$shd = "none";
}
?>

<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong>Report <?php _e(__BILLING);?></strong>
<span class="pull-right">

<a class="btn bg-danger" href="./?load=billing&get=migreport" onclick="return confirm('Serius Mau Migrasi?...')" title="Migrasi sisa Report"><i class="fa fa-retweet"></i> Migrasi Billing Report</a>
</span>
</header>
<div class="panel-body">
<p class="text-muted">
<div style=""> 

<button class="btn bg-primary" onclick="exportTableToCSV('report-mikmos-<?php _e($filedownload);?>.csv')" title="Download selling report"><i class="fa fa-download"></i> CSV</button>

<button class="btn bg-primary" onclick="location.href='./?load=billing';" title="Reload all data"><i class="fa fa-search"></i>Reload ALL</button>


<form style="display: <?php _e($shd);?>;" autocomplete="off" method="post" action="">
<center>

<button style="display: <?php _e($shd);?>;" name="remdata" class="btn bg-danger" onclick="return confirm('Anda yakin untuk menhapusnya ?...')" title="Delete Data <?php _e($filedownload);?>"><i class="fa fa-remove"></i> Delete data <?php _e($filedownload);?></button>
</center>
</form>

<div style="padding-top: 5px;">
<?php
$ntgl=date("d");
$nbulan=date("n");
$nbulanan=array(1=>'01','02','03','04','05','06','07','08','09','10','11','12');
$nthn=date("Y");

$ibln =array(1=>"Januari","Februari","Maret","April","Mei", "Juni","Juli","Agustus","September","Oktober", "November","Desember"); 
$ibln1 =array(1=>"jan","feb","mar","apr","may", "jun","jul","aug","sep","okt", "nov","des"); 
echo '<select style="padding:7.5px;" id="sday">
<option value="" >Semua</option>'; 
for($itgl=1; $itgl<=31; $itgl++){ 
$tgl_leng=strlen($itgl); 
if ($tgl_leng==1) $i="0".$itgl; 
else $i=$itgl;
if($i==$ntgl){ echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';}else{ echo '<option value="'.$i.'" >'.$i.'</option>';}
} 
echo "</select>"; 
echo "  "; 
echo '<select style="padding:7.5px;" id="smonth">'; 
for($ibul=1; $ibul<=12; $ibul++){ 
$ibul_leng=strlen($ibul); 
if ($ibul_leng==1) $ib="0".$ibul; 
else $ib=$ibul; 
if($ib==$nbulanan[$nbulan]){ echo '<option value="'.$ibln1[$ibul].'" selected="selected">'.$ibln[$ibul].'</option>';}else{ echo '<option value="'.$ibln1[$ibul].'" >'.$ibln[$ibul].'</option>';}
} 
echo '</select>'; 
echo "  "; 
echo '<select style="padding:7.5px;" id="syear">'; 
for($ithn=2018; $ithn<=$nthn; $ithn++){ 
if($ithn==$nthn){ echo '<option value="'.$ithn.'" selected="selected">'.$ithn.'</option>';}else{ echo '<option value="'.$ithn.'">'.$ithn.'</option>';}
}
echo '</select> ';
?>
<input class="btn bg-primary" type="button" value=" Cari " name="sbutton" onclick="javascript:var x = $('#sday').val();var y = $('#smonth').val();var z = $('#syear').val(); if (x && y && z){document.location = '?load=billing&idhr='+y+'/'+x+'/'+z;}else{document.location = '?load=billing&idbl='+y+''+z;}"/>

</div>
</div>

</p><hr>
<p>
Jika Report Kosong, karna sebelumnya menggunakan aplikasi lain, silahkan klik tombol MIGRASI BILLING REPORT untuk menampilkannya.
</p>

<div class="table-responsive">
<div class="">

 <table class="table table-bordered table-hover text-nowrap" id="mikmos-tbl-desc">
<thead>
<tr>
<th colspan="2">Billing report <?php _e($filedownload);?><b style="font-size:0;">,</b></th>
<th style="text-align:right;">Total</th>
<th style="text-align:right;font-weight:bold;" id="total"></th>
</tr>
<tr>
<th>Waktu</th>
<th>Tanggal</th>
<th class="no-sort">Username / Vouchers</th>
<th class="no-sort" style="text-align:right;">Penjualan <?php _e($curency);?></th>
</tr>
</thead>
<tbody>
<?php
$TotalReg = count($ARRAY);
for ($i=0; $i<$TotalReg; $i++){
$regtable = $ARRAY[$i];
$getname = explode("-|-",$regtable['name']);
$getowner = $regtable['owner'];
$tgl = $getname[0];
$getdy = explode("/",$tgl);
$m = $getdy[0];
$dy = $m."/".$getdy[1]."/".$getdy[2];
$ltime = $getname[1];
$username = $getname[2];
$price = $getname[3];
?>
<tr>
<td><?php _e($ltime);?></td>
<td><?php _e($dy);?></td>
<td><?php _e($username);?></td>
<td style='text-align:right;'><?php _e($price);?></td>
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
<script>
function downloadCSV(csv, filename) {
var csvFile;
var downloadLink;
csvFile = new Blob([csv], {type: "text/csv"});
downloadLink = document.createElement("a");
downloadLink.download = filename;
downloadLink.href = window.URL.createObjectURL(csvFile);
downloadLink.style.display = "none";
document.body.appendChild(downloadLink);
downloadLink.click();
}

function exportTableToCSV(filename) {
var csv = [];
var rows = document.querySelectorAll("#billing tr");

 for (var i = 0; i < rows.length; i++) {
var row = [], cols = rows[i].querySelectorAll("td, th");
 for (var j = 0; j < cols.length; j++)
row.push(cols[j].innerText);
csv.push(row.join(","));
}
downloadCSV(csv.join("\n"), filename);
}

window.onload=function() {
var sum = 0;
var dataTable = document.getElementById("billing");
var cells = document.querySelectorAll("td + td + td + td");
for (var i = 0; i < cells.length; i++)
sum+=parseFloat(cells[i].firstChild.data);

var th = document.getElementById('total');
th.innerHTML = th.innerHTML + (sum) ;
}
</script>

<?php

break;
case'migreport':
$mikmosLoad = $API->comm("/system/script/print", array("?comment" => "mikhmon"));
$mikmosTot = count($mikmosLoad);
for ($i=0; $i<$mikmosTot; $i++){
$mikmosView = $mikmosLoad[$i];
$idget = $mikmosView['.id'];
$MIKMOSCMS = 'MIKMOScms';
$API->comm("/system/script/set", array(".id" => "$idget", "comment" => "$MIKMOSCMS"));
}
_e('<script>window.history.go(-1)</script>');
break;
}
?>
