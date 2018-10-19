<?php
switch($_GET['get']){
default:
?>
<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-body">
<div class="card-two">
<header>
<div class="avatar">
<img src="./assets/images/logo.png" alt="<?php _e(__CMS);?>" />
</div>
</header>
<h3><?php _e(__CMS);?></h3>
<div class="desc">
<p><?php _e(__WEBTITLLE);?></p>
<p><?php _e(__WEBDESC);?></p>
</div>
<div class="contacts">
<?php
 $t_v = file_get_contents('./db/social.txt');
 $rs_v = explode("\n", $t_v);
 array_shift($rs_v);
 $i=1;
 foreach($rs_v as $r_v => $d_v) { $rd_v = explode('|', $d_v);
?> 
<a href="<?php _e($rd_v[2]);?>" class="<?php _e($rd_v[1]);?>-bg" target="_blank"><i class="fa fa-<?php _e($rd_v[1]);?>"></i></a>
<?php } ?>
<div class="clear"></div>
</div>
</div>
</div>
</div>
</div>
<div class="col-lg-12">
<div class="card">
<ul class="nav nav-tabs profile-tab" role="tablist">
<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#update" role="tab">Update</a> </li>
<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#referensi" role="tab">Referensi</a> </li>
</ul>
<div class="tab-content">
<div class="tab-pane active" id="update" role="tabpanel">
<div class="card-body">
<div class="message-center">
<table class="table table-hover" style="font-size:80%;">
<tr>
<td>Seri</td>
<td>Tanggal</td>
<td>Versi</td>
<td>Logs</td>
</tr>
<?php
$t_v = file_get_contents('./db/update.txt');
$rs_v = explode("\n", $t_v);
array_shift($rs_v);
$i=1;
foreach($rs_v as $r_v => $d_v) { $rd_v = explode('|', $d_v);
?> 
<tr>
<td><?php _e($rd_v[2]);?></td>
<td><i class="sl-date"><?php _e($rd_v[1]);?></i></td>
<td><i class="m-t-10"><?php _e($rd_v[3]);?></i></td>
<td><i class="m-t-10"><?php _e($rd_v[4]);?></i></td>
</tr>
<?php 
}
?>
</table>
</div>
</div>
</div>
<div class="tab-pane " id="referensi" role="tabpanel">
<div class="card-body">
<div class="message-center">
<div class="sl-item">
<div class="sl-right">
<div>
<blockquote class="m-t-10"></blockquote>
</div>
<?php
 $t_r = file_get_contents('./db/ref.txt');
 $rs_r = explode("\n", $t_r);
 array_shift($rs_r);
 $i=1;
 foreach($rs_r as $r_r => $d_r) { $rd_r = explode('|', $d_r);
?> 
<div>
<blockquote class="m-t-10">
<a href="<?php _e($rd_r[2]);?>" target="_blank"><?php _e($rd_r[1]);?></a>
</blockquote>
</div>
<hr>
<?php } ?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php
break;
}
?>