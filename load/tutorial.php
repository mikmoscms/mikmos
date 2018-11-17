
<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong>Monitoring <?php echo __INTERFACE;?></strong>
<span class="tools pull-right">
</span>
</header>
<div class="panel-body"><hr>
<?php //print_r($mikmosLoad);?>
<div class="adv-table">
<div class="table-responsive">

<table class="table table-hover" style="font-size:80%;">
<tr>
<td>Deskripsi</td>
</tr>
<?php
$t_v = file_get_contents('./db/update.txt');
$rs_v = explode("\n", $t_v);
array_shift($rs_v);
$i=1;
foreach($rs_v as $r_v => $d_v) { $rd_v = explode('|', $d_v);
?> 
<tr>
<td><span onclick="myFunction<?php _e($rd_v[2]);?>()"><?php _e($rd_v[2]);?></span>
<div id="myDIV<?php _e($rd_v[2]);?>">
asdadada
</div>
</td>
</tr>
<script> 
function myFunction<?php _e($rd_v[2]);?>() {
    var x = document.getElementById("myDIV<?php _e($rd_v[2]);?>");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
</script>
<?php 
}
?>
</table>



</div>
</div>
</div>
</div>
</div>
</div>
