<table style="display: inline-block;border-collapse: collapse;border: 1px solid #666;margin: 2.5px;width: 190px;background:#666;">
  <tbody>
    <tr>
      <td style="color:#666;width:30px;" valign="top">
			<!--NUM-->
			<div style="float:left;margin-top:0px;width:5%;margin-left:5px;font-size:7px;color:#fff;">
			<?php echo " [$v_num]";?>
			</div>
			<!--NUM-->	
	  <div class="teks_berdiri"><small style="font-size:10px;">Rp.</small><?php echo $v_harga;?></div>
	  </td>
      <td style="color:#666;width:160px;font-size:9px;font-weight:bold;background:#fff;border:5px solid #666;;" valign="top">
<table style="width:100%;text-align:center;border-collapse: collapse;">
  <tbody>
    <tr>
      <td style="border:1px solid #666;color:#666;font-weight:bold;text-transform:uppercase;color:#fff;background:#666;" valign="top" colspan="2"><?php echo $v_spot;?></td>
    </tr>
    <tr>
      <td style="border:1px solid #666;color:#666;" valign="top">Paket</td>
      <td style="border:1px solid #666;color:#666;" valign="top"><?php echo $v_profile;?></td>
    </tr>
    <tr>
      <td style="border:1px solid #666;color:#666;" valign="top">Aktif</td>
      <td style="border:1px solid #666;color:#666;" valign="top"><?php echo $v_valid;?></td>
    </tr>
    <tr>
      <td style="border:1px solid #666;color:#666;" valign="top">Tenggang</td>
      <td style="border:1px solid #666;color:#666;" valign="top"><?php echo $v_tlimit;?></td>
    </tr>
    <tr>
      <td style="border:1px solid #666;color:#666;" valign="top">Kuota</td>
      <td style="border:1px solid #666;color:#666;" valign="top"><?php if(empty($v_dlimit)){;?>Unlimted <?php }else{ echo $v_dlimit;}?></td>
    </tr>
	

			<!--USER-->
			<?php if($v_opsi=='up'){ ?>
    <tr>
      <td style="border:1px solid #666;color:#fff;background:#666;" valign="top">Username</td>
      <td style="border:1px solid #666;color:#fff;background:#666;" valign="top">Password</td>
    </tr>
    <tr>
      <td style="border:1px solid #666;color:#666;font-weight:bold;font-size:12px;" valign="top"><?php echo $v_user;?></td>
      <td style="border:1px solid #666;color:#666;font-weight:bold;font-size:12px;" valign="top"><?php echo $v_pass;?></td>
    </tr>
			<?php }else{ ?>
    <tr>
      <td style="border:1px solid #666;color:#fff;background:#666;" valign="top" colspan="2">Voucher</td>
    </tr>
    <tr>
      <td style="border:1px solid #666;color:#666;font-weight:bold;font-size:12px;" valign="top" colspan="2"><?php echo $v_user;?></td>
    </tr>
			<?php } ?>
			<!--USER--> 
			
    <tr>
      <td style="border:1px solid #666;color:#fff;background:#666; valign="top" colspan="2">
			<!--URL-->
			status/logout: http://<?php echo $v_dns;?>
			<!--URL-->	
	  </td>
    </tr>
  </tbody>
</table>
	  </td>
    </tr>
  </tbody>
</table>


<style>
.teks_berdiri {
     writing-mode:tb-rl;
    -webkit-transform:rotate(-90deg);
    -moz-transform:rotate(-90deg);
    -o-transform: rotate(-90deg);
    -ms-transform:rotate(-90deg);
    transform: rotate(180deg);
    white-space:nowrap;
	text-align:center;
	font-weight:bold;
    font-size: 24px;
    color: #FFF;
    text-transform: uppercase;
}
</style>