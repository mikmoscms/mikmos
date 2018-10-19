<table style="display: inline-block;border-collapse: collapse;border: 1px solid #666;margin: 2.5px;width: 190px;">
  <tbody>
    <tr>
      <td style="color:#666;" valign="top">
		<table style="width:100%;">
		  <tbody>
			<tr>
			  <td style="width:75px">
			  <img style="margin:5px 0 0 5px;" width="70" height="18" src="<?php echo $v_logo ?>" alt="logo">
			  </td>	
			  <td style="width:115px">
			<!--NUM-->
			<div style="float:right;margin-top:-6px;margin-right:0px;width:5%;text-align:right;font-size:7px;">
			<?php echo " [$v_num]";?>
			</div>
			<!--NUM-->	
			<!--HARGA-->
			<div style="text-align:right;font-weight:bold;font-family:Tahoma;font-size:18px;padding-left:17px;">
			<small style="font-size:10px;margin-left:-17px;position:absolute;">Rp.</small><?php echo $v_harga;?>
			</div>	
			<!--HARGA-->	  
			  </td>		
			</tr>
		  </tbody>
		</table>
	  </td>
    </tr>
    <tr>
      <td style="color:#666;border-collapse: collapse;" valign="top">
		<table style="width:100%;border-collapse: collapse;">
		  <tbody>
			<tr>
			  <td style="width:95px" valign="top">
			<!--USER-->
			<div style="clear:both;color:#666;margin-top:2.5px;margin-bottom:2.5px;">
			<?php if($v_opsi=='up'){ ?>
			<div style="padding:0px;border-top:1px solid #666;text-align:center;font-weight:bold;font-size:10px;">MEMBER</div>
			<div style="padding:0px;border-top:1px solid #666;border-bottom:1px dotted #666;text-align:center;font-weight:bold;font-size:14px;"><?php echo $v_user;?></div>
			<div style="padding:0px;border-bottom:1px solid #666;text-align:center;font-weight:bold;font-size:14px;"><?php echo $v_pass;?></div>
			<?php }else{ ?>
			<div style="padding:0px;border-top:1px dotted #666;text-align:center;font-weight:bold;font-size:10px;">VOUCHER</div>
			<div style="padding:0px;border-top:1px dotted #666;border-bottom:1px solid #666;text-align:center;font-weight:bold;font-size:14px;"><?php echo $v_user;?></div>
			<?php } ?>
			</div>
			<!--USER--> 
			<!--URL-->
			<div style="text-align:left;color:#111;font-size:9px;font-weight:bold;margin:0px;padding:2.5px;">
			status/logout: <br/>
			http://<?php echo $v_dns;?>
			</div>
			<!--URL-->	  
			  </td>	
			  <td style="width:95px;text-align:right;">
			<!--VALIDASI-TIMELIMIT-KUOTA-->
			<div style="clear:both;padding:0 2.5px;font-size:9px;font-weight:bold;color:#666;">
			Validasi <?php echo $v_valid;?><br/>
			Time Limit <?php echo $v_tlimit;?><br/>
			Kuota <?php echo $v_dlimit;?>
			</div>
			<!--VALIDASI-TIMELIMIT-KUOTA-->  
			<!--QRCODE-->
			<div style="float:right;padding:1px;text-align:right;width:70%;margin:0 5px -20px 0;"><img style="width:100%;" src="<?php echo $v_qrcode ?>" alt="qrcode"></div>
			<!--QRCODE--> 
			  </td>		
			</tr>
    <tr>
      <td style="background:#666;color:#666;padding:0px;" valign="top" colspan="2">
	  
			<!--URL-->
			<div style="text-align:left;color:#fff;font-size:9px;font-weight:bold;margin:0px;padding:2.5px;">
			CS: <?php echo $v_hp;?>
			</div>
			<!--URL-->	 
			</td>
    </tr>
		  </tbody>
		</table>
	  </td>
    </tr>
  </tbody>
</table>
