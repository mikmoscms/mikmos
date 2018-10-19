<?php
session_start();
error_reporting(0);
include_once('../inc/config.php');
include_once('../lib/fungsi.php');
include_once('../lib/routeros_api.class.php');
include_once('../inc/lang/id.php');
include_once('../inc/ip_mk/'.$_ROUTER.'.php');
$interface = $_GET["interface"];
$API = new RouterosAPI();
$API->debug = false;
$KONEK = $API->connect($_IPMK, $_USMK, _de(ltrim($_PSMK, __CMS)));
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
<div class="row">
<div class="col-lg-6">
<div class="card">
<div class="card-title">
<h4><?php _e(__SYSTEM_RESOURCES);?></h4>
</div>
<div class="card-body">
<div class="message-center">
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
<div class="message-center">
<table class="table table-hover" style="font-size:80%;">
<?php
$mikmosLog = $API->comm("/system/logging/print", array("?prefix" => "=>",));
$mikmosLogd = $mikmosLog[0];
if($mikmosLogd['prefix'] == "=>"){}else{ $API->comm("/system/logging/add", array("action" => "disk","prefix" => "=>","topics" => "hotspot,info,debug",)); }
$mikmosLogdbg = $API->comm("/log/print", array("?topics" => "hotspot,info,debug",));
$mikmosLogView = array_reverse($mikmosLogdbg);
$mikmosLogdbgTot = count($mikmosLogdbg);
for ($i=0; $i<$mikmosLogdbgTot; $i++){
_e("<tr>");
_e("<td>" . $mikmosLogView[$i]['time']."</td>");
_e("<td>" . $mikmosLogView[$i]['message']."</td>");
_e("</tr>");
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
