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
<strong>Grafik <?php _e(__BILLING);?></strong>

</header>
<div class="panel-body">
<hr>
<div class="row">
<div class="col-sm-8">
<div class="adv-table">
<div class="table-responsive">
<div id="myDIV">
<div id="trafiknya" style="margin:0;padding:0!important;width:100%;height:300px;"></div>
</div>

</div>
</div>
</div>
<div class="col-sm-4">

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
$pendptan = mikBillingHR($mikHRini,'all');
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
$getcomment = $_GET['comment'];
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
$mikLoadbill = $API->comm("/system/script/print", array("?source" => "$pilhr"));
$mikTotbill = count($mikLoadbill);
$mikDL = $pilhr;
$linknya = 'pilhr='.$pilhr.'&comment='.$getcomment;
$shf = "hidden";
$shd = "inline-block";
}elseif(strlen($pilbl) > "0"){
$mikLoadbill = $API->comm("/system/script/print", array("?owner" => "$pilbl"));
$mikTotbill = count($mikLoadbill);
$mikDL = $pilbl;
$linknya = 'pilbl='.$pilbl.'&comment='.$getcomment;
$shf = "hidden";
$shd = "inline-block";
}elseif($pilhr == "" || $pilbl == "" || $getcomment == ""){
$mikLoadbill = $API->comm("/system/script/print", array("?comment" => "MIKMOScms"));
$mikTotbill = count($mikLoadbill);
$mikDL = "all";
$shf = "text";
$shd = "none";
}
if($pilhr){$totolbil = rupiah(mikBillingHR($pilhr,$getcomment));}
elseif($pilbl){$totolbil = rupiah(mikBillingBL($pilbl,$getcomment));}
else{$totolbil = rupiah(mikBillingALL($getcomment));}
?>

<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong>Tabel <?php _e(__BILLING);?> </strong>
<span class="pull-right">
<a class="btn bg-danger" href="./?load=billing&get=migreport" onclick="return confirm('Serius Mau Migrasi?...')" title="Migrasi Report Penjualan sebelumnya menggunakan Aplikasi mikh***"><i class="fa fa-retweet"></i> Migrasi Billing Report</a>
</span>
</header>

<div class="panel-body">
<hr>
<p>
Jika ingin mendapatkan Repot Penjualan, maka di Setting di Profile Users -> Mode Expired -> Remove Record / Notice Record
</p>

<p>Disarankan untuk menghapus report perbulannya.</p>
<hr>
<p class="text-muted">
<div style=""> 

<button style="display: <?php _e($shd);?>;" class="btn bg-primary" onclick="location.href='./?load=billing&get=listen';" title="Reload all data"><i class="fa fa-search"></i>Reload ALL</button>

<a class="btn bg-primary text-white" style="cursor:pointer;display: <?php _e($shd);?>;" onclick="window.open('./api/export_pdf.php?<?php _e($linknya);?>', 'newwindow', 'width=800,height=600'); return false;" title="Lihat PDF <?php _e($mikDL);?>"><i class="fa fa-file-pdf-o"></i> PDF  <?php _e($mikDL);?> </i>
</a>
<form style="display: <?php _e($shd);?>;" autocomplete="off" method="post" action="">
<center>
<button style="display: <?php _e($shd);?>;" name="mikhapus" class="btn bg-danger" onclick="return confirm('Anda yakin untuk menhapusnya ?...')" title="Hapus Data <?php _e($mikDL);?>"><i class="fa fa-remove"></i> Hapus data <?php _e($mikDL);?></button>
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


 <select style="padding:7.5px;" id="comment" name="comment" required="1">
<option style="text-transform:uppercase" value="all">Semua Voucher</option> 
 </select>
 
 
<input class="btn bg-success" type="button" value=" LIHAT " name="sbutton" onclick="javascript:var x = $('#sday').val();var y = $('#smonth').val();var z = $('#syear').val();var c = $('#comment').val(); if (x && y && z && c){document.location = '?load=billing&get=listen&pilhr='+y+'/'+x+'/'+z+'&comment='+c;}else{document.location = '?load=billing&get=listen&pilbl='+y+''+z+'&comment='+c;}"/>


 
 
</div>
</div>

</p>

<div class="table-responsive">
<div class="">

 <table class="table table-bordered table-hover text-nowrap" id="mikmos-tbl-desc1">
<thead>
<tr>
<th colspan="2">Billing report <?php _e($mikDL);?><b style="font-size:0;">,</b></th>
<th style="text-align:right;">Total</th>
<th style="text-align:right;font-weight:bold;"><?php echo $totolbil;?></th>
</tr>
<tr>
<th>Waktu</th>
<th class="no-sort">Username / Vouchers</th>
<th class="no-sort" style="text-align:right;">Penjualan</th>
<th class="no-sort" style="text-align:right;">Comment</th>
</tr>
</thead>
<tbody>
<?php
for ($i=0; $i<$mikTotbill; $i++){
$regtable = $mikLoadbill[$i];
$getname = explode("-|-",$regtable['name']);
$getowner = $regtable['owner'];
$tgl = $getname[0];
$getdy = explode("/",$tgl);
$m = $getdy[0];
$dy = $m."/".$getdy[1]."/".$getdy[2];
$ltime = $getname[1];
$username = $getname[2];
$price = $getname[3];
if($getcomment==$getname[7]){
?>
<tr>
<td><?php _e($dy);?> <?php _e($ltime);?></td>
<td><?php _e($username);?></td>
<td style='text-align:right;'><?php _e(rupiah($price));?></td>
<td style='text-align:right;'><?php _e($getname[7]);?></td>
</tr>
<?php }elseif($getcomment=='all'){ ?>
<tr>
<td><?php _e($dy);?> <?php _e($ltime);?></td>
<td><?php _e($username);?></td>
<td style='text-align:right;'><?php _e(rupiah($price));?></td>
<td style='text-align:right;'><?php _e($getname[7]);?></td>
</tr>
<?php }elseif($getcomment==''){ ?>
<tr>
<td><?php _e($dy);?> <?php _e($ltime);?></td>
<td><?php _e($username);?></td>
<td style='text-align:right;'><?php _e(rupiah($price));?></td>
<td style='text-align:right;'><?php _e($getname[7]);?></td>
</tr>
<?php }  ?>
<?php } ?>
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
case'x':
?>
 <select class="form-control" id="comment" name="vouchers" required="1">
<option style="text-transform:uppercase" value="all">Semua Voucher <?php echo $mikmosView['name'];?></option> 

 <?php 
$mikmosLoad = $API->comm("/ip/hotspot/user/print");
$mikmosTot = count($mikmosLoad);
for ($i=0; $i<$mikmosTot; $i++){
 $userdetails = $mikmosLoad[$i];
 $ucomment = $userdetails['comment'];
$counts = count($ucomment);
if($counts==1){
if($ucomment !== $mikmosLoad[$i-1]['comment']){echo '<option style="text-transform:uppercase" value="'.$ucomment.'">Voucher => '.$ucomment.'</option>';}
}
 }
?>

 </select>
 
 
 




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
