<?php
session_start();
error_reporting(0);
include_once('../inc/lang/id.php');
include_once('../inc/TELEGRAM.php');
$load = $_GET['load'];
if($load == "telegram"){
echo '<table style="width:100%;padding:0!important;">';
if($_STATTELEG==0){echo '<tr>
<td width="30%">Telegram</td><td>Bot Telegram belum diaktfikan<br/> Untuk mengaktifkan Bot Telegram, input Bot telegram <br/>di Menu -> Administrator -> Telegram</td>
</tr>
<tr>';
}else{echo '<tr>
<td width="30%">Nama Device/AP</td><td>
<input class="form-control" type="text" name="device" value="" placeholder="Akses_Point" required >
</td>
</tr>
<tr>';
	
}
echo "</table>";
}
if($load == "script"){
echo '<table style="width:100%;padding:0!important;">';
echo '<tr>
<td width="30%">Up Script</td><td>
<textarea class="form-control" name="upscript"></textarea>
</td>
</tr>
<tr>
<td>Down Script</td><td>
<textarea class="form-control" name="downscript"></textarea>
</td>
</tr>';
echo "</table>";
}
?>