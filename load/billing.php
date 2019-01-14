<?php
switch($_GET['get']){
default:
$mikHRini = strtolower(date('M')).'/'.date('d').'/'.date('Y');
$mikBLini = strtolower(date('M')).''.date('Y');
//$mikbilBLN = $API->comm("/system/script/print");
$mikbilBLN = $API->comm("/system/script/print", array("?=owner" => $mikBLini));
$mikbilBLNtot = count($mikbilBLN);
for ($i=0; $i<$mikbilBLNtot; $i++){
$mikmosData = $mikbilBLN[$i];
$mikmoslits = explode("-|-",$mikmosData['name']);
$bilBLN += $mikmoslits[3];
}
$mikbilHR = $API->comm("/system/script/print", array("?=source" => $mikHRini));
$mikbilHRtot = count($mikbilHR);
for ($i=0; $i<$mikbilHRtot; $i++){
$mikmosData = $mikbilHR[$i];
$mikmoslits = explode("-|-",$mikmosData['name']);
$bilHR += $mikmoslits[3];
}
?>

<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong>Report <?php _e(__BILLING);?></strong>

<span class="pull-right">

<a class="btn bg-danger" href="./?load=billing&get=migreport" onclick="return confirm('Serius Mau Migrasi?...')" title="Migrasi sisa Report"><i class="fa fa-retweet"></i> Migrasi Billing Report</a>
</span>
</header>
<div class="panel-body">
<hr>
<p>
Jika ingin mendapatkan Repot Penjualan, maka di Setting di Profile Users -> Mode Expired -> Remove Record / Notice Record
</p>
<p>
Jika sudah di Setting di Profile Users dan Report Kosong, mungkin sebelumnya menggunakan aplikasi lain, silahkan klik tombol MIGRASI BILLING REPORT untuk menampilkannya.
</p>
<hr>
<div class="row">
<div class="col-sm-7">
<div class="adv-table">
<div class="table-responsive">
<div id="myDIV">
<div id="trafiknya" style="margin:0;padding:0!important;width:100%;height:300px;"></div>
</div>

</div>
</div>
</div>
<div class="col-sm-5">

<div class="p-20 m-b-10" style="background-color:#fa8564">
<div class="media widget-ten">
<div class="media-left meida media-middle">
<span class="color-white"><i class="fa fa-money f-s-60"></i></span>
</div>
<div class="media-body media-text-right">
<h3 class="color-white">Pendapatan</h3>
<small class="color-white"><?php _e(date('d M Y'));?></small><br/>
<strong class="color-white">Hari ini <?php echo rupiah($bilHR);?></strong><br/>
<strong class="color-white"><?php echo date('F');?> <?php echo rupiah($bilBLN);?></strong>
</div>
</div>
</div>

<a class="btn btn-primary" href="./?load=billing&get=listen"> Lihat Billing List <i class="fa fa-arrow-right"></i></a>
</div>
</div>


</div> 
</div> 
</div> 
</div> 
</div> 

<script type="text/javascript" src="assets/js/lib/highcharts/highcharts.js"></script>
<script type="text/javascript" src="assets/js/lib/highcharts/themes/mikmos.js"></script>

<script> 
function myFunction() {
    var x = document.getElementById("myDIV");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
Highcharts.chart('trafiknya', {

  title: {
    text: 'Grafik Billing Bulan <?php echo date('F');?> '
  },

  yAxis: {
    title: {
      text: 'Penjualan'
    }
  },
  xAxis: {
	categories: []
  },

  plotOptions: {
    series: {
      label: {
        connectorAllowed: false
      },
      pointStart: 01
    }
  },

  series: [{
    name: 'Penjualan',
    data: [

<?php
$datesnya = date('d')+1;
for ($i=1; $i<$datesnya; $i++){
$tgl_leng=strlen($i); 
if ($tgl_leng==1) $ix="0".$i;else $ix=$i;
$mikHRini = strtolower(date('M')).'/'.$ix.'/'.date('Y');
$pendptan = mikBillingHR($mikHRini);
if(!empty($pendptan)){
	$dpthari = $pendptan;
}else{
	$dpthari = 0;
}
?>
	['Tanggal <?php echo $ix;?>', <?php echo $dpthari;?>],
<?php } ?>
	]
  }],

  responsive: {
    rules: [{
      condition: {
        maxWidth: 500
      },
      chartOptions: {
        legend: {
          layout: 'horizontal',
          align: 'center',
          verticalAlign: 'bottom'
        }
      }
    }]
  }
});
</script>





<?php
break;
case'listen':

$pilhr = $_GET['pilhr'];
$pilbl = $_GET['pilbl'];
$mikhapus = ($_POST['mikhapus']);
if(isset($mikhapus)){
if(strlen($pilhr) > "0"){
if($_SESSION['connect']=='connect') {
$API->write('/system/script/print', false);
$API->write('?source='.$pilhr.'', false);
$API->write('=.proplist=.id');
$MIKREM = $API->read();
for ($i=0;$i<count($MIKREM);$i++) {
$API->write('/system/script/remove', false);
$API->write('=.id=' . $MIKREM[$i]['.id']);
$READ = $API->read();
}}
}elseif(strlen($pilbl) > "0"){
if($_SESSION['connect']=='connect') {
$API->write('/system/script/print', false);
$API->write('?owner='.$pilbl.'', false);
$API->write('=.proplist=.id');
$MIKREM = $API->read();
for ($i=0;$i<count($MIKREM);$i++) {
$API->write('/system/script/remove', false);
$API->write('=.id=' . $MIKREM[$i]['.id']);
$READ = $API->read();
}}}
_e('<script>window.history.go(-1)</script>');
}
if(strlen($pilhr) > "0"){
if($_SESSION['connect']=='connect') {
$API->write('/system/script/print', false);
$API->write('?=source='.$pilhr.'');
$ARRAY = $API->read();
$API->disconnect();
}
$mikDL = $pilhr;
$shf = "hidden";
$shd = "inline-block";
}elseif(strlen($pilbl) > "0"){
if($_SESSION['connect']=='connect') {
$API->write('/system/script/print', false);
$API->write('?=owner='.$pilbl.'');
$ARRAY = $API->read();
$API->disconnect();
}
$mikDL = $pilbl;
$shf = "hidden";
$shd = "inline-block";
}elseif($pilhr == "" || $pilbl == ""){
if($_SESSION['connect']=='connect') {
$API->write('/system/script/print', false);
$API->write('?=comment=MIKMOScms');
$ARRAY = $API->read();
$API->disconnect();
}
$mikDL = "all";
$shf = "text";
$shd = "none";
}
if($pilhr){$totolbil = rupiah(mikBillingHR($pilhr));}
elseif($pilbl){$totolbil = rupiah(mikBillingBL($pilbl));}
else{$totolbil = rupiah(mikBillingALL());}
?>

<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong>Report <?php _e(__BILLING);?> </strong>
</header>
<p>Disarankan untuk menghapus report perbulannya.</p>
<div class="panel-body"><hr>
<p class="text-muted">
<div style=""> 

<a class="btn bg-danger" href="./?load=billing"><i class="fa fa-arrow-left"></i> Billing</a>

<button class="btn bg-primary" onclick="exportTableToCSV('report-mikmos-<?php _e($mikDL);?>.csv')" title="Download selling report"><i class="fa fa-download"></i> CSV</button>

<button class="btn bg-primary" onclick="location.href='./?load=billing&get=listen';" title="Reload all data"><i class="fa fa-search"></i>Reload ALL</button>


<form style="display: <?php _e($shd);?>;" autocomplete="off" method="post" action="">
<center>

<button style="display: <?php _e($shd);?>;" name="mikhapus" class="btn bg-danger" onclick="return confirm('Anda yakin untuk menhapusnya ?...')" title="Delete Data <?php _e($mikDL);?>"><i class="fa fa-remove"></i> Delete data <?php _e($mikDL);?></button>
</center>
</form>

<div style="padding-top: 5px;">
<?php
$ntgl=date("d");
$nbulan=date("n");
$nbulanan=array(1=>'01','02','03','04','05','06','07','08','09','10','11','12');
$nthn=date("Y");
$tglnya = explode("/",$pilhr);
$ibln =array(1=>"Januari","Februari","Maret","April","Mei", "Juni","Juli","Agustus","September","Oktober", "November","Desember"); 
$ibln1 =array(1=>"jan","feb","mar","apr","may", "jun","jul","aug","sep","oct", "nov","dec"); 
echo '<select style="padding:7.5px;" id="sday">
<option value="" selected="selected">Semua</option>'; 
for($itgl=1; $itgl<=31; $itgl++){ 
$tgl_leng=strlen($itgl); 
if ($tgl_leng==1) $i="0".$itgl; 
else $i=$itgl;
if($i==$tglnya[1]){ echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';}else{ echo '<option value="'.$i.'" >'.$i.'</option>';}
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
<input class="btn bg-primary" type="button" value=" Cari " name="sbutton" onclick="javascript:var x = $('#sday').val();var y = $('#smonth').val();var z = $('#syear').val(); if (x && y && z){document.location = '?load=billing&get=listen&pilhr='+y+'/'+x+'/'+z;}else{document.location = '?load=billing&get=listen&pilbl='+y+''+z;}"/>

</div>
</div>

</p>

<div class="table-responsive">
<div class="">

 <table class="table table-bordered table-hover text-nowrap" id="mikmos-tbl-desc">
<thead>
<tr>
<th colspan="2">Billing report <?php _e($mikDL);?><b style="font-size:0;">,</b></th>
<th style="text-align:right;">Total</th>
<th style="text-align:right;font-weight:bold;"><?php echo $totolbil;?></th>
</tr>
<tr>
<th>Waktu</th>
<th>Tanggal</th>
<th class="no-sort">Username / Vouchers</th>
<th class="no-sort" style="text-align:right;">Penjualan</th>
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
<td style='text-align:right;'><?php _e(rupiah($price));?></td>
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
var rows = document.querySelectorAll("#mikmos-tbl-desc tr");

 for (var i = 0; i < rows.length; i++) {
var row = [], cols = rows[i].querySelectorAll("td, th");
 for (var j = 0; j < cols.length; j++)
row.push(cols[j].innerText);
csv.push(row.join(","));
}
downloadCSV(csv.join("\n"), filename);
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
