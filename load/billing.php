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
<span class="tools pull-right">
<a class="btn bg-danger" href="./?load=billing&get=migreport" onclick="return confirm('Migrasi Billing Report?...')" title="Migrasi sisa Report"><i class="fa fa-retweet"></i> Migrasi Billing Report</a>
</span>
</header>
<div class="panel-body">
<p>

<div style="display: table;">
<div style="padding-bottom: 5px; padding-top: 5px;"> 
<button class="btn bg-primary" onclick="exportTableToCSV('report-mikmos-<?php _e($filedownload);?>.csv')" title="Download selling report"><i class="fa fa-download"></i> CSV</button>
<button class="btn bg-primary" onclick="location.href='./?load=billing';" title="Reload all data"><i class="fa fa-search"></i> ALL</button>


<form style="display: <?php _e($shd);?>;" autocomplete="off" method="post" action="">
<center>

<button style="display: <?php _e($shd);?>;" name="remdata" class="btn bg-danger" onclick="return confirm('Anda yakin untuk menhapusnya ?...')" title="Delete Data <?php _e($filedownload);?>"><i class="fa fa-remove"></i> Delete data <?php _e($filedownload);?></button>
</center>
</form>

</div>
</div>

</p>
<hr>
<div class="table-responsive">
<div class="adv-table">

 <table class="table table-bordered table-hover text-nowrap" id="mikmos-tbl-desc">
<thead class="thead-light">
<tr>
<th colspan=3 >Billing report <?php _e($filedownload);?><b style="font-size:0;">,</b></th>
<th style="text-align:right;">Total</th>
<th style="text-align:right;font-weight:bold;" id="total"></th>
</tr>
<tr>
<th >Bulan</th>
<th >Date</th>
<th >Time</th>
<th class="no-sort">Username</th>
<th class="no-sort" style="text-align:right;">Price <?php _e($curency);?></th>
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
<td><strong><a href='./?load=billing&idbl=<?php _e($getowner);?>' title='Lihat Bulan : <?php _e($getowner);?>'><i class='fa fa-search'></i> <?php _e($m);?></a></strong></td>
<td><strong><a href='./?load=billing&idhr=<?php _e($tgl);?>' title='Lihat Tanggal : <?php _e($tgl);?>'><i class='fa fa-search'></i> <?php _e($dy);?></a></strong></td>
<td><?php _e($ltime);?></td>
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
var rows = document.querySelectorAll("#selling tr");

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
var dataTable = document.getElementById("selling");
var cells = document.querySelectorAll("td + td + td + td + td");
for (var i = 0; i < cells.length; i++)
sum+=parseFloat(cells[i].firstChild.data);

var th = document.getElementById('total');
th.innerHTML = th.innerHTML + (sum) ;
}
</script>
<script>
function fTgl() {
var input, filter, table, tr, td, i;
input = document.getElementById("filterData");
filter = input.value.toUpperCase();
table = document.getElementById("selling");
tr = table.getElementsByTagName("tr");
for (i = 1; i < tr.length; i++) {
td = tr[i].getElementsByTagName("td")[0];
if (td) {
if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
tr[i].style.display = "";
} else {
tr[i].style.display = "none";
}
}
}
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
echo Loading('./?load=billing','0');
break;
}
?>
