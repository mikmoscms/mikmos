<?php
function rupiah($angka){
$hasil_rupiah = "Rp " . number_format($angka,2,',','.').".-";
return $hasil_rupiah;
}

function mikBillingHR($da){
include('./inc/config.php');
include('./inc/ip_mk/'.$_ROUTER.'.php');
$API = new RouterosAPI();
$API->debug = false;
$API->connect($_IPMK, $_POMK, $_USMK, _de(ltrim($_PSMK, __CMS)));
$mikbilHR = $API->comm("/system/script/print", array("?=source" => $da));
$mikbilHRtot = count($mikbilHR);
for ($i=0; $i<$mikbilHRtot; $i++){
$mikmosData = $mikbilHR[$i];
$mikmoslits = explode("-|-",$mikmosData['name']);
$bilHR += $mikmoslits[3];
}
$API->disconnect();
return $bilHR;
}
function mikBillingBL($da){
include('./inc/config.php');
include('./inc/ip_mk/'.$_ROUTER.'.php');
$API = new RouterosAPI();
$API->debug = false;
$API->connect($_IPMK, $_POMK, $_USMK, _de(ltrim($_PSMK, __CMS)));
$mikbilHR = $API->comm("/system/script/print", array("?=owner" => $da));
$mikbilHRtot = count($mikbilHR);
for ($i=0; $i<$mikbilHRtot; $i++){
$mikmosData = $mikbilHR[$i];
$mikmoslits = explode("-|-",$mikmosData['name']);
$bilHR += $mikmoslits[3];
}
$API->disconnect();
return $bilHR;
}
function mikBillingALL(){
include('./inc/config.php');
include('./inc/ip_mk/'.$_ROUTER.'.php');
$API = new RouterosAPI();
$API->debug = false;
$API->connect($_IPMK, $_POMK, $_USMK, _de(ltrim($_PSMK, __CMS)));
$mikbilHR = $API->comm("/system/script/print");
$mikbilHRtot = count($mikbilHR);
for ($i=0; $i<$mikbilHRtot; $i++){
$mikmosData = $mikbilHR[$i];
$mikmoslits = explode("-|-",$mikmosData['name']);
$bilHR += $mikmoslits[3];
}
$API->disconnect();
return $bilHR;
}

function ini_lokal() {
$whitelist = array( '127.0.0.1', '::1' );
if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) )
return true;
}
function _Get_Pre($num = 0) {
if($num == 0){ return ''; }
}
function _Mikmos_Web($num = 0) {
if($num == 0){ return 'https://mikmos.my.id/';}
if($num == 1){ return 'https://mikmos.online/';}
if($num == 2){ return 'https://mikmos.my.id/?load=voucher';}
if($num == 10){ return 'http://localhost/web/';}
}
function compresspage($buffer) {
$search = array('/\n/','/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s');
$replace = array(' ','>','<','\\1');
$buffer = preg_replace($search, $replace, $buffer);
return $buffer;
}
function rem_slash($ar, $no=0) {
$str = $ar;
$cek = explode('/',$str);
return $cek[$no];
}
function formatBytes($size, $decimals = 0){
$unit = array('0' => 'Byte','1' => 'KiB','2' => 'MiB','3' => 'GiB','4' => 'TiB','5' => 'PiB','6' => 'EiB','7' => 'ZiB','8' => 'YiB');
for($i = 0; $size >= 1000 && $i <= count($unit); $i++){
$size = $size/1000;
}
return round($size, $decimals).' '.$unit[$i];
}
function formatBytes2($size, $decimals = 0){
$unit = array('0' => 'Byte','1' => 'KB','2' => 'MB','3' => 'GB','4' => 'TB','5' => 'PB','6' => 'EB','7' => 'ZB','8' => 'YB');
for($i = 0; $size >= 1000 && $i <= count($unit); $i++){
$size = $size/1000;
}
return round($size, $decimals).''.$unit[$i];
}
function formatBites($size, $decimals = 0){
$unit = array('0' => 'bps','1' => 'kbps','2' => 'Mbps','3' => 'Gbps','4' => 'Tbps','5' => 'Pbps','6' => 'Ebps','7' => 'Zbps','8' => 'Ybps');
for($i = 0; $size >= 1000 && $i <= count($unit); $i++){
$size = $size/1000;
}
return round($size, $decimals).' '.$unit[$i];
}
function _en($string, $key=128) {
$result = '';
for($i=0, $k= strlen($string); $i<$k; $i++) {
$char = substr($string, $i, 1);
$keychar = substr($key, ($i % strlen($key))-1, 1);
$char = chr(ord($char)+ord($keychar));
$result .= $char;
}
return base64_encode($result);
}
function _de($string, $key=128) {
$result = '';
$string = base64_decode($string);
for($i=0, $k=strlen($string); $i< $k ; $i++) {
$char = substr($string, $i, 1);
$keychar = substr($key, ($i % strlen($key))-1, 1);
$char = chr(ord($char)-ord($keychar));
$result .= $char;
}
return $result;
}
function formatDTM($dtm){
$val_conver = $dtm; 
$new_format = str_replace("s", "", str_replace("m", ":", str_replace("h", ":", str_replace("d", "d ", str_replace("w", "w ", $val_conver)))));
return $new_format;
}
function Loading($url,$time,$title){
if(empty($time)){$urlnya='<meta http-equiv="refresh" content="0; url='.$url.'"/>';}else{$urlnya='<meta http-equiv="refresh" content="'.$time.'; url='.$url.'"/>';}
if(empty($title)){$titlenya='Loading...';}else{$titlenya=$title;}
$loading = ''.$urlnya.'<div class="rowx"><div class="main-content"><div class="panel"><i class="fa fa-refresh fa-spin"></i> <span>'.$titlenya.'</span></div></div></div>';
return $loading;
}
function ganti_spasi($str){
$str =str_replace(' ', '_', $str);
return $str;
}
function install_ipmk($link){
$rep=opendir($link);
while ($file = readdir($rep)) {
if($file != '..' && $file !='.' && $file !=''){
if ($file !='index.php' && $file !='index.html' && $file !='.htaccess'){
if(!is_dir($file)){
return $file;
}}}}}

function load_router($router, $dir, $on){
$rep=opendir($dir);
while ($file = readdir($rep)) {
if($file != '..' && $file !='.' && $file !=''){
if ($file !='index.php' && $file !='index.html' && $file !='.htaccess'){
if(!is_dir($file)){
if($on=='on'){
if ($router==substr($file, 0, -4)){ 
echo '<div class="card p-20" style="background-color:#fa8564"><div class="media widget-ten"><div class="media-left meida media-middle"><span class="color-white"><i class="fa fa-server f-s-40"></i></span></div>
<div class="media-body media-text-right">
<h2 class="color-white">'.substr($file, 0, -4).'</h2>
<p class="m-b-0 color-white"><a class=" color-white" href="#" title="'.__ENABLE.' Router '.substr($file, 0, -4).'">'.__ENABLE.' <i class="fa fa-unlock"></i> </a></p>
<p class="m-b-0 color-white"><a class=" color-white" href="./settings.php?index=mikrotik_ae&id='.substr($file, 0, -4).'" title="'.__EDIT.' Router '.substr($file, 0, -4).'">'.__EDIT.' <i class="fa fa-edit"></i> </a></p>
</div>
</div>
</div>';
}}
if($on=='off'){
if ($router!==substr($file, 0, -4)){ 
echo '<div class="card p-20" style="background-color:#fa8564"><div class="media widget-ten"><div class="media-left meida media-middle"><span class="color-white"><i class="fa fa-server f-s-40"></i></span></div>
<div class="media-body media-text-right">
<h2 class="color-white">'.substr($file, 0, -4).'</h2>
<p class="m-b-0 color-white"><a class=" color-white" href="#" title="'.__ENABLE.' Router '.substr($file, 0, -4).'">'.__DISABLE.' <i class="fa fa-lock"></i> </a></p>
<p class="m-b-0 color-white"><a class=" color-white" href="./settings.php?index=mikrotik_ae&id='.substr($file, 0, -4).'" title="'.__EDIT.' Router '.substr($file, 0, -4).'">'.__EDIT.' <i class="fa fa-edit"></i> </a></p>
<p class="m-b-0 color-white"><a class=" color-white" href="./settings.php?index=mikrotik_del&id='.substr($file, 0, -4).'" title="Remove Router '.substr($file, 0, -4).'">'.__DEL.' <i class="fa fa-trash"></i> </a></p>
</div>
</div>
</div>';
}}}}}}}
function load_adm($dir){
$rep=opendir($dir);
while ($file = readdir($rep)) {
 if($file != '..' && $file !='.' && $file !=''){
 if ($file !='index.php' && $file !='index.html' && $file !='.htaccess'){
 if(!is_dir($file)){
echo '<div class="card p-20" style="background-color:#34a853"><div class="media widget-ten"><div class="media-left meida media-middle"><span class="color-white"><i class="fa fa-users f-s-40"></i></span></div>
<div class="media-body media-text-right">
<h2 class="color-white">'.substr($file, 0, -4).'</h2>
<p class="m-b-0 color-white"><a class="color-white" href="./settings.php?index=administrator_ae&id='.substr($file, 0, -4).'" title="'.__EDIT.' Router '.substr($file, 0, -4).'">'.__EDIT.' <i class="fa fa-edit"></i> </a></p>
</div>
</div>
</div>';
}}}}}
function load_teleg(){
include './inc/TELEGRAM.php';
echo '<div class="card p-20" style="background-color:#0088cc"><div class="media widget-ten"><div class="media-left meida media-middle"><span class="color-white"><i class="fa fa-telegram f-s-40"></i></span></div>
<div class="media-body media-text-right">
<h2 class="color-white">TELEGRAM</h2>
<p class="m-b-0 color-white"><a class="color-white" href="./settings.php?index=telegram_ae" title="'.__EDIT.' TELEGRAM">'.__EDIT.' <i class="fa fa-edit"></i> </a></p>
</div>
</div>
</div>';
}
function _e($echo){
echo $echo;
}
function versi_off($item){
$dir= "./db/versi.xml";
$index_theme = @implode( '', file( $dir ) );
$info_themes = str_replace ( '\r', '\n', $index_theme );
preg_match( '|<'.$item.'>(.*)<\/'.$item.'>|ims', $info_themes, $item );
return $item[1];
}

function perse_version($versi=null){
$expl1 = explode('.',$versi);
$versi= $expl1[2]-1;
$version = $expl1[0].'.'.$expl1[1].'.'.$versi;
return $version;
}
function update_system(){
$urlon = _Mikmos_Web(0);
$file = "versi/versi.xml";
$contents = get_content($urlon.$file);
if(!$contents){
$content .="<a href=\"./settings.php?index=update\" class=\"btn btn-info btn-sm\">MIKMOS Versi ".versi_off("versi")." </a>";
}else{
preg_match( '|<versi>(.*)<\/versi>|ims', $contents, $versi );
$versi1 = versi_off("versi");
if($versi[1] > versi_off('versi')){
$content .= "<a title=\"Update ".$versi[1]." Tersedia\" href=\"./settings.php?index\" class=\"btn btn-danger btn-sm\">Update ".$versi[1]." Tersedia </a>";
}else{
$content .= "<span class='btn btn-info btn-sm'>MIKMOS Versi ".versi_off('versi')."</span>";
}
}
return $content;
}
function cek_update(){
$urlon = _Mikmos_Web(0);
$file = "versi/versi"._Get_Pre(0).".xml";
$contents = get_content($urlon.$file);
if(!$contents){
$content .="";
}else{
preg_match( '|<versi>(.*)<\/versi>|ims', $contents, $versi );
preg_match( '|<seri>(.*)<\/seri>|ims', $contents, $seri );
$versi1 = versi_off("versi");
if($versi[1] > versi_off('versi')){
$content .= '
<div id="cekupdate">
<div style="top: 199.5px; left: 551.5px; display: none;" id="dialog" class="updatebox">
<h3>Versi Update Tersedia!</h3>
<div id="infonya">
<p> Versi yang Anda gunakan sekarang MIKMOS versi '.versi_off("versi").'</p>
<p> Versi: '.$versi[1].' - Seri: '.$seri[1].'</p>
</div>
<div id="popupfoot"> 
<p><a class="btn btn-danger" href="'.$urlon.'files'._Get_Pre(0).'/update_mikmos_v.'.$versi1.'_to_v.'.$versi[1].'.zip"> <i class="fa fa-download"></i> Update Offline</a> 
<a class="btn btn-warning" href="./settings.php?index=update_online&url='.$urlon.'files'._Get_Pre(0).'/update_mikmos_v.'.$versi1.'_to_v.'.$versi[1].'.zip"> <i class="fa fa-upload"></i> Update Online</a>
</p>
<a href="#" class="closex">Nanti Saja</a> 
</div>
</div>
<div style="" id="cekupdatemask"></div>
</div>';
}else{
$content .= "";
}
}
return $content;
}

function masaaktif(){
$urlon = _Mikmos_Web(0);
$folder = "versi/";
$klien = $_SERVER['SERVER_NAME'];
$file =  $folder.$klien.".xml";
$contents = get_content($urlon.$file);
if(!$contents){
$content .="";
}else{
preg_match( '|<mikmos>(.*)<\/mikmos>|ims', $contents, $kmikmos );
preg_match( '|<klien>(.*)<\/klien>|ims', $contents, $kklien );
preg_match( '|<mulai>(.*)<\/mulai>|ims', $contents, $kmulai );
preg_match( '|<akhir>(.*)<\/akhir>|ims', $contents, $kakhir );
preg_match( '|<paket>(.*)<\/paket>|ims', $contents, $kpaket );
$GMT = (0 * 3600);
$hari_ini=date("d/m/Y – H:i:s", time() + $GMT);
$start = $hari_ini;
$end = $kakhir[1];
$awal = "$start";
$akhir = "$end";
$hari_awal = substr($awal, 3,2);
$bulan_awal = substr($awal, 0,2);
$tahun_awal = substr($awal, 6,4);
$hari_akhir = substr($akhir, 3,2);
$bulan_akhir = substr($akhir, 0,2);
$tahun_akhir = substr($akhir, 6,4);
$tanggal_awal = mktime(0, 0, 0, $hari_awal, $bulan_awal, $tahun_awal);
$tanggal_akhir = mktime(0, 0, 0, $hari_akhir, $bulan_akhir, $tahun_akhir);
$hasil_awal = $tanggal_awal;
for ($hw=$tanggal_awal; $hw<=$tanggal_akhir; $hw+=86400) {
if ($hasil_awal==" ") {
$hasil_awal = $hw;
}
}
$hasil_akhir = $hw;
$jumlah_harix = ((($hasil_akhir-$hasil_awal) / 86400)-1);
if($jumlah_harix < 1){$jumlah_hari = "<script>alert('Mikmos Online Sudah Expired!');window.location.replace('./?index=logout');</script>" ;}else{$jumlah_hari = $jumlah_harix;}
if($kpaket[1]==0){$paket1 = 'Demo | Mikmos Online';}
if($kpaket[1]==1){$paket1 = '1 Bulan | Mikmos Online';}
if($kpaket[1]==2){$paket1 = '3 Bulan | Mikmos Online';}
if($kpaket[1]==3){$paket1 = '6 Bulan | Mikmos Online';}
if($kpaket[1]==4){$paket1 = '1 Bulan | Mikmos Online + SRSTunnel';}
if($kpaket[1]==5){$paket1 = '3 Bulan | Mikmos Online + SRSTunnel';}
if($kpaket[1]==6){$paket1 = '6 Bulan | Mikmos Online + SRSTunnel';}
$content .= "
<table class='table table-striped'>
<tr><td colspan='2'>Terimakasih Bos Ku, salam hangat</td></tr>
<tr><td width='40%'>Klien</td><td>".$kklien[1]."</td></tr>
<tr><td>Paket</td><td>".$paket1."</td></tr>
<tr><td>Mulai</td><td>".$kmulai[1]." s.d. ".$kakhir[1]."</td></tr>
<tr><td>Sisa</td><td><strong class='blink_me'>".$jumlah_hari." Hari lagi</strong></td></tr>
</table>
";
}
$contentx = "
<table class='table table-striped'>
<tr><td colspan='2' style='text-align:center;'>Terima kasih sudah menggunakan MIKMOS, Jika Bos ku ingin berlangganan MIKMOS ONLINE bisa <a title='Mikmos Online' href='"._Mikmos_Web(1)."' target='_blank'><strong class='blink_me'>KLIK DISINI</strong></a><br/><br/>- MIKMOS -</td></tr>
</table>";
$contentz = "
<table class='table table-striped'>
<tr><td colspan='2' style='text-align:center;'>Jika Bos ku menggunakan MIKMOS Online, berarti Bos ku sudah membantu usia MIKMOS. Terimakasih Bos ku salam kenal<br/><br/>- MIKMOS -</td></tr>
</table>";

if (!ini_lokal()){
if ($kmikmos[1]=='mikmosonline'){
return $content;
}else{
return $contentz;
}
}else{
return $contentx;
}
}

function get(){
$urlon = _Mikmos_Web(0);
$folder = "versi/";
$klien = $_SERVER['SERVER_NAME'];
$file =  $folder.$klien.".xml";
$contents = get_content($urlon.$file);
if(!$contents){
$content .="";
}else{
preg_match( '|<klien>(.*)<\/klien>|ims', $contents, $kklien );
echo $kklien[1];
}
}
function get_content($url)
{
if(!function_exists('curl_init')):
return false;
else:
$ch = curl_init();
curl_setopt ($ch, CURLOPT_URL, $url );
curl_setopt ($ch, CURLOPT_HEADER, 0);
ob_start();
curl_exec ($ch);
curl_close ($ch);
$string = ob_get_contents();
ob_end_clean();
return $string;
endif; 
}
?>