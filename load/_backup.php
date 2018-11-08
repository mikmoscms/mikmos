<?php
switch($_GET['get']){
default:

$_BEM = 'Backup_Email_Mikmos';
$mikmosLoadP = $API->comm("/tool/e-mail/print");
$mikmosP = $mikmosLoadP[0];
$mikmosLoadS = $API->comm("/system/script/print", array("?comment"=> "Backup_Email_Mikmos",));
$mikmosS = $mikmosLoadS[0];
$mikmosLoadSc = $API->comm("/system/schedule/print", array("?comment"=> "Backup_Email_Mikmos",));
$mikmosSc = $mikmosLoadSc[0];
?>

<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong>[BEM] - <?php _e(__BACKUP);?> <?php _e(__EMAIL);?> MIKMOS</strong>
</header>

<div class="panel-body">
<p class="text-muted">
<?php if(($mikmosSc['disabled']=='false') or ($mikmosS['comment']==$_BEM) or ($mikmosP['from']==$_BEM)){ ?>
<a onclick="return confirm('Anda yakin untuk mereset settingan Backup Email?')" title="[BEM] Reset Ulang" class="btn btn-danger" href="./?index=backup&get=del&id1=<?php echo $mikmosS['.id'];?>&id2=<?php echo $mikmosSc['.id'];?>"> <i class="fa fa-edit"></i> [BEM] Reset Ulang</a>
<a onclick="return confirm('Jangan Lupa Cek Email Tujuan!')" title="Coba Running" class="btn btn-success" href="./?index=backup&get=runscript&id=<?php echo $mikmosS['.id'];?>"> <i class="fa fa-play"></i> [BEM] Run</a>
<?php }else{ ?> 
<a title="[BEM] Tambahkan" class="btn btn-primary" href="./?index=backup&get=form_ae"> <i class="fa fa-edit"></i> [BEM] Tambahkan</a>
<?php  } ?> 
</p><hr>
<div class="row">
<div class="col-md-6">

<div class="card p-20" style="background-color:#34a853"><div class="media widget-ten"><div class="media-left meida media-middle"><span class="color-white"><i class="fa fa-envelope f-s-40"></i></span></div>
<div class="media-body media-text-right">
<h2 class="color-white">Email</h2>
<?php if(!empty($mikmosP['from']==$_BEM)){ ?>
<p class="m-b-0 color-white"><i class="fa fa-check"></i> Email OK!</p>
<?php }else{ ?>
<p class="m-b-0 color-white"><i class="fa fa-strip"></i> Klik Tombol BEM</p>
<?php }?>
</div>
</div>
</div>
<div class="card p-20" style="background-color:#fa8564"><div class="media widget-ten"><div class="media-left meida media-middle"><span class="color-white"><i class="fa fa-calendar f-s-40"></i></span></div>
<div class="media-body media-text-right">
<h2 class="color-white">Scheduler</h2>
<?php if($mikmosS['comment']==$_BEM){ ?>
<p class="m-b-0 color-white"><i class="fa fa-check"></i> Scheduler OK!</p>
<p class="m-b-0 color-white"><i class="fa fa-bar-chart"></i> <?php _e($mikmosSc['run-count']);?>x Scheduler</p>
<p class="m-b-0 color-white">Selanjutnya <?php _e($mikmosSc['next-run']);?></p>
<?php }else{ ?>
<p class="m-b-0 color-white"><i class="fa fa-strip"></i> Klik Tombol BEM</p>
<?php }?>
</div>
</div>
</div>
<div class="card p-20" style="background-color:#0088cc"><div class="media widget-ten"><div class="media-left meida media-middle"><span class="color-white"><i class="fa fa-code f-s-40"></i></span></div>
<div class="media-body media-text-right">
<h2 class="color-white">Script</h2>
<?php if($mikmosSc['disabled']=='false'){ ?>
<p class="m-b-0 color-white"><i class="fa fa-check"></i> Script OK!</p>
<p class="m-b-0 color-white"><i class="fa fa-bar-chart"></i> <?php _e($mikmosS['run-count']);?>x Run Script</p>
<p class="m-b-0 color-white">Terakhir <?php _e($mikmosS['last-started']);?></p>
<?php }else{ ?>
<p class="m-b-0 color-white"><i class="fa fa-strip"></i> Klik Tombol BEM</p>
<?php }?>

<?php echo $mikmosSc['source]'];?>
</div>
</div>
</div>
</div>
<div class="col-md-6">
<p>
<strong>[BEM] Backup Email Mikmos</strong> ini adalah paket 3 in 1, menyatukan Email, Scheduler & Script dalam 1 input.
</p>
<p><strong>INFO</strong></p>
<p>
Apabila kita mengirimkan email dengan akun gmail melalui router mikrotik, maka secara otomatis akan diblok oleh google, ini karena kita login ke akun gmail bukan melalui platform resmi milik google (Gmail) melainkan melalui router mikrotik, hal itu akan dianggap tidak aman oleh google sehingga akan diblok.
</p>
Untuk itu kita perlu melakukan sedikit pengaturan untuk mengijinkan agar akun Gmail bisa login dari perangkat / aplikasi lain selain platform Gmail, caranya klik tautan dibawah ini.
<br/>
<a title="Izinkan aplikasi kurang aman di Google - Cek" target="_blank" class="btn btn-danger" href="https://myaccount.google.com/lesssecureapps">KLIK DISINI</a>
<p>Pastikan seperti gambar dibawah ini:</p>
<img src="assets/images/bem.png"></img>
</div>
</div>
</div>

</div>
</div>
</div>
<?php

break;
case'add':

if(isset($_POST['save'])){
$ebem = $_ROUTER;
$eaddress = '74.125.200.109';
$eport = '587';
$estarttls = 'yes';
$emailasal = ($_POST['emailasal']);
$passasal = ($_POST['passasal']);
$emailtujuan = ($_POST['emailtujuan']);

$sstartdate = 'Nov/08/2018';
$sstarttime = '00:00:00';
$sinterval =  '1d';

/*--- */
$sname = 'Backup_Email_Mikmos';
$ssource = '/system backup save name="BEM-BACKUP-'.$ebem.'"; :global backupname ("Backup" . "-" . [/system identity get name] . "-" . \ [:pick [/system clock get date] 4 6] . [:pick [/system clock get date] 0 3] . [:pick [/system clock get date] 7 11]); /tool e-mail send to="'.$emailtujuan.'" subject=("[BEM] - Mikrotik " . [/system identity get name] . \ " Backup") file="BEM-BACKUP-'.$ebem.'" start-tls=yes body=("[BEM] Backup Email Mikmos - Ini Adalah e-mail otomatis untuk mengirim hasil backup Mikrotik!!! Dikirim pada hari ini " .\ ([/system clock get date]).\ " pukul ".\ ([/system clock get time]));'; 

$API->comm("/tool/e-mail/set", array(
  "address" => "$eaddress",
  "port" => "$eport",
  "start-tls" => "$estarttls",
  "from" => "$sname",
  "user" => "$emailasal",
  "password" => "$passasal",
));
$API->comm("/system/script/add", array(
  "name" => "$sname",
  "comment" => "$sname",
  "source" => "$ssource",
));
$API->comm("/system/schedule/add", array(
  "name" => "$sname",
  "start-date" => "$sstartdate",
  "start-time" => "$sstarttime",
  "interval" => "$sinterval",
  "on-event" => "$sname",
  "comment" => "$sname",
));

echo "<script>window.location='./?index=backup'</script>";
  }
  
  ?>
  
<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong><?php echo __EDIT." ".__PROFILE;?></strong></i>

<span class="tools pull-right">
 </span>
</header>
<form action="" method="post">
<div class="panel-body">

<hr>

<div class="row">
<div class="col-md-7">
  
<p class="text-muted">
<a class="btn btn-danger" href="./?index=backup"> <i class="fa fa-close"></i> <?php echo __CANCEL;?></a>
<button type="submit" class="btn bg-primary" name="save"><i class="fa fa-save"></i> <?php echo __SAVE;?></button>
</p>

<table class="table">
  <tr>
<td>Nama File Backup</td><td><input class="form-control" type="text" autocomplete="off" name="ebem" value="<?php echo $ebem;?>" required="1" autofocus></td>
  </tr>
  <tr>
<td>Email Pengirim</td><td><input class="form-control" type="text" autocomplete="off" name="emailasal" value="<?php echo $emailasal;?>" required="1"></td>
  </tr>
  <tr>
<td>Password Email</td><td><input class="form-control" type="text" autocomplete="off" name="passasal" value="<?php echo $passasal;?>" required="1"></td>
  </tr>
  <tr>
<td>Email Tujuan</td><td><input class="form-control" type="text" autocomplete="off" name="emailtujuan" value="<?php echo $emailtujuan;?>" required="1"></td>
  </tr>
</table>

</div>
<div class="col-md-5">

<header class="panel-heading">
<strong><?php echo __INFO;?></strong>

<span class="tools pull-right">
 </span>
</header>

<div class="panel-body">
</div>
</div>
</div>
</div>
</form>

</div>
</div>
</div>




<?php
break;
case'form_ae':

if(isset($_POST['edit'])){
$ebem = $_ROUTER;
$eaddress = '74.125.200.109';
$eport = '587';
$estarttls = 'yes';
$emailasal = ($_POST['emailasal']);
$passasal = ($_POST['passasal']);
$emailtujuan = ($_POST['emailtujuan']);

$sstartdate = ($_POST['startdate']);
$sstarttime = ($_POST['starttime']);
$sinterval =  ($_POST['interval']);

/*--- */
$sname = 'Backup_Email_Mikmos';
$ssource = '/system backup save name="BEM-BACKUP-'.$ebem.'"; :global backupname ("Backup" . "-" . [/system identity get name] . "-" . \ [:pick [/system clock get date] 4 6] . [:pick [/system clock get date] 0 3] . [:pick [/system clock get date] 7 11]); /tool e-mail send to="'.$emailtujuan.'" subject=("[BEM] - Mikrotik " . [/system identity get name] . \ " Backup") file="BEM-BACKUP-'.$ebem.'" start-tls=yes body=("[BEM] Backup Email Mikmos - Ini Adalah e-mail otomatis untuk mengirim hasil backup Mikrotik!!! Dikirim pada hari ini " .\ ([/system clock get date]).\ " pukul ".\ ([/system clock get time]));'; 

$API->comm("/tool/e-mail/set", array(
  "address" => "$eaddress",
  "port" => "$eport",
  "start-tls" => "$estarttls",
  "from" => "$sname",
  "user" => "$emailasal",
  "password" => "$passasal",
));
$API->comm("/system/script/add", array(
  "name" => "$sname",
  "comment" => "$sname",
  "source" => "$ssource",
));
$API->comm("/system/schedule/add", array(
  "name" => "$sname",
  "start-date" => "$sstartdate",
  "start-time" => "$sstarttime",
  "interval" => "$sinterval",
  "on-event" => "$sname",
  "comment" => "$sname",
));

echo "<script>window.location='./?index=backup'</script>";
  }
 
$_BEM = 'Backup_Email_Mikmos';
$mikmosLoadP = $API->comm("/tool/e-mail/print");
$mikmosP = $mikmosLoadP[0];
$mikmosLoadS = $API->comm("/system/script/print", array("?comment"=> "Backup_Email_Mikmos",));
$mikmosS = $mikmosLoadS[0];
$mikmosLoadSc = $API->comm("/system/schedule/print", array("?comment"=> "Backup_Email_Mikmos",));
$mikmosSc = $mikmosLoadSc[0];


$ssource = $mikmosS['source'];
//$getexpmode = explode(";",$ssource);
$getexpmode = $ssource;
  ?>
  
<script>
function PassUser(){
var x = document.getElementById('passUser');
if (x.type === 'password') {
x.type = 'text';
} else {
x.type = 'password';
}}
</script>
<div class="row">
<div class="col-sm-12">
<div class="panel">
<header class="panel-heading">
<strong><?php echo __EDIT." ".__PROFILE;?></strong></i>

<span class="tools pull-right">
 </span>
</header>
<form action="" method="post">
<div class="panel-body">
<hr>
<div class="row">
<div class="col-md-7">
<p class="text-muted">
<a class="btn btn-danger" href="./?index=backup"> <i class="fa fa-close"></i> <?php echo __CANCEL;?></a>
<button type="submit" class="btn bg-primary" name="edit"><i class="fa fa-save"></i> <?php echo __SAVE;?></button>
</p>

<table class="table">
  <tr>
<td>Email Pengirim</td><td><input class="form-control" type="email" autocomplete="off" name="emailasal" value="<?php echo $mikmosP['user'];?>" required="1" placeholder="pengirim@gmail.com"></td>
  </tr>
<tr>
<td class="align-middle">Password Email</td><td>
<div class="input-group input-group-flat">
<input class="form-control" id="passUser" type="password" name="passasal" autocomplete="new-password" value="<?php echo $mikmosP['password'];?>" required="1" placeholder="password">
 <span class="input-group-btn btn btn-danger" title="Show/Hide Password" onclick="PassUser()"><i class="fa fa-eye"></i></span>
 </div> 

</td>
</tr>
  <tr>
<td>Email Tujuan</td><td><input class="form-control" type="email" autocomplete="off" name="emailtujuan" value="<?php echo $emailtujuan;?>" required="1" placeholder="tujuan@gmail.com"><?php if(!empty($_GET['id'])){echo '*Silahkan isi kembali Email Tujuannya';}?></td>
  </tr>
  <tr>
<td>Tanggal Mulai</td><td><input class="form-control" type="text" autocomplete="off" name="startdate" value="<?php _e(date('M'));?>/<?php _e(date('d'));?>/<?php _e(date('Y'));?>" required="1" placeholder="Jun/25/2018"></td>
  </tr>
  <tr>
<td>Waktu Mulai</td><td><input class="form-control" type="text" autocomplete="off" name="starttime" value="00:00:00" required="1" placeholder="00:00:00"></td>
  </tr>
  <tr>
<td>Interval</td><td><input class="form-control" type="text" autocomplete="off" name="interval" value="<?php echo $mikmosSc['interval'];?>" required="1" placeholder="1d"></td>
  </tr>
</table>

</div>
<div class="col-md-5">

<header class="panel-heading">
<strong><?php echo __INFO;?></strong>

<span class="tools pull-right">
 </span>
</header>

<div class="panel-body">
  <?php if($_LANG == "id"){?>
<table class="table">
  <tr><td>Nama File Backup</td><td>BEM-BACKUP-<?php _e($_ROUTER);?>.backup</td></tr>
  <tr><td>Format Interval</td><td>[wdhm] Contoh : 1d = 1hari, 12h = 12jam</td></tr>
  </table>
  <?php }else{?>
<table class="table">
  <tr><td>Format Interval</td><td>[wdhm] Contoh : 1d = 1hari, 12h = 12jam</td></tr>
  </table>
  
  <?php }?>
</div>
</div>
</div>
</div>
</form>

</div>
</div>
</div>



<?php
break;
case'runscript':
$removeuserprofile = $_GET['id'];
$API->comm("/system/script/run", array(".id"=> "$removeuserprofile",));
$API->disconnect();
_e('<script>window.history.go(-1)</script>');
break;
case'del':
$id1 = $_GET['id1'];
$id2 = $_GET['id2'];
$API->comm("/tool/e-mail/set", array("address" => "0.0.0.0", "from" => "", "user" => "", "password" => "",));
$API->comm("/system/script/remove", array(".id"=> "$id1",));
$API->comm("/system/schedule/remove", array(".id"=> "$id2",));
_e('<script>window.history.go(-1)</script>');
break;
}
?>
