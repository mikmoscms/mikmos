<?php
error_reporting(0);
switch($_GET['get']){
default:
@session_start();
if(!isset($_SESSION['connect'])){
 echo "<meta http-equiv='refresh' content='0;url=./?load=settings' />";
}

$mikmosLoad = $API->comm("/log/print", array("?topics" => "hotspot,info,debug"));
$mikmosData = array_reverse($mikmosLoad);
$mikmosTot = count($mikmosLoad);

?>
<div class="row">
<div class="col-sm-12">
<section class="panel">
<header class="panel-heading">
<strong><?php echo __LOG_ACTIVITY;?></strong>

<span class="tools pull-right">
 </span>
</header>
<div class="panel-body">
<?php//print_r($mikmosLoad);?>
<div class="table-responsive">
<div class="adv-table">
<table id="mikmos-tbl-desc" class="table table-sm table-bordered table-hover text-nowrap">
<thead>
<tr>
<th></th>
<th>Time</th>
<th>Details</th>
</tr>
</thead>
<tbody>
<?php
for ($i=0; $i<$mikmosTot; $i++){
?>
<tr>
<td><?php _e($mikmosData[$i]['.id']);?></td>
<td><?php _e($mikmosData[$i]['time']);?></td>
<td><?php _e($mikmosData[$i]['message']);?></td>
</tr>
<?php 
}
$API->disconnect();
?>
  </tbody>
</table>
</div>
</div>

</div>
</section>
</div>
</div>

<script type="text/javascript">
setTimeout(function(){
   window.location.reload(1);
}, 30000);
</script>


<?php
break;

}
?>
