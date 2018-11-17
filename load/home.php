<?php
session_start();
error_reporting(0);
include_once('../inc/config.php');
include_once('../lib/fungsi.php');
include_once('../lib/routeros_api.class.php');
include_once('../inc/lang/id.php');
include_once('../inc/ip_mk/'.$_ROUTER.'.php');
$interface = $_GET["interface"];
$mikmosLoadJ = $API->comm("/system/clock/print");
$mikmosJ = $mikmosLoadJ[0];
$mikmosLoadResource = $API->comm("/system/resource/print");
$mikmosResource = $mikmosLoadResource[0];
$mikmosLoadRB = $API->comm("/system/routerboard/print");
$mikmosRB = $mikmosLoadRB[0];
$mikmosLoadActive = $API->comm("/ip/hotspot/active/print", array( "count-only" => "")); if($mikmosLoadActive < 2 ){$hunit = "item"; }elseif($mikmosLoadActive > 1){ $hunit = "items"; }
$mikmosTotUs = $API->comm("/ip/hotspot/user/print", array( "count-only" => "")); if($mikmosTotUs < 2 ){$uunit = "item"; }elseif($mikmosTotUs > 1){ $uunit = "items";}
$bg_array = array("#CEED9D","#ECED9D","#EDCF9D","#EC9CA7","#fdd752","#a48ad4","#aec785","#1fb5ac","#fa8564");
?>
<div id="reloadHomex">
<div class="row">
<div class="col-md-3 col-sm-6"><a title="<?php _e($mikmosLoadActive);?> <?php _e(__USERS_ACTIVE);?>" href="./?load=users_active">
<div class="card p-20" style="background-color:<?php _e($bg_array[rand(0,8)]);?>">
<div class="media widget-ten">
<div class="media-left meida media-middle">
<span class="color-white"><i class="fa fa-bar-chart f-s-40"></i></span>
</div>
<div class="media-body media-text-right">
<h2 class="color-white"><?php _e($mikmosLoadActive);?></h2>
<p class="m-b-0 color-white"><?php _e(__USERS_ACTIVE);?></p>
</div>
</div>
</div></a>
</div>
<div class="col-md-3 col-sm-6"><a title="<?php _e($mikmosTotUs);?> <?php _e(__USERS);?>" href="./?load=users">
<div class="card p-20" style="background-color:<?php _e($bg_array[rand(0,8)]);?>">
<div class="media widget-ten">
<div class="media-left meida media-middle">
<span class="color-white"><i class="fa fa-users f-s-40"></i></span>
</div>
<div class="media-body media-text-right">
<h2 class="color-white"><?php _e($mikmosTotUs);?></h2>
<p class="m-b-0 color-white"><?php _e(__USERS);?></p>
</div>
</div>
</div></a>
</div>
<div class="col-md-3 col-sm-6">
<div class="card p-20" style="background-color:<?php _e($bg_array[rand(0,8)]);?>">
<div class="media widget-ten">
<div class="media-left meida media-middle">
<span class="color-white"><i class="fa fa-clock-o f-s-40"></i></span>
</div>
<div class="media-body media-text-right">
<h2 class="color-white"><?php _e(formatDTM($mikmosResource['uptime']));?></h2>
<p class="m-b-0 color-white"><?php _e(__UPTIME);?></p>
</div>
</div>
</div>
</div>
<div class="col-md-3 col-sm-6">
<div class="card p-20" style="background-color:<?php _e($bg_array[rand(0,8)]);?>">
<div class="media widget-ten">
<div class="media-left meida media-middle">
<span class="color-white"><i class="fa fa-line-chart f-s-40"></i></span>
</div>
<div class="media-body media-text-right">
<h2 class="color-white"><?php _e($mikmosResource['cpu-load']);?>%</h2>
<p class="m-b-0 color-white"><?php _e(__CPU_LOAD);?></p>
</div>
</div>
</div>
</div>
</div>
<?php 
if(!empty($_RETR)){
?>
<div class="row">
<?php
$interfaceeth = 'ether'.$_RETR;
$API->comm("/system/logging/action/set", array("name" => "memory", "memory-lines" => "1", "memory-stop-on-full" => "yes"));
$mikmosLoad = $API->comm("/interface/print", array("?running"=> "true"));
$mikmosLoadx = $API->comm("/interface/print", array("?default-name"=> "$interfaceeth"));
$mikmosTot = count($mikmosLoad);
if(empty($_SESSION['loncat'])){$timerloncat = '3000';}else{$timerloncat = $_SESSION['loncat'];}
?>
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong>Monitoring <?php echo __INTERFACE;?>  <?php _e($mikmosLoadx[0]['name']);?></strong>
<span class="tools pull-right">
<a title="Sedang Aktif" onclick="return confirm('Yakin untuk non-aktifkan, untuk meng aktif kan di menu Interface')"  href="?load=interface&get=enabled&id=0" class="btn btn-danger"><i class="fa fa-power-off"></i> Non Aktif</a> </span>
</header>
<div class="panel-body"><hr>
<?php //print_r($mikmosLoad);?>
<div class="adv-table">
<div class="table-responsive">

<div id="container" style="min-width: 400px; height: 300px; margin: 0 auto"></div>
<input hidden name="interface" id="interface" type="text" value="<?php _e($interfaceeth);?>" />
<div id="trafiknya"></div>
</div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript" src="assets/js/lib/highcharts/highcharts.js"></script>
<script> 
	var chart;
	function requestDatta(interface) {
		$.ajax({
			url: './api/grafik.php?interface='+interface,
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
<?php } ?>
<div class="row">
<div class="col-lg-6">
<div class="card">
<div class="card-title">
<h4><?php _e(__SYSTEM_RESOURCES);?></h4>
</div>
<div class="card-body">
<div style="height:360px;overflow:auto;">
<table class="table table-striped" style="font-size:80%;">
<tr><td><?php _e(__PLATFORM);?></td><td><?php _e($mikmosResource['platform']);?></td></tr>
<tr><td><?php _e(__MODEL);?></td><td><?php _e($mikmosRB['model']);?></td></tr>
<tr><td><?php _e(__VERSI);?></td><td><?php _e($mikmosResource['version']);?></td></tr>
<tr><td><?php _e(__BOARD_NAME);?></td><td><?php _e($mikmosResource['board-name']);?></td></tr>
<tr><td><?php _e(__ARCHITECTURE);?></td><td><?php _e($mikmosResource['architecture-name']);?></td></tr>
<tr><td><?php _e(__CPU);?></td><td><?php _e($mikmosResource['cpu']);?></td></tr>
<tr><td><?php _e(__CPU_COUNT);?></td><td><?php _e($mikmosResource['cpu-count']);?></td></tr>
<tr><td><?php _e(__MEMORY);?></td><td><?php _e(formatBytes($mikmosResource['free-memory'],2));?>/<?php _e(formatBytes($mikmosResource['total-memory'],2));?></td></tr>
<tr><td><?php _e(__HDD);?></td><td><?php _e(formatBytes($mikmosResource['free-hdd-space'],2));?>/<?php _e(formatBytes($mikmosResource['total-hdd-space'],2));?></td></tr>
<tr><td><?php _e(__BULID_TIME);?></td><td><?php _e($mikmosResource['build-time']);?></td></tr>
</table>
</div>
</div>
</div>
</div>
<div class="col-lg-6">
<div class="card">
<div class="card-title">
<h4><?php _e(__LOG_ACTIVITY);?></h4>
</div>
<div class="card-body">
<div style="height:360px;overflow:auto;">
<table class="table table-hover" style="font-size:80%;">
<?php
$mikmosLoad = $API->comm("/log/print", array("?topics" => "hotspot,info,debug"));
$mikmosData = array_reverse($mikmosLoad);
$mikmosTot = count($mikmosLoad);
?>
<tbody>
<?php
for ($i=0; $i<$mikmosTot; $i++){
?>
<tr>
<td><?php _e($mikmosData[$i]['time']);?></td>
<td><?php _e($mikmosData[$i]['message']);?></td>
</tr>
<?php 
}
$API->disconnect();
?>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
