<?php
switch($_GET['get']){
default:
$mikmosLoad = $API->comm("/interface/getall");
$mikmosTot = count($mikmosLoad);
?>
<div id="reloadInterfacex">

<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong><?php echo __INTERFACE;?></strong>
<span class="tools pull-right"> </span>
</header>
<div class="panel-body">
<p class="text-muted">
</p><hr>
<?php //print_r($mikmosLoad);?>
<div class="table-responsive">
<div class="adv-table">
<div class="table-responsive">
 <table class="table table-bordered table-hover text-nowrap" id="mikmos-tbl-noinfo">
 <thead>
<tr> 
<th class="text-center" style="width:50px;"></th>
<th>Name</th>
<th>Default</th>
<th>Mac</th>
<th>tx-packet</th>
<th>rx-packet</th>
<th>tx-byte</th>
<th>rx-byte</th>
<th>Monitoring</th>
</tr>
</thead>

<tbody>
<?php
for ($i=0; $i<$mikmosTot; $i++){
	$mikmosData = $mikmosLoad[$i];
?>
<tr>
<td class="text-center">
<?php if($mikmosData['running']=='true'){ ?><span title="Status Running" class="btn btn-info btn-xs">R</span><?php } ?>

</td>
<td><?php echo $mikmosData['name'];?></td>
<td class="text-center"><?php echo $mikmosData['default-name'];?></td>
<td class="text-center"><?php echo $mikmosData['mac-address'];?></td>
<td class="text-center"><?php echo formatBytes2($mikmosData['tx-packet']);?></td>
<td class="text-center"><?php echo formatBytes2($mikmosData['rx-packet']);?></td>
<td class="text-center"><?php echo formatBytes2($mikmosData['tx-byte']);?></td>
<td class="text-center"><?php echo formatBytes2($mikmosData['rx-byte']);?></td>
<td class="text-center"><?php if($mikmosData['running']=='false'){?><?php }else{ ?><a title="Lihat Trafik Interface <?php echo $mikmosData['name'];?>" href="?load=interface&get=interface&id=<?php echo $mikmosData['default-name'];?>" class="btn btn-xs btn-danger"><i class="fa fa-random"></i> TRAFFIC</a><?php } ?></td>
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
case'interface':
$interfaceeth = $_GET['id'];

$API->comm("/system/logging/action/set", array("name" => "memory", "memory-lines" => "1", "memory-stop-on-full" => "yes"));

$mikmosLoad = $API->comm("/interface/print", array("?running"=> "true"));
$mikmosLoadx = $API->comm("/interface/print", array("?default-name"=> "$interfaceeth"));
$mikmosTot = count($mikmosLoad);
if(empty($_SESSION['loncat'])){$timerloncat = '3000';}else{$timerloncat = $_SESSION['loncat'];}


?>


<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong>Monitoring <?php echo __INTERFACE;?>  <?php _e($mikmosLoadx[0]['name']);?></strong>
<span class="tools pull-right"> </span>
</header>
<div class="panel-body">
<p class="text-muted">

<div class="row">
<div class="col-sm-8">
<a class="btn btn-success" href="./?load=interface"> <i class="fa fa-arrow-left"></i> <?php echo __BACK;?></a>
</div>
<div class="col-sm-2">
<select class="form-control" onchange="if (this.value) window.location.href=this.value">
<?php
for ($i=0; $i<$mikmosTot; $i++){
	$mikmosData = $mikmosLoad[$i];?>
<option <?php if($interfaceeth==$mikmosData['default-name']){ echo 'selected';} ?> style="text-transform:uppercase" value="./?load=interface&get=interface&id=<?php echo $mikmosData['default-name'];?>"><?php echo $mikmosData['name'];?></option>
<?php }
?></select>
</div>
<div class="col-sm-2">

<select class="form-control" onchange="if (this.value) window.location.href=this.value">
<option <?php if($timerloncat=="1000"){ echo 'selected';} ?> style="text-transform:uppercase" value="./?load=interface&get=timer&loncat=1000&id=<?php _e($interfaceeth);?>">1 Detik</option>
<option <?php if($timerloncat=="3000"){ echo 'selected';} ?> style="text-transform:uppercase" value="./?load=interface&get=timer&loncat=5000&id=<?php _e($interfaceeth);?>">3 Detik</option>
<option <?php if($timerloncat=="5000"){ echo 'selected';} ?> style="text-transform:uppercase" value="./?load=interface&get=timer&loncat=5000&id=<?php _e($interfaceeth);?>">5 Detik</option>
<option <?php if($timerloncat=="10000"){ echo 'selected';} ?> style="text-transform:uppercase" value="./?load=interface&get=timer&loncat=10000&id=<?php _e($interfaceeth);?>">10 Detik</option>
<option <?php if($timerloncat=="20000"){ echo 'selected';} ?> style="text-transform:uppercase" value="./?load=interface&get=timer&loncat=20000&id=<?php _e($interfaceeth);?>">20 Detik</option>
<option <?php if($timerloncat=="30000"){ echo 'selected';} ?> style="text-transform:uppercase" value="./?load=interface&get=timer&loncat=30000&id=<?php _e($interfaceeth);?>">30 Detik</option>
<option <?php if($timerloncat=="60000"){ echo 'selected';} ?> style="text-transform:uppercase" value="./?load=interface&get=timer&loncat=60000&id=<?php _e($interfaceeth);?>">60 Detik</option>
</select>
</div>
</div>
<span class="pull-right">
</span>
</p><hr>
<?php //print_r($mikmosLoad);?>
<div class="table-responsive">
<div class="adv-table">
<div class="table-responsive">

	<div id="container" style="min-width: 400px; height: 300px; margin: 0 auto"></div>
	<input hidden name="interface" id="interface" type="text" value="<?php _e($interfaceeth);?>" />
    <div id="trafiknya"></div>
</div>
</div>
</div>
</section>
</div>
</div>
</div>









	<script type="text/javascript" src="assets/js/lib/highcharts/highcharts.js"></script>
	<script> 
	var chart;
	function requestDatta(interface) {
		$.ajax({
			url: 'api/grafik.php?interface='+interface,
			datatype: "json",
			success: function(data) {
				var midata = JSON.parse(data);
				if( midata.length > 0 ) {
					var TX=parseInt(midata[0].data);
					var RX=parseInt(midata[1].data);
					var x = (new Date()).getTime(); 
					shift=chart.series[0].data.length > 19;
					chart.series[0].addPoint([x, TX], true, shift);
					chart.series[1].addPoint([x, RX], true, shift);
					//document.getElementById("trafiknya").innerHTML=TX + " / " + RX;
				}else{
					//document.getElementById("trafiknya").innerHTML="- / -";
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
				console.error("Status: " + textStatus + " request: " + XMLHttpRequest); console.error("Error: " + errorThrown); 
			}       
		});
	}	

	$(document).ready(function() {
			Highcharts.setOptions({
				global: {
					useUTC: false
				}
			});
	

           chart = new Highcharts.Chart({
			   chart: {
				renderTo: 'container',
				animation: Highcharts.svg,
				type: 'spline',
				events: {
					load: function () {
						setInterval(function () {
							requestDatta(document.getElementById("interface").value);
						}, <?php _e($timerloncat);?>);
					}				
			}
		 },
		 title: {
			text: 'Monitoring Interface <?php _e($mikmosLoadx[0]['name']);?>'
		 },
		 xAxis: {
			type: 'datetime',
				tickPixelInterval: 150,
				maxZoom: 20 * 1000
		 },
		 yAxis: {
			minPadding: 0.2,
				maxPadding: 0.2,
				title: {
					text: 'Trafik',
					margin: 10
				}
		 },
            series: [{
                name: 'TX',
                data: []
            }, {
                name: 'RX',
                data: []
            }]
	  });
  });
</script>
<?php
break;
case'timer':
$loncat = $_GET['loncat'];
$interface = $_GET['id'];
$_SESSION['loncat'] = $loncat;
echo Loading('./?load=interface&get=interface&id='.$interface.'','0');
break;
case'enabled':
$interface = $_GET['id'];
$my_file_d = './inc/ip_mk/'.$_ROUTER.'.php';
unlink($my_file_d);
$my_file = './inc/ip_mk/'.$_ROUTER.'.php';
$handle = fopen($my_file, 'w') or die('Cannot open file: '.$my_file);
$data = '<?php
/** 
Yedin Abu Shafa 
Kontak WA: 081802161315
**/
$_ROUTER 	= "'.$_ROUTER.'";
$_IPMK 		= "'.$_IPMK.'";
$_USMK 		= "'.$_USMK.'";
$_PSMK 		= "'.$_PSMK.'";
$_RPER 		= "'.$_RPER.'";
$_RKOT 		= "'.$_RKOT.'";
$_RTEL 		= "'.$_RTEL.'";
$_RDNS 		= "'.$_RDNS.'";
$_RETR 		= "'.$interface.'";
$_RLOG 		= "'.$_RLOG.'";
?>';
fwrite($handle, $data);
chmod($my_file,0644);
echo Loading('./?load=interface','0');
break;
}
?>
